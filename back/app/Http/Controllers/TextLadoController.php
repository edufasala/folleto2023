<?php

namespace App\Http\Controllers;

use App\Models\TextLado;
use App\Http\Requests\StoreTextLadoRequest;
use App\Http\Requests\UpdateTextLadoRequest;

class TextLadoController extends Controller{
    public function index(){
        return TextLado::pluck('name');
    }
    public function store(StoreTextLadoRequest $request){
        $textLado = new TextLado;
        $textLado->name = $request->name;
        $textLado->save();
    }
}
