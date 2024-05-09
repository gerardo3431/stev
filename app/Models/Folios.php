<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folios extends Model
{
    protected $fillable = [
        'folio',
        'estatus',
    ];
    use HasFactory;

    // Mutator
    // public function setFolioAttribute($value){
    //     $this->attributes['folio'] = 
    // }


    // Funcion
    public function laboratorio(){
        return $this->belongsToMany(Laboratory::class, 'folios_has_laboratories');
    }
}
