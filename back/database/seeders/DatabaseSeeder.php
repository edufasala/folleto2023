<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Direccion;
use App\Models\Empresa;
use App\Models\Note;
use App\Models\Pedido;
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
            ->count(20)
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
                Note::factory()
                    ->count(10)
                    ->create([
                        'empresa_id' => $empresa->id,
                    ]);
                Pedido::factory()
                    ->count(10)
                    ->create([
                        'empresa_id' => $empresa->id,
                        'sucursal_id' => $empresa->sucursals->random()->id,
                        'facturacion_id' => $empresa->facturacion->random()->id,
                        'direccion_id' => $empresa->direccion->random()->id,
                        'persona_id' => $empresa->person->random()->id,
                        'phone_id' => $empresa->person->random()->phone->random()->id,
                    ]);
            });
    }
}
