<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoNssController extends Controller
{
    /**
     * Actualiza el Número de Seguridad Social (NSS) de un alumno.
     * Diseñado para actualizaciones rápidas desde la vista de Acuerdos.
     */
    public function update(Request $request, Alumno $alumno)
    {
        $validated = $request->validate([
            'numero_ss' => 'required|string|max:20',
        ]);

        $alumno->update([
            'numero_ss' => $validated['numero_ss']
        ]);

        return back()->with('success', 'Número de Seguridad Social actualizado correctamente para ' . $alumno->nombre);
    }
}
