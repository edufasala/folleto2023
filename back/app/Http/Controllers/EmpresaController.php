<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Models\Pedido;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\error;

class EmpresaController extends Controller{
    public function index(Request $request){
        $search = $request->search;
        $filter = $request->filter;
        $search = $search=='null'?'':$search;
        if ($filter == 'numero') {
            $empresas= Empresa::where('nombre', 'like', '%'.$search.'%')
                ->orWhere('id', 'like', '%'.$search.'%')
                ->paginate(100);
            return $empresas;
        }
        if ($filter == 'nombre') {
            $empresas = Empresa::whereHas('person', function ($query) use ($search) {
                $query->where('nombre', 'like', '%'.$search.'%');
            })->paginate(100);
            return $empresas;
        }
        if ($filter == 'telefono') {
            $empresas = Empresa::whereHas('person.phone', function ($query) use ($search) {
                $query->where('phone', 'like', '%'.$search.'%');
            })->paginate(100);
            return $empresas;
        }
        if ($filter == 'email') {
            $empresas = Empresa::whereHas('person.email', function ($query) use ($search) {
                $query->where('email', 'like', '%'.$search.'%');
            })->paginate(100);
            return $empresas;
        }
        if ($filter == 'sucursal') {
            $empresas = Empresa::whereHas('sucursals', function ($query) use ($search) {
                $query->where('nombre', 'like', '%'.$search.'%');
            })->paginate(100);
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
        $empresa->promedioDiasCompra = round($promedioDiasCompra, 2);
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
