<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observaciones extends Model
{
    use HasFactory;

    protected $fillable = [
        'observacion'
    ];


    public function estudio(){
        return $this->belongsToMany(Estudio::class, 'observaciones_has_estudios')->withPivot('recepcions_id');
    }

    public function recepcions(){
        return $this->belongsToMany(Recepcions::class, 'observaciones_has_estudios')->withPivot('estudio_id');
    }

    public function comentarios(){
        return $this->belongsToMany(Recepcions::class, 'recepcions_has_observaciones')->withPivot('recepcions_id');

    }
}
