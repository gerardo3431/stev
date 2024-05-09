<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Inventories;
use App\Models\Recepcions;
use App\Models\Requests;
use App\Models\User;
use App\Models\Warehouses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use function PHPUnit\Framework\isEmpty;

class AlmacenController extends Controller
{

    public function get_inventories(){
        $inventories = Inventories::all();

        return $inventories;
    }

    public function get_requests(Request $request){
        $search = $request->only('q');

        if($request->input('id')){
            $query = Requests::where('id', $request->id)->first();
            $articles = $query->inventories()->get();
            foreach ($articles as $key => $value) {
                // Buscar por ubicación
                $resultado = Inventories::where('id', $value->id)->where('ubicacion', $value->ubicacion)->first();
                // // Buscar cuantos estan por surtir
                $surtir = $resultado->request()->where('status', 'pending')->get()->pluck('pivot.cantidad')->sum();
                // Buscar articulo para obtener la pieza que entrega
                $unidad_entrega = Articles::where('clave', $resultado->clave)->first();
                // // Asigno una nueva propiedad que indica la pieza que se entrega (caja, pieza, componenente)
                $value->unidad = $unidad_entrega->unidad;
                // // Asigno una nueva propiedad que indica la cantidad de piezas que no se han surtido
                $value->surtir = $surtir;
            }
            $query->articles = $articles;
        }else{
            $query = Requests::where('folio', 'LIKE', "%{$search['q']}%")->get();
        }

        return $query;
    }

    public function get_recepcions(Request $request){
        $search = $request->only('q');
        $query = Recepcions::where('folio', 'LIKE', "%{$search['q']}%")->get();
        return $query;

    }

    public function get_article_ubicacion(Request $request){
        $area = $request->input('ubicacion');

        if($area != ""){
            $inventories = Inventories::where('ubicacion', $area)->get();
        }

        return $inventories;
    }

    public function get_movement_request(Request $request){
        // $fi = $request->only('fecha_inicio');
        // $ff = $request->only('fecha_final');
        $fecha_inicio   = Carbon::parse($request->fecha_inicio);
        $fecha_final    = Carbon::parse($request->fecha_final)->addDay();
        $estado         = $request->estado;
        $folio          = $request->folio;

        if($folio){
            // $query = Recepcions::where('id', $folio)->first();
            $solicitudes = Requests::where('id', $folio)->first();
            $conteo = Requests::where('id', $folio)->count();
        }else{
            if($estado != "todo"){
                $solicitudes = Requests::where('status', $estado)->whereBetween('created_at', [$fecha_inicio, $fecha_final])->get();
            }else{
                $solicitudes = Requests::whereBetween('created_at', [$fecha_inicio, $fecha_final])->get();
            }
            
        }

        
        if($solicitudes){
            $articulos = collect();
            // if (!$solicitudes instanceof Illuminate\Database\Eloquent\Collection) {
            //     $solicitudes = collect([$solicitudes]);
            // }
            if(isset($conteo) && $conteo ===1){
                $articulosDeSolicitud = $solicitudes->inventories()->get();
                if ($articulosDeSolicitud->count() > 0) {
                    foreach ($articulosDeSolicitud as $articulo) {
                        $articulo->requested = User::where('id', $solicitudes->requested_id)->first()->name;
                        $articulo->approved = User::where('id', $solicitudes->approved_id)->first() ? User::where('id', $solicitudes->approved_id)->first()->name : 'Sin aprobar';
                        $articulos->push($articulo);
                    }
                }
            }else{
                foreach ($solicitudes as $key => $solicitud) {
                    $articulosDeSolicitud = $solicitud->inventories()->get();
                    if ($articulosDeSolicitud->count() > 0) {
                        foreach ($articulosDeSolicitud as $articulo) {
                            $articulo->requested = User::where('id', $solicitud->requested_id)->first()->name;
                            $articulo->approved = User::where('id', $solicitud->approved_id)->first() ? User::where('id', $solicitud->approved_id)->first()->name : 'Sin aprobar';
                            $articulos->push($articulo);
                        }
                    }
                }
            }
            return $articulos;
        }else{
            return null;
        }
    }

    public function inventario_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        // Obtiene datos, verifica si hay inventario, de lo contrario notifica.
        if (Inventories::exists()) {
            session()->flash('msj', 'Nothing');
        } else {
            session()->flash('msj', 'Iniciar inventario inicial.');
            session()->flash('estatus', 'No hay inventario.');
        }

