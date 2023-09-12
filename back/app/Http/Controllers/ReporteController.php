<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function reportBetween(Request $request)
    {
        return Pedido::selectRaw('fecha, count(*) as cantidad')
            ->whereBetween('fecha', [$request->dateIni, $request->dateFin])
            ->groupBy('fecha')
            ->get();
    }
}
