<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'body' => $this->faker->text(),
            'date' => $this->faker->date(),
            'color' => $this->faker->randomElement(["red","white"]),
            'user_id' => $this->faker->randomElement(["1","2","3","4","5","6","7","8","9","10"]),
        ];
    }
}
