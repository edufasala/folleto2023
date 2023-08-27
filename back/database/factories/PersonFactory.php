<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nombre" => $this->faker->name(),
            "cargo" => $this->faker->randomElement(["Administrador", "Empleado","Dueño","Cliente","Marketing"]),
            "dni" => $this->faker->numberBetween(10000000, 99999999),
        ];
    }
}
