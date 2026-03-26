<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acuerdo extends Model
{
    use HasFactory;
    protected $fillable = [
        'alumno_id', 'empresa_id', 'contacto_empresa_id', 'tutor_dual_id', 'representante_id', 'localidad',
        'nombre_acuerdo', 'estado_id', 'horario', 'horas_totales',
        'grupo', 'curso', 'ciclo', 'ano_academico',
    ];

    public function estado()
    {
        return $this->belongsTo(EstadoAcuerdo::class , 'estado_id');
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function contactoEmpresa()
    {
        return $this->belongsTo(ContactoEmpresa::class , 'contacto_empresa_id');
    }

    public function tutorDual()
    {
        return $this->belongsTo(TutorDual::class);
    }

    public function representante()
    {
        return $this->belongsTo(ContactoEmpresa::class , 'representante_id');
    }
}
