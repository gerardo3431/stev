<?php

namespace App\Http\Controllers;

use App\Models\Doctores;
use App\Models\Estudio;
use App\Models\Pacientes;
use App\Models\Recepcions;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Milon\Barcode\DNS1D;

use function PHPUnit\Framework\isEmpty;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // return view('auth.login');
        return view('welcome');
    }

    public function resultados(){
        return view('resultados.index');
    }

    public function show_resultados(Request $request){
        $folio = $request->validate([
            'folio' => 'required | numeric | exists:recepcions,folio',
            // 'token' => 'required | exists:recepcions,token',
        ]);
        $token = Recepcions::where('folio', $folio['folio'])->where('token', $request->token)->first();

        $paciente = $token->paciente()->first();
        $otros = $paciente->recepcions()->orderBy('id', 'desc')->get();

        return view('resultados.show')->with(['resultado' => $token, 'otros' => $otros]);
    }

    public function get_resultado(Request $request){
        $dato = $request->id;
        $folio_old = Recepcions::where('id', $dato)->first();
        $verifica = Recepcions::where('id', $dato)->where('estado', 'pagado')->first();
        $capturado = Recepcions::where('id', $dato)->first()->areas()->where('recepcions_has_areas.estatus_area', '=', 'validado')->get();

        // if ($capturado->isEmpty()) {
        //     session()->flash('message', 'Estudios no listos para su entrega a cliente. Por favor reintente mas tarde.');
        //     return redirect()->route('resultados.index');
        // }else{
        //     if($verifica == null){
        //         session()->flash('message', 'Registro no pagado, revise su pago por favor. Parada del sistema, reintente por favor');
        //     }
        // }
        
        if($verifica !=null){
            // if(Storage::exists($analito['imagen'])){
            if(Storage::disk('public')->exists($folio_old->patient_file)){
                return Storage::disk('public')->download($folio_old->patient_file);
            }else{
                session()->flash('message', 'Archivo no generado por laboratorio, solicite su generación al laboratorio.');
                return redirect()->route('resultados.index');
            }

        }else{
            session()->flash('message', 'Archivo no encontrado, solicite su generación al laboratorio.');
            return redirect()->route('resultados.index');
        }

    }

    public function get_resultados(Request $request){
        $folio = $request->validate([
            'folio' => 'required | numeric | exists:recepcions,folio',
            'nombre'=> 'required | exists:pacientes,nombre',
        ]);
        $all_estudios = [];
        $date = Date('dmys');

        $paciente = Pacientes::where('nombre', $folio['nombre'])->first();

        $verifica = Recepcions::where('folio', $folio['folio'])->where('estado', 'pagado')->where('id_paciente', $paciente->id)->first();

        if(!$paciente){
            session()->flash('message', 'Paciente no existe, revise por favor.');
        }

        if($verifica == null){
            session()->flash('message', 'Registro no pagado, revise su pago por favor.');
        }

        if($verifica && $paciente){
            $usuario        = $verifica->valida()->first();
            $laboratorio    = $usuario->labs()->first();
            $sucursal       = $usuario->sucs()->where('estatus', 'activa')->first();
    
            $folios         = Recepcions::where('folio', $folio['folio'])->first();
            $pacientes      = $folios->paciente()->first();
                $edad = Carbon::createFromFormat('d/m/Y', $pacientes->fecha_nacimiento)->age;
            
            $doctor = Doctores::where('id', $folios->id_doctor)->first();
            $valido = User::where('id', $folios->valida_id)->first();
            $img_valido = base64_encode(Storage::disk('public')->get($valido->firma));
            
            return Storage::disk('public')->download($folios->patient_file);
        }else{
            return redirect()->route('resultados.index');
        }
    }


    public function certifica_estudio(Request $request){
        $folio  =  htmlspecialchars($request->folio);
        $id     = htmlspecialchars($request->estudio);

        $recepcion = Recepcions::where('folio', $folio)->first();
        // dd($recepcion->estudios()->where('estudios.clave','=' ,$id)->get()->toArray());

        $valida = Carbon::createFromFormat('Y-m-d H:i:s', $recepcion->created_at)->format('d/m/Y');
        if($recepcion){
            $estudio = Estudio::where('clave', $id)->first();

            if($estudio->valida_qr){
                $analito    = $estudio->analitos()->where('valida_qr','=', 'on')->first();
                $top        = $recepcion->historials()->where('recepcions_id', '=', $recepcion->id)
                                ->where('clave', '=', $analito->clave)
                                ->first();

                return view('resultados.certificate', ['recepcion'=> $recepcion, 'estudio' => $estudio, 'analito' => $top, 'valida' => $valida] );
            }else if(!$estudio){
                session()->flash('message', 'Estudio no encontrado para el folio');
                return redirect()->route('resultados.index');
            }else{
                session()->flash('message', 'Estudio no certificado');
                return redirect()->route('resultados.index');
            }
        }else{
            session()->flash('message', 'Folio no encontrado.');
            return redirect()->route('resultados.index');
        }

    }

}
