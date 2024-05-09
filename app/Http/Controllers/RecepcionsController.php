<?php

namespace App\Http\Controllers;

use App\Exports\DatosExport;
use App\Helpers\PaymentHelper;
use App\Helpers\PdfHelper;
use App\Helpers\TicketHelper;
use App\Http\Requests\StoreFolioRequest;
use App\Jobs\ProcesaCorreo;
use App\Models\Analito;
use App\Models\Caja;
use App\Models\Doctores;
use App\Models\Empresas;
use App\Models\Estudio;
use App\Models\Historial;
use App\Models\Observaciones;
use App\Models\Pacientes;
use App\Models\Picture;
use App\Models\Prefolio;
use App\Models\Profile;
use App\Models\Recepcions;
use App\Models\Subsidiary;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use App\Jobs\MaquilaArchivoImgJob;
use App\Jobs\MaquilaArchivoJob;
use App\Jobs\PatientiFileJob;
use App\Models\Area;
use App\Services\AnalitoService;
use App\Services\FolioService;
use App\Services\ImportacionService;
use App\Services\PdfService;
use App\Services\PrefolioService;
use App\Services\ResultadoService;
use Maatwebsite\Excel\Facades\Excel;
use Milon\Barcode\DNS1D;
use setasign\Fpdi\Fpdi;
// use Stichoza\GoogleTranslate\GoogleTranslate;

class RecepcionsController extends Controller{

    protected $folioService;
    protected $prefolioService;
    protected $pdfService;
    protected $analitoService;
    protected $resultadoService;
    protected $importacionService;
    public function __construct(FolioService $folioService, PrefolioService $prefolioService, PdfService $pdfService, AnalitoService $analitoService, ResultadoService $resultadoService, ImportacionService $importacionService)
    {
        $this->folioService = $folioService;
        $this->prefolioService = $prefolioService;
        $this->pdfService = $pdfService;
        $this->analitoService = $analitoService;
        $this->resultadoService = $resultadoService;
        $this->importacionService = $importacionService;

    }
    // Get
    public function get_recepcions_folio(Request $request){
        $folio = $request->only('folio');
        $recepcion = Recepcions::where('folio', $folio['folio'])->first()->observaciones;
        return $recepcion;
    }
    // Get observacion para el folio
    public function get_observacion_folio(Request $request){
        $folio = $request->only('folio');
        $estudio = $request->only('estudio');

        $recepcion = Recepcions::where('folio', $folio['folio'])->first();
        $estudios = Estudio::where('clave', $estudio['estudio'])->first();
        $obs = Recepcions::where('folio', $folio['folio'])->first()
            ->observaciones()->where('observaciones_has_estudios.estudio_id', $estudios->id)->first();
            // dd($obs);
        return $obs;
    }

    public function index(Request $request){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        $empresas = User::where('id', Auth::user()->id)->first()->labs()->first()->empresas()->get();

        $pacientes = User::where('id', Auth::user()->id)->first()->labs()->first()->pacientes()->get();
        $doctores = User::where('id', Auth::user()->id)->first()->labs()->first()->doctores()->get();

        // $laboratorio_id    = User::where('id', Auth::user()->id)->first()->labs()->first()->id;
        
        // Verificar y contar caja del usuario
        $caja = User::where('id', Auth::user()->id)->first()->caja()->where('estatus', 'abierta')->first();
        
        if(isset($caja)){

            // Verifica tiempo de caja
            $fecha_inicial = $caja->created_at;
            // dd($fecha_inicial);
            // dd(Carbon::today());
            // dd(Carbon::tomorrow());

            // dd($fecha_inicial->diffInDays(Carbon::now()->isMidnight()));
            // dd($fecha_inicial->isMidnight());
            // dd(Carbon::today()->addDay());
            // $today = Carbon::today();
            // dd($fecha_inicial->diffInDays(Carbon::today()));
            // dd($fecha_inicial->diffAsCarbonInterval(Carbon::today()));
            // dd($fecha_inicial->diffInHours(Carbon::tomorrow()));
            // dd(Carbon::today()->diffInDays($fecha_inicial));
            // dd($fecha_inicial->diffInDays(Carbon::today()));
            // $fecha_final = $fecha_inicial->diffInHours(Carbon::today());
            // dd($fecha_inicial->diffInHours(Carbon::today()));
            // dd(Carbon::now()->diffInDays($fecha_inicial));
            // $fecha_final = Carbon::now()->diffInDays($fecha_inicial);
            // dd(Carbon::now()->today()->diffInHours($fecha_inicial));

            $fecha_final = $fecha_inicial->diffInDays(Carbon::now());

            // Notifico si paso de 24 horas
            if($fecha_final == 0){
                session()->flash('status', 'Caja activa, recuerde que se cierra cada 24 horas, o cuando usted cierre manualmente la caja.');
            }elseif($fecha_final > 0 ){
                $caja = Caja::where('id', $caja->id)->first();

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
                // $new_caja = Caja::where('id', $caja->id)->update(['estatus' => 'cerrada']);
                session()->flash('status', 'Caja cerrada automáticamente...');
            }
        }else{
            session()->flash('status','Debes aperturar caja antes de empezar a trabajar.' );
        }
        return view('recepcion.registro.index', ['active'=>$active,
                                            'sucursales'=>$sucursales, 
                                            'empresas'=>$empresas,
                                            'pacientes'=>$pacientes, 
                                            'doctores' => $doctores, 
                                            // 'folio' => $reservacion
                                        ]);  
    }  

    public function guardar(StoreFolioRequest $request){
        $arreglo = $request->validated();
        $recepcions = $this->folioService->create($arreglo);      

        if($request['prefolio']){
            $this->prefolioService->asociarRecepcion($request['prefolio'], $recepcions);
        }

        // Invoco al logger
        activity('recepcion')->performedOn($recepcions)->log('Folio creado');
        
        // Preparar los documentos de consentimiento
        return response()->json([
            'success'   => true,
            'data'      => $recepcions,
            'msj'       => 'Folio creado con exito.',
        ], 201);

    }

    public function guardar_estudios(Request $request){
        // $this->folioService->linkStudies($request->lista, 'Estudios', $request->id);
        // $this->folioService->linkStudies($request->perfiles, 'Perfiles', $request->id);
        // $this->folioService->linkStudies($request->imagenes, 'Imagenologia', $request->id);

        $response = $this->folioService->linkPrecios($this->folioService->getFolioByID($request->id), $request->lista);

        // Invoco al logger
        activity('recepcion')->performedOn($this->folioService->getFolioByID($request->id))->log('Estudios guardados para folio objetivo');

        return response()->json([
            'success' => true,
            'mensaje' => 'Estudios agregados con éxito',
            'data'    => $response
        ],201);
    }

    public function create_formatos_pdf(Request $request){
        
        $sangre = $request->sangre;
        $vih    = $request->vih;
        $micro  = $request->micro;

        if($sangre !=="false" || $vih !== "false" || $micro !== "false"){
            $user           = User::where('id', Auth::user()->id)->first();
            $laboratorio    = $user->labs()->first();
            $logotipo       = base64_encode(Storage::disk('public')->get($laboratorio->logotipo));
            $response       = [];

            $formatos = compact(
                'sangre', 
                'vih', 
                'micro'
            );
            
            $formatos = array_filter($formatos, function($value) {
                return $value === "true";
            });
            
            $formatos = array_intersect_key($formatos, array_flip(['sangre', 'vih', 'micro']));
            
            $pdfData = [
                'logotipo' => $logotipo,
                'laboratorio' => $laboratorio,
                'formatos'      => $formatos,
            ];
            
            $pdf = Pdf::loadView('invoices.formatos.invoice-formato', $pdfData);
            $pdf->setPaper('A4', 'portrait');
            $pdf->render();
    
            return $pdf->stream();
        
        }
    }
    
    //borrar 31082023


    public function genera_etiquetas_laboratorio(Request $request){
        $estudios_areas = [];
        $perfil_estudio = [];
        $id = $request->id;
        $folio = Recepcions::where('id', $id)->first();
        $estudios = $folio->lista()->get();

        $estudios       = $folio->estudios()
            ->whereNotIn('recepcions_has_estudios.estudio_id', function ($subquery) use ($folio){
                $subquery->select('estudio_id')
                    ->from('profiles_has_estudios')
                    ->whereIn('profile_id', $folio->recepcion_profiles()->pluck('profiles.id')->toArray());
            })->get();

        $perfiles       = $folio->recepcion_profiles()->get();
        $pictures       = $folio->picture()->get();

        if(!isset($estudios)){
            $estudio = null;
        }

        if(!isset($perfiles)){
            $perfil_estudio = null;
        }

        if(!isset($pictures)){
            $picture = null;
        }

        // Revisar esta weonada
        foreach($estudios as $key => $estudio){
            $recipiente = $estudio->recipientes()->first();
            $estudio->recipiente = $recipiente ? $recipiente->descripcion : null;
        }

        $groupEstudios = collect();
        foreach($perfiles as $key => $perfil){
            foreach ($perfil->perfil_estudio()->get() as $key => $estudio) {
                $proRecipiente = $estudio->recipientes()->first();
                $estudio->recipiente = $proRecipiente ? $proRecipiente->descripcion : null;
                // $groupEstudios->push($estudio); 
                $estudios->push($estudio);
            }
        }

        // $estudios->push($groupEstudios);
// dd($estudios->toArray());

        $estudiosAgrupados = $estudios->groupBy('recipiente');
        // $perfilesAgrupados = $groupEstudios->groupBy('recipiente');
        // dd($perfiles->toArray());
        $areas = User::where('id', Auth::user()->id)->first()->labs()->first()->areas()->get();

        $paciente       = Recepcions::where('id', $id)->first()->paciente()->first();
        $edad = $paciente->getAge();
        // $edad = $paciente->edad ;

        $barcode = DNS1D::getBarcodeSVG($folio->folio, 'C128', 1.70, 30, 'black' ,true);

        $pdf        = Pdf::loadView('invoices.etiquetas.etiquetas-laboratorio', [
            'paciente'  => $paciente,
            'edad'      => $edad,
            'areas'     => $areas,
            'estudios'  => $estudiosAgrupados,
            // 'perfiles'  => $perfilesAgrupados,
            'pictures'  => $pictures,
            'barcode'   => $barcode,
        ]);
        // 38x25 mm y 40x22
        // Tamaño de insadisa
        // $pdf->setPaper(array(0, 0, 141, 70), 'portrait');

        // Tamaño de 40 x 22
        // 113 x 62
        // $pdf->setPaper(array(0, 0, 113, 62), 'portrait');
        // Tamaño de 38 x 25
        // 107 x 70
        $ancho = (5.2 / 2.54) * 72;
        $alto  = (2.5 / 2.54) * 72;
        
        $pdf->setPaper(array(0, 0, $ancho, $alto), 'portrait');

        // $path       = 'public/etiquetas-laboratorio/F-'. $folio->folio . '.pdf';
        // $pathSave   = Storage::put($path, $pdf->output());
        // $request['etiquetas'] = '/public/storage/etiquetas-laboratorio/F-'. $folio->folio . '.pdf';
        $pdf->render();
        return $pdf->stream();
        // return $request;
    }

    public  function pendientes_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
        // Areas
        $areas = User::where('id', Auth::user()->id)->first()->labs()->first()->areas()->get();

        $laboratorio    = User::where('id', Auth::user()->id)->first()->labs()->first();

        $caja = User::where('id', Auth::user()->id)->first()->caja()->where('estatus', 'abierta')->first();

