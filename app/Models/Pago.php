<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable=[
        'descripcion',
        'importe',
        'tipo_movimiento',
        'metodo_pago',
        'observaciones',

        'is_factura',
        'razon_social',
        'rfc',
        'domicilio',
        'email',

        'estatus',
    ];

    use HasFactory;

    // Pagos_has_cajas
    public function cajas(){
        return $this->belongsToMany(Caja::class, 'pagos_has_cajas');
    }

    // Pagos_has_recepcions
    public function folio(){
        return $this->belongsToMany(Recepcions::class, 'pagos_has_recepcions');
    }

    // Pagos_has_users
    public function user(){
        return $this->belongsToMany(User::class, 'pagos_has_users');
    }

    // Pagos_has_subsidiaries
    public function sucursal(){
        return $this->belongsToMany(Subsidiary::class, 'pagos_has_subsidiaries');
    }
}
