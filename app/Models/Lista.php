<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Precios;

class Lista extends Model
{
    protected $fillable = [
        'clave',
        'descripcion',
        'tipo',
        'precio',
    ];
    use HasFactory;

    public function precio(){
        return $this->belongsToMany(Precio::class, 'precios_has_listas');
    }


    // Prefolios
    public function prefolio(){
        return $this->BelongsToMany(Prefolio::class, 'prefolios_has_listas');
    }

    // Repceions
    public function recepcions(){
        return $this->belongsToMany(Recepcions::class, 'recepcions_has_precios');
    }

    // public function precios(){
    //     return $this->belongsToMany(Precios::class, 'recepcions_has_precios')->withPivot('recepcions_id');
    // }
}