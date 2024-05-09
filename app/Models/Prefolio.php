<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefolio extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'prefolio',
        'nombre',
        'observaciones',
        'doctor',
        'estado',
    ];

    // Prefolios
    public function laboratorie(){
        return $this->belongsToMany(Laboratory::class,'prefolios_has_laboratories')->withPivot('user_id');
    }

    public function user(){
        return $this->belongsToMany(User::class, 'prefolios_has_laboratories')->withPivot('laboratory_id');
    }

    // Estudios
    public function estudios(){
        return $this->belongsToMany(Lista::class, 'prefolios_has_listas');
    }

    // Prefolios has recepcions
    public function folio(){
        return $this->belongsToMany(Recepcions::class, 'prefolios_has_recepcions');
    }

}
