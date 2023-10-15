<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller{
    public function index(Request $request){
        return Permission::all();
    }
    public function store(Request $request){
        $permission = Permission::create($request->all());
        return response()->json($permission, 201);
    }
    public function show($id){
        return Permission::findOrFail($id);
    }
    public function update(Request $request, $id){
        $permission = Permission::findOrFail($id);
        $permission->update($request->all());
        return response()->json($permission, 200);
    }
    public function destroy($id){
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response()->json(null, 204);
    }
}
