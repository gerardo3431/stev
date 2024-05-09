<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deparments extends Model
{
    protected $fillable = [
        'descripcion',
        'observaciones',
    ];

    use HasFactory;

    // Deparments has laboratories
    public function laboratorie(){
        return $this->belongsToMany(Laboratory::class, 'deparments_has_laboratories');
    }

    // Deparments has imagenologia
    public function picture(){
        return $this->belongsToMany(Picture::class, 'pictures_has_deparments');
    }

    // Recepcions has deparments
    public function recepcions(){
        return $this->belongsToMany(Recepcions::class, 'recepcions_has_deparments')->withPivot('picture_id');
    }

    public function pictures(){
        return $this->belongsToMany(Picture::class, 'recepcions_has_deparments')->withPivot('recepcions_id');
    }
}
