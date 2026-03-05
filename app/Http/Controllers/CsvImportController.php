<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\TutorDual;
use App\Models\Responsable;
use Illuminate\Support\Facades\Validator;

class CsvImportController extends Controller
{
    public function showForm()
    {
        return view('csv-import');
    }

    public function importAlumnos(Request $request)
    {
        return $this->processCsv($request, Alumno::class , [
            'nombre', 'apellidos', 'fecha_nacimiento', 'curso', 'grupo', 'direccion', 'telefono', 'email'
        ]);
    }

    public function importEmpresas(Request $request)
    {
        return $this->processCsv($request, Empresa::class , [
            'razon_social', 'cif', 'direccion', 'poblacion', 'email', 'campo_laboral'
        ]);
    }

    public function importTutores(Request $request)
    {
        return $this->processCsv($request, TutorDual::class , [
            'dni', 'nombre', 'apellidos', 'email', 'telefono', 'ciclo'
        ]);
    }

    public function importResponsables(Request $request)
    {
        return $this->processCsv($request, Responsable::class , [
            'dni', 'nombre', 'apellidos', 'email', 'telefono', 'cargo'
        ]);
    }

    private function processCsv(Request $request, $model, $fields)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle); // Assuming first row is header

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) < count($fields)) {
                continue; // Skip malformed rows
            }
            $data = array_combine($fields, array_slice($row, 0, count($fields)));

            // Default values for missing critical fields
            if ($model === Empresa::class && !isset($data['ciclos'])) {
                $data['ciclos'] = [];
            }

            $model::create($data);
        }

        fclose($handle);

        return back()->with('success', 'Datos importados correctamente.');
    }
}
