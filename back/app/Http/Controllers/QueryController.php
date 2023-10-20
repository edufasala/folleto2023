<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Pedido;
use Illuminate\Http\Request;

class QueryController extends Controller
{
    public function numeracionDePedidos()
    {
        $empresas = Empresa::take(10)->get();
//        $pedidos = Pedido::all();
        $pedidosAll = Pedido::select('id','codigo', 'empresa_id')->get();

        foreach ($empresas as $empresa) {
            $pedidoEmpresa = $pedidosAll->where('empresa_id', $empresa->id);
            $numeroCodigo = 1;
            error_log("empresas: " . json_encode($empresas));
            foreach ($pedidoEmpresa as $pedido) {
                $pedido->codigo = $numeroCodigo;
                $pedido->save();
                error_log($numeroCodigo);
                $numeroCodigo++;
            }
        }
    }
}
