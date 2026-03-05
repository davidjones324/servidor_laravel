<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alumno>
 */
class AlumnoFactory extends Factory
{
    public function definition(): array
    {
        $ciclo = $this->faker->randomElement(['ASIR', 'SMR', 'DAM']);

        return [
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName() . ' ' . $this->faker->lastName(),
            'fecha_nacimiento' => $this->faker->date(),
            'curso' => '2025/2026',
            'grupo' => $this->faker->randomElement(['A', 'B', 'C']),
            'ciclo' => $ciclo,
            'anio_ciclo' => $this->faker->randomElement([1, 2]),
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'carnet_conducir' => $this->faker->boolean(),
            'coche_propio' => $this->faker->boolean(),
            'transporte' => $this->faker->randomElement(['carnet_y_coche', 'transporte_publico', 'sin_desplazamiento']),
            'estudios_anteriores' => $this->faker->optional()->sentence(),
            'practicas_pasadas' => $this->faker->optional()->company(),
            'ha_realizado_fct_anterior' => $this->faker->boolean(20),
            'empresa_fct_anterior' => $this->faker->optional(0.2)->company(),
            'localidad_fct_anterior' => $this->faker->optional(0.2)->city(),
            'apto_ffoe' => $this->faker->boolean(80),
            'motivo_exclusion' => $this->faker->optional(0.1)->randomElement(['Baja', 'No supera RRLL/PE I', 'Ya cursada']),
            'residencia' => $this->faker->city(),
            'observaciones' => $this->faker->optional()->sentence(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
