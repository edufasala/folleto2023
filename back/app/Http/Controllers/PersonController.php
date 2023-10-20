<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\Person;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Models\Phone;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller{
    public function index(){ return Person::all(); }
    public function show(Person $person){ return $person; }
    public function store(StorePersonRequest $request){
        DB::beginTransaction();
        $person = Person::create($request->all());
        if (isset($request->phone)) {
            $phone = new Phone();
            $phone->person_id = $person->id;
            $phone->phone = $request->phone;
            $phone->save();
        }
        if (isset($request->email)) {
            $email = new Email();
            $email->person_id = $person->id;
            $email->email = $request->email;
            $email->save();
        }
        DB::commit();
    }
    public function update(UpdatePersonRequest $request, Person $person){ return $person->update($request->all()); }
    public function destroy(Person $person){ return $person->delete(); }
}
