<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $fillable = [
        'descripcion',
        'observaciones',
    ];
    
    use HasFactory;

    public function laboratorios(){
        return $this->belongsToMany(Laboratory::class, 'equipos_has_laboratories');
    }
}
