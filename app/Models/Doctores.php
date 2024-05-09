<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctores extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $fillable = [
        'clave',
        'nombre',
        'telefono',
        'celular',
        'email',
    ];

    
    public function laboratory(){
        return $this->belongsToMany(Laboratory::class, 'doctores_has_laboratories');
    }       
    
    public function user(){
        return $this->belongsToMany(User::class, 'doctores_has_users');
    }
}
