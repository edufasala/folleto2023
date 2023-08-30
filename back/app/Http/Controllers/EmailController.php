<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Http\Requests\StoreEmailRequest;
use App\Http\Requests\UpdateEmailRequest;
use Illuminate\Http\Request;

class EmailController extends Controller{
    public function index(){}
    public function store(StoreEmailRequest $request){
        $email = Email::create($request->all());
        return $email;
    }
    public function show(Email $email){}
    public function update(UpdateEmailRequest $request, Email $email){
        $email->update($request->all());
        return $email;
    }
    public function destroy(Email $email){
        $email->delete();
        return $email;
    }
}
