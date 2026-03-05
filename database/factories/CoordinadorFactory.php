<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coordinador>
 */
class CoordinadorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dni' => $this->faker->bothify('#########?'),
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'telefono' => $this->faker->phoneNumber(),
        ];
    }
}
