<?php

namespace App\Http\Controllers;

use App\Models\ProductoDiseno;
use App\Models\TextDiseno;
use App\Http\Requests\StoreTextDisenoRequest;
use App\Http\Requests\UpdateTextDisenoRequest;

class TextDisenoController extends Controller{
    public function index(){
        return TextDiseno::pluck('name');
    }
    public function store(StoreTextDisenoRequest $request){
        $textDiseno = new TextDiseno;
        $textDiseno->name = $request->name;
        $textDiseno->save();
    }
    public function disenoNombre(){
        $textDiseno = ProductoDiseno::select('diseno','tamano')->groupBy('diseno','tamano')->get();
        $disenoNombres = [];
        foreach ($textDiseno as $diseno) {
            array_push($disenoNombres, $diseno->diseno.' '.$diseno->tamano);
        }
        return $disenoNombres;
    }
    public function precioDiseno($disenoNombre,$lado){
        $tamano = explode(' ',$disenoNombre)[1];
        $diseno = explode(' ',$disenoNombre)[0];
//        error_log("tamano: ".$tamano." diseno: ".$diseno." lado: ".$lado);
        $textDiseno = ProductoDiseno::where('diseno',$diseno)
            ->where('tamano',$tamano)
            ->where('lado',$lado)
            ->first();
//        error_log("productoDiseno: ".json_encode($textDiseno));
        return $textDiseno==null?0:$textDiseno->precio;
    }
}
