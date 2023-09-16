<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MigracionController extends Controller
{
    public function migracion($tabla){
        if ($tabla=='usuarios') {
            $usuarios = DB::connection('mysql2')->select('select * from users');
            User::truncate();
            foreach ($usuarios as $usuario) {
                DB::table('users')->insert([
                    'id' => $usuario->id,
                    'name' => $usuario->name,
                    'email' => $usuario->email,
                    'password' => $usuario->password,
                    'active' => $usuario->actived,
                    'created_at' => $usuario->created_at,
                    'updated_at' => $usuario->updated_at,
                ]);
            }
        }
    }
}
