<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Http\Requests\StorePagoRequest;
use App\Http\Requests\UpdatePagoRequest;
use App\Models\Pedido;

class PagoController extends Controller{
    public function index(){}
    public function store(StorePagoRequest $request){
//        'fecha',
//        'hora',
//        'monto',
//        'facturado',
//        'tipo',
//        'metodoPago',
//        'comentario',
//        'user_id',
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
}
