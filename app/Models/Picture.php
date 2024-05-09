<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    protected $fillable = [
        'clave',
        'codigo',
        'descripcion',
        'condiciones',
        'precio',
    ];
    
    use HasFactory;

    public function laboratorio(){
        return $this->belongsToMany(Laboratory::class, 'pictures_has_laboratories');
    }

    // Deparments has imagenologia
    public function deparment(){
        return $this->belongsToMany(Deparments::class, 'pictures_has_deparments');
    }

    // Recepcions has deparments
    public function recepcion(){
        return $this->belongsToMany(Recepcions::class, 'recepcions_has_deparments')->withPivot('deparments_id');
    }

    public function deparments(){
        return $this->belongsToMany(Deparments::class, 'recepcions_has_deparment')->withPivot('recepcions_id');
    }

    // Historial has recepcions
    public function historials(){
        return $this->belongsToMany(Historial::class, 'historials_has_recepcions')->withPivot('recepcions_id');
    }

    public function recepcions(){
        return $this->belongsToMany(Recepcions::class, 'historials_has_recepcions')->withPivot('historial_id');
    }

    // observaciones
    public function analitos(){
        return $this->belongsToMany(Analito::class, 'pictures_has_analitos');
    }
}