        if(isset($caja)){

            // Verifica tiempo de caja
            $fecha_inicial = $caja->created_at;
            $fecha_final = $fecha_inicial->diffInDays(Carbon::now());

            // Notifico si paso de 24 horas
            if($fecha_final == 0){
                
                session()->flash('status', 'Caja activa, recuerde que se cierra cada 24 horas, o cuando usted cierre manualmente la caja.');
            
            }elseif($fecha_final > 0 ){
                // Cierra caja
                $new_caja = Caja::where('id', $caja->id)->update(['estatus' => 'cerrada']);
                session()->flash('status', 'Caja cerrada automáticamente...');

            }

        }else{

            session()->flash('status','Debes aperturar caja antes de empezar a trabajar.' );

        }
        return view('recepcion.pendientes.index', [
            'active'        => $active, 
            'sucursales'    => $sucursales, 
            'areas'         => $areas,
        ]);
    }

    public function pendientes_consulta_folios(Request $request){
        // dd($request);
        $fecha_inicio = Carbon::parse($request->fecha_inicio);
        $fecha_final = Carbon::parse($request->fecha_final)->addDay();
        $laboratorio    = User::where('id', Auth::user()->id)->first()->labs()->first();

        $folios = Recepcions::when($request->sucursal !== 'todo', function ($query) use ($request){
            $query->whereRelation('sucursales', 'recepcions_has_subsidiaries.subsidiary_id', '=', $request->sucursal);
        })->whereBetween('recepcions.created_at',[$fecha_inicio, $fecha_final])->where('recepcions.estado', 'no pagado')
        ->orderBy('id', 'desc')->get()->load(['sucursales', 'paciente', 'empresas']);

        // dd($folios);
        // if($request->sucursal == 'todo'){
        //     $folios = Recepcions::whereBetween('recepcions.created_at', [$fecha_inicio, $fecha_final])
        //         ->where('recepcions.estado', '=', 'no pagado')->orderBy('id', 'desc')->get()
        //     ->load(['sucursales', 'paciente', 'empresas']);
        // }else{
        //     $folios = Recepcions::whereRelation('sucursales', 'recepcions_has_subsidiaries.subsidiary_id', '=', $request->sucursal)
        //         ->whereBetween('recepcions.created_at', [$fecha_inicio, $fecha_final])
        //         ->where('recepcions.estado', '=', 'no pagado')->orderBy('id', 'desc')->get()
        //     ->load(['sucursales', 'paciente', 'empresas']);
        // }
        // // dd($folios);

        return json_encode($folios);
    }

    public function recepcion_captura_block_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
        // Areas
        $areas = User::where('id', Auth::user()->id)->first()->labs()->first()->areas()->get();


        return view('captura-block.index',['active'=> $active, 'sucursales' => $sucursales, 'areas' => $areas]);
    }

    public function recepcion_block_consulta(Request $request){
        $fecha_inicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fecha_final = Carbon::parse($request->fecha_final)->addDay();
        $estudio = Estudio::where('id', $request->estudio)->first();

        // Consulta por sucursal y area
        $folios = Recepcions::when($request->sucursal !== 'todo', function($query) use ($request){
            $query->whereHas('sucursales', function($query) use ($request){
                $query->where('subsidiary_id', $request->sucursal);
            });
        })->when($estudio !== null, function ($query) use ($request){
            $query->whereHas('estudios', function($query) use ($request){
                $query->where('estudios.id', $request->estudio);
            });
        })->whereBetween('recepcions.created_at', [$fecha_inicio, $fecha_final])->orderBy('id', 'desc')->get();

        // Tratar folios por el campo de estudio y de acuerdo al area
        foreach ($folios as $key => $folio) {
            // $folio->estudios = $this->folioService->recover_estudios($folio, $request);
            
            $estudios = $folio->estudios()->when($request->area !== 'todo', function ($query) use ($request){
                $query->whereHas('area', function($query) use ($request){
                    $query->where('area_id', $request->area);
                });
            })->when($request->estudio !== null, function ($query) use ($request){
                $query->where('estudios.id', $request->estudio);
            })->get();
            

            $folio->estudios = $this->folioService->loadInformation($folio, $estudios);
            
        }

        return $folios;
    }

    // Para buscar estudio por id, en cojunto de la busqueda del area
    // when($estudio !== null, function ($query) use ($request){
    //     $query->where('estudio_id', $request->estudio);
    // })->

    public function recepcion_captura_index(){
        
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
        // Areas
        $areas = User::where('id', Auth::user()->id)->first()->labs()->first()->areas()->get();


        return view('captura.index',['active' => $active, 'sucursales'=> $sucursales, 'areas' => $areas]);
    }

    public function recepcion_captura_consulta(Request $request){
        $injection = $this->folioService->recoverInformation($request);
        return $injection;
    }

    public function recover_estudios(Request $request){
        // Medir tiempo de reaccion
        // $inicio = microtime(true);
        $query  = Recepcions::where('folio', $request->folio)->first();
        $estudios = $this->folioService->recover_estudios($query, $request);
        $estudios['observaciones'] = $query->observaciones;
        
        if($query->maq_file != null){
            $estudios['msj'] = 'Este folio contiene un archivo maquilado, por favor revise.';
            $estudios['path'] = '/public/storage/' . $query->maq_file;
        }

        if($query->maq_file_img != null){
            $estudios['msj_img'] = 'Este folio contiene un archivo maquilado, por favor revise.';
            $estudios['path_img'] = '/public/storage/' . $query->maq_file_img;
        }

        // $fin = microtime(true);
        // dd($fin - $inicio);
        return $estudios;
    }

    public function verifica_resultados(Request $request){
        $data = $request->except('_token');
        $estudio = Estudio::where('clave', $data['identificador'])->first();
        $picture = Picture::where('clave', $data['identificador'])->first();

        if($estudio){
            $verifica = Recepcions::where('folio', $data['folio'])->first()
            ->historials()->where('historials_has_recepcions.estudio_id', $estudio->id)->get()->toArray();
        }else{
            $verifica = Recepcions::where('folio', $data['folio'])->first()
            ->historials()->where('historials_has_recepcions.picture_id', $picture->id)->get()->toArray();
        }
        
        return $verifica;
    }

    //traer el valor de acuerdo a la edad edad age
    public function recover_valores_referenciales(Request $request){
        $folio = $request->only('folio');
        $clave = $request->only('clave');

        $folio = Recepcions::where('folio', $folio['folio'])->first();
        $paciente = $folio->paciente()->first();
        $valores = $this->analitoService->getReferencial($paciente, $clave['clave']);
        return $valores;       
        
    }

    public function upload_img_resultados(Request $request){
        $id = $request->only('id_analito');
        $folio = $request->only('folio');
        $codigo = $request->only('clave');
        $descripcion = $request->only('descripcion');
        $identificador = $request->only('identificador');

        $rand = rand(1,100) . '-'  ;
        $path = $request->file('file')->storeAs('public', 'resultados/imagenes/img-' . $rand .  $codigo['clave']. '-' . date('mdy') . '.png');
        $path = 'resultados/imagenes/img-'. $rand .  $codigo['clave'] . '-' . date('mdy') . '.png';

        $recepcion = Recepcions::where('folio', $folio['folio'])->first();
        $clave_estudio = Estudio::where('clave', $identificador['identificador'])->first();

        activity('captura')->performedOn($clave_estudio)->withProperties(['folio' => $recepcion->id])->log('Imagen para captura capturada');
        
        $insercion = Historial::updateOrCreate([
            'id' => $id,
            'clave' => $codigo['clave'], 
            'descripcion'=>$descripcion['descripcion'],     
        ],[
            'valor' => $path,
        ]);
        
        $consulta = DB::table('historials_has_recepcions')->where([
            'recepcions_id' => $recepcion->id,
            'historial_id'  => $insercion->id,
            'estudio_id'    => $clave_estudio->id,
        ])->first();

        if($consulta){
        }else{
            $recepcion->historials()->attach($insercion->id, [
                'estudio_id' => $clave_estudio->id, 
                'recepcions_id' => $recepcion->id
            ]);
        }

        if($insercion) {
            $response['msj'] = true;
            $response['id'] = $insercion->id;

        } else {
            $response['msj'] = false;
        }
        

        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        return $response;
    }

    public function upload_zip_file(Request $request){
        $id = $request->only('id_analito');
        $folio = $request->only('folio');
        $codigo = $request->only('clave');
        $descripcion = $request->only('descripcion');
        $identificador = $request->only('identificador');

        if ($request->hasFile('file')) {
            $extension = $request->file('file')->extension();
            // dd($extension);
            $prepathName = rand(1,100) . '-' . $folio['folio'] . '-' . $identificador['identificador'] . '-' . $codigo['clave']. '-' . date('mdy') . '.' . $extension;
            // $file_name  = 'resultados/imagenes/img-'. rand(1,100) . '-' . $prepathName . '.' . $archivo->getClientOriginalExtension();
            // Si es una imagen
            if (in_array($extension, ['jpg', 'jpeg', 'png'])) {
                $path = $request->file('file')->storeAs('public', 'resultados/imagenes/img-' . $prepathName );
                $path = 'resultados/imagenes/img-'. $prepathName;
            } elseif (in_array($extension, ['zip', 'rar'])) {
                // Si es un archivo comprimido
                $path = $request->file('file')->storeAs('public',  'resultados/imagenes/img-' . $prepathName);
                $path = 'resultados/imagenes/img-'. $prepathName; // quitamos la carpeta public
            } else {
                // Manejar otros tipos de archivos
                return response()->json([
                    'error' => 'El tipo de archivo no es compatible.'
                ], 400);
            }
        } else {
            return response()->json([
                'error' => 'No se ha enviado ningún archivo.'
            ], 400);
        }

        $recepcion = Recepcions::where('folio', $folio['folio'])->first();
        $clave_estudio = Picture::where('clave', $identificador['identificador'])->first();
        activity('captura')->performedOn($clave_estudio)->withProperties(['folio' => $recepcion->id])->log('Imagen para imagenologia capturada');

        $insercion = Historial::updateOrCreate([
            'id' => $id,
            'clave' => $codigo['clave'], 
            'descripcion'=>$descripcion['descripcion'],     
        ],[
            'valor' => $path,
        ]);
        
        $consulta = DB::table('historials_has_recepcions')->where([
            'recepcions_id' => $recepcion->id,
            'historial_id'  => $insercion->id,
            'picture_id'    => $clave_estudio->id,
        ])->first();
        
        if(! $consulta){
            $recepcion->historials()->attach($insercion->id, [
                'picture_id' => $clave_estudio->id, 
                'recepcions_id' => $recepcion->id
            ]);
        }

        return response()->json([
            'msj' => true,
            'id' => $insercion->id,
        ],201);        
    }

    public function verify_pending_pay(Request $request){
        $folio = $request->only('folio');

        $recepcion = Recepcions::where('folio', $folio['folio'])->first();

        if($recepcion->estado == 'pagado'){
            $response['msj'] = true;
        }else{
            $response['msj'] = false;
        }

        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        return json_encode($response);
    }

    public function maquila_archivo(Request $request){
        
        $folio = $request->only('folio');

        // Pdf for merge
        $setFile = $request->file('archivo')->storeAs('public/maquila/', 'ejemplo.pdf');
        // Url publico
        $urlFilePath = public_path() . '/storage/maquila/ejemplo.pdf' ;

        // Picture for watermark
        if($request->file('imagen')){
            $setImg = $request->file('imagen')->storeAs('public/maquila/imagenes/', 'ejemplo.png');
            // Url publico
            $urlImgPath = public_path() . '/storage/maquila/imagenes/ejemplo.png';
        }else{
            $urlImgPath = null;
        }

        $job = MaquilaArchivoJob::dispatch($folio['folio'], $urlFilePath, $urlImgPath);
         

        return response()->json([
            'pdf'       => '/public/storage/maquila/M-'. $folio['folio'].'.pdf',
            'msj'       => 'Generando maquila. Sino se genera archivo, revisar que la imagen sea png.'
        ], 202);
    }

    public function maquila_file_img(Request $request){
        
        $folio = $request->only('folio');

        // Pdf for merge
        $setFile = $request->file('archivo')->storeAs('public/maquila/', 'ejemplo.pdf');
        // Url publico
        $urlFilePath = public_path() . '/storage/maquila/ejemplo.pdf' ;

        // Picture for watermark
        if($request->file('imagen')){
            $setImg = $request->file('imagen')->storeAs('public/maquila/imagenes/', 'ejemplo.png');
            // Url publico
            $urlImgPath = public_path() . '/storage/maquila/imagenes/ejemplo.png';
        }else{
            $urlImgPath = null;
        }

        $job = MaquilaArchivoImgJob::dispatch($folio['folio'], $urlFilePath, $urlImgPath);          

        return response()->json([
            'pdf'       => '/public/storage/maquila/MI-'. $folio['folio'].'.pdf',
            'msj'       => 'Generando maquila. Sino se genera archivo, revisar que la imagen sea png.'
        ], 202);
    }

    public function delete_maquila_file(Request $request){
        $mensaje = false;
        
        $query = Recepcions::where('folio', $request->ID)->first();

        switch ($request->type) {
            case 'recepcion':
                if(Storage::disk('public')->exists($query->maq_file)){
                    Storage::disk('public')->delete($query->maq_file);
                    $delete = $query->update(['maq_file' => null]);
                }
                break;
            case 'imagenologia':
                if(Storage::disk('public')->exists($query->maq_file_img)){
                    Storage::disk('public')->delete($query->maq_file_img);
                    $delete = $query->update(['maq_file_img' => null]);
                }
                break;
            default:
                # code...
                break;
        }

        return $delete ? true : false;
    }

    public function store_resultados_estudios(Request $request){


        // Recabado de la información a manipular
        $estudios = $request->only('estudio');
        $codigo = $request->only('folio');
        $referencia = $request->only('identificador');
        $observaciones = $request->only('observacion');


        // Información a requerir
        $recepcion = Recepcions::where('folio', $codigo['folio'])->first();
        $estudio = Estudio::where('clave', $referencia['identificador'])->first();
        $analitos = $estudio->analitos()->get();


        // Filtro los parametros con sus contrapartes de captura que estan llegando al controlador
        $coincidencias = [];
        foreach ($analitos as $parametro) {
            // Obtener la clave del elemento A
            $claveA = $parametro->clave;
        
            // Buscar el elemento correspondiente en el grupo B por la clave
            $elementoB = array_filter($estudios["estudio"], function ($item) use ($claveA) {
                return $item["clave"] === $claveA;
            });
        
            // Verificar si se encontró un elemento en el grupo B
            if (!empty($elementoB)) {
                // Agregar la coincidencia al array de coincidencias
                $coincidencias[] = [
                    'parametro' => $parametro->toArray(),
                    'captura'   => reset($elementoB), // Tomar el primer elemento del array filtrado
                ];
            }
        }


        // Guarda los resultados de los estudios
        foreach ($coincidencias as $key => $fila) {
            $consulta_historial = $recepcion->historials()
                ->where('historials_has_recepcions.estudio_id', $estudio->id)
                ->where('historials.clave', $fila['parametro']['clave'])
                ->first();
            if($consulta_historial){
                $consulta_historial->update([
                    'valor'         => $fila['captura']['valor'],
                    'absoluto'      => ( isset($fila['captura']['porcentualBool'])) ? $fila['captura']['porcentualBool'] : '0',
                    'valor_abs'     => ( isset($fila['captura']['porcentual']) ) ? $fila['captura']['porcentual'] : null,
                ]);
            }else{
                $create = Historial::create([
                    'clave'         => $fila['parametro']['clave'], 
                    'descripcion'   => $fila['parametro']['descripcion'],
                    'valor'         => $fila['captura']['valor'] ?? null,
                    'absoluto'      => ( isset($fila['captura']['porcentualBool'])) ? $fila['captura']['porcentualBool'] : '0',
                    'valor_abs'     => ( isset($fila['captura']['porcentual']) ) ? $fila['captura']['porcentual'] : null,
                ]);

                $recepcion->historials()->attach($create->id, [
                    'estudio_id'    => $estudio->id,
                    'recepcions_id' => $recepcion->id
                ]);

            }
        }


        // Observaciones
        $obs_query = $recepcion->observaciones()->where('observaciones_has_estudios.estudio_id', $estudio->id)->first();
        if($obs_query){
            $obs_query->update(['observacion' => $observaciones['observacion'][0]['observacion']]);
        }else{
            $observacion_insert = Observaciones::create(['observacion' => $observaciones['observacion'][0]['observacion']]);
            $estudio->recepcions()->attach($estudio->id, [
                'observaciones_id'  => $observacion_insert->id, 
                'recepcions_id'     => $recepcion->id
            ]);
        }

        
        // Actualizas quien capturo la información 
        $recepcion->estudios()->updateExistingPivot($estudio->id, ['status' => 'capturado']);


        // 
        activity('captura')->performedOn($estudio)->withProperties(['folio' => $recepcion->id])->log('Estudio capturado');

        // Retornas algo al sistema
        return response()->json([
            'status' => true
        ],201);
    }

    public function valida_resultados(Request $request){
        $user = User::where('id', Auth::user()->id)->first();        
        if($user->hasPermissionTo('valida_resultados')){
            $folio = $request->only('folio');
            $estudios = $request->only('estudios');
            $referencia = $request->only('identificador');
            
            $recepcion = Recepcions::where('folio', $folio)->first();
            $estudio = Estudio::where('clave', $referencia['identificador'])->first();

              // Actualizas quien capturo la información 
            $recepcion->estudios()->updateExistingPivot($estudio->id, ['status' => 'validado']);
            $recepcion->historials()->where('estudio_id', $estudio->id)->update(['estatus'=>'validado']);

            activity('captura')->performedOn($estudio)->withProperties(['folio' => $recepcion->id])->log('Estudio validado');

            return response()->json([
                'success' => true,
                'message' => 'Estudio validado'
            ],201);

        }else{
            return response()->json([
                'success' => false,
                'message' => 'Usted no tiene el permiso para realizar la validación.'
            ],401);
        }
    }

    public function invalida_resultados(Request $request){
        // dd($request);
        $user = User::where('id', Auth::user()->id)->first(); 
        // dd($user->hasPermissionTo('invalida_resultados'));
        if($user->hasPermissionTo('invalida_resultados')){
            $folio = $request->only('folio');
            $estudios = $request->only('estudios');
            $referencia = $request->only('identificador');
    
            $recepcion = Recepcions::where('folio', $folio)->first(); 
            $estudio = Estudio::where('clave', $referencia['identificador'])->first();
    
            $recepcion->estudios()->updateExistingPivot($estudio->id, ['status' => 'capturado']);
    
            activity('captura')->performedOn($estudio)->withProperties(['folio' => $recepcion->id])->log('Estudio invalidado');
    
            return response()->json([
                'success' => true,
                'message'=> 'Estudio invalidado'
            ],201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Usted no tiene el permiso para realizar la validación.'
            ],401);
        }
    }

    public function valida_imagenologia(Request $request){
        $user = User::where('id', Auth::user()->id)->first();
        
        if($user->hasPermissionTo('valida_resultados')){
            $folio = $request->only('folio');
            $estudios = $request->only('estudios');
            $referencia = $request->only('identificador');
    
            $recepcion = Recepcions::where('folio', $folio)->first();
            $recepcion_estado = Recepcions::where('folio', $folio)->update([
                'estatus_solicitud' => 'validado'
            ]);

            $clave_estudio = Picture::where('clave', $referencia['identificador'])->first();
            
            foreach ($estudios['estudios'] as $key=>$estudio) {
                $actualizar = Historial::where('id', $estudio['id'])->update(['estatus'=>'validado']);
            }

            Recepcions::where('id', $recepcion->id)->update([
                'valida_id' => Auth::user()->id,
            ]);

            activity('captura')->performedOn($clave_estudio)->withProperties(['folio' => $recepcion->id])->log('Estudio para imagenologia validada');

            
            if($actualizar) {
                $recepcion->deparment()->where('deparments.id', $clave_estudio->deparment()->first()->id)->update(['estatus_area' => 'validado']);
                $response['response'] = true;
                $response['msj'] = 'Datos fueron validados.';
                header("HTTP/1.1 200 OK");
                header('Content-Type: application/json');
            } else {
                $response['response'] = false;
                $response['msj'] = 'Datos no fueron validados. Vuelva a abrir la ventana de captura.';
                header("HTTP/1.1 400");
                header('Content-Type: application/json');
            }
    
            return json_encode($response);
        }else{
            $response['response'] = false;
            $response['msj'] = 'Usted no tiene los permisos requeridos para validar resultados. Revise sus permisos.';
            header("HTTP/1.1 400");
            header('Content-Type: application/json');
            return json_encode($response);
        }
    }

    public function invalida_imagenologia(Request $request){
        $user = User::where('id', Auth::user()->id)->first(); 
        // dd($user->hasPermissionTo('invalida_resultados'));
        if($user->hasPermissionTo('invalida_resultados')){
            $folio = $request->only('folio');
            $estudios = $request->only('estudios');
            $referencia = $request->only('identificador');
    
            $recepcion = Recepcions::where('folio', $folio)->first(); 
            $estudio = Picture::where('clave', $referencia['identificador'])->first();
            activity('captura')->performedOn($estudio)->withProperties(['folio' => $recepcion->id])->log('Estudio imagenologia invalidada');
    
            $recepcion->picture()->updateExistingPivot($estudio->id, ['estatus_area' => 'capturado']);
    
            return response()->json([
                'success' => true,
                'message'=> 'Estudio invalidado'
            ],201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Usted no tiene el permiso para realizar la validación.'
            ],401);
        }
    }

    public function store_resultados_imagenelogia(Request $request){
        $estudios = $request->only('estudio');
        $codigo = $request->only('folio');
        $referencia = $request->only('identificador');
        $observaciones = $request->only('observacion');

        $recepcion = Recepcions::where('folio', $codigo['folio'])->first();
        $recepcion_estado = Recepcions::where('folio', $codigo['folio'])->update([
            'estatus_solicitud' => 'capturado'
        ]);

        $clave_estudio = Picture::where('clave', $referencia['identificador'])->first();

        foreach ($estudios['estudio'] as $key=>$estudio) {
            $id = $estudio['id'];
            $valor = ($estudio['valor'] != null) ? $estudio['valor'] : null;
            // dd($valor);
            $insercion = Historial::updateOrCreate([
                    'id'=> $id, 
                    'clave' => $estudio['clave'], 
                    'descripcion'=>$estudio['descripcion'],
            ],[
                    'valor' => $valor
            ]);
            // dd($insercion);
            $response['data'][$key]= [
                    'clave' => $insercion->clave, 
                    'id'    =>$insercion->id,
            ];
            
            $consulta = DB::table('historials_has_recepcions')->where([
                'recepcions_id' => $recepcion->id,
                'historial_id'  => $insercion->id,
                'picture_id'    => $clave_estudio->id,
            ])->first();

            if($consulta){
                
            }else{

                $recepcion->historials_pictures()->attach($insercion->id, [
                                                'picture_id'    => $clave_estudio->id, 
                                                'recepcions_id' => $recepcion->id
                                            ]);
            }
        }

        // Actualiza quien valida
        Recepcions::where('id', $recepcion->id)->update(['captura_id' => Auth::user()->id]);

        activity('captura')->performedOn($clave_estudio)->withProperties(['folio' => $recepcion->id])->log('Estudio imagenologia capturada');

        // if($insercion) {
        //     // $insercion->recepcions()->first()
        //     //     ->areas()->where('areas.id', $clave_estudio->areas()->first()->id)
        //     //     ->update(['recepcions_has_areas.estatus_area' => 'capturado']);
        // } else {
        //     $response['msj'] = false;
        // }
        $response['msj'] = true;

        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        return json_encode($response);
    }

    public function upload_img_imagenologia(Request $request){
        $id = $request->only('id_analito');
        $folio = $request->only('folio');
        $codigo = $request->only('clave');
        $descripcion = $request->only('descripcion');
        $identificador = $request->only('identificador');
        $token = Str::random(4);

        $archivo = $request->file('file');
        $prepathName = $folio['folio'] . '-' . $identificador['identificador'] . '-' . $codigo['clave']. '-' . date('mdy') ;
        $file_name  = 'resultados/imagenes/img-'. rand(1,100) . '-' . $prepathName . '.' . $archivo->getClientOriginalExtension();
        $file       = $archivo->storeAs('public', $file_name);
        
        $path       = 'public/storage/resultados/imagenes/img-zip-'.  $prepathName . '.zip';

        $zipper = new \Madnest\Madzipper\Madzipper;
        $zipper->make($path)
            ->folder('prueba')
            ->add(Storage::disk('public')->path($file_name));

        $store = Storage::disk('public')->put($path, $zipper);

        $recepcion = Recepcions::where('folio', $folio['folio'])->first();
        $clave_estudio = Picture::where('clave', $identificador['identificador'])->first();
        activity('captura')->performedOn($clave_estudio)->withProperties(['folio' => $recepcion->id])->log('Estudio para imagenologia validada');

        
        $insercion = Historial::updateOrCreate([
            'id' => $id,
            'clave' => $codigo['clave'], 
            'descripcion'=>$descripcion['descripcion'],     
        ],[
            'valor' => $path,
        ]);
        
        $consulta = DB::table('historials_has_recepcions')->where([
            'recepcions_id' => $recepcion->id,
            'historial_id'  => $insercion->id,
            'picture_id'    => $clave_estudio->id,
        ])->first();

        if($consulta){
        }else{
            $recepcion->historials_pictures()->attach($insercion->id, [
                'picture_id' => $clave_estudio->id, 
                'recepcions_id' => $recepcion->id
            ]);
        }

        if($insercion) {
            $response['msj'] = true;
            $response['id'] = $insercion->id;

        } else {
            $response['msj'] = false;
        }
        

        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        return $response;
    }

    public function generate_report_img_single(Request $request){
        // dd($request);
        $resultados = [];
        $date = Date('dmys');
        $folio = $request->only('folio');
        $estudios = $request->only('estudios');
        $clave = $request->only('clave');
        $membrete = $request->only('membrete');
        $seleccion = $request->seleccion;

        $usuario        = User::where('id', Auth::user()->id)->first();
        $laboratorio    = User::where('id', Auth::user()->id)->first()->labs()->first();
        $sucursal       = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        $folios         = Recepcions::where('folio', $folio)->first();
        $pacientes      = Recepcions::where('folio', $folio)->first()->paciente()->first();
        $edad = $pacientes->edad != null ? $pacientes->edad :  Carbon::createFromFormat('d/m/Y', $pacientes->fecha_nacimiento)->age;
        $doctor = Doctores::where('id', $folios->id_doctor)->first();

        $capturo = User::where('id', $folios->captura_id)->first();
        $valido = User::where('id', $folios->valida_id)->first();
        $img_valido = base64_encode(Storage::disk('public')->get($valido->firma));


        $barcode        = DNS1D::getBarcodeSVG($folios->folio, 'C128', 1.20, 35);

        $logotipo = base64_encode(Storage::disk('public')->get($laboratorio->logotipo));
        
        switch ($request->seleccion) {
            case 'imagenologia':
                $fondo = $laboratorio->membrete_img;
                break;
            case 'principal':
                $fondo = $laboratorio->membrete;
                break;
            case 'secundario':
                $fondo = $laboratorio->membrete_secundario;
                break;
            case 'terciario':
                $fondo = $laboratorio->membrete_terciario;
                break;
            default:
                $fondo = $laboratorio->membrete;
                break;
        }

        // dd(public_path(). '/storage/' . $fondo);
        $pdf = Pdf::loadView('invoices.imagenologia.invoice-single-imagenologia', [
            'laboratorio'   => $laboratorio, 
            'sucursal'      => $sucursal, 
            'doctor'        => $doctor,
            'usuario'       => $usuario,
            'paciente'      => $pacientes, 
            'edad'          => $edad,
            'folios'        => $folios,
            'clave'         => $clave,

            'logo'          => $logotipo,
            'barcode'       => $barcode,

            // 'membrete'      => $memb,

            'capturo'       => $capturo,
            'valido'        => $valido,
            'img_valido'    => $img_valido,

            'fondo'         => $membrete['membrete'],
        ]);
        
        $pdf->setPaper('letter', 'portrait');
        $path = 'public/imagenologia/F-'.$folio['folio'].'.pdf';
        $deletepre = Storage::delete($path); 
        $pathSave = Storage::put($path, $pdf->output());
        $folios->res_file_img = '/imagenologia/F-'.$folio['folio'].'.pdf';

        if($request->membrete == 'si'){
            $membreteFile = new Fpdi('P', 'mm', 'letter');
            $documento = $membreteFile->setSourceFile(public_path() . '/storage/' . $folios->res_file_img);
            $imagen     = public_path(). '/storage/' . $fondo;
            
            for($pageNo = 1; $pageNo <= $documento; $pageNo++){
                $template = $membreteFile->importPage($pageNo);
                $membreteFile->AddPage();
                $membreteFile->Image($imagen, 0, 0, 216, 279);
                $membreteFile->useTemplate($template, ['adjustPageSize' => true]);
            }
            $membreteFile->Output('F', 'public/storage/imagenologia/F-'.$folio['folio'].'.pdf');
        }
        $request = ['pdf' => '/public/storage/imagenologia/F-'.$folio['folio'].'.pdf'];
        return $request;
    }

    // gENERA REPORTE DE IMAGENOLOGIA COMPLETO
    public function generate_report_img_all(Request $request){
        $all_estudios = [];
        $date = Date('dmys');

        $folio = $request->only('folio');
        $membrete = $request->only('membrete');
        $estudios = $request->only('estudios');
        $seleccion = $request->seleccion;

        // Datos del usuario
        $usuario        = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $usuario->labs()->first();
        $folios         = Recepcions::where('folio', $folio)->first();
        $img_valido     = base64_encode(Storage::disk('public')->get($folios->valida()->first()->firma));
        $barcode        = DNS1D::getBarcodeSVG($folios->folio, 'C128', 1.20, 35);
        
        // Service:
        $path = 'imagenologia/F-'.$folios->folio.'.pdf';

        $pdfData = [
            'laboratorio'   => $laboratorio, 
            'usuario'       => $usuario,
            'folios'        => $folios,

            'barcode'       => $barcode,

            'fondo'         => $membrete['membrete'],

            'barcode'       => $barcode,
            // 'membrete'      => 'data:image/jpeg;base64,' .base64_encode($fondo),
            
            'img_valido'    => $img_valido,
        ];

        $pdf = $this->pdfService->generateAndStorePDF('invoices.imagenologia.invoice-single-imagenologia', $pdfData, 'letter', 'portrait', $path, false);
        // $path = 'public/imagenologia/F-'.$folios->folio.'.pdf';
        $pathSave = Storage::disk('public')->put($path, $pdf->output());
        $folios->update(['res_file_img' => 'imagenologia/F-'.$folios->folio.'.pdf']);

        if($membrete['membrete'] === 'si'){
            switch ($seleccion) {
                case 'imagenologia':
                    $fondo = $laboratorio->membrete_img;
                    break;
                case 'principal':
                    $fondo = $laboratorio->membrete;
                    break;
                case 'secundario':
                    $fondo = $laboratorio->membrete_secundario;
                    break;
                case 'terciario':
                    $fondo = $laboratorio->membrete_terciario;
                    break;
                default:
                    $fondo = $laboratorio->membrete_img;
                    break;
            }

            $membreteFile = new Fpdi('P', 'mm', 'letter');
            $documento = $membreteFile->setSourceFile(public_path() . '/storage/' . $folios->res_file_img);
            $imagen     = public_path(). '/storage/' . $fondo;
            // $img = Storage::disk('public')->get($fondo);
            
            for($pageNo = 1; $pageNo <= $documento; $pageNo++){
                $template = $membreteFile->importPage($pageNo);
                $membreteFile->AddPage();
                $membreteFile->Image($imagen, 0, 0, 216, 279);
                $membreteFile->useTemplate($template, ['adjustPageSize' => true]);
            }
            $membreteFile->Output('F', 'public/storage/imagenologia/F-'.$folios->folio.'.pdf');
        }
         // JOB creado, realizar pruebas luego
        // try {
        //     $job  = GeneratePdfImg::dispatch($usuario, $folios, null, $seleccion, $membrete['membrete'] );
        //     $ruta = ['pdf' => '/public/storage/imagenologia/F-'. $folio['folio'] .'.pdf'];
        //     return $ruta;
        // } catch (\Throwable $e) {
        //     dd($e);
        //     // Log::error("Error al generar reporte: ". $e->getMessage() );
        // }

        // $response = ['pdf' => '/public/storage/imagenologia/F-'.$folio['folio'].'.pdf'];

        // return $response;
        return response()->json([
            'pdf' =>  '/public/storage/' . $path
        ],201);
    }

    // Genera resultados por correo
    public function send_report_imagen(Request $request){
        $all_estudios = [];
        $date = Date('dmys');

        $folio = $request->only('folio');
        $membrete = $request->only('membrete');
        $estudios = $request->only('estudios');
        $seleccion = $request->seleccion;
        $correo = $request->only('correo');
        // Datos del usuario
        $usuario        = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $usuario->labs()->first();
        $folios         = Recepcions::where('folio', $folio)->first();
        // $img_valido     = base64_encode(Storage::disk('public')->get($folios->valida()->first()->firma));
        $img_valido     = base64_encode(Storage::disk('public')->get($laboratorio->firma_img));
        $barcode        = DNS1D::getBarcodeSVG($folios->folio, 'C128', 1.20, 35);
        
        
        // Aqui seleccionan el membrete disponible de 3 opciones
        switch ($seleccion) {
            case 'principal':
                $fondo = $laboratorio->getMembrete($laboratorio->membrete);
                break;
            case 'secundario':
                $fondo = $laboratorio->getMembrete($laboratorio->membrete_secundario);
                break;
            case 'terciario':
                $fondo = $laboratorio->getMembrete($laboratorio->membrete_terciario);
                break;
            default:
                $fondo = $laboratorio->getMembrete($laboratorio->membrete);
                break;
        }
        if($fondo == null){
            $response['msj'] = 'Membrete no existe. Generando reporte...';
        }

        if($img_valido == null){
            return $response['msj'] = 'Firma no existe o no fue agregada...';
            $response['response'] = false;
        }

        $entrega = $folios->historials()->update(['entrega'=> 'entregado']);

        $pdf = Pdf::loadView('invoices.imagenologia.invoice-single-imagenologia', [
            'laboratorio'   => $laboratorio, 
            'usuario'       => $usuario,
            'folios'        => $folios,

            'barcode'       => $barcode,

            'fondo'         => $membrete['membrete'],

            'barcode'       => $barcode,
            'membrete'      => 'data:image/jpeg;base64,' .base64_encode($fondo),
            'img_valido'    => $img_valido,
        ]);
        

        $pdf->setPaper('letter', 'portrait');
        $path = 'public/imagenologia/F-'.$folio['folio'].'.pdf';
        $pathpdf = URL::to('/') . '/public/storage/imagenologia/F-'.$folio['folio'].'.pdf';
        $pathSave = Storage::put($path, $pdf->output());
        $response = ['pdf' => '/public/storage/imagenologia/F-'.$folio['folio'].'.pdf'];

        if(empty($correo)){
            if($folios->paciente()->first()->email){
                $envio = ProcesaCorreo::dispatch($pathpdf, $folios->paciente()->first()->email , $laboratorio, $folios->paciente()->first() )->afterResponse();
            }else{
                return $response['msg'] = 'Paciente no tiene correo...';
            }
        }else{
            foreach($correo['correo'] as $key => $valor){
                if(filter_var($valor['value'], FILTER_VALIDATE_EMAIL)){
                    $envio = ProcesaCorreo::dispatch($pathpdf, $valor['value'] , $laboratorio, $folios->paciente()->first())->afterResponse();
                }
            }
        }
        
        if($envio){
            $response['msj'] = "Exito, correo enviado";
            $response['response'] = true;
        }else{
            $response['msj'] = "Error, correo no enviado";
            $response['response'] = false;
        }

        return $response;
    }

    // Genera resultados por whatsapp
    public function generate_sms_whatsapp(Request $request){
        // Fecha del dia
        $date = Date('dmys');

        $search = $request->only('folio');
        $seleccion = $request->only('seleccion');

        $paciente = Recepcions::where('folio', $search['folio'])->first()->paciente()->first();
        $laboratorio = Recepcions::where('folio', $search['folio'])->first()->sucursales()->first()->laboratorio()->first();

        // Datos del usuario
        $usuario        = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $usuario->labs()->first();
        $folios         = Recepcions::where('folio', $search['folio'])->first();
        // $img_valido     = base64_encode(Storage::disk('public')->get($folios->valida()->first()->firma));
        $img_valido     = base64_encode(Storage::disk('public')->get($laboratorio->firma_sanitario));
        // $barcode        = DNS1D::getBarcodeSVG($folios->folio, 'C128', 1.20, 35);

        // $logotipo = base64_encode(Storage::disk('public')->get($laboratorio->logotipo));
        $barcode        = DNS1D::getBarcodeSVG($folios->folio, 'C128', 1.20, 30, 'black', false);

        // Aqui seleccionan el membrete disponible de 3 opciones
        switch ($seleccion) {
            case 'principal':
                $fondo = $laboratorio->getMembrete($laboratorio->membrete);
                break;
            case 'secundario':
                $fondo = $laboratorio->getMembrete($laboratorio->membrete_secundario);
                break;
            case 'terciario':
                $fondo = $laboratorio->getMembrete($laboratorio->membrete_terciario);
                break;
            default:
                $fondo = $laboratorio->getMembrete($laboratorio->membrete);
                break;
        }

        if($fondo == null){
            $response['msg'] = 'Membrete no existe. Generando reporte...';
        }

        if($img_valido){
            $response['msg'] = 'Firma no existe o no fue agregada...';
        }

        $pdf = Pdf::loadView('invoices.imagenologia.invoice-single-imagenologia', [
            'laboratorio'   => $laboratorio, 
            'usuario'       => $usuario,
            'folios'        => $folios,

            'barcode'       => $barcode,

            'fondo'         => 'si',

            'barcode'       => $barcode,
            'membrete'      => 'data:image/jpeg;base64,' .base64_encode($fondo),
            'img_valido'    => $img_valido,
        ]);
        

        $pdf->setPaper('letter', 'portrait');
        $path = 'public/imagenologia/F-'.$folios->folio .'.pdf';
        $pathpdf = public_path() . '/storage/imagenologia/F-'.$folios->folio .'.pdf';
        $pathSave = Storage::put($path, $pdf->output());
        $response = ['pdf' => '/public/storage/imagenologia/F-'.$folios->folio .'.pdf'];

        $patient['telefono']    = $paciente->celular;
        $patient['nombre']      = $paciente->nombre;
        $patient['laboratorio'] = $laboratorio->nombre;
        $patient['url']         = url('public/storage/imagenologia/F-'. $folios->folio .'.pdf');

        return $patient;
    }
    // Ward para el reporte
    // Medidas de las imagenes 7.5 * 10
    // Individual
    public function genera_documento_resultados(Request $request){
        // dd($request->membrete);
        // Fecha del dia
        $date = Date('dmys');

        // Recepcion de datos
        $resultados = [];
        $folio = $request->only('folio');
        $estudios = $request->only('estudios');
        $clave = $request->only('clave');
        $membrete = $request->only('membrete');
        $seleccion = $request->seleccion;

        // Data
        $usuario        = Auth::user();
        $folios         = Recepcions::where('folio', $folio)->first();
        $path           = 'resultados/F-'.$folios->folio.'.pdf';
        // dd(Estudio::where('clave', $clave['clave'])->first());

        $pdfData = [
            'laboratorio'   => $usuario->labs()->first(), 
            'usuario'       => $usuario,
            'folios'        => $folios,
            'resultados'    => $this->resultadoService->getDataStudie($folios, Estudio::where('clave', $clave['clave'])->first()),
            'perfiles'      => null,
            'fondo'         => $membrete['membrete'], //Se usa para mostrar la firma cuando no se solicita membrete
            // 'membrete'      => 'data:image/png;base64,' .base64_encode($this->resultadoService->obtainWatermark($request->seleccion)),
            'barcode'       => $this->resultadoService->getBarcode($folios),
            'img_valido'    => $this->resultadoService->getSign($usuario->labs()->first()),
            'salto'         => $request->estilo,
        ];

        $pdf = $this->pdfService->generateAndStorePDF('invoices.resultados.invoice-all-resultado-membrete', $pdfData, 'letter', 'portrait', $path, false);

        Storage::disk('public')->put($path, $pdf->output());
        $folios->update(['res_file' => $path]);

        if($request->membrete === 'si'){
            $this->pdfService->insertWatermark($folios, $request->membrete, $request->seleccion, $path);
        }

        return response()->json([
            'pdf' =>  '/public/storage/' . $path
        ],201);
    }

    // Completos
    public function genera_resultados_todos(Request $request){
        // Recibimos data
        $folio = $request->only('folio');
        $membrete = $request->only('membrete');
        $seleccion = $request->seleccion;
        $salto = $request->only('estilo');
        // dd($folio, $membrete, $seleccion, $salto, $request, );
        
        // Datos del usuario
        $usuario        = Auth::user();
        $folios         = Recepcions::where('folio', $folio)->first();
        // $archivo = new PdfHelper($usuario, $folios, $seleccion, $membrete['membrete'] );
        $path       = 'resultados-completos/F-'.$folios->folio.'.pdf';

        $pdfData = [
            'laboratorio'   => $usuario->labs()->first(), 
            'usuario'       => $usuario,
            'folios'        => $folios,
            'resultados'    => $this->resultadoService->getDataStudie($folios),
            'perfiles'      => $this->resultadoService->getDataProfile($folios),
            'fondo'         => $membrete['membrete'], //Se usa para mostrar la firma cuando no se solicita membrete
            // 'membrete'      => 'data:image/png;base64,' .base64_encode($this->resultadoService->obtainWatermark($request->seleccion)),
            'barcode'       => $this->resultadoService->getBarcode($folios),
            'img_valido'    => $this->resultadoService->getSign($usuario->labs()->first()),
            'salto'         => $salto['estilo'],
        ];
        
        $pdf = $this->pdfService->generateAndStorePDF('invoices.resultados.invoice-all-resultado-membrete', $pdfData, 'letter', 'portrait', $path, false);
        // $pdf = $this->pdfService->generateAndStorePDF('invoices.resultados.invoice-all-resultado-membrete', $pdfData, 'letter', 'portrait', $path, false);
        Storage::disk('public')->put($path, $pdf->output());
        $folios->update(['res_file' => $path]);

        if($request->membrete === 'si'){
            $this->pdfService->insertWatermark($folios, $request->membrete, $request->seleccion, $path);
        }


        // SetProtection
        // dd(Storage::disk('public')->path($path));
        // $fileCompress = Storage::disk('public')->path($path);

        // PDFPasswordProtect::encrypt($fileCompress, $fileCompress, 'stevdeb');

        return response()->json([
            'pdf' =>  $path
        ],201);
        // return $archivo->generatePdfCaptura();
    }

        // JOB creado, realizar pruebas luego
        // try {
        //     $job  = GeneratePdf::dispatch($usuario, $folios, null, $seleccion, $membrete['membrete'] );
        //     Event::listen(pdfResultReceived::class, function (pdfResultReceived $event) {
        //     });

        //     $ruta = ['pdf' => '/public/storage/resultados-completos/F-'. $folio['folio'] .'.pdf'];
        //     return $ruta;
        // } catch (\Throwable $e) {
        //     dd($e);
        //     // Log::error("Error al generar reporte: ". $e->getMessage() );
        // }
        // $response   = ['pdf' => '/public/storage/resultados-completos/F-'.$folio['folio'].'.pdf']; //este es la ruta que recibira la vista

        // return $response;
        

    // Genera exportacion de los resultados
    public function export_resultados_todos(Request $request){
        // Fecha del dia
        $date = Date('dmys');

        // Recibimos data
        $all_estudios = [];
        $folio = $request->only('folio');
        $membrete = $request->only('membrete');
        $estudios = $request->only('estudios');
        $seleccion = $request->seleccion;

        // Datos del usuario
        $usuario        = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $usuario->labs()->first();
        $folios         = Recepcions::where('folio', $folio)->first();
        // dd($request);
        // $barcode        = DNS1D::getBarcodeSVG($folios->folio, 'C128', 1.20, 35);

        // if($folios->valida()->first()->firma){
            // $img_valido     = base64_encode(Storage::disk('public')->get($folios->valida()->first()->firma));
            // $img_valido     = base64_encode(Storage::disk('public')->get($laboratorio->firma_sanitario)); //revisar  wey
        // }

        // Esto debe generar solo una vez el archivo
        $lista_estudios = $folios->estudios()->get();
        foreach ($lista_estudios as $clave => $estudio) {

            $query = $folios->historials()->where('historials_has_recepcions.estudio_id', $estudio->id)->where('historials.estatus', 'validado')->get();
            
            if(! $query->isEmpty()){
                $all_estudios[$clave] = $estudio;
                $all_estudios[$clave]['analito'] = $estudio->analitos()->orderBy('analitos_has_estudios.orden', 'asc')->get();
                $all_estudios[$clave]['resultado'] = $folios->historials()->where('historials_has_recepcions.estudio_id', $estudio->id)->where('historials.estatus', 'validado')->get();
            }

            if($estudio->valida_qr == 'on'){
                // $pathQr   = URL::to('/') . '/resultados/valida/' . $folios->folio . '/' . $estudio->clave;
                // $all_estudios[$clave]['qr']  = base64_encode(DNS2DFacade::getBarcodeSVG($pathQr, 'QRCODE',5,5 ));
            }
            
        }

        $lista_perfiles = $folios->recepcion_profiles()->get();
        if($lista_perfiles->count() == 0){
            $all_perfiles = null;
        }else{
            foreach($lista_perfiles as $perfil_id => $perfil){
                    $all_perfiles[$perfil_id] = $perfil->toArray();
                foreach($perfil->perfil_estudio()->get() as $index => $estudio){
                    $query = $folios->historials()->where('historials_has_recepcions.estudio_id', $estudio->id)->where('historials.estatus', 'validado')->get();

                    if(! $query->isEmpty()){
                        $all_perfiles[$perfil_id]['estudios'][$index] = $estudio;
                        $all_perfiles[$perfil_id]['estudios'][$index]['analito'] = $estudio->analitos()->orderBy('analitos_has_estudios.orden', 'asc')->get();
                        $all_perfiles[$perfil_id]['estudios'][$index]['resultado'] = $folios->historials()->where('historials_has_recepcions.estudio_id', $estudio->id)->where('historials.estatus', 'validado')->get();
                    }

                    if($estudio->valida_qr == 'on'){
                        // $pathQr   = URL::to('/') . '/resultados/valida/' . $folios->folio . '/' . $estudio->clave;
                        // $all_perfiles[$perfil_id]['estudios'][$index]['qr']  = base64_encode(DNS2DFacade::getBarcodeSVG($pathQr, 'QRCODE',5,5 ));
                    }
                }
            }
        }

        
        // Genero el excel
        $nameExport = '/export-resultados/F-'.$folio['folio'].'.xlsx';
        $export     = new DatosExport($laboratorio, $usuario, $folios, $all_estudios, $all_perfiles);
        $archivo    = Excel::store($export,  $nameExport, 'public', null);
        // Excel::store(new InvoicesExport(2018), 'invoices.xlsx', 's3', null, 'private');

        // Guardo y obtengo ruta
        $path       = 'public/export-resultados/' . $nameExport;
        // $pathSave   = Storage::put($path, $archivo);
        $response   = ['xlsx' => '/public/storage/' . $nameExport]; //este es la ruta que recibira la vista
        
        return $response;
    }

    public function obtain_mails(Request $request){
        $folio = $request->only('folio');

        $recepcion = Recepcions::where('folio', $folio)->first();
        
        $patient['correo_patient'] = $recepcion->paciente()->first()->email;
        $patient['correo_doctor'] = $recepcion->doctores()->first()->email;
        $patient['correo_empresa'] = $recepcion->empresas()->first()->email;

        return response()->json([
            'success'   => true,
            'data'      => $patient 
        ],201);
    }
    
    public function mailer_genera_resultados_todos(Request $request){
        // Fecha del dia
        // dd($request);
        // $date = Date('dmys');

        // Recibimos la data
        $all_estudios   = [];
        $folio          = $request->only('folio');
        $membrete       = $request->only('membrete');
        $estudios       = $request->only('estudios');
        $seleccion      = $request->seleccion;

        // Datos del usuario
        $usuario        = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $usuario->labs()->first();
        $folios         = Recepcions::where('folio', $folio)->first();

        // $img_valido     = base64_encode(Storage::disk('public')->get($folios->valida()->first()->firma));
        // $barcode        = DNS1D::getBarcodeSVG($folios->folio, 'C128', 1.20, 35);

        // $pathpdf        = URL::to('/') .  '/public/storage/patient_files/F-'.$folio['folio'].'.pdf';

        // Path para entrega de resultados
        // $pathpdf        = url('/public/storage/resultados-completos/F-'.$folio['folio'].'.pdf');
        // $pathpdf        = public_path('/patient_files/F-'.$folio['folio'].'.pdf');
        // $pathpdf        = storage_path('app/public/patient_files/F-'.$folio['folio'].'.pdf');
        // Compress file to encription
        // $path       = 'resultados-completos/F-'.$folios->folio.'.pdf';
        // $fileCompress = Storage::disk('public')->path($path);
        // PDFPasswordProtect::encrypt($fileCompress, $fileCompress, $folios->token); #
        
        // $pathtemp       = storage_path('/public/storage/patient_files/F-'.$folio['folio'].'.pdf');
        // $response       = ['pdf' => '/public/storage/resultados-completos/F-'.$folio['folio'].'.pdf'];
        $pdf = URL::to('/') . '/public/storage/patient_files/F-'.$folio['folio'].'.pdf';
        $pathpdf = Storage::disk('public')->path('patient_files/F-' . $folio['folio'].'.pdf' );

        $envioPaciente          = ProcesaCorreo::dispatch($pdf, $pathpdf, $folios->paciente()->first()->email, $laboratorio, $folios->paciente()->first());
        $envioDoctor            = ProcesaCorreo::dispatch($pdf, $pathpdf, $folios->doctores()->first()->email, $laboratorio, $folios->paciente()->first());
        $envioEmpresa           = ProcesaCorreo::dispatch($pdf, $pathpdf, $folios->empresas()->first()->email, $laboratorio, $folios->paciente()->first());

        return response()->json([
            'response'  => true,
            'msj'       => "Enviando correo",
        ], 201);

    }

    public function send_multiple_correo(Request $request){
        // Fecha del dia
        $date = Date('dmys');

        // Recibo informacion
        $all_estudios = [];
        $folio = $request->only('folio');
        $membrete = $request->only('membrete');
        $estudios = $request->only('estudios');
        $correo = $request->only('correo');

        $seleccion = $request->seleccion;
        $dato = [];

        // Datos del usuario
        $usuario        = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $usuario->labs()->first();
        $folios         = Recepcions::where('folio', $folio)->first();

        $pathpdf = URL::to('/') . '/public/storage/resultados-completos/F-'.$folio['folio'].'.pdf';
        // $pathpdf        = url('/public/storage/patient_files/F-'.$folio['folio'].'.pdf');

        foreach($correo['correo'] as $key => $valor){
            if(filter_var($valor['value'],FILTER_VALIDATE_EMAIL)){
                $envio = ProcesaCorreo::dispatch($pathpdf, $valor['value'] , $laboratorio, $folios->paciente()->first())->afterResponse();
            }
        }


        return response()->json([
            'response'  => true,
            'msj'       => "Enviando correo",
        ], 201);
    }

    public function send_sms_direct(Request $request){
        //          %0A          - para realizar salto de linea.
        // $quita_espacio = explode(' ',$message['message']); 
        // $remove_space  = join('%20',$quita_espacio);

        // $agrega_salto = explode('.',$remove_space); 
        // $final_message  = join('.%0A',$agrega_salto);
        $number = $request->only('phone'); 
        $message = $request->only('message'); 
        
        
        $whatAppLink['url'] = 'https://api.whatsapp.com/send?phone=' . $number['phone'] . '&text=' . $message['message'];

        return $whatAppLink; 
    }

    public function recepcion_editar_index(Request $request){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
        // Areas
        $areas = User::where('id', Auth::user()->id)->first()->labs()->first()->areas()->get();
        

        $caja = User::where('id', Auth::user()->id)->first()->caja()->where('estatus', 'abierta')->first();
        
        if(isset($caja)){

            // Verifica tiempo de caja
            $fecha_inicial = $caja->created_at;
            $fecha_final = $fecha_inicial->diffInDays(Carbon::now());

            // Notifico si paso de 24 horas
            if($fecha_final == 0){
                
                session()->flash('status', 'Caja activa, recuerde que se cierra cada 24 horas, o cuando usted cierre manualmente la caja.');
            
            }elseif($fecha_final > 0 ){
                // Cierra caja
                $new_caja = Caja::where('id', $caja->id)->update(['estatus' => 'cerrada']);
                session()->flash('status', 'Caja cerrada automáticamente...');
            }
        }else{
            session()->flash('status','Debes aperturar caja antes de empezar a trabajar.' );
        }

        $empresas = User::where('id', Auth::user()->id)->first()->labs()->first()->empresas()->get();
        $pacientes = User::where('id', Auth::user()->id)->first()->labs()->first()->pacientes()->get();
        $doctores = User::where('id', Auth::user()->id)->first()->labs()->first()->doctores()->get();
        // $recepcions = User::where('id', Auth::user()->id)->first()->sucursal()->first()->folios()->orderBy('id', 'DESC')->get();

        // $user = User::where('id', Auth::user()->id)->with('sucursal.folios')->first();

        // $folios = $user->sucursal->flatMap(function ($sucursal) {
        //     return $sucursal->folios;
        // });

        return view('recepcion.editar.index',[
            'active'    => $active,
            'sucursales'=> $sucursales,
            // 'areas'     => $areas, 
            // 'empresas'  => $empresas,
            // 'pacientes' => $pacientes, 
            // 'doctores'  => $doctores, 
            // 'recepcions'=> $folios
            // 'listas'    => $listas,
        ]);
    }

    public function recepcion_editar($id){  
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        $folio = Recepcions::where('id', $id)->first();
        $listas = $folio->lista()->get();

        // Registro a la bitacora
        // Logger::logAction()
        $nota = 'ingreso al folio número:'. $folio->folio;
        session()->flash('note', $nota);

        return view('recepcion.editar.editar', [
            'active'    =>$active,
            'sucursales'=>$sucursales, 
            'folio'     =>$folio,
            'lista'     =>$listas
        ]);
    }

    public function recepcion_actualizar(Request $request, $id){
        dd($request->data);
        // $recep = Recepcions::findOrFail($id);

        // $recep->folio = $request->folio;
        // $recep->numOrden = $request->numOrden;
        // $recep->numRegistro = $request->numRegistro;
        // $recep->id_empresa = $request->id_empresa;
        // $recep->servicio = $request->servicio;
        // $recep->tipPasiente = $request->tipPasiente;
        // $recep->turno = $request->turno;
        // $recep->id_doctor = $request->id_doctor;
        // $recep->numCama = $request->numCama;
        // $recep->peso = $request->peso;
        // $recep->talla = $request->talla;
        // $recep->fur = $request->fur;
        // $recep->medicamento = $request->medicamento;
        // $recep->diagnostico = $request->diagnostico;
        // $recep->observaciones = $request->observaciones;
        // $recep->listPrecio = $request->listPrecio;

        // $recep->save();
        // return redirect()->route('stevlab.recepcion.editar');
        // $recepcions = $this->folioService->update($arreglo);      

        if($request['prefolio']){
            // $this->prefolioService->asociarRecepcion($request['prefolio'], $recepcions);
        }

        // Invoco al logger
        // Logger::logAction($request, 'Folios', $recepcions->id, 'store');
        
        // Preparar los documentos de consentimiento
        // return response()->json([
        //     'success'   => true,
        //     'data'      => $recepcions,
        //     'msj'       => 'Folio creado con exito.',
        // ], 200);

    }

    public function recover_estudios_edit(Request $request){ //revisar 
        $folio = $request->only('identificador');
        $query = Recepcions::where('id', $folio['identificador'])->first();
        $precio = $query->lista()->get();
        return response()->json([
            'success' => true,
            'data'    => $precio
        ],201);
        // Evaluo si la empresa tiene lista de precio
        // if($precio->precio()->first() != null){
        //     // Obten lista
        //     $lista = $precio->precio()->first()->lista()->get();
        //     // Si la lista no esta vacia
        //     if($lista->isNotEmpty()){
        //         $response = [];
        //         $estudios = Recepcions::where('id', $folio['identificador'])->first()->estudios()->get();
        //         $perfiles = Recepcions::where('id', $folio['identificador'])->first()->recepcion_profiles()->get();
        //         $imagenes = Recepcions::where('id', $folio['identificador'])->first()->picture()->get();
        
        //         foreach ($lista as $key => $value) {
        //             foreach ($estudios as $estudio) {
        //                 if($value->clave == $estudio->clave){
        //                     $response[$key] = $value->toArray();
        //                 }else{
        //                     // $response[$key] = $estudio->toArray();
        //                 }
        //             }
        //             foreach ($perfiles as $perfil) {
        //                 if($value->clave == $perfil->clave){
        //                     $response[$key] = $value->toArray();
        //                 }
        //             }

        //             foreach ($imagenes as $imagen) {
        //                 if($value->clave == $imagen->clave){
        //                     $response[$key] = $value->toArray();
        //                 }
        //             }
        //         }
        //         // dd($response);

        //     // Si la lista esta vacia
        //     }else{
        //         $response['estudios'] = $query->estudios()->get();
        //         $response['perfiles'] = $query->recepcion_profiles()->get();
        //         $response['imagenes'] = $query->picture()->get();

        //     }
        // // Si no tiene lista de precios
        // }else{
        //     $response['estudios'] = $query->estudios()->get();
        //     $response['perfiles'] = $query->recepcion_profiles()->get();
        //     $response['imagenes'] = $query->picture()->get();
        // }
        
        
        
        // return json_encode($response);
    }

    // public function recepcion_estudio_edit_precio(Request $request){
    //     $identificador = $request->only('estudio');
    //     $empresa = $request->only('empresa');

    //     $estudio = Estudio::where('id', $identificador['estudio'])->first();
    //     $descuento = Empresas::where('id', $empresa['empresa'][0])->first()->precio()->first();
        
    //     if(isset($descuento)){
    //         $lista = Empresas::where('id', $empresa['empresa'][0])->first()
    //                 ->precio()->where('empresas_has_precios.empresas_id', '=', $empresa['empresa'][0])->first()
    //                 ->estudios()->where('estudios_has_precios.estudio_id', $estudio->id)->first();
    //         // Si esta en la lista hace todo esto, en caso contrario retorna solo el estudio con el precio base
    //         if(isset($lista)){
    //             $calculo = $estudio->precio - ($estudio->precio / 100 * $descuento->descuento);
    //             return $calculo;
    //         }else{
    //             return null;
    //         }
    //     }
    //     return null;
    // }

    public function recepcion_perfil_edit_precio(Request $request){
        $peril = $request->only('perfil');
        $empresa = $request->only('empresa');

        // $estudio = $folio
        // ->estudios()
        // ->when($request->areaId != 'todo', function ($query) use ($request){
        //     $query->whereHas('area', function($query) use ($request){
        //         $query->where('area_id', $request->areaId);
        //     });
        // })
        // ->whereNotIn('recepcions_has_estudios.estudio_id', function ($subquery) use ($folio){
        //     $subquery->select('estudio_id')
        //         ->from('profiles_has_estudios')
        //         ->whereIn('profile_id', $folio->recepcion_profiles()->pluck('profiles.id')->toArray());
        // })
        // ->get();

        $perfil = Profile::where('id', $peril['perfil'])->first();
        $descuento = Empresas::where('id', $empresa['empresa'][0])->first()->precio()->first();

        if(isset($descuento)){
            $lista = Empresas::where('id', $empresa['empresa'][0])->first()
                ->precio()->where('empresas_has_precios.empresas_id', '=', $empresa['empresa'][0])->first()
                ->profiles()->where('profiles_has_precios.profile_id', $perfil->id)->first();
    
            if(isset($lista)){
                $calculo = $perfil->precio - ($perfil->precio / 100 * $descuento->descuento);
                return $calculo;
            }else{
                return null;
            }
        }
        return null;

    }

    public function recepcion_estudio_edit_remove(Request $request){
        $recibo = $request->only('estudio');
        $identificador = $request->only('folio');

        $folio = Recepcions::where('id', $identificador['folio'])->first();

        $precio = $folio->lista()->where('clave', $recibo['estudio'])->first();

        switch ($precio->tipo) {
            case 'Estudio':
                $estudio = $folio->estudios()->where('clave', $recibo['estudio'])->first();
                activity('recepcion')->performedOn($folio)->withProperties(['estudio' => $estudio->clave])->log('Estudio eliminado');
                $folio->estudios()->detach($estudio);
                break;
            case 'Perfil':
                $perfil = $folio->recepcion_profiles()->where('clave', $recibo['estudio'])->first();
                activity('recepcion')->performedOn($folio)->withProperties(['perfil' => $perfil->clave])->log('Perfil eliminado');
                foreach ($perfil->perfil_estudio()->get() as $key => $value) {
                    $folio->estudios()->detach($value);
                }
                $folio->recepcion_profiles()->detach($perfil);
                break;
            case 'Imagenologia':
                $estudio = $folio->picture()->where('clave', $recibo['estudio'])->first();
                activity('recepcion')->performedOn($folio)->withProperties(['imagen' => $estudio->clave])->log('Imagen eliminado');
                $folio->picture()->detach($estudio);
                break;
            default:
                print('No contemplado');
                break;
        }

        $eliminar = $folio->lista()->detach($precio);

        
        // Bitacora 

        if($eliminar){
            return response()->json([
                'response'  => true,
                // 'note'      => 'DELETE: estudio con clave ' . $estudio->clave. ' eliminado de folio ' . $folio->folio, 
            ], 200);
        }else{
            return response()->json([
                'response'  => false,
                'note'      => 'ERROR: estudio no eliminado', 
            ], 400);
        }
    }

    public function recepcion_perfil_edit_remove(Request $request){
        $recibo = $request->only('perfil');
        $identificador = $request->only('folio');

        $perfil = Profile::where('clave', $recibo['perfil'])->first();
        $folio = Recepcions::where('id', $identificador['folio'])->first();

        $eliminar = $folio->recepcion_profiles()->detach($perfil);

        
        if($eliminar){
            return response()->json([
                'response'  => true,
                // 'note'      => 'DELETE: perfil con clave ' . $perfil->clave. ' eliminado de folio ' . $folio->folio, 
            ], 200);
        }else{
            return response()->json([
                'response'  => false,
                'note'      => 'ERROR: perfil no eliminado', 
            ], 400);
        }
    }

    public function recepcion_img_edit_remove(Request $request){
        $recibo = $request->only('img');
        $identificador = $request->only('folio');

        $img = Picture::where('clave', $recibo['img'])->first();
        $folio = Recepcions::where('id', $identificador['folio'])->first();

        $eliminar = $folio->picture()->detach($img);


        
        if($eliminar){
            return response()->json([
                'response'  => true,
                'note'      => 'DELETE: imagenologia con clave ' . $img->clave. ' eliminado de folio ' . $folio->folio, 
            ], 200);
        }else{
            return response()->json([
                'response'  => false,
                'note'      => 'ERROR: imagenologia no eliminado', 
            ], 400);
        }
    }

    public function recepcion_folio_update(Request $request){
        // dd($request);
        $data   = $request->except(['_token', 'comentarios', 'folio']);
        $folio  = Recepcions::where('folio', $request->folio)->first();
        $coment = $request->comentarios;
        $update = $folio->update($data);

        $comentario = Observaciones::create(['observacion' => $coment]);
        $comentario->comentarios()->save($folio);

        activity('recepcion')->performedOn($folio)->withProperties(['observacion' => $comentario->observacion])->log('Folio actualizado');

        return response()->json([
            'success'   => true,
            'data'      => $folio->id,
            'msj'       => 'Folio actualizado con exito.',
        ],201);


        // $data = $request->only('data');
        // $estudios = $request->only('lista');
        // $perfiles = $request->only('perfiles');
        // $imagenes = $request->only('imagenes');
        // $total = $request->only('total');
        // $folio = $request->only('folio');
        // $sucursal_activa = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();

        // $dato = [];
        // foreach($data['data'] as $key=>$valor){
        //     $dato[$valor['name']] = $valor['value'];
        // }


        // $old_folio = Recepcions::where('id', $folio['folio'])->first();
        // // $old_paciente = Pacientes::where('id', $dato['id_paciente'])->first();
        // // $old_empresa = Empresas::where('id', $dato['id_empresa'])->first();
        // $dato['num_total'] = $total['total'];
        
        // // $paciente = Pacientes::where('id', $dato['id_paciente'])->first();

        // $folios = Recepcions::where('id', $folio['folio'])->update([
        //     'fecha_entrega'     => $dato['fecha_entrega'],
        //     'tipPasiente'       => $dato['tipPasiente'],
        //     'turno'             => $dato['turno'],
        //     'numCama'           => $dato['numCama'],
        //     'peso'              => $dato['peso'],
        //     'talla'             => $dato['talla'],
        //     'fur'               => $dato['fur'],
        //     'f_flebotomia'      => $dato['f_flebotomia'],
        //     'h_flebotomia'      => $dato['h_flebotomia'],
        //     'num_vuelo'         => $dato['num_vuelo'],
        //     'pais_destino'      => $dato['pais_destino'],
        //     'aerolinea'         => $dato['aerolinea'],
        //     'medicamento'       => $dato['medicamento'],
        //     'observaciones'     => $dato['observaciones'],
        //     // 'id_paciente'       => $dato['id_paciente'],
        //     // 'id_empresa'        => $dato['id_empresa'],
        //     'id_doctor'         => $dato['id_doctor'],
        //     'num_total'         => $dato['num_total'],

        // ]);

        // $recepcions = Recepcions::where('id', $folio['folio'])->first();

        // $comentario = Observaciones::create(['observacion' => $dato['comentarios']]);
        // $comentario->comentarios()->save($recepcions);
        
        // // Desasignamos pacientes
        // // $old_paciente->recepcions()->detach($old_folio);
        // // Reasignamos al nuevo paciente
        // // $paciente->recepcions()->save($recepcions);
        // // // actualizamos o agregamos los estudios 
        // if($estudios){
        //     foreach ($estudios as $key => $value){
        //         foreach($value as $id => $valor){
        //             $estudio = Estudio::where('clave', $valor)->first();
        //             $area   = $estudio->areas()->first();
        //             // Detach
        //             $old_folio->estudios()->detach($estudio);
        //             // Ward para editar
        //             $area->recepcions()->detach($recepcions);
        //             // Guardamos los estudios asignados al folio
        //             $old_folio->estudios()->save($estudio);
        //             // Guardamos las areas que corresponden con el folio
        //             $area->recepcions()->save($recepcions);
        //         }
        //     }
        // }

        // if($perfiles){
        //     $perfilClaves = $perfiles['perfiles'];
        //     $profileIds = Profile::whereIn('clave', $perfilClaves)->pluck('id');

        //     if (!$profileIds->isEmpty()) {
        //         $recepcions->recepcion_profiles()->sync($profileIds);
        //     }

        //     foreach($perfiles as $key=>$value){
        //         $profile = Profile::where('clave', $value)->first();

        //         foreach ($profile->perfil_estudio()->get() as $a => $estudio) {
        //             $area = $estudio->areas()->first();
        //             $area->recepcions()->detach($recepcions);
        //             $area->recepcions()->save($recepcions);
        //         }
        //     }
        // }

        // if($imagenes){
        //     foreach($imagenes as $key=>$value){
        //         foreach($value as $id => $valor){
        //             $estudio    = Picture::where('clave', $valor)->first();
        //             $area       = $estudio->deparment()->first();
        //             // Detach
        //             $old_folio->picture()->detach($estudio);
        //             // Guardamos los estudios asignados al folio
        //             $old_folio->picture()->attach($estudio, ['deparments_id' => $area->id]);
        //         }
        //     }
        // }

        // // Logger
        // Logger::logAction($request, 'Folios', $old_folio->id, 'update');
        
        // if($folio) {
        //     return response()->json([
        //         'response'  => true,
        //         'data'      => $recepcions->id,
        //         'msj'       => 'Folio creado con exito.',
        //         // 'note'      => 'UPDATE:  folio actualizado con el numero:' . $recepcions->folio, 
        //     ], 200);
        // } else {
        //     return response()->json([
        //         'response'  => false,
        //         'msj'       => 'Folio creado con exito.',
        //         'note'      => 'ERROR:  folio no actualizado', 
        //     ], 400);
        // }

    }

    public function recepcion_folio_update_estudios(Request $request){
        // dd($request);
        $response = $this->folioService->linkPreciosUpdate($this->folioService->getFolioByID($request->id), $request->lista);
        activity('recepcion')->performedOn($this->folioService->getFolioByID($request->id))->log('Folio con estudios actualizado');

        return response()->json([
            'success' => true,
            'mensaje' => 'Estudios actualizados con éxito',
            'data'    => $response
        ],201);
    }

    public function genera_ingreso_edit(Request $request){
        
        // dd($request);
        // $folios  = $request->only('folio');
        // // $total  = $request->only('total');
        // // $metodo = $request->only('metodo');
        // // $observaciones = $request->only('observaciones');
        // // $factura = $request->only('factura');
        // // $pago_anterior = $request->only('pago_anterior');
        // // $ancho = $request->only('ancho');
        // $prueba = $request->only('prueba');
        // // $descuento = $request->only('descuento');
        // // $subtotal = $request->only('subtotal');
        // // $response = $request->only('prueba');
        // // dd(isEmpty($response));

        // // Obtengo usuario
        // $user           = User::where('id', Auth::user()->id)->first();
        // // Obtengo laboratorio
        // $laboratorio    = $user->labs()->first();
        // // Obten logotipo del laboratorio
        // $logotipo       = base64_encode(Storage::disk('public')->get($laboratorio->logotipo));
        // // Obtengo caja activa
        // $caja           = $user->caja()->where('estatus', 'abierta')->first();
        // // Obtengo sucursal
        // $sucursal       = $user->sucs()->where('estatus', 'activa')->first();
        // // Obtengo folio
        // $folio          = Recepcions::where('id', $folios['folio'])->first();
        // // Obten al paciente
        // $paciente       = $folio->paciente()->first();
        // // Calcula su edad
        // $edad = $paciente->edad != null ? $paciente->edad :  Carbon::createFromFormat('d/m/Y', $paciente->fecha_nacimiento)->age;
        // // Obten al doctor
        // $doctor         = Doctores::where('id', $folio->id_doctor)->first();        
        // //barcode
        // $barcode        = DNS1D::getBarcodeSVG($folio->folio, 'C128', 1.20, 20, "black", false);
        // // qr
        // $path           = URL::to('/') .'/resultados/search/resultado/'.$folio->id;

        // $qr             = DNS2DFacade::getBarcodeSVG($path, 'QRCODE',5,5 );


        // // Evalua si el total es mayor que el subtotal
        // // if($request->total >= $request->subtotal){
        // //     $new_total = $request->subtotal;
        // // }else{
        // //     $new_total = $request->total;
        // // }

        // // // Crea pago
        // // $pago = Pago::create([
        // //     'descripcion'       => 'Ánalisis de laboratorio',
        // //     'importe'           => $new_total,
        // //     'tipo_movimiento'   => 'ingreso',
        // //     'metodo_pago'       => $metodo['metodo'],
        // //     'observaciones'     => $observaciones['observaciones'],
        // // ]);

        // $pago           = PaymentHelper::payment($request, $caja, $user);



        // //Esto pa que es ?  || ya vi, obten el total registrado
        // $new_monto = 0;
        // if(!isEmpty($prueba['prueba'])){
        //     foreach ($prueba['prueba'] as $key => $value) {
        //         $new_monto = $new_monto + $value['costo'];
        //     }
        // }else{
        //     $new_monto = $folio->num_total;
        // }
        
        // // Ahora obten el descuento pasado y añadele el descuento actual si es que se añadio (de todas maneras recoge 0 si no se edita)
        // // $new_descuento['descuento'] = $folio->descuento + $descuento['descuento'];

        // if($request->estado == 'pagado'){
        //     $folio->update([
        //         'estado' => 'pagado'
        //     ]);
        //     // $actualiza_recepcion = Recepcions::where('id', $folio->folio)->update(['estado' => 'pagado']);
        // }else{
        //     // $actualiza_recepcion = Recepcions::where('id', $folio->folio)->update(['estado' => 'no pagado']);
        // }

        // // Actualiza el folio con los nuevos datos
        // $update_descuento = $folio->update([
        //     'num_total' => $new_monto, 
        //     'descuento' => $folio->descuento + $request->descuento,
        // ]);

        // // Aqui suma el importe de todos los abonos hechos mas el nuevo ingreso
        // $monto = $folio->pago()->sum('importe') + $request->monto;
        // // Calcula el resto pendiente
        
        // // $resta      = ($request->total >= $request->subtotal) ? (($folio->num_total - $request->total) - $request->descuento) : 0;

        // $resta = ($folio->num_total - $monto) - $folio->descuento;

        // //Aqui evalua si pasaron a estatus pagado en caso contrario 
        // // observacion: (cuando pagaron completo y añadieron un nuevo estudio, actualiza a no pagado)
        

        // // Evalua la lista recogida con la lista de precios
        // // Evalua si esta vacio el arreglo
        // if(isEmpty($request->prueba)){
        //     // Evalua si la empresa tiene lista
        //     if($folio->empresas()->first()->precio()->first() != null){
        //         // Obten lista
        //         $lista = $folio->empresas()->first()->precio()->first()->lista()->get();
        //         // Si la lista no esta vacia compara el arreglo de la vista con lo de la lista
        //         if($lista->isNotEmpty()){
        //             $response = [];
        //             $estudios = $folio->estudios()->get();
        //             $perfiles = $folio->recepcion_profiles()->get();
        //             $imagenes = $folio->picture()->get();

        //             foreach ($lista as $key => $value) {
        //                 foreach ($estudios as $estudio) {
        //                     if(strcasecmp($value->clave, $estudio->clave) == 0){
        //                         $response[$key] = $value->toArray();
        //                     }
        //                 }
        //                 foreach ($perfiles as $perfil) {
        //                     if($value->clave == $perfil->clave){
        //                         $response[$key] = $value->toArray();
        //                     }
        //                 }
        //                 foreach ($imagenes as $imagen) {
        //                     if($value->clave == $imagen->clave){
        //                         $response[$key] = $value->toArray();
        //                     }
        //                 }
        //             }
        //         // En caso de estar vacio, obten todos los estudios y perfiles del folio
        //         }else{
        //             $estudies           = $folio->estudios()->get();
        //             $profiles           = $folio->recepcion_profiles()->get();
        //             $imagenes           = $folio->picture()->get();
        //             $response           = $estudies->merge($profiles);
        //             $response           = $estudies->merge($imagenes);
        //         }
        //     // Si empresa no tiene lista obten los estudios y perfiles del estudio;
        //     }else{
        //         $estudies           = $folio->estudios()->get();
        //         $profiles           = $folio->recepcion_profiles()->get();
        //         $imagenes           = $folio->picture()->get();
        //         $response           = $estudies->merge($profiles);
        //         $response           = $estudies->merge($imagenes);
        //     }
        // }

        // $ticket         = TicketHelper::ticket($request, $folio, $user, $pago, $response, $barcode, $qr, $resta);

        // // Se creo el pago correctamente?
        // // if($pago){
        // //     // // Asocia el pago con la caja
        // //     // $caja->pagos()->save($pago);
        // //     // // Asocia el pago con el folio
        // //     // $folio->pago()->save($pago);
        // //     // // Asocia el usuario con el pago
        // //     // $user->pago()->save($pago);
        // //     // // Asocia la sucursal en donde se realizo el pago
        // //     // $sucursal->pago()->save($pago);
        // //     // // Mensaje
        // //     // $request['response'] = true;
        // //     // // Calcula las entras + el nuevo importe
        // //     // $monto_anterior = $caja->entradas;
        // //     // $monto_actual = $monto_anterior + $new_total;

        // //     // // Actualiza la entradas con el nuevo monto y el total
        // //     // $actualizar_caja = User::where('id', Auth::user()->id)->first()
        // //     //     ->caja()->where('estatus', 'abierta')->update([
        // //     //     'entradas' => $monto_actual,
        // //     //     'total'    => $monto_actual,
        // //     // ]);

        // //     // // Actualiza estadisticas de cada ingreso
        // //     // if($metodo['metodo'] == 'efectivo'){
        // //     //     $monto_efectivo_anterior = $caja->ventas_efectivo;
        // //     //     $monto_efectivo_actual = $monto_efectivo_anterior + $total['total'];
        // //     //     $actualizar_caja = User::where('id', Auth::user()->id)->first()->caja()->where('estatus', 'abierta')->update([
        // //     //         'ventas_efectivo' => $monto_efectivo_actual ,
        // //     //     ]);
        // //     // }else if($metodo['metodo'] == 'tarjeta'){
        // //     //     $monto_tarjeta_anterior = $caja->ventas_tarjeta;
        // //     //     $monto_tarjeta_actual = $monto_tarjeta_anterior + $total['total'];
        // //     //     $actualizar_caja = User::where('id', Auth::user()->id)->first()->caja()->where('estatus', 'abierta')->update([
        // //     //         'ventas_tarjeta' => $monto_tarjeta_actual,
        // //     //     ]);
        // //     // }else if($metodo['metodo'] == 'transferencia'){
        // //     //     $monto_transferencia_anterior = $caja->ventas_transferencia;
        // //     //     $monto_transferencia_actual = $monto_transferencia_anterior + $total['total'];
        // //     //     $actualizar_caja = User::where('id', Auth::user()->id)->first()->caja()->where('estatus', 'abierta')->update([
        // //     //         'ventas_transferencia' => $monto_transferencia_actual ,
        // //     //     ]);
        // //     // }

        // //     if($factura['factura']=='ticket'){
        // //         $medida = ($ancho['ancho'] / 2.54) * 72;
        // //         // Para ticket
        // //         $pdf        = Pdf::loadView('invoices.ticket.ticket', [
        // //             'ancho'         => $ancho['ancho'],
        // //             'logotipo'      => $logotipo,
        // //             'laboratorio'   => $laboratorio,
        // //             'folios'        => $folio,
        // //             'paciente'      => $paciente,
        // //             'edad'          => $edad,
        // //             'doctor'        => $doctor,
        // //             'usuario'       => $user,
        // //             'estudios'      => $response,
        // //             'pago'          => $pago,
        // //             'barcode'       => $barcode,
        // //             'sucursal'      => $sucursal,
        // //             'logo'          => $logotipo,
        // //             'qr'            => $qr,
        // //             'resta'         => $resta,
        // //             'descuento'     => $new_descuento,
        // //             'subtotal'      => $subtotal,
        // //         ]);
        // //         $pdf->setPaper(array(0,0, $medida ,700), 'portrait');
        // //     }else{
        // //         // Para hoja
        // //         $pdf        = Pdf::loadView('invoices.ticket.ticket-letter-complete', [
        // //             'logo'          => $logotipo,
        // //             'laboratorio'   => $laboratorio,
        // //             'folios'        => $folio,
        // //             'paciente'      => $paciente,
        // //             'edad'          => $edad,
        // //             'doctor'        => $doctor,
        // //             'usuario'       => $user,
        // //             'pago'          => $pago,
        // //             'barcode'       => $barcode,
        // //             'sucursal'      => $sucursal,
        // //             'logo'          => $logotipo,
        // //             'qr'            => $qr,
        // //             'resta'         => $resta,
        // //             'estudios'      => $response,
        // //             'descuento'     => $new_descuento,
        // //             'subtotal'      => $subtotal,
        // //         ]);
        // //         $pdf->setPaper('letter', 'portrait');
        // //     }

        // //     $path       = 'public/tickets/F-'. $folio->folio . '.pdf';
        // //     $pathSave   = Storage::put($path, $pdf->output());
        // //     $request['pdf'] = '/public/storage/tickets/F-'. $folio->folio . '.pdf';

        // //     // Logger
        // //     Logger::logAction($request, 'Pago', $pago->id, 'store', 'Caja', $caja->id);
        // // }else{
        // //     $request['response'] = false;
        // // }
        // // return $request;
        // if($pago && $ticket){
        //     return response()->json([
        //         'response'  => true,
        //         'pdf'       => '/public/storage/tickets/F-'. $folio->folio . '.pdf',
        //         'msj'       => 'Pago con exito.',
        //     ], 200);
        // }else{
        //     return response()->json([
        //         'response'  => false,
        //         'msj'       => 'Pago no procesado.',
        //     ], 200);
        // }
    }

     // Para tamaño de insadisa
    // $barcode = DNS1D::getBarcodeSVG($folio->folio, 'C128', 2, 40);
    // Para tamaño de 40 x 22
    // $barcode = DNS1D::getBarcodeSVG($folio->folio, 'C128', 1.4, 30);
    // Para tamaño de 38 x 25
    // $barcode = DNS1D::getBarcodeSVG($folio->folio, 'C128', 1.35, 35);
    // $barcode = DNS1D::getBarcodeSVG($folio->folio, 'C128', 1.20, 35);
     // 38x25 mm y 40x22
    // Tamaño de insadisa
    // $pdf->setPaper(array(0, 0, 141, 70), 'portrait');

    // Tamaño de 40 x 22
    // 113 x 62
    // $pdf->setPaper(array(0, 0, 113, 62), 'portrait');
    // Tamaño de 38 x 25
    // 107 x 70

    public function recepcion_re_etiquetas($id){
        $estudios_areas = [];
        $perfil_estudio = [];
        $id = $id;
        $folio = Recepcions::where('id', $id)->first();

        $estudios       = Recepcions::where('id', $id)->first()
            ->estudios()->whereNotIn('recepcions_has_estudios.estudio_id', function ($subquery) use ($folio){
                $subquery->select('estudio_id')
                    ->from('profiles_has_estudios')
                    ->whereIn('profile_id', $folio->recepcion_profiles()->pluck('profiles.id')->toArray());
            })->get();
        $perfiles       = Recepcions::where('id', $id)->first()->recepcion_profiles()->get();
        $pictures       = Recepcions::where('id', $id)->first()->picture()->get();

        if(!isset($estudios)){
            $estudio = null;
        }

        if(!isset($perfiles)){
            $perfil_estudio = null;
        }
        if(!isset($pictures)){
            $picture = null;
        }

        // Revisar esta weonada
        foreach($estudios as $key => $estudio){
            $estudio->recipiente = $estudio->recipientes()->first()->descripcion;
        }

        $groupEstudios = collect();
        foreach($perfiles as $key => $perfil){
            foreach ($perfil->perfil_estudio()->get() as $key => $estudio) {
                $estudio->recipiente = $estudio->recipientes()->first()->descripcion;
                
                $groupEstudios->push($estudio); 
            }
        }

        $estudiosAgrupados = $estudios->groupBy('recipiente');
        $perfilesAgrupados = $groupEstudios->groupBy('recipiente');
        
        $areas = User::where('id', Auth::user()->id)->first()->labs()->first()->areas()->get();

        $paciente       = Recepcions::where('id', $id)->first()->paciente()->first();
        $edad = $paciente->edad != null ? $paciente->edad :  Carbon::createFromFormat('d/m/Y', $paciente->fecha_nacimiento)->age;

        $barcode = DNS1D::getBarcodeSVG($folio->folio, 'C128', 1.70, 30, 'black' ,true);

        $pdf        = Pdf::loadView('invoices.etiquetas.etiquetas-laboratorio', [
            'paciente'  => $paciente,
            'edad'      => $edad,
            'areas'     => $areas,
            'estudios'  => $estudiosAgrupados,
            'perfiles'  => $perfilesAgrupados,
            'pictures'  => $pictures,
            'barcode'   => $barcode,
        ]);
        
        $ancho = (5.2 / 2.54) * 72;
        $alto  = (2.5 / 2.54) * 72;
        
        $pdf->setPaper(array(0, 0, $ancho, $alto), 'portrait');

        $path       = 'public/etiquetas-laboratorio/F-'. $folio->folio . '.pdf';
        $pathSave   = Storage::put($path, $pdf->output());
        $request    = ['etiquetas'=> '/public/storage/etiquetas-laboratorio/F-'. $folio->folio . '.pdf'];

        return $pdf->stream();

    }

    public function recepcion_re_ticket($id){
        $folio = Recepcions::where('id', $id)->first();
        // $logotipo   = base64_encode(Storage::disk('public')->get($laboratorio->logotipo));
        // return response()->download(Storage::disk('public')->get("tickets/F-". $folio->folio. ".pdf"));
        return response()->download('/public/storage/tickets/F-'. $folio->folio .'.pdf');

        // $request    = ['pdf'=> '/public/storage/tickets/F-'. $folio->folio . '.pdf'];

    }

    public function recepcion_delete_folio($id, Request $request){
        $delete = Recepcions::where('id', $id)->delete();
        activity('recepcion')->performedOn(Recepcions::withTrashed()->find($id))->log('Folio eliminado');
        return redirect()->route('stevlab.recepcion.editar');
    }

    public function paciente_guardar(Request $request){
        $laboratorio = User::Where('id', Auth::user()->id)->first()->labs()->first();
        $paciente = $request->validate([
            'nombre'            => 'required',
            'domicilio'         => 'nullable', 
            'colonia'           => 'nullable',
            'sexo'              => 'required', 
            'fecha_nacimiento'  => 'required',
            'celular'           => 'nullable', 
            'email'             => 'nullable',
            'id_empresa'        => 'required', 
            'seguro_popular'    => 'nullable',
            'vigencia_inicio'   => 'nullable', 
            'vigencia_fin'      => 'nullable',
        ]);
        $recep = Pacientes::create($paciente);

        $laboratorio->pacientes()->save($recep);
        return redirect()->route('stevlab.catalogo.pacientes');
    }

    public function doctores_guardar(Request $request){
        $laboratorio = User::Where('id', Auth::user()->id)->first()->labs()->first();
        $doctor = $request->validate([
            'clave' => 'required | unique:doctores',
            'nombre' => 'required', 
            'ap_paterno' => 'required',
            'ap_materno' => 'required', 
            'telefono' => 'nullable',
            'celular' => 'nullable', 
            'email' => 'nullable',
        ]);
        $recep = Doctores::create($doctor);
        $laboratorio->doctores()->save($recep);
        return back();
    }

    // Prefolios para recepcion
    public function prefolio_index(){
        $user           = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $user->labo()->first();
        //Verificar sucursal
        $active         = $user->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales     = $user->sucs()->orderBy('id', 'asc')->get();

        // $prefolios  = $laboratorio->prefolios()->orderBy('id', 'asc')->paginate(10);

        return view('recepcion.prefolios.index', [
                'active'        => $active, 
                'sucursales'    => $sucursales,  
                // 'prefolios'     => $prefolios
            ]);
    }

    public function prefolio_get_lista(Request $request){
        // dd($request);
        $user           = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $user->labo()->first();


        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');
        // Binding de las columnas que manda jquery datatable
        switch ($orderColumn) {
            case 0:
                $column = 'id';
                break;
            case 1:
                $column = 'prefolio'; 
                break;
            case 2:
                $column = 'nombre';
                break;
            case 3:
                $column = 'doctor'; 
                break;
            case 3:
                $column = 'created_at'; 
                break;
            default:
                $column = 'id'; 
                break;
        }

        $prefolios = Prefolio::select('prefolios.id', 'prefolios.nombre', 'prefolios.prefolio', 'prefolios.doctor', 'prefolios.created_at')
            ->when($searchValue !== null, function ($query) use ($searchValue){
                $query->where('prefolio', 'LIKE', '%'.$searchValue.'%')
                    ->orWhere('nombre', 'LIKE', '%'.$searchValue.'%')
                    ->orWhere('created_at', 'LIKE', '%'.$searchValue.'%')
                    ->orWhereHas('doctor', function ($query) use ($searchValue){
                        $query->where('users.nombre', 'LIKE', '%'. $searchValue .'%');
                    });
            })->when(($orderColumn !== null && $orderDir !== null), function ($query) use ($column, $orderDir){
                $query->orderBy($column, $orderDir);
            })->with(['user' => function ($query){
                $query->select('users.name');
            }])
            ->skip($start)
            ->take($length)
            ->get();

        // dd($prefolios->toArray());
        $countTotal = Prefolio::count();
        $countFiltered = $prefolios->count();

        return response()->json([
            "draw"              => intval($draw),
            "recordsTotal"      => $countFiltered,
            "recordsFiltered"   => $countTotal,
            "data"              => $prefolios,
        ]);
    }

    public function prefolio_recover_data(Request $request){
        $response = $request->only('folio');
        $prefolio = Prefolio::where('prefolio', $response['folio'])->first();
        if(! $prefolio->folio()->first()){
            $user       = $prefolio->user()->first();
    
            $merge['prefolio']  = $prefolio->toArray();
            $merge['pacientes'] = Pacientes::where('nombre', 'LIKE', "%{$prefolio['nombre']}%")->get()->toArray();
            $merge['usuario']   = $user->toArray();
            $merge['estudios']  = $prefolio->estudios()->get()->toArray();
    
            if($user){
                if($user->doctor->first()){
                    $merge['doctor']  = $prefolio->user()->first()->doctor()->first()->toArray();
                }else{
                    $merge['doctor']  = Doctores::where('id', $prefolio->doctor)->first();
                }
            }else{
                $merge['doctor']  = null;
            }
            // $path       = URL::to('/') .'/resultados/search/resultado/'.$folio->id;
            // $path       = 'public/tickets/F-'. $folio->folio . '.pdf';
            //    
            // $file = public_path() . $prefolio->adjunto;
            // dd(public_path());
    
            // $path = URL::to('/public/storage/' . $prefolio->adjunto);
            // $download = Response
            // return response()->download($file, 'adjunto');
            // return Response::download($prefolio->adjunto);
    
            return response($merge);
            
        }else{
            return response(['error'=>'prefolio ya fue asignado a ' . $prefolio->folio()->first()->folio],404);
        }
    }

    public function prefolio_send_recepcion(Request $request){

        $data = $request->except('_token');
        $dato = [];
        foreach($data['data'] as $key=>$valor){
            if($valor['name'] != '_token' || $valor['name'] == 'identificador_folio'){
                $dato[$valor['name']] = $valor['value'];
            }
            if($valor['name'] == 'identificador_folio'){
                $prefolio = Prefolio::where('id', $dato)->first();
                $update = $prefolio->update(['estado' => 'solicitado']);
            }
        }
        // dd($dato);
        $estudios = $prefolio->estudios()->get()->toArray();
        $prefolio = Prefolio::where('id', $dato['identificador_folio'])->first()->prefolio;
        $session['data'] = $dato;
        $session['estudios'] = $estudios;
        
        // Id paciente
        $request->session()->flash('idpaciente', $dato['id_doctor']);
        $request->session()->flash('iddoctor', $dato['id_paciente']);
        $request->session()->flash('observaciones', $dato['observaciones']);
        $request->session()->flash('idprefolio', $dato['identificador_folio']);
        $request->session()->flash('prefolio', $prefolio);

        $response = true;
    
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        return json_encode($response);
    }

    public function check_prefolio_recepcion(Request $request){
        $id_paciente = $request->paciente;
        $id_doctor = $request->doctor;
        $id_prefolio = $request->prefolio;

        $response['paciente'] = Pacientes::where('id', $id_paciente)->first();
        $response['doctor'] = Doctores::where('id', $id_doctor)->first();
        $prefolio = Prefolio::where('id', $id_prefolio)->first();
        $response['estudios'] = $prefolio->estudios()->get();
        $response['empresa']  = Empresas::where('id', 1)->first();

        return $response;
    }

    // Listas de trabajo
    public function lista_trabajo_index(){
        $user           = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $user->labo()->first();
        //Verificar sucursal
        $active         = $user->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales     = $user->sucs()->orderBy('id', 'asc')->get();
        // Areas
        $areas = User::where('id', Auth::user()->id)->first()->labs()->first()->areas()->get();

        $prefolios  = $laboratorio->prefolios()->get();

        return view('recepcion.trabajos.index', [
                'active'        => $active, 
                'sucursales'    => $sucursales,
                'areas'         => $areas,  
                'prefolios'     => $prefolios
            ]);
    }

    // genera reporte de trabajo
    public function make_reporte_trabajo(Request $request){
        // dd($request);
        $search = $request->except('_token');
        $fecha_inicio = Carbon::parse($request->selectInicio)->startOfDay();
        $fecha_final = Carbon::parse($request->selectFinal)->addDay();


        $folios =  Recepcions::when($request->selectSucursal != 'todo', function($query) use ($request){
            $query->whereHas('sucursales', function($query) use ($request){
                $query->where('subsidiary_id', $request->selectSucursal);
            });
        })->whereBetween('recepcions.created_at', [$fecha_inicio, $fecha_final])->orderBy('id', 'desc')->get();
        
        foreach ($folios as $key => $value) {
            $value->estudios = $value->estudios()->when($request->selectArea !== "todo", function($query) use ($request){
                $query->whereHas('areas', function($subquery) use ($request){
                    $subquery->where('areas.id', $request->selectArea);
                });
            })->get();
        }
        

        // foreach($folios as $key => $folio){
        //     $estudios = $folio->estudios()->when($request->selectArea != 'todo', function ($query) use ($request){
        //         $query->whereHas('areas', function($query) use ($request){
        //             $query->where('areas.id', $request->selectArea);
        //         });
        //     })->get();

        //     $folio->allEstudios = $estudios;
        
        // }
        // $inicio = microtime(true);
        // $tiempo = microtime(true) - $inicio;
        // echo "La consulta tardó $tiempo segundos en ejecutarse.";

        $laboratorio    = User::where('id', Auth::user()->id)->first()->labs()->first();
        $sucursal       = Subsidiary::where('id', $request->selectSucursal)->first();
        $membrete       = Storage::disk('public')->get($laboratorio->membrete);
        $jpg            = "data:image/jpeg;base64," . base64_encode($membrete);


        $pdf            = Pdf::loadView('invoices.trabajo.lista', [
                'laboratorio'   => $laboratorio, 
                'sucursal'      => $sucursal, 
                'membrete'      => $jpg,
                'folios'        => $folios,
            ]);
    
        // $token = Str::random();
        $pdf->setPaper('letter', 'portrait');
        $path = 'public/listas-trabajo/listJob.pdf';
        $pathpdf = public_path() . '/storage/listas-trabajo/listJob.pdf';
        $pathSave = Storage::put($path, $pdf->output());
        $request = ['pdf' => '/public/storage/listas-trabajo/listJob.pdf'];
        return $request;
    }


    // Utils

    public function delivery_index(){
        $user           = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $user->labo()->first();
        //Verificar sucursal
        $active         = $user->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales     = $user->sucs()->orderBy('id', 'asc')->get();
        // $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
        // Areas
        $areas = User::where('id', Auth::user()->id)->first()->labs()->first()->areas()->get();

        return view('recepcion.delivery.index', [
                'active'        => $active, 
                'sucursales'    => $sucursales,
                'areas'         => $areas
            ]);
    }

    public function get_results_preview(Request $request){
        $folio_request = $request->only('valor');

        $query = Recepcions::where('folio', $folio_request)
            ->select('id', 'folio',  'res_file', 'res_file_img' ,'maq_file_img', 'maq_file', 'patient_file')
            ->first();
        // $query->paciente = ($query->paciente()->first()) ? ($query->paciente()->first())->nombre : '';
        // $query->telefono = ($query->paciente()->first()) ? ($query->paciente()->first())->celular : '';
        // $query->correo_paciente = ($query->paciente()->first())  ? ($query->paciente()->first())->email : '';
        // $query->doctor = ($query->doctores()->first()) ? $query->doctores()->first()->nombre : '';
        // $query->correo_doctor = ($query->doctores()->first()) ? $query->doctores()->first()->email : '' ;

        return $query;
    }


    public function get_file_complete(Request $request){
        $user        = User::where('id', Auth::user()->id)->first();
        $query_folio = Recepcions::where('folio', $request->folio )->first();
        
        $folio = $request->only('folio');
        $captura = $request->only('captura');
        $img = $request->only('img');
        $maq_captura = $request->only('maq_captura');
        $maq_img = $request->only('maq_img');


        // dd($folio['folio']);
        try {
            $merge = PatientiFileJob::dispatch($folio['folio'], $captura['captura'], $img['img'], $maq_captura['maq_captura'], $maq_img['maq_img'] );
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }

        $paciente = $query_folio->paciente()->first();
               
        

        // return $ruta;

        return response()->json([
            'response'          => true,
            'pdf'               => '/public/storage/patient_files/F-'. $query_folio->folio.'.pdf',
            'url'               => url('public/storage/patient_files/F-'. $query_folio->folio .'.pdf'),
            'laboratorio'       => $user->labs()->first()->nombre,
            'nombre_paciente'   => $paciente    ? $paciente->nombre    : '',
            'correo_paciente'   => $paciente    ? $paciente->email     : '',
            'celular_paciente'  => $paciente    ? $paciente->celular   : '',
            'nombre_doctor'     => $query_folio->doctores()->first()    ? $query_folio->doctores()->first()->nombre    : '',
            'correo_doctor'     => $query_folio->doctores()->first()    ? $query_folio->doctores()->first()->email     : '',
        ], 200);

        // Datos del usuario
        // $usuario        = User::where('id', Auth::user()->id)->first();
        // $laboratorio    = $usuario->labs()->first();
        // $folios         = Recepcions::where('folio', $folio)->first();
        
        // // JOB creado, realizar pruebas luego
        // try {
        //     $job  = GeneratePdf::dispatch($usuario, $folios, null, 'principal', 'si' );
        //     $ruta = ['pdf' => '/public/storage/resultados-completos/F-'. $folio['folio'] .'.pdf'];
        //     return $ruta;
        // } catch (\Throwable $e) {
        //     dd($e);
        //     // Log::error("Error al generar reporte: ". $e->getMessage() );
        // }
        // $response   = ['pdf' => '/public/storage/resultados-completos/F-'.$folio['folio'].'.pdf']; //este es la ruta que recibira la vista

        // return $response;
        
    }

    /* -------------------------------------------------------------------------- */
    /*                                IMPORTACION DE EXCEL                        */
    /* -------------------------------------------------------------------------- */
    public function importacion_index(){
        $user           = User::where('id', Auth::user()->id)->first();
        //Verificar sucursal
        $active         = $user->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales     = $user->sucs()->orderBy('id', 'asc')->get();
        $areas          = $user->labs()->first()->areas()->get();


        return view('recepcion.importacion.index', [
                'active'        => $active, 
                'sucursales'    => $sucursales,  
                'areas'         => $areas,
            ]);
    }

    public function file_import(Request $request){
        $file = $request->validate([
            'area' => 'nullable',
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $area = Area::findOrFail($file['area']);

        $string = 'importaciones/importacion.xlsx';

        if($request->hasFile('file')){
            if(Storage::disk('public')->exists(( $string))){
                Storage::disk('public')->delete( $string);
            }

            $request->file('file')->storeAs("public", $string);
        }

         // Importar el archivo Excel y analizar su contenido
        $datos = Excel::toCollection(null, $request->file('file'));
        
        //Recorremos el arreglo para acomodar las filas por folio
        $response = $this->importacionService->import($datos, $area);

        $user           = User::where('id', Auth::user()->id)->first();
        //Verificar sucursal
        $active         = $user->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales     = $user->sucs()->orderBy('id', 'asc')->get();

        return view('recepcion.importacion.deploy', [
            'active'        => $active, 
            'sucursales'    => $sucursales,  
            'arreglo'       => $response,
            'area'          => $area,
        ]);
    }

    public function store_dato(Request $request){
        // dd($request);
        $data = $request->except('_token');

        $folio = Recepcions::where('id', $data['folio'])->first();

        $result = collect($data['analito'])->map(function ($estudio, $index) use ($data, $folio) {
            return [
                "folio" => $folio->folio,
                // "estudio" => $data['estudio'],
                "analito" => $data['analito'][$index],
                "valor" => $data['valor'][$index],
            ];
        })->all();

        $area = Area::findOrFail($request['area']);

        foreach ($result as $a => $fila) {
            $estudios = $folio->estudios()->whereRelation('area', 'estudios_has_laboratories.area_id', '=', $area->id)->get();
            foreach ( $estudios as $b => $estudio) {
                $analitos = $estudio->analitos()->where('descripcion', 'LIKE', '%'. $fila['analito'] . '%')->get();
                if($analitos){
                    foreach ($analitos as $c => $analito) {
                        $this->importacionService->importAjax($fila, $analito, $estudio, $folio);
                    }
                }
            }
        }

        return response()->json([
            'success'   => true,
            'msj'       => 'Procesado'
        ],201);
    }

    public function import_estudios(Request $request){
        $folio = $request->id;

        $query = Recepcions::findOrFail($folio);

        $listEstudios = $query->estudios()->get();


        return response()->json([
            'success' => true,
            'msj'     => 'Registros recuperados',
            'data'    => $listEstudios
        ],201);
        
    }
}