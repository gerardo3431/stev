<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudio extends Model
{
    protected $fillable = [
        'clave',
        'codigo',
        'descripcion',
        'condiciones',
        'aplicaciones',
        'dias_proceso',
        'precio',
        'valida_qr',
    ];

    use HasFactory;
    use SoftDeletes;


    // Laboratorios del estudio
    public function laboratorios(){
        return $this->belongsToMany(Laboratory::class, 'estudios_has_laboratories');
    }

    // // Guardar estudios con datos de las otras secciones
    public function recipientes(){
        return $this->belongsToMany(Recipiente::class, 'estudios_has_laboratories');
    }
    public function area(){
        return $this->belongsToMany(Area::class, 'estudios_has_laboratories');
    }

    public function muestra(){
        return $this->belongsToMany(Muestra::class, 'estudios_has_laboratories');
    }

    public function metodo(){
        return $this->belongsToMany(Metodo::class, 'estudios_has_laboratories');
    }
    public function tecnica(){
        return $this->belongsToMany(Tecnica::class, 'estudios_has_laboratories');
    }

    // public function laboratorio(){
    //     return $this->belongsToMany(Laboratory::class, 'estudios_has_laboratories')->withPivot();
    // }
    // // 
    // public function area(){
    //     return $this->belongsToMany(Area::class, 'estudios_has_laboratories')->withPivot();
    // }
    // // 
    // public function muestra(){
    //     return $this->belongsToMany(Muestra::class, 'estudios_has_laboratories')->withPivot();
    // }
    // // 
    // public function metodo(){
    //     return $this->belongsToMany(Metodo::class, 'estudios_has_laboratories')->withPivot();
    // }
    // // 
    // public function tecnica(){
    //     return $this->belongsToMany(Tenica::class, 'estudios_has_laboratories')->withPivot();
    // }

    // analitos_has_estudios
    public function analitos(){
        return $this->belongsToMany(Analito::class, 'analitos_has_estudios');
    }


    // Historials has recepcions
    public function recepcion(){
        return $this->belongsToMany(Recepcions::class, 'historials_has_recepcions')->withPivot('historial_id');
    }

    public function historial(){
        return $this->BelongsToMany(Historial::class, 'historials_has_recepcions')->withPivot('recepcions_id');
    }

    // Perfiles has estudios
    public function perfil_perfil(){
        return $this->belongsToMany(Profile::class, 'profiles_has_estudios');
    }

    // areas_has_estudios
    public function areas(){
        return $this->belongsToMany(Area::class, 'areas_has_estudios');
    }


    // Estudios has precios
    public function precios(){
        return $this->belongsToMany(Precio::class, 'estudios_has_precios');
    }


    // Observaciones has estudios
    public function observaciones(){
        return $this->belongsToMany(Observaciones::class, 'observaciones_has_estudios')->withPivot('recepcions_id');
    }

    public function recepcions(){
        return $this->belongsToMany(Recepcions::class, 'observaciones_has_estudios')->withPivot('observaciones_id');
    }

    // Recepcions_has_estudios
    public function recepciones(){
        return $this->belongsToMany(Recepcions::class, 'recepcions_has_estudios');
    }

    // public function areaRecepcion(){
    //     return $this->belongsToMany(Area::class, 'recepcions_has_estudios')->withPivot('recepcions_id');
    // }

    // 

    public function formula(){
        return $this->belongsToMany(Formulas::class, 'formulas_has_estudios');
    }
}
