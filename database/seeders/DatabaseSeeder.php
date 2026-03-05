<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a professor user for testing
        \App\Models\User::factory()->create([
            'name' => 'Profesor de Prueba',
            'email' => 'profesor@test.com',
            'password' => bcrypt('password'),
            'role' => \App\Models\User::ROLE_PROFESOR,
        ]);

        // Create an alumno user with his alumno record
        $alumnoUser = \App\Models\User::factory()->create([
            'name' => 'Alumno de Prueba',
            'email' => 'alumno@test.com',
            'password' => bcrypt('password'),
            'role' => \App\Models\User::ROLE_ALUMNO,
        ]);

        $alumno = \App\Models\Alumno::factory()->create([
            'user_id' => $alumnoUser->id,
            'email' => $alumnoUser->email,
            'nombre' => $alumnoUser->name,
        ]);

        // Create form response for the test alumno
        \App\Models\RespuestaFormularioAlumno::factory()->create([
            'alumno_id' => $alumno->id,
        ]);

        // Create more data
        $empresas = \App\Models\Empresa::factory(10)->create();

        // Create contactos for some empresas (with some FCT tutors)
        foreach ($empresas->take(5) as $empresa) {
            \App\Models\ContactoEmpresa::factory()->create([
                'empresa_id' => $empresa->id,
                'es_tutor_laboral_fct' => true,
            ]);
        }

        \App\Models\TutorDual::factory(5)->create();
        \App\Models\Coordinador::factory(3)->create();
        \App\Models\Acuerdo::factory(20)->create();
    }
}
