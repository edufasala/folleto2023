<?php

namespace App\Http\Controllers;

use App\Models\TextMedida;
use App\Http\Requests\StoreTextMedidaRequest;
use App\Http\Requests\UpdateTextMedidaRequest;

class TextMedidaController extends Controller{
    public function index(){
        return TextMedida::pluck('name');
    }
    public function store(StoreTextMedidaRequest $request){
        $textMedida = new TextMedida;
        $textMedida->name = $request->name;
        $textMedida->save();
    }
}
