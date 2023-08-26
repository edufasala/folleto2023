<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Direccion;
use App\Models\Empresa;
use App\Models\Person;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            UserSeeder::class,
        ]);
        Empresa::factory()
            ->count(1000)
//            ->hasDireccion(2)
            ->hasFacturacion(2)
            ->hasSucursals(2)
//            ->hasPerson(2)
            ->create()
            ->each(function ($empresa) {
                Person::factory()
                    ->count(2)
                    ->hasPhone(2)
                    ->hasEmail(2)
                    ->create([
                        'empresa_id' => $empresa->id,
                    ]);
                Direccion::factory()
                    ->count(2)
                    ->hasPhoneDireccions(2)
                    ->create([
                        'empresa_id' => $empresa->id,
                    ]);
            });
    }
}
