<?php

namespace App\Http\Controllers;

use App\Models\Direccion;
use App\Http\Requests\StoreDireccionRequest;
use App\Http\Requests\UpdateDireccionRequest;

class DireccionController extends Controller{
    public function index(){}
    public function show(Direccion $direccion){}
    public function store(StoreDireccionRequest $request){
        return  Direccion::create($request->all());
    }
    public function update(UpdateDireccionRequest $request, Direccion $direccion){
        $direccion->update($request->all());
        return $direccion;
    }
    public function destroy(Direccion $direccion){
        $direccion->delete();
        return $direccion;
    }
}
