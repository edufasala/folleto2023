<?php

namespace App\Http\Controllers;

use App\Models\PhoneDireccions;
use App\Http\Requests\StorePhoneDireccionsRequest;
use App\Http\Requests\UpdatePhoneDireccionsRequest;

class PhoneDireccionsController extends Controller{
    public function index(){}
    public function show(PhoneDireccions $phoneDireccions){}
    public function store(StorePhoneDireccionsRequest $request){
        $phoneDireccions = PhoneDireccions::create($request->all());
        return redirect()->route('phoneDireccions.show', $phoneDireccions->id);
    }
    public function update(UpdatePhoneDireccionsRequest $request, PhoneDireccions $phoneDireccions){}
    public function destroy($id){
        $phoneDireccions = PhoneDireccions::find($id);
        $phoneDireccions->delete();
        return $phoneDireccions;
    }
}
