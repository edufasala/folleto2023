<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facturacion>
 */
class FacturacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "cuit"=>$this->faker->numberBetween(10000000000,99999999999),
            "condicional"=>$this->faker->name(),
            "razonSocial"=>$this->faker->name(),
            "comentario"=>$this->faker->text(50),
        ];
    }
}
