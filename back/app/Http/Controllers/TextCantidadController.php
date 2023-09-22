<?php

namespace App\Http\Controllers;

use App\Models\TextCantidad;
use App\Http\Requests\StoreTextCantidadRequest;
use App\Http\Requests\UpdateTextCantidadRequest;

class TextCantidadController extends Controller{
    public function index(){
        return TextCantidad::pluck('name');
    }
    public function store(StoreTextCantidadRequest $request){
        $textCantidad = new TextCantidad;
        $textCantidad->name = $request->name;
        $textCantidad->save();
    }
}
