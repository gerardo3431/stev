<?php

namespace App\Helpers;

use App\Models\Caja;
use App\Models\Doctores;
use App\Models\Pago;
use App\Models\Recepcions;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Milon\Barcode\DNS1D;
use Milon\Barcode\Facades\DNS2DFacade;

use function PHPUnit\Framework\isEmpty;

class PaymentHelper
{
    public static function payment(Request $request, Caja $caja, User $user){
        $folio          = Recepcions::where('id', $request->folio)->first();
        $laboratorio    = $user->labs()->first();
        $sucursal       = $user->sucs()->where('estatus', 'activa')->first();
        $new_total      = min($request->total, $request->subtotal);
        
        $pago = DB::transaction(function () use ($request, $new_total) {
            return Pago::create([
                'descripcion'       => 'Análisis de laboratorio',
                'importe'           => $new_total,
                'tipo_movimiento'   => 'ingreso',
                'metodo_pago'       => $request->metodo,
                'observaciones'     => $request->observaciones,
            ]);

        });

        if($caja && $pago){
            // Pagos has cajas
            $caja->pagos()->save($pago);
            // pagos has folios (recepcions)
            $folio->pago()->save($pago);
            // Pagos_has_user
            $user->pago()->save($pago);
            // Pagos_has_subsidiaries
            $sucursal->pago()->save($pago);
        }else{
            return false;
        }

        return $pago;
    }
}