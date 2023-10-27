<?php

namespace App\Http\Controllers;

use App\Models\Statu;
use App\Http\Requests\StoreStatuRequest;
use App\Http\Requests\UpdateStatuRequest;
use Illuminate\Http\Request;

class StatuController extends Controller{
    public function index(Request $request){
        $pedido_id = $request->input('pedido_id');
        return Statu::where('pedido_id', $pedido_id)->get();
    }
    public function store(Request $request){
        $statu = new Statu();
        $statu->fecha = date('Y-m-d');
        $statu->hora = date('H:i:s');
        $statu->realizado = $request->input('realizado');
        $statu->nota = $request->input('nota');
        $statu->pedido_id = $request->input('pedido_id');
        $statu->user_id = $request->user()->id;
        $statu->save();
        return Statu::with('user')->find($statu->id);
    }
}
