<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    protected $fillable = [
        'clave',
        'codigo',
        'descripcion',
        'observaciones',
        'precio'
    ];
    use HasFactory;
    use SoftDeletes;

    // perfiles has estudios
    public function perfil_estudio(){
        return $this->belongsToMany(Estudio::class,'profiles_has_estudios');
    }

    // Perfiles has laboratories
    public function laboratorios(){
        return $this->belongsToMany(Laboratory::class, 'profiles_has_laboratories');
    }

    // Perfiles has recepcions (perfiles asignados a los folios de recepcion)
    public function recepcion_profiles(){
        return $this->belongsToMany(Recepcions::class, 'recepcions_has_profiles');
    }

    // Perfiles tienene precios
    public function precios(){
        return $this->belongsToMany(Precio::class, 'profiles_has_precios');
    }
}
