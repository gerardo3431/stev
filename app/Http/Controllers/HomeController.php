<?php

namespace App\Http\Controllers;

use App\Helpers\CajaHelper;
use App\Models\Caja;
use App\Models\Estudio;
use App\Models\Lista;
use App\Models\Recepcions;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\Facades\LarapexChart;
use Carbon\Carbon;
use Estudios;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class HomeController extends Controller
{

    //GETTERS
    // Chart pacientes ultimos 7 dias
    public function generate_chart_patient(){
        $user           = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $user ->laboratorio()->first();

        $fecha_inicial  = Carbon::now()->subDays(7);
        $fecha_final    = Carbon::now();
        $count          = $fecha_inicial->diffInDays($fecha_final);

        $a              = intval($count);
        $informacion    = [];
        $periodo        = [];
        
        for($i = $count; $i>0; $i--){
            $b = $a;
            $a--;
            $c = $a;

            $informacion[]  = $laboratorio->pacientes()->whereBetween('pacientes.created_at', [Carbon::now()->subDays($b), Carbon::now()->subDays($c)])->get()->count();
            $periodo[]      = '' . Carbon::now()->subDays($c)->day . ' ' . Carbon::now()->subDays($c)->monthName;
        }

        $period[] =[
                'name' => $laboratorio->nombre,
                'data' => $informacion,
            ];
        
        $data['dato']   = $period;
        $data['labels'] = $periodo;
        
        return json_encode($data);
    }

    // Genera solicitudes
    public function generate_chart_solicitudes(){
        $user           = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $user->laboratorio()->first();
        $sucursal       = $user->sucs()->get();

        $fecha_inicial  = Carbon::now()->subMonths(12);
        $fecha_final    = Carbon::now();
        $count          = $fecha_inicial->diffInMonths($fecha_final);

        $a              = intval($count);
        $informacion    = [];
        $periodo        = [];
        
        for($i = $count; $i>0; $i--){
            $b = $a;
            $a--;
            $c = $a;

            $informacion[]  = Recepcions::whereBetween('recepcions.created_at', [Carbon::now()->subMonth($b), Carbon::now()->subMonth($c)])->get()->count();
            $periodo[]      = Carbon::now()->subMonth($c)->monthName;
        }

        $period[] =[
                'name' => $laboratorio->nombre,
                'data' => $informacion,
            ];
        
        $data['dato']   = $period;
        $data['labels'] = $periodo;
        
        return json_encode($data);
    }

    // Chart semanal
    public function generate_week_chart(){
        $user           = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $user->laboratorio()->first();
        $sucursales     = $user->sucs()->orderBy('id', 'asc')->get();

        $fecha_inicial  = Carbon::now()->subDays(7);
        $fecha_final    = Carbon::now();
        $count          = $fecha_inicial->diffInDays($fecha_final);
// dd($count);
        $a              = intval($count);
        $informacion    = [];
        $periodo        = [];
        
        // Para los dias
        foreach ($sucursales as $key => $sucursal) {
            $a = intval($count);

            $informacion = [];
            $periodo = [];
            // Data
            for ($i=$count; $i > 0 ; $i--) {
                $b = $a;
                $a--;
                $c = $a;
                $informacion[]  = $sucursal->pago()->whereBetween('pagos.created_at', [Carbon::now()->subDays($b), Carbon::now()->subDays($c)])->get()->sum('importe');
                $periodo[]      = '' . Carbon::now()->subDays($c)->day . ' ' . Carbon::now()->subDays($c)->monthName;
            
            }
            // data
            $period[] =[
                'name' => $sucursal->sucursal,
                'data' => $informacion,
            ];
        }
        
        $data['dato']   = $period;
        $data['labels'] = $periodo;
        
        return json_encode($data);
    }

    // Chart mensual
    public function generate_month_chart(){
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
        $fecha_inicial = Carbon::now()->subDays(31);
        $fecha_final = Carbon::now();
        $count = $fecha_inicial->diffInDays($fecha_final);
        $data=[];
        
        foreach ($sucursales as $key => $sucursal) {
            $a = intval($count);
            $informacion = [];
            $periodo = [];

            // Data
            for ($i=$count; $i > 0 ; $i--) { 
                $b = $a;
                $a--;
                $c = $a;
                $informacion[]  = $sucursal->pago()->whereBetween('pagos.created_at', [Carbon::now()->subDays($b), Carbon::now()->subDays($c)])->get()->sum('importe');
                $periodo[]      = '' . Carbon::now()->subDays($c)->day . ' ' . Carbon::now()->subDays($c)->monthName;
            }
            $period[] =[
                'name' => $sucursal->sucursal,
                'data' => $informacion,
            ];
        }
        $data['dato'] = $period;

        // Label
        $data['labels'] = $periodo;

        return json_encode($data);

    }

    // Chart entre rangos de fecha
    public function generate_chart(Request $request){
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        $fecha_inicial = Carbon::parse($request->fecha_inicial);
        $fecha_final = Carbon::parse($request->fecha_final)->addDay();
        // Diferencia
        $count = $fecha_inicial->diffInDays($fecha_final);

        $data=[];

        foreach ($sucursales as $key => $sucursal) {
            $a = intval($count);

            $informacion = [];
            $periodo = [];
            // Data
            for ($i=$count; $i > 0 ; $i--) {
                $b = $a;
                $a--;
                $c = $a;
                $informacion[]  = $sucursal->pago()->whereBetween('pagos.created_at', [Carbon::now()->subDays($b), Carbon::now()->subDays($c)])->get()->sum('importe');
                $periodo[]      = '' . Carbon::now()->subDays($c)->day . ' ' . Carbon::now()->subDays($c)->monthName;
            
            }
            // data
            $period[] =[
                'name' => $sucursal->sucursal,
                'data' => $informacion,
            ];
        }

        $data['dato'] = $period;
        $data['labels'] = $periodo;

        return json_encode($data);
    }

    


    // SETTERS

    public function dashboard(){
        if(auth()->user()->hasRole('Doctor')){
            return redirect()->route('stevlab.doctor.dashboard');
        }else if(auth()->user()->hasRole('Empresa')){
            return redirect()->route('stevlab.empresa.dashboard');
        }else{
            // Laboratorio
            $laboratorio =  User::where('id', Auth::user()->id)->first()->labs()->first();
            //Verificar sucursal
            $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
            // Lista de sucursales que tiene el usuario
            $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
            // Verificar y contar caja del usuario
            $caja = User::where('id', Auth::user()->id)->first()->caja()->where('estatus', 'abierta')->first();
            // Obtengo usuario
            $user = Auth::user();
    
            $resultado = CajaHelper::verificarCajaAbierta($user);
            session()->flash('status', $resultado);
    
            
            $pacientes = $laboratorio->pacientes()->count();
            $sucursales = $laboratorio->subsidiary()->get();
            $today = [];
            
            $soli_soli = 0;
            $soli_vali = 0;
            $soli_pendi = 0;
    
            // Para los dias
            foreach ($sucursales as $key => $sucursal) {
    
                $today[] =[
                    'name' => $sucursal->sucursal,
                    'data' => [
                        $sucursal->pago()->whereBetween('pagos.created_at', [Carbon::now()->subDay(), Carbon::now()])->get()->sum('importe'),
                    ]
                ];
                
                $soli_soli   = $soli_soli + $sucursal->folios()->whereBetween('recepcions.created_at', [Carbon::now()->subDay(), Carbon::now()])->get()->count();
                $soli_vali = $soli_vali + $sucursal->folios()->where('recepcions.estatus_solicitud', '=', 'validado')->whereBetween('recepcions.created_at', [Carbon::now()->subDay(), Carbon::now()])->get()->count();
                $soli_pendi = $soli_pendi + $sucursal->folios()->where('recepcions.estatus_solicitud', '=', 'solicitado')->whereBetween('recepcions.created_at', [Carbon::now()->subDay(), Carbon::now()])->get()->count();
            }
            // Pagos
            $today_pay  = $active->pago()->where('tipo_movimiento', '=', 'ingreso')->whereBetween('pagos.created_at', [Carbon::now()->subDay(), Carbon::now()])->sum('pagos.importe');
            $today_expense  = $active->pago()->where('tipo_movimiento', '=', 'egreso')->whereBetween('pagos.created_at', [Carbon::now()->subDay(), Carbon::now()])->sum('pagos.importe');
            $profit         = $today_pay - $today_expense;
    
            // Solicitudes 
            $recepcions = Recepcions::whereBetween('recepcions.created_at', [Carbon::now()->subDay(), Carbon::now()])->get();
            
            $a = 0; 
            $b = 0; 
            $c = 0;
    
            foreach ($recepcions as $d => $recepcion) {
                $solicitado = $recepcion->areas()->where('recepcions_has_areas.estatus_area', '=', 'solicitado')->get();
                $capturado = $recepcion->areas()->where('recepcions_has_areas.estatus_area', '=', 'capturado')->get();
                $validado = $recepcion->areas()->where('recepcions_has_areas.estatus_area', '=', 'validado')->get();
    
                $studies = $recepcion->estudios()->get();            
                foreach ($studies as $e => $studie) {
                    $area = $studie->areas()->first();
    
                    if(!$solicitado->isEmpty()){
                        foreach ($solicitado as $f => $solicitud) {
                            if($studie->areas()->first()->id == $solicitud->id){
                                $a++;
                            }
                        }
                    }
    
                    if(!$capturado->isEmpty()){
                        foreach ($capturado as $f => $solicitud) {
                            if($studie->areas()->first()->id == $solicitud->id){
                                $b++;
                            }
                        }
                    }
    
                    if(!$validado->isEmpty()){
                        foreach ($validado as $f => $solicitud) {
                            if($studie->areas()->first()->id == $solicitud->id){
                                $c++;
                            }
                        }
                    }
                }
            }
    
            $chartToday = LarapexChart::setType('bar')->setDataLabels(true)->setHeight(400)->setStroke(3)->setMarkers(0)->setXAxis([
                '' . Carbon::now()->subDays(1)->day . ' ' . Carbon::now()->subDay()->monthName,
            ])->setDataSet($today)->setColors(["#6571ff","#7987a1","#05a34a","#66d1d1","#fbbc06","#ff3366","#e9ecef","#060c17","#7987a1",]);
    
            $mostWanted = Estudio::withCount('recepciones')->orderByDesc('recepciones_count')->take(10)->get();
            $leastWanted = Estudio::withCount('recepciones')->orderBy('recepciones_count')->take(10)->get();
    
            
            return view('dashboard', [
                                'active'            => $active, 
                                'sucursales'        => $sucursales, 
                                'caja'              => $caja,
                                // Baldosas
                                'pacientes'         => $pacientes,
                                'solicitudes'       => $soli_soli,
                                'solicitudes_vali'  => $soli_vali,
                                'solicitudes_pend'  => $soli_pendi,
                                'chartToday'        => $chartToday,
                                'ingreso'           => $today_pay,
                                'egreso'            => $today_expense,
                                'balance'           => $profit,
                                'solicitados'       => $a,
                                'capturados'        => $b,
                                'validados'         => $c,
                                'mostWanted'        => $mostWanted,
                                'leastWanted'       => $leastWanted,
                            ]);
        }
    }

}