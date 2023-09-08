<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pago>
 */
class PagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'fecha' => $this->faker->date(),
            'hora' => $this->faker->time(),
            'tipo' => $this->faker->randomElement(["Seña","Pago"]),
            'monto' => $this->faker->randomFloat(2, 0, 100),
            'facturado' => $this->faker->randomElement(["No","Si"]),
            'metodoPago' => $this->faker->randomElement(["Efectivo","Transferencia","Tarjeta","Cheque","Otro"]),
            'comentario' => $this->faker->text(),
            'user_id' => $this->faker->randomElement(\App\Models\User::pluck('id')->toArray()),
        ];
    }
}
