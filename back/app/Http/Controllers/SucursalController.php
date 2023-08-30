<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use App\Http\Requests\StoreSucursalRequest;
use App\Http\Requests\UpdateSucursalRequest;

class SucursalController extends Controller{
    public function index(){}
    public function show(Sucursal $sucursal){}
    public function store(StoreSucursalRequest $request){
        return Sucursal::create($request->all());
    }
    public function update(UpdateSucursalRequest $request, Sucursal $sucursal){
        $sucursal->update($request->all());
        return $sucursal;
    }
    public function destroy(Sucursal $sucursal){
        $sucursal->delete();
        return $sucursal;
    }
}
