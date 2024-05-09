<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paquetes extends Model
{
    protected $fillable=[
        'paquete',
    ];
    
    use HasFactory;

    public function laboratorios(){
        return $this->belongsToMany(Laboratory::class, 'laboratories_has_paquetes');
    }
}
