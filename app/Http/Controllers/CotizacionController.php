<?php

namespace App\Http\Controllers;

use App\Models\Empresas;
use App\Models\Estudio;
use App\Models\Picture;
use App\Models\Profile;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Precios;

use function PHPUnit\Framework\isEmpty;

class CotizacionController extends Controller
{
    public function cotizacion_index(Request $request){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        $listas = User::where('id', Auth::user()->id)->first()->sucursal()->first()->folios()->get();


        $empresas = User::where('id', Auth::user()->id)->first()->labs()->first()->empresas()->get();
        $estudios = User::where('id', Auth::user()->id)->first()->labs()->first()->estudios()->get();



        return view('recepcion.cotizacion.index',
        ['active'=>$active,'sucursales'=>$sucursales, 'empresas' => $empresas, 'estudios' => $estudios]);


    }

    public function cotizacion_pdf(Request $request){
        // dd($request);

        $nombre = $request->only('nombre');
        $empresa = $request->only('empresa');
        $observaciones = $request->only('observaciones');
        $estudios = $request->only('estudios');
        $total =  $request->only('total');


        $usuario        = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $usuario->labs()->first();
        $logotipo       = base64_encode(Storage::disk('public')->get($laboratorio->logotipo));
        $memb = "data:image/jpeg;base64," . base64_encode(Storage::disk('public')->get($laboratorio->membrete));

        $empresa = Empresas::where('id', $empresa['empresa'])->first();
        $lista = $empresa->precio()->first();

        $claves = array_column($estudios['estudios'], 'clave');
        $estudios_listas = $lista->lista()->whereIn('clave', $claves)->get();
        foreach ($estudios_listas as $key => $estudio) {
            $query = Estudio::where('clave', $estudio->clave)->first();
            $estudio->dias_proceso = isset($query->dias_proceso) ? $query->dias_proceso : '.';
            $estudio->condiciones = isset($query->condiciones) ? $query->condiciones : '.';
        }

        switch ($request->formato) {
            case 'hoja':
                $pdf = Pdf::loadView('invoices.cotizacion.cotizacion', [
                        'membrete'          => $memb ,
                        'fondo'             => 'si',
                        'empresa'           => $empresa,
                        'paciente'          => $nombre,
                        'estudios'          => $estudios_listas,
                        'total'             => $total, 
                        'observaciones'     => $observaciones, 
                        'laboratorio'       => $laboratorio,
                        'logotipo'          => $logotipo
                    ]);
        
                $pdf->setPaper('letter', 'portrait' );    

                break;
            case 'ticket':
                $pdf = Pdf::loadView('invoices.cotizacion.cotizacion-ticket', [
                        'membrete'          => $memb ,
                        'fondo'             => 'si',
                        'empresa'           => $empresa,
                        'paciente'          => $nombre,
                        'estudios'          => $estudios_listas,
                        'total'             => $total, 
                        'observaciones'     => $observaciones, 
                        'laboratorio'       => $laboratorio,
                        'logotipo'          => $logotipo
                        
                    ]);
                $ancho = (8 / 2.54) * 72;
                $pdf->setPaper(array(0, 0, $ancho, 1000),  'portrait'); 
                break;
            default:
                # code...
                // dd('nothing');
                break;
        }
        //Configurame el formato de hoja, es lo unico que te faltaria, en esta parte, acomoda los datos en el pdf.

        $date= Date('dmys');
        $path = 'public/cotizaciones/F-'.$date.'.pdf';
        $pathSave = Storage::put($path, $pdf->output());
        $request = ['pdf' => '/public/storage/cotizaciones/F-'.$date.'.pdf'];

        return $request;

    }

