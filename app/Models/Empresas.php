<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresas extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $fillable = ['clave',
                        'descripcion',
                        'calle',
                        'colonia',
                        'ciudad',
                        'telefono',
                        'rfc',
                        'email',
                        'contacto',
                    ];


    public function recepcions(){
        return $this->hasMany(Recepcions::class, 'id'); 
    }
    
    public function laboratory(){
        return $this->belongsToMany(Laboratory::class, 'empresas_has_laboratories');
    }
    public function pacientes(){
        return $this->hasMany(Pacientes::class, 'id'); 
    }                    

    // Empresas has precios
    public function precio(){
        return $this->belongsToMany(Precio::class, 'empresas_has_precios');
    }

    // Empresas has users
    public function users(){
        return $this->belongsToMany(User::class, 'empresas_has_users');
    }
}
