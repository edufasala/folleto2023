<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Models\Pedido;

class EmpresaController extends Controller{
    public function index(){ return Empresa::get(); }
    public function show(Empresa $empresa){
//
//        $promedioDiasCompra = Pedido::where('empresa_id', $empresa->id)
//            ->where('estadoPedido', 'Terminado')
//            ->avg('diasCompra');
        $empresa= Empresa::where('id', $empresa->id)
            ->with([
                'direccion.phoneDireccions',
                'facturacion',
                'sucursals',
                'person.phone',
                'person.email',
                'notes.user',
                'pedidos'
            ])
            ->first();
//        $empresa->promedioDiasCompra = $promedioDiasCompra->round(2);
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
