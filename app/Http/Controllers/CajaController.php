<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Laboratory;
use App\Models\Pago;
use App\Models\Profile;
use App\Models\Recepcions;
use App\Models\Retiro;
use App\Models\Subsidiary;
use App\Models\User;
use App\Services\PagoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CajaController extends Controller
{

    protected $pagoService;

    public function __construct(PagoService $pagoService)
    {
        $this->pagoService = $pagoService;

    }
    // Getters
    public function get_pendiente_pago(Request $request){
        $monto = [];
        $result= 0;
        $montito = 0;

        $identificador = $request->only('identificador');
        $folio = Recepcions::where('id', $identificador['identificador'])->first();
        $pagos = $folio->pago()->get();

        foreach ($pagos as $key => $pago) {
            $montito = $montito + $pago->importe;
        }

        $precio = $folio->lista()->sum('precio');
        

        $monto['all']   = $precio;
        $monto['monto'] = $montito;
        $monto['pago']  = $folio->descuento;
        $monto['folio']  = $folio->folio;
        return $monto;
    }

    /**
     * Return a amount from specific Folio
     * @param Request $request
     * @return mixed
     */
    public function get_pago_pendiente(Request $request){ #para el pago de pendientes
        // dd($request);
        $monto = [];
        $montito = 0;

        $identificador = $request->only('identificador');
        $folio = Recepcions::where('id', $identificador['identificador'])->first();
        $pagos = $folio->pago()->get();

        foreach ($pagos as $key => $pago) {
            $montito = $montito + $pago->importe;
        }

        $monto['total'] = ($folio->num_total - $montito) - $folio->descuento;
        $monto['monto'] = $montito;
        $monto['pago']  = $folio->descuento;
        return $monto;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index()
    {
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
        // Verificar y contar caja del usuario
        $caja = User::where('id', Auth::user()->id)->first()->caja()->where('estatus', 'abierta')->first();
        // Trae las cajas que haya aperturado y cerrado el usuario
        $cajas = User::where('id', Auth::user()->id)->first()->caja()->get();
        
        // Trae los movimientos de pagos realizados
        if($caja){
            $movimientos = User::where('id', Auth::user()->id)->first()->caja()->where('estatus', 'abierta')->first()->pagos()->orderBy('id','desc')->get();
        }else{
            $movimientos = null;
        }
        
        // Si existe caja
        if(isset($caja)){
            // Verifica tiempo de caja
            $fecha_inicial = $caja->created_at;
            $fecha_final = $fecha_inicial->diffInDays(Carbon::now());

            // Notifico si paso de 24 horas
            if($fecha_final == 0){
                // Calcula el monto para la caja en su consulta actual
                $ingreso = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'ingreso')->get()->sum('importe');
                $egreso  = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'egreso')->get()->sum('importe');
                $retiro  = $caja->retiros()->get()->sum('cantidad');

                $total   = ($caja->apertura + $ingreso) - ($retiro  + $egreso);

                $ingreso_efectivo       = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'ingreso')->where('pagos.metodo_pago', '=', 'efectivo')->get()->sum('importe');
                $ingreso_tarjeta        = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'ingreso')->where('pagos.metodo_pago', '=', 'tarjeta')->get()->sum('importe');
                $ingreso_transferencia  = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'ingreso')->where('pagos.metodo_pago', '=', 'transferencia')->get()->sum('importe');

                
                $egreso_efectivo        = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'egreso')->where('pagos.metodo_pago', '=', 'efectivo')->get()->sum('importe');
                $egreso_tarjeta         = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'egreso')->where('pagos.metodo_pago', '=', 'tarjeta')->get()->sum('importe');
                $egreso_transferencia   = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'egreso')->where('pagos.metodo_pago', '=', 'transferencia')->get()->sum('importe');


                $update  = Caja::where('id', $caja->id)->update([
                    'entradas'              =>$ingreso,
                    'salidas'               =>$egreso,
                    'ventas_efectivo'       =>$ingreso_efectivo,
                    'ventas_tarjeta'        =>$ingreso_tarjeta,
                    'ventas_transferencia'  =>$ingreso_transferencia,
                    'salidas_efectivo'      =>$egreso_efectivo,
                    'salidas_tarjeta'       =>$egreso_tarjeta,
                    'salidas_transferencia' =>$egreso_transferencia,
                    'retiros'               =>$retiro,
                    'total'                 =>$total, 
                ]);
                $caja = Caja::where('id', $caja->id )->first();
                session()->flash('status_caja', 'Caja activa, recuerde que se cierra cada 24 horas, o cuando usted cierre manualmente la caja.');
            }elseif($fecha_final > 0 ){
                // Calcula el monto para la caja en su consulta actual
                $ingreso = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'ingreso')->get()->sum('importe');
                $egreso  = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'egreso')->get()->sum('importe');
                $retiro  = $caja->retiros()->get()->sum('cantidad');

                $total   = ($caja->apertura + $ingreso) - ($retiro  + $egreso);

                $ingreso_efectivo       = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'ingreso')->where('pagos.metodo_pago', '=', 'efectivo')->get()->sum('importe');
                $ingreso_tarjeta        = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'ingreso')->where('pagos.metodo_pago', '=', 'tarjeta')->get()->sum('importe');
                $ingreso_transferencia  = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'ingreso')->where('pagos.metodo_pago', '=', 'transferencia')->get()->sum('importe');

                
                $egreso_efectivo        = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'egreso')->where('pagos.metodo_pago', '=', 'efectivo')->get()->sum('importe');
                $egreso_tarjeta         = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'egreso')->where('pagos.metodo_pago', '=', 'tarjeta')->get()->sum('importe');
                $egreso_transferencia   = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'egreso')->where('pagos.metodo_pago', '=', 'transferencia')->get()->sum('importe');


                $update  = Caja::where('id', $caja->id)->update([
                    'entradas'              =>$ingreso,
                    'salidas'               =>$egreso,
                    'ventas_efectivo'       =>$ingreso_efectivo,
                    'ventas_tarjeta'        =>$ingreso_tarjeta,
                    'ventas_transferencia'  =>$ingreso_transferencia,
                    'salidas_efectivo'      =>$egreso_efectivo,
                    'salidas_tarjeta'       =>$egreso_tarjeta,
                    'salidas_transferencia' =>$egreso_transferencia,
                    'retiros'               =>$retiro,
                    'total'                 =>$total,
                    'estatus'               => 'cerrada', 
                ]);
                // $new_caja = Caja::where('id', $caja->id)->update(['estatus' => 'cerrada']);
                session()->flash('status_caja', 'Caja cerrada automáticamente...');
            }
        }else{
            $caja = null;
            session()->flash('status_caja','Debes aperturar caja antes de empezar a trabajar.' );
        }

        
        echo view('caja.index', [
                            'active'        => $active,
                            'sucursales'    => $sucursales, 
                            'caja'          => $caja,
                            'cajas'         => $cajas, 
                            'movimientos'   => $movimientos,
                        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $monto = request()->validate([
            'monto'                    => 'required',
        ],[
            'monto.required'             => 'Ingresa la cantidad correcta para aperturar caja',
        ]);


        // Esto trae al usuario
        $usuario = User::where('id', Auth::user()->id)->first();
        // Trae la clinica en la que esta registrado el usuario
        $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();
        // Trae la sucursal actual
        $sucursal = User::where('id', Auth::user()->id)->first()->sucs()->first();

        $query = User::where('id', Auth::user()->id)->first()->caja()->where('estatus', 'abierta')->first();
        if($query == null){
            $caja = Caja::create([
                                    'apertura'  => $monto['monto'],
                                    'estatus'   => 'abierta',
                                ]);
            $sucursal->cajas()->attach($caja->id, ['user_id' => $usuario->id, 'subsidiary_id' => $sucursal->id]);
        }

        
        return redirect()->route('stevlab.caja.index');
    }

    public function close_caja(Request $request){
        $id = $request->id;
        $caja = Caja::where('id', $id)->first();

        // Calcula el monto para la caja en su consulta actual
        $ingreso = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'ingreso')->get()->sum('importe');
        $egreso  = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'egreso')->get()->sum('importe');
        $retiro  = $caja->retiros()->get()->sum('cantidad');

        $total   = ($caja->apertura + $ingreso) - ($retiro  + $egreso);

        $ingreso_efectivo       = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'ingreso')->where('pagos.metodo_pago', '=', 'efectivo')->get()->sum('importe');
        $ingreso_tarjeta        = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'ingreso')->where('pagos.metodo_pago', '=', 'tarjeta')->get()->sum('importe');
        $ingreso_transferencia  = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'ingreso')->where('pagos.metodo_pago', '=', 'transferencia')->get()->sum('importe');

        
        $egreso_efectivo        = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'egreso')->where('pagos.metodo_pago', '=', 'efectivo')->get()->sum('importe');
        $egreso_tarjeta         = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'egreso')->where('pagos.metodo_pago', '=', 'tarjeta')->get()->sum('importe');
        $egreso_transferencia   = $caja->pagos()->where('pagos.tipo_movimiento', '=', 'egreso')->where('pagos.metodo_pago', '=', 'transferencia')->get()->sum('importe');


        $update  = Caja::where('id', $caja->id)->update([
            'entradas'              =>$ingreso,
            'salidas'               =>$egreso,
            'ventas_efectivo'       =>$ingreso_efectivo,
            'ventas_tarjeta'        =>$ingreso_tarjeta,
            'ventas_transferencia'  =>$ingreso_transferencia,
            'salidas_efectivo'      =>$egreso_efectivo,
            'salidas_efectivo'      =>$egreso_tarjeta,
            'salidas_efectivo'      =>$egreso_transferencia,
            'retiros'               =>$retiro,
            'total'                 =>$total,
            'estatus'               => 'cerrada', 
        ]);
        // $caja = Caja::where('id', $id)->update(['estatus' => 'cerrada']);

        if($caja){
            session()->flash('caja_estatus', 'Caja cerrada automáticamente...');
            return redirect()->route('stevlab.caja.index');
        }else{
            session()->flash('caja_estatus', 'Caja no cerrada, intente de nuevo');
            return back();
        }
    }

    public function store_retiro(Request $request){
        $fecha = Carbon::now();

        $id_caja = $request->only('caja');
        $total = $request->only('cantidad');

        $caja = Caja::where('id', $id_caja['caja'])->first();
        $user = Auth::user();
        $retiro = Retiro::create([
            'cantidad'  => $total['cantidad'],
            'fecha'     => $fecha,
        ]);

        $caja->retiros()->attach($retiro->id, ['user_id' => $user->id]);

        // $total_retiro = $caja->retiros + $total['cantidad'];
        // $total_caja   = $caja->total - $total['cantidad'];
        // // $total_retiro = $caja->retiros + $total['cantidad'];
        // Caja::where('id', $id_caja['caja'])->update([
        //     'total'   => $total_caja,
        //     'retiros' => $total_retiro
        // ]);

        if($retiro){
            $response = true;
        }else{
            $response = false;
        }
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        return json_encode($response);
    }

    public function caja_egreso(Request $request){
        $movimiento = $request->validate([
            'tipo_movimiento'   => 'required',
            'descripcion'       => 'required',
            'metodo_pago'       => 'required',
            'importe'           => 'required',
            'observaciones'     => 'nullable',
            'is_factura'        => 'nullable',
        ]);

        $user           = User::where('id', Auth::user()->id)->first();
        $caja           = User::where('id', Auth::user()->id)->first()->caja()->where('estatus', 'abierta')->first();
        $sucursal       = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();

        // Guardamos pago
        $pago = Pago::create($movimiento);

        if($pago){
            // Pagos has cajas
            $caja->pagos()->save($pago);
            // Pagos_has_user
            $user->pago()->save($pago);
            // Pagos_has_subsidiaries
            $sucursal->pago()->save($pago);


            $response = true;

        }else{
            $response = false;
        }
        

        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        return $response;
    }

    public function pay(Request $request){
        // dd($request);

        $create = $this->pagoService->create($request);
        return response()->json([
            'success' => true,
            'mensaje' => 'Pago realizado con exito',
            'data'    => $create
        ],201);
    }

    public function pay_edit(Request $request){
        $pay = $this->pagoService->create($request);
        return response()->json([
            'success' => true,
            'mensaje' => 'Pago realizado con exito',
            'data'    => $pay
        ],201);
    }

    public function make_note(Request $request){
        $nota = $this->pagoService->makeNote($request);
        return $nota->stream();
    }

    public function genera_reporte_dia(Request $request){
        $identificador  = $request->except('_token');
        $laboratorio    = User::where('id', Auth::user()->id)->first()->labs()->first();
        $sucursal       = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        $cuenta         = Caja::where('id', $identificador['id'])->first();
        $movimientos    = Caja::where('id', $identificador['id'])->first()->pagos()->get();

        $memb = "data:image/jpeg;base64," . base64_encode(Storage::disk('public')->get($laboratorio->membrete));

        $pdf        = Pdf::loadView('invoices.reportes.caja.arqueo-caja', [
            'laboratorio'   => $laboratorio,
            'sucursal'      => $sucursal,
            'cuenta'        => $cuenta,
            'movimientos'   => $movimientos,
            'membrete'      => $memb,
        ]);

        $pdf->setPaper('letter', 'portrait');
        $path = 'public/caja/caja_'. $cuenta->id . '/r_' . date('dmY') . '.pdf';
        $pathSave = Storage::put($path, $pdf->output());
        $request = ['pdf' => '/public/storage/caja/caja_'. $cuenta->id . '/r_' . date('dmY') . '.pdf'];

        return $request;
    }

    public function genera_reporte_arqueo_pacientes(Request $request){
        

        $identificador  = $request->except('_token');
        $laboratorio    = User::where('id', Auth::user()->id)->first()->labs()->first();
        $sucursal       = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        $cuenta         = Caja::where('id', $identificador['id'])->first();
        $movimientos    = $cuenta->pagos()->get();

        if(isset($movimientos)){
            $folios = [];
            foreach ($movimientos as $key => $value) {
                if($value->folio->first() != null){
                    $folios[] = $value->folio()->first();
                }else{
                }
            }
            
            $memb = "data:image/jpeg;base64," . base64_encode(Storage::disk('public')->get($laboratorio->membrete));
    
            $pdf        = Pdf::loadView('invoices.reportes.caja.arqueo-caja', [
                'laboratorio'   => $laboratorio,
                'sucursal'      => $sucursal,
                'cuenta'        => $cuenta,
                'folios'        => $folios,
                'membrete'      => $memb,
            ]);
    
            $pdf->setPaper('letter', 'portrait');
            $path = 'public/caja/caja_'. $cuenta->id . '/r_' . date('dmY') . '.pdf';
            $pathSave = Storage::put($path, $pdf->output());
            $request = ['pdf' => '/public/storage/caja/caja_'. $cuenta->id . '/r_' . date('dmY') . '.pdf'];
    
            return $request;

        }else{
            return false;
        }
    }

    public function genera_reporte_rapido(Request $request){
        $identificador = $request->except('_token');

        $laboratorio    = User::where('id', Auth::user()->id)->first()->labs()->first();
        $sucursal       = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        $cuenta         = Caja::where('id', $identificador['id'])->first();
        $memb = "data:image/jpeg;base64," . base64_encode(Storage::disk('public')->get($laboratorio->membrete));


        $pdf        = Pdf::loadView('invoices.reportes.caja.arqueo-caja', [
            'laboratorio'   => $laboratorio,
            'sucursal'      => $sucursal,
            'cuenta'        => $cuenta,
            'membrete'      => $memb,
        ]);

        $pdf->setPaper('letter', 'portrait');
        $path = 'public/caja/caja_'. $cuenta->id . '/rr_' . date('dmY') . '.pdf';
        $pathSave = Storage::put($path, $pdf->output());
        $request = ['pdf' => '/public/storage/caja/caja_'. $cuenta->id . '/rr_' . date('dmY') . '.pdf'];

        return $request;
    }

    public function genera_reporte_rango(Request $request){
        $data = $request->except('_token');

        $fecha_inicio = Carbon::parse($data['fecha_inicio']);
        $fecha_final = Carbon::parse($data['fecha_final'])->addDay();

        $laboratorio    = User::where('id', Auth::user()->id)->first()->labs()->first();
        $sucursal       = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        $cajas          = Subsidiary::where('id', $sucursal->id)->first()->cajas()->whereBetween('cajas.created_at', [$fecha_inicio, $fecha_final])->get();

        $memb = "data:image/jpeg;base64," . base64_encode(Storage::disk('public')->get($laboratorio->membrete));

        $pdf        = Pdf::loadView('invoices.reportes.caja.arqueo-caja', [
            'laboratorio'   => $laboratorio,
            'sucursal'      => $sucursal,
            'cajas'         => $cajas,
            'membrete'      => $memb,
        ]);

        $pdf->setPaper('letter', 'portrait');
        $path = 'public/caja/reportes_generales/lab_' . $laboratorio->id . '/r_' . $sucursal->id .  '-' . date('dmY') . '.pdf';
        $pathSave = Storage::put($path, $pdf->output());
        $request = ['pdf' => '/public/storage/caja/reportes_generales/lab_' . $laboratorio->id . '/r_' . $sucursal->id . '-' .  date('dmY') . '.pdf'];

        return $request;
    }
}
