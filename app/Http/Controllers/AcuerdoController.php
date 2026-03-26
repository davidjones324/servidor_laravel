<?php

namespace App\Http\Controllers;

use App\Models\Acuerdo;
use App\Models\Alumno;
use App\Models\Empresa;
use App\Models\TutorDual;
use App\Models\ContactoEmpresa;
use App\Models\EstadoAcuerdo;
use Illuminate\Http\Request;

class AcuerdoController extends Controller
{
    public function index(Request $request)
    {
        $query = Acuerdo::with(['alumno', 'empresa', 'tutorDual', 'representante', 'contactoEmpresa', 'estado']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('empresa', function ($sq) use ($search) {
                $sq->where('razon_social', 'LIKE', $search . '%');
            });
        }

        if ($request->filled('estado_id')) {
            $query->where('estado_id', $request->input('estado_id'));
        }

        if ($request->filled('ano_academico')) {
            $query->where('ano_academico', 'LIKE', $request->input('ano_academico') . '%');
        }

        if ($request->filled('curso')) {
            $query->where('curso', $request->input('curso'));
        }

        if ($request->filled('grupo')) {
            $query->where('grupo', $request->input('grupo'));
        }

        $acuerdos = $query->latest()->paginate(10)->withQueryString();
        $estados = EstadoAcuerdo::all();

        return view('acuerdos.index', compact('acuerdos', 'estados'));
    }

    public function create()
    {
        $alumnos = Alumno::with('matriculas')->get();
        $empresas = Empresa::with('contactos')->get();
        $tutores = TutorDual::all();
        $estados = EstadoAcuerdo::all();
        return view('acuerdos.create', compact('alumnos', 'empresas', 'tutores', 'estados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'empresa_id' => 'required|exists:empresas,id',
            'contacto_empresa_id' => 'nullable|exists:contacto_empresas,id',
            'tutor_dual_id' => 'required|exists:tutor_duals,id',
            'representante_id' => 'nullable|exists:contacto_empresas,id',
            'localidad' => 'required|string|max:150',
            'nombre_acuerdo' => 'required|string|max:255',
            'estado_id' => 'required|exists:estado_acuerdos,id',
            'horario' => 'nullable|string',
            'horas_totales' => 'required|integer',
            'grupo' => 'required|string|max:20',
            'curso' => 'required|string|max:20',
            'ciclo' => 'required|string|max:255',
            'ano_academico' => 'required|string|max:20',
            'tiene_seguro' => 'nullable|boolean',
        ]);

        $validated['tiene_seguro'] = $request->has('tiene_seguro');

        Acuerdo::create($validated);

        // Actualizar datos del alumno (NSS y Seguro Escolar)
        if ($request->filled('alumno_id')) {
            $alumno = Alumno::find($request->alumno_id);
            if ($alumno) {
                $alumno->update([
                    'numero_ss' => $request->input('numero_ss'),
                    'seguro_escolar' => $request->has('tiene_seguro') ? 1 : 0
                ]);
            }
        }

        return redirect()->route('acuerdos.index')->with('success', 'Acuerdo creado correctamente.');
    }

    public function show(Acuerdo $acuerdo)
    {
        $acuerdo->load(['alumno', 'empresa', 'tutorDual', 'representante', 'contactoEmpresa', 'estado']);
        return view('acuerdos.show', compact('acuerdo'));
    }

    public function edit(Acuerdo $acuerdo)
    {
        $alumnos = Alumno::with('matriculas')->get();
        $empresas = Empresa::with('contactos')->get();
        $tutores = TutorDual::all();
        $estados = EstadoAcuerdo::all();
        return view('acuerdos.edit', compact('acuerdo', 'alumnos', 'empresas', 'tutores', 'estados'));
    }

    public function update(Request $request, Acuerdo $acuerdo)
    {
        $validated = $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'empresa_id' => 'required|exists:empresas,id',
            'contacto_empresa_id' => 'nullable|exists:contacto_empresas,id',
            'tutor_dual_id' => 'required|exists:tutor_duals,id',
            'representante_id' => 'nullable|exists:contacto_empresas,id',
            'localidad' => 'required|string|max:150',
            'nombre_acuerdo' => 'required|string|max:255',
            'estado_id' => 'required|exists:estado_acuerdos,id',
            'horario' => 'nullable|string',
            'horas_totales' => 'required|integer',
            'grupo' => 'required|string|max:20',
            'curso' => 'required|string|max:20',
            'ciclo' => 'required|string|max:255',
            'ano_academico' => 'required|string|max:20',
            'tiene_seguro' => 'nullable|boolean',
        ]);

        $validated['tiene_seguro'] = $request->has('tiene_seguro');

        $acuerdo->update($validated);

        // Actualizar datos del alumno (NSS y Seguro Escolar)
        if ($request->filled('alumno_id')) {
            $alumno = Alumno::find($request->alumno_id);
            if ($alumno) {
                $alumno->update([
                    'numero_ss' => $request->input('numero_ss'),
                    'seguro_escolar' => $request->has('tiene_seguro') ? 1 : 0
                ]);
            }
        }

        return redirect()->route('acuerdos.index')->with('success', 'Acuerdo actualizado correctamente.');
    }

    public function destroy(Acuerdo $acuerdo)
    {
        $acuerdo->delete();
        return redirect()->route('acuerdos.index')->with('success', 'Acuerdo eliminado correctamente.');
    }
}
