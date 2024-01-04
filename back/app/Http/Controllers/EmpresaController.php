<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Models\Pago;
use App\Models\Pedido;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\error;

class EmpresaController extends Controller{
    public function index(Request $request){
//        $this->eliminarEmpresasSinPedidos();
        $search = $request->search;
        $filter = $request->filter;
        $search = $search=='null'?'':$search;
        $paginate = 50;
        if ($filter == 'numero') {
            $empresas= Empresa::where('nombre', 'like', '%'.$search.'%')
                ->orWhere('id', 'like', '%'.$search.'%')
                ->paginate($paginate);
            return $empresas;
        }
        if ($filter == 'nombre') {
            $empresas = Empresa::whereHas('person', function ($query) use ($search) {
                $query->where('nombre', 'like', '%'.$search.'%');
            })->paginate($paginate);
            return $empresas;
        }
        if ($filter == 'telefono') {
            $empresas = Empresa::whereHas('person.phone', function ($query) use ($search) {
                $query->where('phone', 'like', '%'.$search.'%');
            })->paginate($paginate);
            return $empresas;
        }
        if ($filter == 'email') {
            $empresas = Empresa::whereHas('person.email', function ($query) use ($search) {
                $query->where('email', 'like', '%'.$search.'%');
            })->paginate($paginate);
            return $empresas;
        }
        if ($filter == 'sucursal') {
            $empresas = Empresa::whereHas('sucursals', function ($query) use ($search) {
                $query->where('sucursals.nombre', 'like', '%'.$search.'%');
            })->paginate($paginate);
            return $empresas;
        }
    }
    public function eliminarEmpresasSinPedidos(){
        Empresa::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('pedidos')
                ->whereRaw('pedidos.empresa_id = empresas.id');
        })->delete();
    }
    public function show(Empresa $empresa){
        $empresa= Empresa::where('id', $empresa->id)
            ->with([
                'direccion.phoneDireccions',
                'facturacion',
                'sucursals',
                'person.phone',
                'person.email',
                'notes.user',
                'pedidos.user',
                'pedidos.sucursal',
                'pedidos.person',
                'pedidos.direccion',
                'pedidos.facturacion',
                'pedidos.phone',
                'pedidos.email',
                'pedidos.pagos.user',
                'pedidos.status.user',
            ])
            ->first();
        list($promedioDiasCompra, $proximoPedido) = $this->searchDiasProximoCompra($empresa);
        $empresa->proximoPedido = $proximoPedido;
        $sumDeudaPedido = Pedido::where('empresa_id', $empresa->id)
            ->where('estadoPedido', '!=', 'Terminado')
            ->sum(DB::raw('precioProducto + precioDiseno + precioEspecificaciones + precioEnvio'));
        $sumPagoEmpresa = Pago::where('empresa_id', $empresa->id)
            ->sum('monto');
        $empresa->promedioDiasCompra = round($promedioDiasCompra, 2);
        $empresa->sumDeudaPedido = $sumDeudaPedido;
        $empresa->sumPagoEmpresa = $sumPagoEmpresa;
        return $empresa;
    }
    public function empresaCredibilidad(Request $request){
        $empresa_id = $request->empresa_id;
        $credibilidad = $request->credibilidad;
        $empresa = Empresa::find($empresa_id);
        $empresa->credibilidad = $credibilidad;
        $empresa->save();
        return $empresa;
    }
    public function store(StoreEmpresaRequest $request){
        DB::beginTransaction();
        $empresa= Empresa::create($request->all());
        $persona = Person::create([
            'nombre' => $request->vendedorNombre,
            'cargo' => $request->vendedorCargo,
            'dni' => $request->vendedorDni,
            'empresa_id' => $empresa->id,
        ]);
        $phone = $persona->phone()->create([
            'phone' => $request->vendedorTelefono,
        ]);
        $email = $persona->email()->create([
            'email' => $request->vendedorEmail,
        ]);
        DB::commit();
        return $empresa;
    }
    public function createEmpresaTotal(Request $request){
        error_log(json_encode($request->empresa['person']));
        DB::beginTransaction();
        $empresa = Empresa::create($request->empresa);
        foreach ($request->empresa['person'] as $person) {
            $persona = Person::create([
                'nombre' => $person['nombre'],//['nombre'
                'cargo' => $person['cargo'],//['cargo'
                'dni' => $person['dni'],//['dni'
                'empresa_id' => $empresa->id,
            ]);
            $phone = $persona->phone()->create([
                'phone' => $person['phone'][0]['phone'],//['phone'
            ]);
            $email = $persona->email()->create([
                'email' => $person['email'][0]['email'],//['email'
            ]);
        }
//        $persona = Person::create([
//            'nombre' => $request->empresa['person'][0]['nombre'],//['nombre'
//            'cargo' => $request->empresa['person'][0]['cargo'],//['cargo'
//            'dni' => $request->empresa['person'][0]['dni'],//['dni'
//            'empresa_id' => $empresa->id,
//        ]);
//        $phone = $persona->phone()->create([
//            'phone' => $request->empresa['person'][0]['phone'][0]['phone'],//['phone'
//        ]);
//        $email = $persona->email()->create([
//            'email' => $request->empresa['person'][0]['email'][0]['email'],//['email'
//        ]);


//        $sucursal = $empresa->sucursals()->create([
//            'nombre' => $request->empresa['sucursals'][0]['nombre'],//['nombre'
//            'comentario' => $request->empresa['sucursals'][0]['comentario'],//['comentario'
//        ]);
        foreach ($request->empresa['sucursals'] as $sucursal) {
            $sucursal = $empresa->sucursals()->create([
                'nombre' => $sucursal['nombre'],//['nombre'
                'comentario' => $sucursal['comentario'],//['comentario'
            ]);
        }

        foreach ($request->empresa['direccion'] as $direccion) {
            $direccion = $empresa->direccion()->create([
                'direccion' => $direccion['direccion'],//['direccion'
                'codigoPostal' => $direccion['codigoPostal'],//['codigoPostal'
                'localidad' => $direccion['localidad'],//['localidad'
            ]);
//            $phoneDireccion = $direccion->phoneDireccions()->create([
//                'phone' => $direccion['phoneDireccions'][0]['phone'],//['phone'
//            ]);
        }
//        facturacion
        foreach ($request->empresa['facturacion'] as $facturacion) {
            $facturacion = $empresa->facturacion()->create([
                'cuit' => $facturacion['cuit'],//['cuit'
                'condicional' => $facturacion['condicional'],//['condicional'
                'razonSocial' => $facturacion['razonSocial'],//['razonSocial'
                'comentario' => $facturacion['comentario'],//['comentario'
            ]);
        }
        $pedido = new Pedido();
        $pedido->codigo = 1;
        $pedido->producto = $request->pedido['producto'];//['producto'
        $pedido->medida = $request->pedido['medida'];//['medida'
        $pedido->cantidad = $request->pedido['cantidad'];//['cantidad'
        $pedido->esp = $request->pedido['esp'];//['esp'
        $pedido->gr = $request->pedido['gr'];//['gr'
        $pedido->lados = $request->pedido['lados'];//['lados'
        $pedido->diseno = $request->pedido['diseno'];//['diseno'
        $pedido->descripcion = $request->pedido['descripcion'];//['descripcion'
        $pedido->estado = 'Diseño';
        $pedido->estadoPedido = 'Activo';
        $pedido->fecha = date('Y-m-d');
        $pedido->fechaEntrega = $request->pedido['fechaEntrega'];//['fechaEntrega'
        $pedido->fechaEspecial = $request->pedido['fechaEspecial'];//['fechaEspecial'
        $pedido->precioProducto = $request->pedido['precioProducto'];//['precioProducto'
        $pedido->precioDiseno = $request->pedido['precioDiseno'];//['precioDiseno'

        $pedido->especificaciones = $request->pedido['especificaciones'];//['especificaciones'
        $pedido->terminacion = $request->pedido['terminacion'];//['terminacion'
        $pedido->envio = $request->pedido['envio'];//['envio'
        $pedido->precioEspecificaciones = $request->pedido['precioEspecificaciones'];//['precioEspecificaciones'
        $pedido->precioEnvio = $request->pedido['precioEnvio'];//['precioEnvio'

        $pedido->pago = $request->pedido['pago'];//['pago'
        $pedido->metodoPago = $request->pedido['metodoPago'];//['metodoPago'
        $pedido->comentarioPago = $request->pedido['comentarioPago'];//['comentarioPago'
        $pedido->iva = $request->pedido['iva'];//['iva'
        $pedido->seFacturo = $request->pedido['seFacturo'];//['seFacturo'
        $pedido->facturaA = $request->pedido['facturaA'];//['facturaA'
        $pedido->user_id = $request->user()->id;
        $pedido->empresa_id = $empresa->id;
        $pedido->sucursal_id = isset($request->pedido['sucursal']['id']) ? $request->pedido['sucursal']['id'] : null;//['sucursal']['id']
        $pedido->facturacion_id = isset($request->pedido['facturacion']['id']) ? $request->pedido['facturacion']['id'] : null;//['facturacion']['id']
        $pedido->direccion_id = isset($request->pedido['direccion']['id']) ? $request->pedido['direccion']['id'] : null;//['direccion']['id']
        $pedido->persona_id = isset($request->pedido['person']['id']) ? $request->pedido['person']['id'] : null;//['person']['id']
        $persona = Person::find(isset($request->pedido['person']['id']) ? $request->pedido['person']['id'] : null);//['person']['id']
        $pedido->phone_id = isset($persona->phone[0]->id) ? $persona->phone[0]->id : null;
        $pedido->email_id = isset($persona->email[0]->id) ? $persona->email[0]->id : null;
        $pedido->save();
        DB::commit();

        $empresa= Empresa::where('id', $empresa->id)
            ->with([
                'direccion.phoneDireccions',
                'facturacion',
                'sucursals',
                'person.phone',
                'person.email',
                'notes.user',
                'pedidos.user',
                'pedidos.sucursal',
                'pedidos.person',
                'pedidos.direccion',
                'pedidos.facturacion',
                'pedidos.phone',
                'pedidos.email',
                'pedidos.pagos.user',
                'pedidos.status.user',
            ])
            ->first();

        return response()->json([
            'empresa' => $empresa,
            'pedido' => $pedido,
        ], 200);
    }
    public function update(UpdateEmpresaRequest $request, $id){
        $empresa = Empresa::findOrFail($id);
        $empresa->update($request->all());
        return $empresa;
    }
    public function destroy(Empresa $empresa){
//        return $empresa->delete();
    }

    /**
     * @param $empresa
     * @return array
     */
    public function searchDiasProximoCompra($empresa): array
    {
        $promedioDiasCompra = Pedido::where('empresa_id', $empresa->id)
//            ->where('estadoPedido', 'Terminado')
            ->avg('diasCompra');

        $diasCompraEntero = intval($promedioDiasCompra);
        $ultimoPedido = Pedido::where('empresa_id', $empresa->id)
            ->orderBy('fecha', 'desc')
            ->first();
        if ($ultimoPedido) {
            $fechaUltimoPedido = Carbon::parse($ultimoPedido->fecha);
            $proximoPedido = $fechaUltimoPedido->addDays($diasCompraEntero);
            $meses = ['ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'];
            $proximoPedido = $proximoPedido->format('d ') . $meses[$proximoPedido->format('n') - 1] . $proximoPedido->format(' Y');
        } else {
            $proximoPedido = null;
        }
        return array($promedioDiasCompra, $proximoPedido);
    }
}
