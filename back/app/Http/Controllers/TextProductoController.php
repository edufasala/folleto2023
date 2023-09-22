<?php

namespace App\Http\Controllers;

use App\Models\TextProducto;
use App\Http\Requests\StoreTextProductoRequest;
use App\Http\Requests\UpdateTextProductoRequest;

class TextProductoController extends Controller{
    public function index(){
        return TextProducto::all();
    }
    public function store(StoreTextProductoRequest $request){
        $textProducto = new TextProducto;
        $textProducto->name = $request->name;
        $textProducto->save();
    }
}
