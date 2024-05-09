<?php

namespace App\Http\Controllers;

use App\Models\Doctores;
use App\Models\Empresas;
use App\Models\Recepcions;
use App\Models\Subsidiary;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReporteController extends Controller
{
    //
    public function get_data_ventas(Request $request){
        // dd($request);
        // dd(count(array_filter($doctores)) > 0);
        // $folios = Recepcions::when($request->area !== 'todo', function($query) use ($request){
        //     $query->whereHas('areas', function($query) use ($request){
        //         $query->where('area_id', $request->area);
        //     });
        // })->when($request->estado !== 'todo', function($query) use ($request){
        //     $query->whereHas('areas', function($query) use ($request){
        //         $query->where('estatus_area', $request->estado);
        //     });
        // })->when($request->sucursal !== 'todo', function($query) use ($request){
        //     $query->whereHas('sucursales', function($query) use ($request){
        //         $query->where('subsidiary_id', $request->sucursal);
        //     });
        // })->whereBetween('recepcions.created_at', [$fecha_inicio, $fecha_final])->orderBy('id', 'desc')->get();

        // $folios = Recepcions::whereBetween('recepcions.created_at', [$fecha_inicio, $fecha_final])->orderBy('id', 'desc')->get();

        // foreach ($folios as $key => $estudio) {
        //     $estudio->sucursal  = $estudio->sucursales()->first()->sucursal;
        //     $estudio->paciente  = ($estudio->paciente()->first() != null) ? $estudio->paciente()->first()->nombre : 'Paciente eliminado';
        //     $estudio->empresa   = ($estudio->empresas()->first() != null) ? $estudio->empresas()->first()->descripcion : 'Empresa eliminada';
        //     $estudio->doctor    = ($estudio->doctores()->first() != null) ? $estudio->doctores()->first()->nombre : 'Doctor eliminada';
        // }
        $fecha_inicio   = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fecha_final    = Carbon::parse($request->fecha_final)->addDay();
        $doctores       = explode(',', $request->input('doctores'));
        $empresas       = explode(',', $request->input('empresas'));

        // Busqueda
        $folios = Recepcions::whereBetween('recepcions.created_at', [$fecha_inicio, $fecha_final]);

        // Verifica si las variables vienen vacias o sin arreglos
        if (count(array_filter($doctores)) > 0) {
            $folios->whereIn('id_doctor', $doctores);
        }

        // Verifica si las variables vienen vacias o sin arreglos
        if (count(array_filter($empresas)) > 0) {
            $folios->whereIn('id_empresa', $empresas);
        }

        // Ordenamiento antes de la entrega
        $folios = $folios->orderBy('id', 'desc')->get();

        // Agregar más datos a los folios
        foreach ($folios as $key => $estudio) {
            $estudio->sucursal  = $estudio->sucursales()->first()->sucursal;
            $estudio->paciente  = ($estudio->paciente()->first() != null) ? $estudio->paciente()->first()->nombre : 'Paciente eliminado';
            $estudio->empresa   = ($estudio->empresas()->first() != null) ? $estudio->empresas()->first()->descripcion : 'Empresa eliminada';
            $estudio->doctor    = ($estudio->doctores()->first() != null) ? $estudio->doctores()->first()->nombre : 'Doctor eliminada';
            $estudio->pago      = $estudio->pago()->sum('importe');
        }

        // Busqueda de relaciones doctores y empresas a los folios
        $new_doctores = $folios->pluck('doctores')->unique();
        foreach ($new_doctores as $doctor) {
            $doctor->total = $folios->where('id_doctor', $doctor->id)->sum('num_total');
        }

        $new_empresas = $folios->pluck('empresas')->unique();
        foreach ($new_empresas as $empresa) {
            $empresa->total  = $folios->where('id_empresa', $empresa->id)->sum('num_total');
        }


        // Creacion del response
        $response = [
            'folios'    => $folios,
            'doctores'  => $new_doctores,
            'empresas'  => $new_empresas
        ];

        // Envio del response
        return response()->json($response);
    }

    public function arqueo_index(){
        
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

        return view('reportes.arqueos.index', [
            'active'=>$active, 
            'sucursales'=>$sucursales,
            'usuarios' => $usuarios,
            'doctores' => $doctores,
            'empresas' => $empresas,
        ]);
    }

    public function make_reporte(Request $request){
        
        $laboratorio    = User::where('id', Auth::user()->id)->first()->labs()->first();
        $memb = "data:image/jpeg;base64," . base64_encode(Storage::disk('public')->get($laboratorio->membrete));


        // dd($request);
        $doctor     = Doctores::where('id', $request->doctor)->first();
        $empresa    = Empresas::where('id', $request->empresa)->first();
        $usuario    = User::where('id', $request->usuario)->first();
        $sucursal   = Subsidiary::where('id', $request->sucursal)->first();
        $inicio     = Carbon::parse($request->inicio)->startOfDay();
        $final      = Carbon::parse($request->final)->addDay();

        $results = Recepcions::whereBetween('recepcions.created_at', [$inicio, $final])
        ->when($request->doctor !== 'todo', function ($query) use ($doctor) {
            $query->where('id_doctor', $doctor->id);
        })
        ->when($request->usuario !== 'todo', function ($query) use ($usuario) {
            $query->where('user_id', $usuario->id);
        })
        ->when($request->empresa !== 'todo', function ($query) use ($empresa) {
            $query->where('id_empresa', $empresa->id);
        })
        ->when($request->sucursal !== 'todo', function ($query) use ($sucursal) {
            $query->whereHas('sucursales', function ($query) use ($sucursal) {
                $query->where('subsidiary_id', $sucursal->id);
            });
        })
        ->orderBy('id', 'desc')
        ->get();
        // dd($results->toArray());
        // OBTENER MONTO

        //pdf
        $pdf = Pdf::loadView('invoices.reportes.arqueo.invoice-arqueo',['membrete' => $memb, 'folios' => $results]);
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream();
    }



    public function ventas_index(Request $request){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        $laboratorio    = User::where('id', Auth::user()->id)->first()->labo()->first();

        return view('reportes.ventas.index', [
            'active'=>$active, 
            'sucursales'=>$sucursales,
        ]);
    }

}
