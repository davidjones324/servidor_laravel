<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Acuerdo>
 */
class AcuerdoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'alumno_id' => \App\Models\Alumno::factory(),
            'empresa_id' => \App\Models\Empresa::factory(),
            'tutor_dual_id' => \App\Models\TutorDual::factory(),
            'coordinador_id' => \App\Models\Coordinador::factory(),
            'localidad' => $this->faker->city(),
            'nombre_acuerdo' => 'Acuerdo ' . $this->faker->word(),
            'estado_convenio' => $this->faker->randomElement(['pendiente', 'hecho_pendiente_firma', 'firmado']),
            'avisado' => $this->faker->boolean(40),
            'horario' => $this->faker->text(50),
            'horas_totales' => $this->faker->numberBetween(100, 400),
            'grupo' => $this->faker->randomElement(['A', 'B']),
            'curso' => '2025/2026',
            'ano' => 2026,
        ];
    }
}