        return view('almacen.inventario.index', ['active' => $active, 'sucursales' => $sucursales]);
    }

    public function inventario_store(Request $request){
        $data = $request->data;
        parse_str($data, $data_array);

        // Crear una instancia de la clase Request y asignar los datos del arreglo
        $request = new Request($data_array);
        try {
            $validar = $request->validate([
                'ubicacion'     =>'required|filled',
                'clave'         =>'required|filled',
                'listArticles'  =>'required|filled',
                'cantidad'      =>'nullable',
                'lote'          =>'nullable',
                'caducidad'     =>'required|filled'
            ],[
                'ubicacion'     =>'El campo ubicacion es requerido',
                'clave'         =>'El campo clave es requerido',
                'listArticles'  =>'El campo articulo es requerido',
                'cantidad'      =>'El campo es requerido',
                'lote'          =>'El campo es requerido',
                'caducidad'     =>'El campo caducidad es requerido'
            ]);
            
            $query = Inventories::where('clave', '=', $validar['clave'] )->where('ubicacion', '=', $validar['ubicacion'])->where('lote', $validar['lote'])->first();
            $articulo = Articles::where('id', '=', $validar['listArticles'])->first();
            if(! $query){
                $articulo = Inventories::create([
                    'ubicacion'     => $validar['ubicacion'],
                    'clave'         => $validar['clave'],
                    'descripcion'   => $articulo->nombre,
                    'cantidad'      => isset($validar['cantidad']) ? $validar['cantidad'] : null,
                    'lote'          => isset($validar['lote']) ? $validar['lote'] : null,
                    'caducidad'     => $validar['caducidad']
                ]);
            }else{
                $cantidad = intval($request['cantidad']);
                $articulo = $query->increment('cantidad', $cantidad);
            }
        
            return response()->json([
                'success' => true,
                'message' => 'Datos del formulario procesados con éxito'
            ], 200);

        } catch (ValidationException $exception) {
            $errors = $exception->validator->errors()->all();
            return response()->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }

    }


    public function articulos_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        // articulos
        $articulos = Articles::paginate(100);
        
        return view('almacen.articulos.index',['active' => $active, 'sucursales' => $sucursales, 'articulos' => $articulos]);
    }

    public function articulos_store(Request $request){

        $validate = request()->validate([
            'clave'         => 'required|unique:articles',
            'clave_salud'   => 'nullable',
            'codigo_barras' => 'nullable',
            'nombre'        => 'required',
            'nombre_corto'  => 'nullable',
            'tipo_material' => 'required',
            'unidad'        => 'nullable',
            'pieza'         => 'nullable',
            'cantidad'      => 'nullable',
            'referencia'    => 'nullable',
            'marca'         => 'nullable',
            'partida'       => 'nullable',
            'ubicacion'     => 'nullable',
            'presentacion'  => 'required',
            'lote'          => 'nullable',
            'caducidad'     => 'nullable',
            'ultimo_precio' => 'nullable',
            'min_stock'     => 'required',
            'max_stock'     => 'required',
            'punto_reorden' => 'nullable',
            'observaciones' => 'nullable',
        ]);

        try {
            $articulo = Articles::create($validate);
            return redirect()->route('stevlab.almacen.articulos')->with('msj', 'Exito, se guardo la información');
        } catch (\Throwable $th) {
            $errorMsg = $th->getMessage();
            $errors = collect([$errorMsg]);
            return redirect()->back()->withErrors($errors);
        }
    }

    public function solicitudes_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
        // articulos
        // $articulos = Articles::paginate(100);

        return view('almacen.solicitudes.index',['active' => $active, 'sucursales' => $sucursales]);
    }

    public function solicitudes_store(Request $request){
        $data = $request->data;
        $array = $request->only('articles');
        parse_str($data, $data_array);

        // Crear una instancia de la clase Request y asignar los datos del arreglo
        $requestnew = new Request($data_array);

        // Valido primero
        $validar = $requestnew->validate([
            'observaciones' =>'nullable',
            'estado'        =>'nullable',
            'tipo'          =>'nullable',
        ]);

        // dd($request->folio[0]);
        if(isset($request->folio[0])){
            $consulta = Requests::where('id', $request->folio[0])->first();
        }else{
            $consulta = null;
        }

        if($consulta){
            $folio = Requests::where('id', $request->folio[0])->first();
            
            $consulta->update([
                'observaciones' => $validar['observaciones'],
                'tipo'          => $validar['estado'],
                'solicitud'     => $validar['tipo'],
                'status'        => ($validar['estado'] == 'cerrado') ? 'approved' : 'pending',
            ]);

            if($request->articles){
                // Recorro el arreglo
                foreach($array['articles'] as $key => $article) {
                    $query = Inventories::where('clave', $article['clave'])->where('ubicacion', $article['area'])->first();
                    $existencia = $folio->inventories()->where('clave', $article['clave'])->where('ubicacion', $article['area'])->first();
                    if ($existencia) {
                        $folio->inventories()->updateExistingPivot($query->id, ['cantidad' => $article['cantidad']]);
                    }else{
                        $folio->inventories()->save($query, ['cantidad' => $article['cantidad']]);
                    }

                    if($validar['estado'] == 'cerrado'){
                        $approved = Requests::where('id', $request->folio[0])->update(['approved_id' => Auth::user()->id]);
                        $query->decrement('cantidad', $article['cantidad']);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'folio'   => $folio->folio,
                'message' => 'Datos del formulario procesados con éxito'
            ], 200);

        }else{
            try {
                            
                // Quiero saber que sucursal esta activa para el usuario
                $sucursal_activa = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
                // Consulto que folio o id va anteriormente:
                $preview = Requests::latest()->first()->id + 1 ;
                // Busco si hay asignado un folio manual de la busqueda
                if($request->folio){
                    $folio = Recepcions::where('id', $request->folio[0])->first();
                }
                // Quiero crear un folio manual
                $turno = 'SM-'.Date('ymd') . str_pad($sucursal_activa->id, 2, '0', STR_PAD_LEFT) . str_pad($preview, 6, '0', STR_PAD_LEFT);
                // Creo un registro
                $create = Requests::create([
                    'folio'         => isset($folio->folio) ? $folio->folio : $turno,
                    'observaciones' => $validar['observaciones'],
                    'tipo'          => $validar['estado'],
                    'solicitud'     => $validar['tipo'],
                    'requested_id'  => auth()->user()->id,
                    'status'        => ($validar['estado'] == 'cerrado') ? 'approved' : 'pending',
                ]);
                // Verifico si mando un array de articulos para ser anexado, en caso contrario no hago nada y la solicitud se crea vacia.
                if($request->articles){
                    // Recorro el arreglo
                    foreach($array['articles'] as $key => $article) {
                        // Busco el articulo del inventario para cotejar
                        $query = Inventories::where('clave', $article['clave'])->where('ubicacion', $article['area'])->first();
                        // Asigno el registro del fomulario con los articulos que consulte y la cantidad que solicitan
                        $create->inventories()->save($query, ['cantidad' => $article['cantidad']]);
    
                        if($validar['estado'] == 'cerrado'){
                            $approved = Requests::where('folio', $request->folio)->update('approved', auth()->user()->id);
                            $query->decrement('cantidad', $article['cantidad']);
                        }
                    }
                }
    
                return response()->json([
                    'success' => true,
                    'folio'   => $create->folio,
                    'message' => 'Datos del formulario procesados con éxito'
                ], 200);
            } catch (ValidationException $exception) {
                $errors = $exception->validator->errors()->all();
                return response()->json([
                    'success' => false,
                    'errors' => $errors
                ], 422);
            }
        }
    }

    public function movimientos_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        return view('almacen.movimientos.index', ['active' => $active, 'sucursales' => $sucursales] );
    }
}



    // public function almacen_index(){
    //     //Verificar sucursal
    //     $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
    //     // Lista de sucursales que tiene el usuario
    //     $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
    //     // Obtener lista de almacenes
    //     $almacenes = User::where('id', Auth::user()->id)->first()->labs()->first()->warehouses()->get();

    //     return view('almacen.almacenes.index', ['active' => $active, 'sucursales' => $sucursales, 'almacenes' => $almacenes]);
    // }

    // public function almacen_store(Request $request){
    //     // Verificar laboratorio asignado
    //     $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();

    //     $rule = request()->validate([
    //         'clave'             => 'required|unique:warehouses|alpha_num:ascii',
    //         'estatus'           => 'nullable',
    //         'descripcion'       => 'required',
    //     ],[
    //         'clave.required'        => 'Ingresa clave',
    //         'estatus.required'      => 'Selecciona estatus',
    //         'descripcion.required'  => 'Ingresa alguna descripcion',
    //     ]);

    //     try {
    //         $almacen = Warehouses::create($rule);
    //         $laboratorio->warehouses()->save($almacen);
    //         return redirect()->route('stevlab.almacen.almacenes')->with('msj', 'Guardado con éxito.');
    //     } catch (\Throwable $th) {
    //         dd($th);
    //         return back()->withInput()->withErrors(['msj' => 'Error al guardar el almacén.']);
    //     }
    // }