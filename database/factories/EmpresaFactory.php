<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresa>
 */
class EmpresaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'razon_social' => $this->faker->company(),
            'cif' => $this->faker->bothify('?#########'),
            'direccion' => $this->faker->address(),
            'poblacion' => $this->faker->city(),
            'email' => $this->faker->companyEmail(),
            'telefono' => $this->faker->phoneNumber(),
            'observaciones' => $this->faker->sentence(),
            'responsable' => $this->faker->name(),
            'horario' => $this->faker->randomElement(['L-V 8:00-15:00', 'L-V 9:00-14:00', 'L-J 8:00-15:00 V 8:00-14:00']),
            'ciclos' => $this->faker->randomElements(['ASIR', 'SMR', 'DAM'], rand(1, 2)),
        ];
    }
}
