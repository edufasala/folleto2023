<?php

namespace App\Http\Controllers;

use App\Models\Facturacion;
use App\Http\Requests\StoreFacturacionRequest;
use App\Http\Requests\UpdateFacturacionRequest;

class FacturacionController extends Controller{
    public function index(){}
    public function show(Facturacion $facturacion){}
    public function store(StoreFacturacionRequest $request){
        $facturacion = Facturacion::create($request->all());
        return $facturacion;
    }
    public function update(UpdateFacturacionRequest $request, $id){
        $facturacion = Facturacion::findOrFail($id);
        $facturacion->update($request->all());
        return $facturacion;
    }
    public function destroy($id){
        $facturacion = Facturacion::findOrFail($id);
        $facturacion->delete();
        return 204;
    }
}
