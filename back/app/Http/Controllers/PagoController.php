<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Http\Requests\StorePagoRequest;
use App\Http\Requests\UpdatePagoRequest;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PagoController extends Controller{
    public function index(){
        return Pago::with('user')->orderBy('id', 'desc')->get();
    }
    public function store(StorePagoRequest $request){
        $pedido = Pedido::find($request->pedido_id);
        $pago = new Pago();
        $pago->fecha = date('Y-m-d');
        $pago->hora = date('H:i:s');
        $pago->monto = $request->monto;
        $pago->facturado = 'NO';
        $pago->tipo = 'PAGO';
        $pago->metodoPago = $request->metodoPago;
        $pago->comentario = $request->comentario;
        $pago->user_id = $request->user()->id;
        $pago->pedido_id = $request->pedido_id;
        $pago->facturacion_id = $pedido->facturacion_id;
        $pago->save();
        return Pago::whereId($pago->id)->with('user')->first();
    }
    public function show($id){
        return Pago::whereId($id)->with('user')->first();
    }
    public function update(UpdatePagoRequest $request, $id){
        $pago = Pago::find($id);
        $pago->fecha = date('Y-m-d');
        $pago->hora = date('H:i:s');
        $pago->monto = $request->monto;
        $pago->facturado = 'NO';
        $pago->tipo = 'PAGO';
        $pago->metodoPago = $request->metodoPago;
        $pago->comentario = $request->comentario;
        $pago->user_id = $request->user()->id;
        $pago->pedido_id = $request->pedido_id;
        $pago->save();
        return Pago::whereId($pago->id)->with('user')->first();
    }
    public function destroy($id){
        $pago = Pago::find($id);
        $pago->delete();
        return $pago;
    }
    public function aceptarEstadoPago(Request $request){
        foreach ($request->pagos as $pago) {
            $pago = Pago::find($pago['id']);
            $pago->estado = 'Aceptado';
            $pago->save();
        }
    }
    public function rechazarEstadoPago(Request $request){
        foreach ($request->pagos as $pago) {
            $pago = Pago::find($pago['id']);
            $pago->estado = 'Rechazado';
            $pago->save();
        }
    }
    public function busquedaPagos(Request $request){
//        http://localhost:8000/api/busquedaPagos?fechaDesde=2023-09-30&fechaHasta=2023-09-30%20%20%20%20%20%20&metodoPago=&user=
        $fechaDesde = $request->fechaDesde;
        $fechaHasta = $request->fechaHasta;
        $metodoPago = $request->metodoPago;
        $user = $request->user=="undefined"?"":$request->user;
        $pagos = Pago::with('user')->whereBetween('fecha', [$fechaDesde, $fechaHasta])->where('metodoPago', 'LIKE', "%$metodoPago%")->where('user_id', 'LIKE', "%$user%")->orderBy('id', 'desc')->get();
        return $pagos;
    }
}
