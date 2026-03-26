<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoAcuerdo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function acuerdos()
    {
        return $this->hasMany(Acuerdo::class , 'estado_id');
    }
}
