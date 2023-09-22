<?php

namespace App\Http\Controllers;

use App\Models\TextTerminacion;
use App\Http\Requests\StoreTextTerminacionRequest;
use App\Http\Requests\UpdateTextTerminacionRequest;

class TextTerminacionController extends Controller{
    public function index(){
        return TextTerminacion::all();
    }
    public function store(StoreTextTerminacionRequest $request){
        $textTerminacion = new TextTerminacion;
        $textTerminacion->name = $request->name;
        $textTerminacion->save();
    }
}
