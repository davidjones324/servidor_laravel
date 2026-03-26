<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $fillable = [
        'razon_social', 'cif', 'direccion', 'poblacion', 'email', 'telefono',
        'observaciones', 'horario', 'ciclos'
    ];

    protected $casts = [
        'ciclos' => 'array',
    ];

    public function contactos()
    {
        return $this->hasMany(ContactoEmpresa::class);
    }

    public function tutorLaboralFct()
    {
        return $this->hasOne(ContactoEmpresa::class)
            ->where('es_tutor_laboral_fct', true);
    }

    public function acuerdos()
    {
        return $this->hasMany(Acuerdo::class);
    }
}
