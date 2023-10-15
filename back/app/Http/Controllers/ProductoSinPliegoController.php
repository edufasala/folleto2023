<?php

namespace App\Http\Controllers;

use App\Models\ProductoConPliego;
use App\Models\ProductoSinPliego;
use App\Http\Requests\StoreProductoSinPliegoRequest;
use App\Http\Requests\UpdateProductoSinPliegoRequest;
use Illuminate\Http\Request;

class ProductoSinPliegoController extends Controller{
    public function index(){ return ProductoSinPliego::all(); }
    public function productos(){
        $sinPliegoGroupBynombre = ProductoSinPliego::select('nombre')->groupBy('nombre')->get();
        $conPliegoGroupBynombre = ProductoConPliego::select('nombre')->groupBy('nombre')->get();
        $productos=[];
        foreach ($sinPliegoGroupBynombre as $sinPliego){
            $producto = $sinPliego->nombre;
            array_push($productos,$producto);
        }
        foreach ($conPliegoGroupBynombre as $conPliego){
            $producto = $conPliego->nombre;
            array_push($productos,$producto);
        }
        return $productos;
    }
    public function gr($nombreProducto){
        $productoSinPliegoGr = ProductoSinPliego::select('gr')->where('nombre',$nombreProducto)->groupBy('gr')->get();
        $productoConPliegoGr = ProductoConPliego::select('gr')->where('nombre',$nombreProducto)->groupBy('gr')->get();
        $productos=[];
        foreach ($productoSinPliegoGr as $sinPliego){
            $producto = $sinPliego->gr;
            array_push($productos,$producto);
        }
        foreach ($productoConPliegoGr as $conPliego){
            $producto = $conPliego->gr;
            array_push($productos,$producto);
        }
        return $productos;
    }
    public function tamano($nombreProducto,$gr){
        $productoSinPliegoGr = ProductoSinPliego::select('tamano')
            ->where('nombre',$nombreProducto)
            ->where('gr',$gr)
            ->groupBy('tamano')->get();
        $productoConPliegoGr = ProductoConPliego::select('tamano')
            ->where('nombre',$nombreProducto)
            ->where('gr',$gr)
            ->groupBy('tamano')->get();
        $productos=[];
        foreach ($productoSinPliegoGr as $sinPliego){
            $producto = $sinPliego->tamano;
            array_push($productos,$producto);
        }
        foreach ($productoConPliegoGr as $conPliego){
            $producto = $conPliego->tamano;
            array_push($productos,$producto);
        }
        return $productos;
    }
    public function cantidad($nombreProducto,$gr,$tamano){
        $productoSinPliegoGr = ProductoSinPliego::select('fracciona')
            ->where('nombre',$nombreProducto)
            ->where('gr',$gr)
            ->where('tamano',$tamano)
            ->groupBy('fracciona')->get();
        $productoConPliegoGr = ProductoConPliego::select('fracciona')
            ->where('nombre',$nombreProducto)
            ->where('gr',$gr)
            ->where('tamano',$tamano)
            ->groupBy('fracciona')->get();
        $productos=[];
        foreach ($productoSinPliegoGr as $sinPliego){
            $producto = $sinPliego->fracciona;
            array_push($productos,$producto);
        }
        foreach ($productoConPliegoGr as $conPliego){
            $producto = $conPliego->fracciona;
            array_push($productos,$producto);
        }
        return $productos;
    }
    public function precio($nombreProducto,$gr,$tamano,$fracciona){
        $productoSinPliegoGr = ProductoSinPliego::select('precio')
            ->where('nombre',$nombreProducto)
            ->where('gr',$gr)
            ->where('tamano',$tamano)
            ->where('fracciona',$fracciona)
            ->groupBy('precio')->get();
        $productoConPliegoGr = ProductoConPliego::select('precio')
            ->where('nombre',$nombreProducto)
            ->where('gr',$gr)
            ->where('tamano',$tamano)
            ->where('fracciona',$fracciona)
            ->groupBy('precio')->get();
        $productos=[];
        foreach ($productoSinPliegoGr as $sinPliego){
            $producto = $sinPliego->precio;
            array_push($productos,$producto);
        }
        foreach ($productoConPliegoGr as $conPliego){
            $producto = $conPliego->precio;
            array_push($productos,$producto);
        }
        return $productos;
    }
    public function show(ProductoSinPliego $productoSinPliego){ return $productoSinPliego; }
    public function store(StoreProductoSinPliegoRequest $request){
        $productoSinPliego = ProductoSinPliego::create($request->all());
        return response()->json($productoSinPliego, 201);
    }
    public function update(UpdateProductoSinPliegoRequest $request, $id){
        $productoSinPliego = ProductoSinPliego::findOrFail($id);
        $productoSinPliego->update($request->all());
        return response()->json($productoSinPliego, 200);
    }
    public function destroy($id){
        $productoSinPliego = ProductoSinPliego::findOrFail($id);
        $productoSinPliego->delete();
        return response()->json(null, 204);
    }
}
