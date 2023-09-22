<?php

namespace App\Http\Controllers;

use App\Models\TextGr;
use App\Http\Requests\StoreTextGrRequest;
use App\Http\Requests\UpdateTextGrRequest;

class TextGrController extends Controller{
    public function index(){
        return TextGr::all();
    }
    public function store(StoreTextGrRequest $request){
        $textGr = new TextGr;
        $textGr->name = $request->name;
        $textGr->save();
    }
}
