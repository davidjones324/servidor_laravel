<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormularioAlumnoController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\TutorDualController;
use App\Http\Controllers\AcuerdoController;
use App\Http\Controllers\ContactoEmpresaController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\CsvImportController;
use App\Http\Controllers\AlumnoRegistrationController;
use App\Http\Controllers\AlumnoNssController;
use App\Http\Controllers\QuickAcuerdoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get("/", function () {
    return view("welcome");
});

Route::get("/dashboard", function () {
    if (Auth::user()->isProfesor()) {
        return view("profesor.dashboard");
    }
    $alumno = Auth::user()->alumno;
    $cuestionario = $alumno?->respuestaFormulario;
    return view("alumno.dashboard", compact("alumno", "cuestionario"));
})->middleware(["auth", "verified"])->name("dashboard");

// Rutas de Alumno
Route::middleware(["auth", "role:alumno"])->group(function () {
    Route::get("/formulario", [FormularioAlumnoController::class, "edit"])->name("formulario.edit");
    Route::put("/formulario", [FormularioAlumnoController::class, "update"])->name("formulario.update");
    Route::get("/registro-alumno", [AlumnoRegistrationController::class, "showForm"])->name("alumno.registro");
    Route::post("/registro-alumno", [AlumnoRegistrationController::class, "store"])->name("alumno.registro.store");
});

// Rutas de Profesor
Route::middleware(["auth", "role:profesor"])->group(function () {
    // Alumnos
    Route::resource("alumnos", AlumnoController::class);
    Route::post("/alumnos/{alumno}/update-nss", [AlumnoNssController::class, "update"])->name("alumnos.updateNss");
    
    // Empresas
    Route::resource("empresas", EmpresaController::class);
    
    // Tutores Duales
    Route::resource("tutores", TutorDualController::class)->parameters(["tutores" => "tutor"]);
    
    // Matrículas (Historial)
    Route::post("/matriculas", [MatriculaController::class, "store"])->name("matriculas.store");
    Route::delete("/matriculas/{matricula}", [MatriculaController::class, "destroy"])->name("matriculas.destroy");
    
    // Creación Rápida de Acuerdos (DataGrid)
    Route::get("/quick-acuerdos/data", [QuickAcuerdoController::class, "getData"])->name("acuerdos.quick.data");
    Route::post("/quick-acuerdos", [QuickAcuerdoController::class, "store"])->name("acuerdos.quick.store");
    
    // Acuerdos
    Route::resource("acuerdos", AcuerdoController::class);
    
    // Contactos
    Route::resource("contactos", ContactoEmpresaController::class);
    
    // Importación CSV
    Route::get("/import", [CsvImportController::class, "showForm"])->name("import.form");
    Route::post("/import/alumnos", [CsvImportController::class, "importAlumnos"])->name("import.alumnos");
    Route::post("/import/empresas", [CsvImportController::class, "importEmpresas"])->name("import.empresas");
    Route::post("/import/tutores", [CsvImportController::class, "importTutores"])->name("import.tutores");
});

// Perfil
Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name("profile.edit");
    Route::patch("/profile", [ProfileController::class, "update"])->name("profile.update");
    Route::delete("/profile", [ProfileController::class, "destroy"])->name("profile.destroy");
});

require __DIR__ . "/auth.php";

Route::post("/alumnos/{alumno}/status", [QuickAcuerdoController::class, "updateAlumnoStatus"])->name("acuerdos.alumno.status");
Route::post("/quick-acuerdos/bulk", [QuickAcuerdoController::class, "bulkStore"])->name("acuerdos.quick.bulk");
Route::get("/alumnos/{alumno}/respuestas", [FormularioAlumnoController::class, "show"])->name("alumnos.respuestas");