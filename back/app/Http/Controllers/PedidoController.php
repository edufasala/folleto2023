<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use Illuminate\Http\Request;

class PedidoController extends Controller{
    public function index(){}
    public function store(StorePedidoRequest $request){}
    public function show(Pedido $pedido){}
    public function update(UpdatePedidoRequest $request, Pedido $pedido){}
    public function destroy(Pedido $pedido){}
    public function getNumeroPedido(Request $request){
        $pedidosCount = Pedido::where('empresa_id', $request->empresa_id)->count();
        $numeroPedido = $pedidosCount + 1;
        return $numeroPedido;
    }
}
