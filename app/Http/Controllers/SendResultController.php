<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\Sender;

class SendResultController extends Controller
{
    
    /** @var Sender */
    private $sender;

    public function __construct(Sender $sender)
    {
        $this->sender = $sender;
    }


    // Envia resultados via whatsapp Api - Twilio
    // public function send_resultados_sms(Request $request){
        
    //     $all_estudios = [];
    //     $date = Date('dmys');

    //     $folio = $request->only('folio');
    //     $membrete = $request->only('membrete');
    //     $estudios = $request->only('estudios');

    //     $usuario = User::where('id', Auth::user()->id)->first();
    //     $laboratorio    = User::where('id', Auth::user()->id)->first()->labs()->first();
    //     $sucursal       = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
    //     $folios         = Recepcions::where('folio', $folio)->first();
    //     $pacientes      = Recepcions::where('folio', $folio)->first()->paciente()->first();
    //         $correo = $pacientes->email;
    //         $edad   = Carbon::parse($pacientes->fecha_nacimiento)->age;

    //     $doctor = Doctores::where('id', $folios->id_doctor)->first();

    //     foreach($estudios['estudios'] as $index=>$estudio){
    //         $all_analitos = [];
    //         $all_estudios[$index] = Estudio::where('clave', $estudio['clave'])->first();

    //         foreach($estudio['analitos'] as $key=>$analito){

    //             $all_analitos[$key]['resultado'] = Historial::where('id', $analito['id'])->where('estatus', 'validado')->first();
    //             $all_analitos[$key]['analito'] = Analito::where('clave', $all_analitos[$key]['resultado']->clave)->first();
    //         }
    //         $all_estudios[$index]['result'] = $all_analitos;
    //     }
    //     // dd($all_estudios);

    //     $logotipo = base64_encode(Storage::disk('public')->get($laboratorio->logotipo));
    //     $barcode        = DNS1D::getBarcodeSVG($folios->folio, 'EAN13');
    //     $memb = "data:image/jpeg;base64," . base64_encode(Storage::disk('public')->get($laboratorio->membrete));

    //     if($membrete['membrete']=='si'){
    //         $pdf = Pdf::loadView('invoices.resultados.invoice-all-resultado-membrete', [
    //             'laboratorio'   => $laboratorio, 
    //             'sucursal'      => $sucursal, 
    //             'doctor'        => $doctor,
    //             'usuario'       => $usuario,
    //             'paciente'      => $pacientes, 
    //             'edad'          => $edad,
    //             'folios'        => $folios,
    //             'resultados'    => $all_estudios,

    //             'logo'          => $logotipo,
    //             'barcode'       => $barcode,

    //             'membrete'      => $memb,
    //                     ]);
    //     }else{
    //         $pdf = Pdf::loadView('invoices.resultados.invoice-all-resultados', [
    //             'laboratorio'   => $laboratorio, 
    //             'sucursal'      => $sucursal, 
    //             'doctor'        => $doctor,
    //             'usuario'       => $usuario,
    //             'paciente'      => $pacientes, 
    //             'edad'          => $edad,
    //             'folios'        => $folios,
    //             'resultados'    => $all_estudios,

    //             'logo'          => $logotipo,
    //             'barcode'       => $barcode,
                
    //                     ]);
    //     }

    //     $pdf->setPaper('letter', 'portrait');
    //     $path = 'public/resultados-completos/F-'.$folio['folio'].'.pdf';
    //     $pathpdf =  url('public/storage/resultados-completos/F-'.$folio['folio'].'.pdf');
    //     $pathSave = Storage::put($path, $pdf->output());
    //     $request = ['pdf' => '/public/storage/resultados-completos/F-'.$folio['folio'].'.pdf'];

    //     // $envio = ProcesaCorreo::dispatch($pathpdf, $correo, $laboratorio, $pacientes)->afterResponse();
        
    //     $message = 'Descargue su archivo haciendo click en el enlace a continuación: ' . $pathpdf;

    //     try {
    //         // $response = $this->sender('+5219931512070' ,$mensaje);
    //         $response = $this->sender->send('whatsapp:+5219931512070' , $message);
    //         // dd($response);
    //     } catch (\Throwable $e) {
    //         dd($e->getMessage());
    //     }
    // }
}
