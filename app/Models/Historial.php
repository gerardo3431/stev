<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    protected $fillable = [
        'clave',
        'historial_id',
        'descripcion',
        'valor',
        'estatus',
        'entrega',
        'absoluto',
        'valor_abs'
    ];

    use HasFactory;

    // historial has estudios
    public function recepcions(){
        return $this->belongsToMany(Recepcions::class, 'historials_has_recepcions')->withPivot('estudio_id');
    }

    public function estudios(){
        return $this->belongsToMany(Estudio::class, 'historials_has_recepcions')->withPivot('recepcions_id');
    }

    // 
    public function recepcionsimg(){
        return $this->belongsToMany(Recepcions::class, 'historials_has_recepcions')->withPivot('picture_id');
    }
    public function pictures(){
        return $this->belongsToMany(Picture::class, 'historialas_has_recepcions')->withPivot('recepcions_id');
    }
}
