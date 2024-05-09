<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    protected $fillable = [
        'folio',
        'observaciones',
        'tipo',
        'solicitud',
        'status',
        'requested_id',
    ];
    
    use HasFactory;

    public function inventories(){
        return $this->belongsToMany(Inventories::class, 'inventories_has_requests')->withPivot('cantidad');
    }
}
