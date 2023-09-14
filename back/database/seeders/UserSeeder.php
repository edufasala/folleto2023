<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
//                'role' => 'Administrador',
            ]
        ]);
        Role::create(['name' => 'Administrador']);
        Role::create(['name' => 'Diseñador']);
        Role::create(['name' => 'Entregador']);
        Role::create(['name' => 'Vendedor']);
        Role::create(['name' => 'Gerente de ventas']);

        Permission::create(['name' => 'Usuarios']);
        Permission::create(['name' => 'Usuarios Crear']);
        Permission::create(['name' => 'Usuarios Editar']);
        Permission::create(['name' => 'Usuarios Eliminar']);
        Permission::create(['name' => 'Estadisticas']);
        Permission::create(['name' => 'Estadisticas Crear']);
        Permission::create(['name' => 'Estadisticas Editar']);
        Permission::create(['name' => 'Estadisticas Eliminar']);
        Permission::create(['name' => 'Central Files']);
        Permission::create(['name' => 'Central Files Crear']);
        Permission::create(['name' => 'Central Files Editar']);
        Permission::create(['name' => 'Central Files Eliminar']);
        Permission::create(['name' => 'Cotizaciones']);
        Permission::create(['name' => 'Cotizaciones Crear']);
        Permission::create(['name' => 'Cotizaciones Editar']);
        Permission::create(['name' => 'Cotizaciones Eliminar']);
        Permission::create(['name' => 'Precios']);
        Permission::create(['name' => 'Precios Crear']);
        Permission::create(['name' => 'Precios Editar']);
        Permission::create(['name' => 'Precios Eliminar']);
        Permission::create(['name' => 'Tesoreria']);
        Permission::create(['name' => 'Tesoreria Crear']);
        Permission::create(['name' => 'Tesoreria Editar']);
        Permission::create(['name' => 'Tesoreria Eliminar']);
        Permission::create(['name' => 'Facturas']);
        Permission::create(['name' => 'Facturas Crear']);
        Permission::create(['name' => 'Facturas Editar']);
        Permission::create(['name' => 'Facturas Eliminar']);
        Permission::create(['name' => 'Diseño']);
        Permission::create(['name' => 'Diseño Crear']);
        Permission::create(['name' => 'Diseño Editar']);
        Permission::create(['name' => 'Diseño Eliminar']);
        Permission::create(['name' => 'Impresion']);
        Permission::create(['name' => 'Impresion Crear']);
        Permission::create(['name' => 'Impresion Editar']);
        Permission::create(['name' => 'Impresion Eliminar']);
        Permission::create(['name' => 'Entregas']);
        Permission::create(['name' => 'Entregas Crear']);
        Permission::create(['name' => 'Entregas Editar']);
        Permission::create(['name' => 'Entregas Eliminar']);
        Permission::create(['name' => 'Nuevo Cliente']);
        Permission::create(['name' => 'Nuevo Cliente Crear']);
        Permission::create(['name' => 'Nuevo Cliente Editar']);
        Permission::create(['name' => 'Nuevo Cliente Eliminar']);

        $role = Role::find(1); //admin
        $role->givePermissionTo(Permission::all());

        $role = Role::find(2); //diseñador
        $role->givePermissionTo(['Diseño', 'Impresion']);

        $role = Role::find(3); //entregador
        $role->givePermissionTo(['Entregas']);

        $role = Role::find(4); //vendedor
        $role->givePermissionTo(['Facturas', 'Tesoreria', 'Cotizaciones']);

        $role = Role::find(5); //gerente de ventas
        $role->givePermissionTo(['Estadisticas', 'Central Files', 'Precios', 'Nuevo Cliente']);

        $user = \App\Models\User::find(1);
        $permissions = Permission::all();
        $user->givePermissionTo($permissions);
        $users = \App\Models\User::factory(20)->create();
        foreach ($users as $user) {
            $randomPermiso = rand(1, 10);
            $user->givePermissionTo($permissions[$randomPermiso - 1]->name);
            $roles = Role::all();
            $user->assignRole($roles[rand(1, 5) - 1]->name);
        }
    }
}
