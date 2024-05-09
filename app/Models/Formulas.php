<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulas extends Model
{
    protected $fillable = [
        'formula',
    ];
    
    use HasFactory;

    public function estudio(){
        return $this->belongsToMany(Estudio::class, 'formulas_has_estudios');
    }
}
