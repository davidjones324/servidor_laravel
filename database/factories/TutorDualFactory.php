<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TutorDual>
 */
class TutorDualFactory extends Factory
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
            'ciclos' => $this->faker->randomElements(['ASIR', 'SMR', 'DAM'], rand(1, 2)),
            'cursos' => $this->faker->randomElements(['1º', '2º'], rand(1, 2)),
            'grupo' => $this->faker->randomElement(['A', 'B', 'C']),
        ];
    }
}
