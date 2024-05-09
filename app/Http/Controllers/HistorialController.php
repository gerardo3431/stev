<?php

namespace App\Http\Controllers;

use App\Models\Doctores;
use App\Models\Historial;
use App\Models\Pacientes;
use App\Models\Estudio;
use App\Models\Recepcions;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;

class HistorialController extends Controller
{
    //

    public function historial_index(){

        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
        
        $laboratorio    = User::where('id', Auth::user()->id)->first()->labo()->first();
        // Usuario
        $usuarios = $laboratorio->usuario()->get();
        // Doctor
        $doctores = $laboratorio->doctores()->get();
        // Empresa
        $empresas = $laboratorio->empresas()->get();

        return view('historial.historial.index', [
            'active'=>$active, 
            'sucursales'=>$sucursales,
            'usuarios' => $usuarios,
            'doctores' => $doctores,
            'empresas' => $empresas,
        ]);
    }

    public function historial_search(Request $request){

        $doctor = (auth()->user()->doctor()->first()) ? auth()->user()->doctor()->first() : null;

        $query = Recepcions::when($request->folio != null, function ($query) use ($request){
            $query->where('folio', $request->folio);
        })->when(auth()->user()->hasRole('Doctor'), function ($query) use ($doctor){
            $query->where('id_doctor', $doctor->id);
        })->when($request->paciente != null, function ($query) use ($request) {
            $query->whereRelation('paciente', 'recepcions_has_paciente.pacientes_id', '=', $request->paciente);
        })->get()->load(['sucursales', 'paciente', 'empresas']);


        return $query;
    }

    public function historial_search_index(Request $request){
        $query = Recepcions::when($request->folio != null, function ($query) use ($request){
            $query->where('folio', $request->folio);
        })->when($request->paciente != null, function ($query) use ($request) {
            $query->whereRelation('paciente', 'recepcions_has_paciente.pacientes_id', '=', $request->paciente);
        })->get()->load(['sucursales', 'paciente', 'empresas']);

        return $query;
    }


    public function historial_generate(Request $request){
        $date = Date('dmys');
        $folio = $request->only('folio');

        $usuario        = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $usuario->labs()->first();
        $sucursal       = $usuario->sucs()->where('estatus', 'activa')->first();
        $folios         = Recepcions::where('folio', $folio)->first();

        $pacientes      = $folios->paciente()->first();
        $edad           = Carbon::createFromFormat('d/m/Y', $pacientes->fecha_nacimiento)->age;

        $doctor         = Doctores::where('id', $folios->id_doctor)->first();

        if($folios->estado === 'pagado'){
            $request = ['pdf' => '/public/storage/resultados-completos/F-'.$folio['folio'].'.pdf'];
    
            return $request;
        }else{
            return ['msj' => 'No hay datos guardados para mostrar en este folio.'];
        }
    }


    public function delta_check(Request $request){
        
        $folio = Recepcions::where('folio', $request->folio)->first();

        $paciente = $folio ? $folio->paciente()->first() : null;

        $estudio = Estudio::where('clave', $request->estudio)->first();

        $folios = Recepcions::whereHas('paciente', function ($query) use ($paciente){
                $query->where('id_paciente', $paciente->id);
            })->whereHas('estudios', function ($query) use ($estudio){
                $query->where('estudio_id', $estudio->id);
            })->whereHas('historials', function($query) use ($request){
                $query->where('clave', $request->clave);
        })->orderBy('id', 'desc')->get();

        $resultados = collect();

        foreach ($folios as $key => $folio) {
            $resultados->push($folio->historials()->where('clave', $request->clave)->first()->valor);
        }

        // Debo retornar esto:
        // [5,6,7,9,9,5,3,2,2,4,6,7,3,4,7,2,7,4,3,1,6,3,7 ]
        // Analizar que hacer si recibo texto o de preferencia evitar
        // [1,NORMAL,POCOS,NEGATIVO]

        return $resultados;

    }
}