    public function cotizacion_whatsapp(Request $request){
        $nombre = $request->only('nombre');
        $empresa = $request->only('empresa');
        $estudios = $request->only('estudios');
        $perfiles = $request->only('perfiles');
        $pictures = $request->only('img');
        $number = $request->only('telefono'); 
        $total = $request->only('total');
        $observaciones = $request->only('observaciones');

        $laboratorio = User::where('id', Auth::user()->id)->first()->laboratorio()->first();
        $lista_estudios = '';
        $lista_perfiles = '';
        $lista_img = '';
        if(isEmpty($estudios['estudios'])){
            foreach ($estudios['estudios'] as $key => $estudio) {
                switch ($estudio['tipo']) {
                    case 'Estudio':
                        # code...
                        $consulta  = Estudio::where('clave', $estudio['clave'])->first()->condiciones;

                        break;
                    
                    case "Perfil":
                        $consulta  = Profile::where('clave', $estudio['clave'])->first()->observaciones;

                        break;
                    case "Imagenologia":
                        $consulta  = Estudio::where('clave', $estudio['clave'])->first()->condiciones;
                        break;
                    default:
                        # code...
                        break;
                }
                $condicion = ($consulta == null) ? 'Sin condición' : $consulta;
                $lista_estudios .= "*". $estudio['descripcion'] . "*\n" . $condicion . "\nPrecio: *$" . $estudio['costo'] . "*\n\n"; 
            }
        }else{
        }
        
        // dd($lista_estudios);
        
        if(isEmpty($perfiles['perfiles'])){
            foreach ($perfiles['perfiles'] as $key => $perfil) {
                $consulta = Profile::where('clave', $perfil['clave'])->first()->observaciones;
                $condicion = ($consulta == null) ? 'Sin condición' : $consulta;
                $lista_perfiles .= "*". $perfil['descripcion'] . "*\n" . $condicion . "\nPrecio: *$" . $perfil['costo'] . "*\n\n"; 
            }
        }else{
        }

        if(isEmpty($pictures['img'])){
            foreach ($pictures['img'] as $key => $img) {
                $consulta = Picture::where('clave', $img['clave'])->first()->condiciones;
                $condicion = ($consulta == null) ? 'Sin condición' : $consulta;
                $lista_img .= "*". $img['descripcion'] . "*\n" . $condicion . "\nPrecio: *$" . $img['costo'] . "*\n\n"; 
            }
        }else{
        }

        $mensaje = 'Hola estimado(a) ' . $nombre['nombre'] . ', *' . $laboratorio->nombre . '* le envia su cotización :' . "\n\n" . $lista_estudios . $lista_perfiles . $lista_img . 'Con un costo total de: ' . $total['total'] . "\nObservaciones anexas: *" . $observaciones['observaciones'] . "*\nSin más por el momento, quedamos a sus ordenes." ;
        $request['url'] = 'https://api.whatsapp.com/send?phone=' . $number['telefono'] . '&text=' . urlencode($mensaje);
        return $request;

    }


    
}























  /*



$dompdf = new Dompdf();
$html = '<h1>Hola</h1>';



  

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');

$dompdf->render();
$dompdf->stream("mypdf.pdf", [ "Attachment" => true]);

    $estudios = $request->only('lista');
    $data = $request->only('data');
    $laboratorio = User::Where('id', Auth::user()->id)->first()->labs()->first();

    $estudios = [];

    foreach ($estudios as $key => $value) {
        foreach($value as $id => $valor){
            $estudio =  Estudio::where('clave', $valor)->first();
            // Aqui solo estas sobreescribiendo el resultado, en el resultado solo te dara al ultimo estudio en la lista
        }
        dd($estudios);
        # code...
       // Recepcions has estudios

    }

    // recepcion has estudios
    // Que pedo con esto? ya no lo ocupas
    if($laboratorio) {
        $response = true;
    } else {
        $response = false;
    }

// Porque asi? por eso la vista esta toda culeibuenii dimer como es porfavor
    $data = [
        'nombre' => $request->nombre,
        'data'  => date('d/m/y'),
        'empresa' => $request->id_empresa,
        'observaciones' => $request->observaciones,
        'listEstudio' => $request->listEstudio //aqui estas llamando a la nada, porque estoy casi seguro que request no tiene listestudio
    
    ];
    // Compadre, hagase la suicidacion
    $pdf = PDF::loadView('recepcion.cotizacion.pdf', $data);
    
    return $pdf->stream();
    
    //return view('recepcion.cotizacion.prueba', $data); 
*/