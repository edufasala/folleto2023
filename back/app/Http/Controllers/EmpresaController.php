<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Models\Pedido;
use Carbon\Carbon;

class EmpresaController extends Controller{
    public function index(){ return Empresa::get(); }
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
            ])
            ->first();
        $promedioDiasCompra = Pedido::where('empresa_id', $empresa->id)
//            ->where('estadoPedido', 'Terminado')
            ->avg('diasCompra');

        $diasCompraEntero = intval($promedioDiasCompra);
        $ultimoPedido = Pedido::where('empresa_id', $empresa->id)
            ->orderBy('fecha', 'desc')
            ->first();
        if ($ultimoPedido){
            $fechaUltimoPedido = Carbon::parse($ultimoPedido->fecha);
            $proximoPedido = $fechaUltimoPedido->addDays($diasCompraEntero);
            $meses = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];
            $proximoPedido = $proximoPedido->format('d ').$meses[$proximoPedido->format('n')-1].$proximoPedido->format(' Y');
        }else{
            $proximoPedido = null;
        }
        $empresa->proximoPedido = $proximoPedido;
        $empresa->promedioDiasCompra = round($promedioDiasCompra, 2);
        return $empresa;
    }
    public function store(StoreEmpresaRequest $request){
        return Empresa::create($request->all());
    }
    public function update(UpdateEmpresaRequest $request, $id){
        $empresa = Empresa::findOrFail($id);
        $empresa->update($request->all());
        return $empresa;
    }
    public function destroy(Empresa $empresa){
//        return $empresa->delete();
    }
}
