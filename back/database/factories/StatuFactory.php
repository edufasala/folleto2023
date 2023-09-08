<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Statu>
 */
class StatuFactory extends Factory
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
            'realizado' => $this->faker->randomElement(["Venta","Entrega","Facturacion","Pago","Envio","Entregado","Cancelado"]),
            'nota' => $this->faker->text(),
            'user_id' => $this->faker->randomElement(\App\Models\User::pluck('id')->toArray()),
        ];
    }
}
