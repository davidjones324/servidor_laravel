<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::user()->isProfesor()) {
        return view('profesor.dashboard');
    }
    return view('alumno.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:profesor'])->group(function () {
    Route::resource('alumnos', \App\Http\Controllers\AlumnoController::class);
    Route::resource('empresas', \App\Http\Controllers\EmpresaController::class);
    Route::resource('tutores', \App\Http\Controllers\TutorDualController::class)->parameters([
        'tutores' => 'tutor'
    ]);
    Route::resource('responsables', \App\Http\Controllers\ResponsableController::class)->parameters([
        'responsables' => 'responsable'
    ]);
    Route::resource('acuerdos', \App\Http\Controllers\AcuerdoController::class);
    Route::resource('contactos', \App\Http\Controllers\ContactoEmpresaController::class);
    Route::get('/import', [\App\Http\Controllers\CsvImportController::class , 'showForm'])->name('import.form');
    Route::post('/import/alumnos', [\App\Http\Controllers\CsvImportController::class , 'importAlumnos'])->name('import.alumnos');
    Route::post('/import/empresas', [\App\Http\Controllers\CsvImportController::class , 'importEmpresas'])->name('import.empresas');
    Route::post('/import/tutores', [\App\Http\Controllers\CsvImportController::class , 'importTutores'])->name('import.tutores');
    Route::post('/import/responsables', [\App\Http\Controllers\CsvImportController::class , 'importResponsables'])->name('import.responsables');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
