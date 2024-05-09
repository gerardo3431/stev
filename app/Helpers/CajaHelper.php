<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Caja;

class CajaHelper
{
    public static function verificarCajaAbierta(User $user){
        $caja = $user->caja()->where('estatus', 'abierta')->first();
        
        if ($caja) {
            $fecha_inicial = $caja->created_at;
            $fecha_actual = Carbon::now()->startOfDay();

            if ($fecha_inicial->isBefore($fecha_actual, 'day')) {

                $caja->update(['estatus' => 'cerrada']);

                return 'Caja cerrada perteneciente al día anterior. Cerrando automáticamente.';

            }

        } else {
            return 'Debes aperturar caja antes de empezar a trabajar.';
        }

        return null;
    }
}
