<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventories extends Model
{
    protected $fillable=[
        'ubicacion',
        'folio',
        'clave',
        'descripcion',
        'cantidad',
        'lote',
        'caducidad',
        'existencia'
    ];
    
    use HasFactory;

    public function request(){
        return $this->belongsToMany(Requests::class, 'inventories_has_requests')->withPivot('cantidad');
    }
}
