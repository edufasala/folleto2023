<?php

namespace App\Http\Controllers;

use App\Models\ProductoTerminacion;
use App\Http\Requests\StoreProductoTerminacionRequest;
use App\Http\Requests\UpdateProductoTerminacionRequest;

class ProductoTerminacionController extends Controller{
    public function terminacionNombre(){
        $productoTerminacion = ProductoTerminacion::select('nombre')->groupBy('nombre')->get();
        $terminacionNombre = [];
        foreach ($productoTerminacion as $terminacion) {
            array_push($terminacionNombre, $terminacion->nombre);
        }
        return $terminacionNombre;
    }
    public function index(){ return ProductoTerminacion::all(); }
    public function show(ProductoTerminacion $productoTerminacion){ return $productoTerminacion; }
    public function store(StoreProductoTerminacionRequest $request){
        $productoTerminacion = ProductoTerminacion::create($request->all());
        return response()->json($productoTerminacion, 201);
    }
    public function update(UpdateProductoTerminacionRequest $request, $id){
        $productoTerminacion = ProductoTerminacion::findOrFail($id);
        $productoTerminacion->update($request->all());
        return response()->json($productoTerminacion, 200);
    }
    public function destroy($id){
        $productoTerminacion = ProductoTerminacion::findOrFail($id);
        $productoTerminacion->delete();
        return response()->json(null, 204);
    }
}
