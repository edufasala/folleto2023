<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use App\Models\Person;
use Illuminate\Http\Request;

class PedidoController extends Controller{
    public function revisionPedidos(){
        return Pedido::where('estadoPedido', 'Activo')
            ->orWhere('estadoPedido', 'Aceptado')
            ->orWhere('estadoPedido', 'Rechazado')
            ->with('user')->get();
    }
    public function rechazarPedido(Request $request){
        $pedido = Pedido::find($request->id);
        $pedido->estadoPedido = 'Rechazado';
        $pedido->save();
    }
    public function aceptarPedido(Request $request){
        $pedido = Pedido::find($request->id);
        $pedido->estadoPedido = 'Aceptado';
        $pedido->save();
    }
    public function index(){}
    public function store(StorePedidoRequest $request){
//        error_log("asa".json_encode($request->person));
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
        $pedido->facturaA = $request->facturaA;
        $pedido->user_id = $request->user()->id;
        $pedido->empresa_id = $request->empresa_id;
        $pedido->sucursal_id = $request->sucursal['id'];
        $pedido->facturacion_id = isset($request->facturacion['id']) ? $request->facturacion['id'] : null;
        $pedido->direccion_id = isset($request->direccion['id']) ? $request->direccion['id'] : null;
        $pedido->persona_id = isset($request->person['id']) ? $request->person['id'] : null;
        $persona = Person::find($request->person['id']);
        $pedido->phone_id = isset($persona->phone[0]->id) ? $persona->phone[0]->id : null;
        $pedido->email_id = isset($persona->email[0]->id) ? $persona->email[0]->id : null;
        $pedido->save();
        return $pedido;
    }
    public function show(Pedido $pedido){}
    public function update(UpdatePedidoRequest $request, $id){
        $pedido= Pedido::find($id);
        $pedido->update($request->all());
        $pedido->save();
    }
    public function destroy(Pedido $pedido){}
    public function getNumeroPedido(Request $request){
        $pedidosCount = Pedido::where('empresa_id', $request->empresa_id)->count();
        $numeroPedido = $pedidosCount + 1;
        return $numeroPedido;
    }
}
