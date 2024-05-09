<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Analito extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'clave',
        'descripcion',
        'bitacora',
        'defecto',
        'unidad',
        'digito',
        'tipo_resultado',
        'valor_referencia',
        'tipo_referencia',
        'tipo_validacion',
        'numero_uno',
        'numero_dos',
        'documento',
        'imagen',
        'valida_qr'
    ];

    use HasFactory;

    public function laboratorios(){
        return $this->belongsToMany(Laboratory::class, 'analitos_has_laboratories');
    }

    // Registra referencia al analito
    public function referencias(){
        return $this->belongsToMany(Referencia::class, 'referencias_has_analitos');
    }

    // analitos_has_estudios
    public function estudios(){
        return $this->belongsToMany(Estudio::class, 'analitos_has_estudios');
    }

    public function pictures(){
        return $this->belongsToMany(Picture::class, 'pictures_has_analitos');
    }
}
