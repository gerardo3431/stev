<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    protected $fillable = [
        'clave',
        'clave_salud',
        'codigo_barras',
        'nombre',
        'nombre_corto',
        'tipo_material',
        'unidad',
        'pieza',
        'cantidad',
        'referencia',
        'marca',
        'partida',
        'ubicacion',
        'presentacion',
        'familia',
        'ultimo_precio',
        'caducidad',
        'lote',
        'min_stock',
        'max_stock',
        'punto_reorden',
        'observaciones',
    ];
    
    use HasFactory;

    
}
