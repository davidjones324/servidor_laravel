<?php

namespace App\Http\Controllers;

use App\Models\Matricula;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'ciclo' => 'required|string|max:50',
            'curso' => 'required|string|max:20',
            'grupo' => 'required|string|max:20',
            'anio_academico' => 'required|string|max:20',
        ]);

        Matricula::create($validated);

        return back()->with('success', 'Matrícula añadida al historial correctamente.');
    }

    public function destroy(Matricula $matricula)
    {
        $matricula->delete();
        return back()->with('success', 'Matrícula eliminada del historial.');
    }
}
