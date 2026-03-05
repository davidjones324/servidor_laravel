<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RespuestaFormularioAlumno>
 */
class RespuestaFormularioAlumnoFactory extends Factory
{
    protected $model = \App\Models\RespuestaFormularioAlumno::class;

    public function definition(): array
    {
        $nivelesInteres = ['mucho', 'normal', 'poco', 'muy_poco'];
        $tieneEmpresa = $this->faker->randomElement(['si', 'no', 'si_sin_contacto']);

        return [
            'alumno_id' => \App\Models\Alumno::factory(),
            'interes_practicas' => $this->faker->randomElement($nivelesInteres),
            'interes_seguir_estudiando' => $this->faker->randomElement($nivelesInteres),
            'interes_quedarse_empresa' => $this->faker->randomElement($nivelesInteres),
            'interes_compartir_empresa' => $this->faker->randomElement($nivelesInteres),
            'miedo_practicas' => $this->faker->randomElement($nivelesInteres),
            'actitud_practicas' => $this->faker->randomElement($nivelesInteres),
            'tiene_empresa_pensada' => $tieneEmpresa,
            'empresa_pensada_nombre' => $tieneEmpresa === 'si' ? $this->faker->company() : null,
            'empresa_pensada_localidad' => $tieneEmpresa === 'si' ? $this->faker->city() : null,
            'empresa_pensada_telefono' => $tieneEmpresa === 'si' ? $this->faker->phoneNumber() : null,
            'empresa_pensada_contacto' => $tieneEmpresa === 'si' ? $this->faker->name() : null,
            'otras_empresas_interes' => $this->faker->optional()->sentence(),
            'observaciones_empresas' => $this->faker->optional()->sentence(),
        ];
    }
}
