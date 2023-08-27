<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use App\Http\Requests\StorePhoneRequest;
use App\Http\Requests\UpdatePhoneRequest;

class PhoneController extends Controller{
    public function index(){ return Phone::all(); }
    public function show(Phone $phone){ return $phone; }
    public function store(StorePhoneRequest $request){ return Phone::create($request->all()); }
    public function update(UpdatePhoneRequest $request, Phone $phone){ return $phone->update($request->all()); }
    public function destroy(Phone $phone){ return $phone->delete(); }
}
