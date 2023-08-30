<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;

class PersonController extends Controller{
    public function index(){ return Person::all(); }
    public function show(Person $person){ return $person; }
    public function store(StorePersonRequest $request){ return Person::create($request->all()); }
    public function update(UpdatePersonRequest $request, Person $person){ return $person->update($request->all()); }
    public function destroy(Person $person){ return $person->delete(); }
}
