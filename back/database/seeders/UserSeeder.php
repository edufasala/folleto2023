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
        Permission::create(['name' => 'usuarios']);
        Permission::create(['name' => 'estadisticas']);
        Permission::create(['name' => 'centralFiles']);
        Permission::create(['name' => 'precios']);
        Permission::create(['name' => 'tesoreria']);
        Permission::create(['name' => 'facturas']);
        Permission::create(['name' => 'diseño']);
        Permission::create(['name' => 'impresion']);
        Permission::create(['name' => 'entregas']);
        Permission::create(['name' => 'nuevoCliente']);
        $user = \App\Models\User::find(1);
        $permissions = Permission::all();
        $user->givePermissionTo($permissions);
    }
}
