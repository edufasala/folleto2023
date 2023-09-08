<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use App\Models\Person;
use Illuminate\Http\Request;

class PedidoController extends Controller{
    public function index(){}
    public function store(StorePedidoRequest $request){
        error_log("asa".json_encode($request->person));
        $pedido = new Pedido();
        $pedido->codigo = $request->codigo;
        $pedido->producto = $request->producto;
        $pedido->medida = $request->medida;
        $pedido->cantidad = $request->cantidad;
        $pedido->esp = $request->esp;
        $pedido->gr = $request->gr;
        $pedido->lados = $request->lados;
        $pedido->diseno = $request->diseno;
        $pedido->descripcion = $request->descripcion;
        $pedido->estado = 'Diseño';
        $pedido->estadoPedido = 'Activo';
        $pedido->fecha = date('Y-m-d');
        $pedido->fechaEntrega = $request->fechaEntrega;
        $pedido->fechaEspecial = $request->fechaEspecial;
        $pedido->precioProducto = $request->precioProducto;
        $pedido->precioDiseno = $request->precioDiseno;

        $pedido->especificaciones = $request->especificaciones;
        $pedido->terminacion = $request->terminacion;
        $pedido->envio = $request->envio;
        $pedido->precioEspecificaciones = $request->precioEspecificaciones;
        $pedido->precioEnvio = $request->precioEnvio;

        $pedido->pago = $request->pago;
        $pedido->metodoPago = $request->metodoPago;
        $pedido->comentarioPago = $request->comentarioPago;
        $pedido->iva = $request->iva;
        $pedido->seFacturo = $request->seFacturo;
        $pedido->user_id = $request->user()->id;
        $pedido->empresa_id = $request->empresa_id;
        $pedido->sucursal_id = $request->sucursal['id'];
        $pedido->facturacion_id = $request->facturacion['id'];
        $pedido->direccion_id = $request->direccion['id'];
        $pedido->persona_id = $request->person['id'];
        $persona = Person::find($request->person['id']);
        $pedido->phone_id = $persona->phone[0]->id;
        $pedido->email_id = $persona->email[0]->id;
        $pedido->save();
    }
    public function show(Pedido $pedido){}
    public function update(UpdatePedidoRequest $request, Pedido $pedido){}
    public function destroy(Pedido $pedido){}
    public function getNumeroPedido(Request $request){
        $pedidosCount = Pedido::where('empresa_id', $request->empresa_id)->count();
        $numeroPedido = $pedidosCount + 1;
        return $numeroPedido;
    }
}
