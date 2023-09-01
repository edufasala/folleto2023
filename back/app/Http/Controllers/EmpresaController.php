<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;

class EmpresaController extends Controller{
    public function index(){ return Empresa::get(); }
    public function show(Empresa $empresa){
        $empresa= Empresa::where('id', $empresa->id)
            ->with([
                'direccion.phoneDireccions',
                'facturacion',
                'sucursals',
                'person.phone',
                'person.email',
                'notes.user',
            ])
            ->first();
        return $empresa;
    }
    public function store(StoreEmpresaRequest $request){
        return Empresa::create($request->all());
    }
    public function update(UpdateEmpresaRequest $request, $id){
        $empresa = Empresa::findOrFail($id);
        $empresa->update($request->all());
        return $empresa;
    }
    public function destroy(Empresa $empresa){
//        return $empresa->delete();
    }
}
