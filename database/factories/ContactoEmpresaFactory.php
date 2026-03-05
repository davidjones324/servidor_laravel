<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactoEmpresa>
 */
class ContactoEmpresaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'empresa_id' => \App\Models\Empresa::factory(),
            'dni' => $this->faker->bothify('#########?'),
            'nombre' => $this->faker->firstName(),
            'apellidos' => $this->faker->lastName(),
            'correo' => $this->faker->email(),
            'telefono' => $this->faker->phoneNumber(),
            'puesto' => $this->faker->jobTitle(),
            'es_tutor_laboral_fct' => $this->faker->boolean(30),
        ];
    }
}
