<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    protected $fillable = [
        'descripcion',
        'observaciones',
    ];

    use HasFactory;

    use SoftDeletes;

    // Recepcions_has_areas
    public function recepcions(){
        return $this->belongsToMany(Recepcions::class, 'recepcions_has_areas');
    }

    // public function recepcions(){
    //     return $this->belongsToMany(Recepcions::class, 'recepcions_has_estudios')->withPivot('estudio_id');
    // }

    // public function estudio(){
    //     return $this->belongsToMany(Estudio::class, 'recepcions_has_estudios')->withPivot('recepcions_id');
    // }
    
    // laboratorios que crearon areas de estudio
    public function laboratorios(){
        return $this->belongsToMany(Laboratory::class, 'areas_has_laboratories');
    }

    // area_has_estudio
    public function estudios(){
        return $this->belongsToMany(Estudio::class,  'areas_has_estudios');
    }
}
