<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\TutorDual;
use Illuminate\Support\Facades\Validator;

class CsvImportController extends Controller
{
    public function showForm()
    {
        return view('csv-import');
    }

    public function importAlumnos(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');

        // Leer cabeceras del CSV
        $headers = fgetcsv($handle, 0, ';');
        $headers = array_map('trim', $headers);

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            if (count($headers) !== count($row))
                continue;

            $data = array_combine($headers, $row);

            // Conversión de fecha de nacimiento (Séneca: dd/mm/yyyy -> DB: yyyy-mm-dd)
            $fechaNacimiento = null;
            if (!empty($data['Fecha nacimiento'])) {
                try {
                    $fechaNacimiento = \Carbon\Carbon::createFromFormat('d/m/Y', $data['Fecha nacimiento'])->format('Y-m-d');
                }
                catch (\Exception $e) {
                    $fechaNacimiento = null;
                }
            }

            // Mapeo CSV → Base de datos (Solo campos necesarios)
            $mapped = [
                'nombre' => $data['Nombre'] ?? null,
                'apellidos' => trim(($data['Primer apellido'] ?? '') . ' ' . ($data['Segundo apellido'] ?? '')),
                'dni' => $data['DNI'] ?? null,
                'fecha_nacimiento' => $fechaNacimiento,
                'curso' => $data['Curso'] ?? null,
                'grupo' => $data['Grupo'] ?? null,
                'direccion' => $data['Dirección'] ?? null,
                'telefono' => $data['Teléfono'] ?? null,
                'email' => $data['Email'] ?? null,
                'localidad' => $data['Localidad'] ?? null,
                'codigo_postal' => $data['Código postal'] ?? null,
                'provincia' => $data['Provincia'] ?? null,
            ];

            // Crear o actualizar por DNI
            if ($mapped['dni']) {
                Alumno::updateOrCreate(
                ['dni' => $mapped['dni']],
                    $mapped
                );
            }
        }

        fclose($handle);

        return back()->with('success', 'Alumnos importados correctamente con filtrado de Séneca.');
    }


    public function importEmpresas(Request $request)
    {
        return $this->processCsv($request, Empresa::class , [
            'razon_social', 'cif', 'direccion', 'poblacion', 'email', 'campo_laboral'
        ]);
    }

    public function importTutores(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');

        $headers = fgetcsv($handle, 0, ';');
        $headers = array_map('trim', $headers);

        while (($row = fgetcsv($handle, 0, ';')) !== false) {
            if (count($headers) !== count($row))
                continue;

            $data = array_combine($headers, $row);

            // Intentar separar Apellidos y Nombre si vienen en un solo campo (Séneca profesores)
            $nombre = $data['Empleado/a'] ?? null;
            $apellidos = null;
            if (str_contains($nombre, ',')) {
                $parts = explode(',', $nombre);
                $apellidos = trim($parts[0]);
                $nombre = trim($parts[1]);
            }

            // Mapeo CSV → Base de datos
            $mapped = [
                'dni' => $data['DNI/Pasaporte'] ?? null,
                'nombre' => $nombre,
                'apellidos' => $apellidos,
                'email' => $data['Cuenta Google/Microsoft'] ?? null,
                'telefono' => $data['Teléfono'] ?? null,
                'ciclos' => $data['Puesto'] ? [$data['Puesto']] : [],
                'cursos' => [], // Campo nuevo, inicializado vacío
            ];

            if ($mapped['dni']) {
                TutorDual::updateOrCreate(
                ['dni' => $mapped['dni']],
                    $mapped
                );
            }
        }

        fclose($handle);

        return back()->with('success', 'Profesores importados correctamente ajustados al nuevo sistema.');
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
