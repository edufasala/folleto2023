<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@test.com',
                'password' => bcrypt('admin123Admin'),
                'role' => 'Administrador',
            ]
        ]);
        Permission::create(['name' => 'Usuarios']);
        Permission::create(['name' => 'Estadisticas']);
        Permission::create(['name' => 'Central Files']);
        Permission::create(['name' => 'Persona crear']);
        Permission::create(['name' => 'Persona editar']);
        Permission::create(['name' => 'Persona eliminar']);
        Permission::create(['name' => 'Precios']);
        Permission::create(['name' => 'Tesoreria']);
        Permission::create(['name' => 'Facturas']);
        Permission::create(['name' => 'Diseño']);
        Permission::create(['name' => 'Impresion']);
        Permission::create(['name' => 'Entregas']);
//        Permission::create(['name' => 'Nuevo Cliente']);
        $user = \App\Models\User::find(1);
        $permissions = Permission::all();
        $user->givePermissionTo($permissions);
        $users = \App\Models\User::factory(20)->create();
        foreach ($users as $user) {
            $random = rand(1, 10);
            $user->givePermissionTo($permissions[$random - 1]->name);
        }
    }
}
