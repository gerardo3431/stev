<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retiro extends Model
{
    protected $fillable = [
        'cantidad',
        'fecha',
    ];
    use HasFactory;

    // Retiros_has_cajas
    // Retiros_has_cajas
    public function cajas(){
        return $this->belongsToMany(Caja::class, 'retiros_has_cajas')->withPivot('user_id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'retiros_has_cajas')->withPivot('caja_id');
    }
}
