<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Precio extends Model
{
    use HasFactory;
    use SoftDeletes;

    
    protected $fillable = [
        'descripcion',
        'descuento',
    ];

    // Estudios has precios 
    public function estudios(){
        return $this->belongsToMany(Estudio::class, 'estudios_has_precios');
    }
    // Profiles has precios
    public function profiles(){
        return $this->belongsToMany(Profile::class, 'profiles_has_precios');
    }

    // Precios has laboratories
    public function laboratorios(){
        return $this->belongsToMany(Laboratory::class, 'precios_has_laboratories');
    }


    // Empresas has precios
    public function empresa(){
        return $this->belongsToMany(Empresas::class, 'empresas_has_precios');
    }

    // Listas has precios
    public function lista(){
        return $this->belongsToMany(Lista::class, 'precios_has_listas');
    }

    // public function recepcions(){
    //     return $this->belongsToMany(Recepcions::class,'recepcions_has_precios')->withPivot('lista_id');
    // }

    // public function listas(){
    //     return $this->belongsToMany(Lista::class,'recepcions_has_precios')->withPivot('recepcions_id');
    // }
}
