<?php

namespace App\Helpers;

use App\Models\Doctores;
use App\Models\Pago;
use App\Models\Recepcions;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;

class TicketHelper{
    public static function ticket(Request $request, Recepcions $folio, User $user, Pago $pago, $response, $barcode, $qr, $resta){
        $laboratorio    = $user->labs()->first();
        $logotipo       = base64_encode(Storage::disk('public')->get($laboratorio->logotipo));
        $sucursal       = $user->sucs()->where('estatus', 'activa')->first();
        $paciente       = $folio->paciente()->first();
        $edad           = ($paciente->fecha_nacimiento != '' || $paciente->fecha_nacimiento != null) ? Carbon::createFromFormat('d/m/Y', $paciente->fecha_nacimiento)->age : $paciente->edad ;
        $doctor         = Doctores::where('id', $folio->id_doctor)->first();
        

        $medida = ($request->ancho / 2.54) * 72;

        if($request->factura == 'ticket'){
            $tipo = 'invoices.ticket.ticket';
        }else{
            $tipo = 'invoices.ticket.ticket-letter';
        }

        $pdf        = Pdf::loadView($tipo, [
            'ancho'         => $request->ancho,
            'logotipo'      => $logotipo,
            'logo'          => $logotipo,
            'laboratorio'   => $laboratorio,
            'folios'        => $folio,
            'paciente'      => $paciente,
            'edad'          => $edad,
            'doctor'        => $doctor,
            'usuario'       => $user,
            'estudios'      => $response,
            'pago'          => $pago,
            'barcode'       => $barcode,
            'sucursal'      => $sucursal,
            'logo'          => $logotipo,
            'qr'            => $qr,
            'resta'         => $resta,
            'descuento'     => $request->descuento,
            'subtotal'      => $request->subtotal,
        ]);

        if($request->factura == 'ticket'){
            $pdf->setPaper(array(0,0, $medida ,700), 'portrait');
        }else{
            $pdf->setPaper('letter', 'portrait');
        }

        $path           = 'public/tickets/F-'. $folio->folio . '.pdf';
        $pathSave       = Storage::put($path, $pdf->output());

        return true;
    }
}