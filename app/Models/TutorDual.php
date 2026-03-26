<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorDual extends Model
{
    use HasFactory;
    protected $fillable = [
        'dni', 'nombre', 'apellidos', 'email', 'telefono', 'ciclos', 'cursos', 'grupo', 'grupos'
    ];

    protected $casts = [
        'ciclos' => 'array',
        'cursos' => 'array',
        'grupos' => 'array',
    ];

    public function acuerdos()
    {
        return $this->hasMany(Acuerdo::class);
    }
}
