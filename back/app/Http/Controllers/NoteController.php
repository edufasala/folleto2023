<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use Illuminate\Http\Request;

class NoteController extends Controller{
    public function index(Request $request){
        return  Note::where('empresa_id', $request->empresa_id)->with('user')->get();
    }
    public function store(StoreNoteRequest $request){
        $request->merge(['user_id' => $request->user()->id]);
        $note = Note::create($request->all());
        return response()->json($note, 201);
    }
    public function show(Note $note){
        return $note;
    }
    public function update(UpdateNoteRequest $request, Note $note){
        $note->update($request->all());
        return response()->json($note, 200);
    }
    public function destroy(Note $note){
        $note->delete();
        return response()->json(null, 204);
    }
}
