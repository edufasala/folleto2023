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
                $fechas = [
                    date('Y-m-d', strtotime('-155 day')),
                    date('Y-m-d', strtotime('-150 day')),
                    date('Y-m-d', strtotime('-145 day')),
                    date('Y-m-d', strtotime('-140 day')),
                    date('Y-m-d', strtotime('-135 day')),
                    date('Y-m-d', strtotime('-130 day')),
                    date('Y-m-d', strtotime('-125 day')),
                    date('Y-m-d', strtotime('-120 day')),
                    date('Y-m-d', strtotime('-115 day')),
                    date('Y-m-d', strtotime('-110 day')),
                    date('Y-m-d', strtotime('-105 day')),
                    date('Y-m-d', strtotime('-100 day')),
                    date('Y-m-d', strtotime('-95 day')),
                    date('Y-m-d', strtotime('-90 day')),
                    date('Y-m-d', strtotime('-85 day')),
                    date('Y-m-d', strtotime('-80 day')),
                    date('Y-m-d', strtotime('-75 day')),
                    date('Y-m-d', strtotime('-70 day')),
                    date('Y-m-d', strtotime('-65 day')),
                    date('Y-m-d', strtotime('-60 day')),
                    date('Y-m-d', strtotime('-55 day')),
                    date('Y-m-d', strtotime('-50 day')),
                    date('Y-m-d', strtotime('-45 day')),
                    date('Y-m-d', strtotime('-40 day')),
                    date('Y-m-d', strtotime('-35 day')),
                    date('Y-m-d', strtotime('-30 day')),
                    date('Y-m-d', strtotime('-25 day')),
                    date('Y-m-d', strtotime('-20 day')),
                    date('Y-m-d', strtotime('-15 day')),
                    date('Y-m-d', strtotime('-10 day')),
                    date('Y-m-d', strtotime('-5 day'))
                ];
                for($i = 0; $i < 30; $i++){
                    Pedido::factory()
                        ->create([
                            'empresa_id' => $empresa->id,
                            'sucursal_id' => $empresa->sucursals->random()->id,
                            'facturacion_id' => $empresa->facturacion->random()->id,
                            'direccion_id' => $empresa->direccion->random()->id,
                            'persona_id' => $empresa->person->random()->id,
                            'phone_id' => $empresa->person->random()->phone->random()->id,
                            'fecha' => $fechas[$i],
                            'fechaEntrega' => $fechas[$i]
                            ]);
                }
            });
    }
}
