<?php

namespace App\Http\Controllers;

use App\Models\TextDiseno;
use App\Http\Requests\StoreTextDisenoRequest;
use App\Http\Requests\UpdateTextDisenoRequest;

class TextDisenoController extends Controller{
    public function index(){
        return TextDiseno::all();
    }
    public function store(StoreTextDisenoRequest $request){
        $textDiseno = new TextDiseno;
        $textDiseno->name = $request->name;
        $textDiseno->save();
    }
}
