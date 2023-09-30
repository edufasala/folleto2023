<?php

namespace App\Http\Controllers;

use App\Models\ProductoConPliego;
use App\Http\Requests\StoreProductoConPliegoRequest;
use App\Http\Requests\UpdateProductoConPliegoRequest;

class ProductoConPliegoController extends Controller{
    public function index(){ return ProductoConPliego::all(); }
    public function show(ProductoConPliego $productoConPliego){ return $productoConPliego; }
    public function store(StoreProductoConPliegoRequest $request){
        $productoConPliego = ProductoConPliego::create($request->all());
        return response()->json($productoConPliego, 201);
    }
    public function update(UpdateProductoConPliegoRequest $request, $id){
        $productoConPliego = ProductoConPliego::findOrFail($id);
        $productoConPliego->update($request->all());
        return response()->json($productoConPliego, 200);
    }
    public function destroy($id){
        $productoConPliego = ProductoConPliego::findOrFail($id);
        $productoConPliego->delete();
        return response()->json(null, 204);
    }
}
