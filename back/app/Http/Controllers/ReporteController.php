<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function reportBetween(Request $request)
    {
        $fechaIni = $request->dateIni;
        $fechaFin = $request->dateFin;
        $usuario = $request->usuario;
        if ($usuario==0){
            return Pedido::selectRaw('fecha, count(*) as cantidad')
                ->whereBetween('fecha', [$fechaIni, $fechaFin])
                ->groupBy('fecha')
                ->get();
        }else{
            return Pedido::selectRaw('fecha, count(*) as cantidad')
                ->whereBetween('fecha', [$fechaIni, $fechaFin])
                ->where('user_id',$usuario)
                ->groupBy('fecha')
                ->get();
        }
    }
}
