<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre', 'apellidos', 'dni', 'fecha_nacimiento', 'curso', 'grupo',
        'ciclo', 'anio_ciclo', 'direccion', 'domicilio', 'localidad', 'codigo_postal', 'provincia', 'numero_ss', 'seguro_escolar', 'telefono', 'email',
        'carnet_conducir', 'coche_propio', 'transporte',
        'estudios_anteriores', 'practicas_pasadas',
        'ha_realizado_fct_anterior', 'empresa_fct_anterior', 'localidad_fct_anterior',
        'apto_ffoe', 'motivo_exclusion', 'residencia', 'segunda_residencia', 'observaciones', 'user_id',
    ];

    protected $casts = [
        'carnet_conducir' => 'boolean',
        'coche_propio' => 'boolean',
        'apto_ffoe' => 'boolean',
        'ha_realizado_fct_anterior' => 'boolean',
        'fecha_nacimiento' => 'date',
        'seguro_escolar' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function acuerdos()
    {
        return $this->hasMany(Acuerdo::class);
    }

    public function respuestaFormulario()
    {
        return $this->hasOne(RespuestaFormularioAlumno::class);
    }

    public function formulario()
    {
        return $this->hasOne(FormularioAlumno::class , 'user_id', 'user_id');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}
