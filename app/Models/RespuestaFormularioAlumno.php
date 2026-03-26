<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaFormularioAlumno extends Model
{
    use HasFactory;

    protected $table = 'respuestas_formulario_alumnos';

    protected $fillable = [
        'alumno_id',
        'interes_practicas', 'interes_seguir_estudiando', 'interes_quedarse_empresa',
        'interes_compartir_empresa', 'miedo_practicas', 'actitud_practicas',
        'tiene_empresa_pensada', 'empresa_pensada_nombre', 'empresa_pensada_localidad',
        'empresa_pensada_telefono', 'empresa_pensada_contacto',
        'otras_empresas_interes', 'observaciones_empresas',
        'desplazamiento', 'observaciones_desplazamiento', 'ciclo_distinto',
        'ha_hecho_fct_antes', 'empresa_fct_anterior', 'poblacion_fct_anterior',
        'empresa_destino_practicas', 'segunda_residencia',
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
