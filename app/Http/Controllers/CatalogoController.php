<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnalitoRequest;
use App\Http\Requests\StoreEstudioRequest;
use App\Http\Requests\StorePerfilRequest;
use App\Jobs\PreciosExcelImport;
use App\Models\Analito;
use App\Models\Area;
use App\Models\Articles;
use App\Models\Doctores;
use App\Models\Empresas;
use App\Models\Estudio;
use App\Models\Formulas;
use App\Models\Inventories;
use App\Models\Laboratory;
use App\Models\Lista;
use App\Models\Metodo;
use App\Models\Muestra;
use App\Models\Pacientes;
use App\Models\Picture;
use App\Models\Precio;
use App\Models\Profile;
use App\Models\Recepcions;
use App\Models\Recipiente;
use App\Models\Referencia;
use App\Models\Tecnica;
use App\Models\User;
use App\Services\AnalitoService;
use App\Services\EstudioService;
use App\Services\PerfilService;
use App\Services\PrecioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;

use function PHPUnit\Framework\isEmpty;

class CatalogoController extends Controller
{
    // Protected
    protected $estudioService;
    protected $analitoService;
    protected $perfilService;
    protected $precioService;

    public function __construct(EstudioService $estudioService, AnalitoService $analitoService, PerfilService $perfilService, PrecioService $precioService){
        $this->estudioService = $estudioService;
        $this->analitoService = $analitoService;
        $this->perfilService  = $perfilService;
        $this->precioService  = $precioService;
    }
    // Getters
    public function get_only_estudios(Request $request){
        $estudios = Estudio::all();
        return $estudios;
    }
    
    public function get_all_estudios(Request $request){ 
        $search = $request->except('_token');
        // Trae listas de estudios
        // $estudios = User::where('id', Auth::user()->id)->first()->labs()->first()->estudios()->where( 'descripcion', 'LIKE', "%{$search['q']}%")->get();
        $estudios = User::where('id', Auth::user()->id)->first()
                    ->labs()->first()
                    ->estudios()->where(function($q) use ($search){
                        $q  ->where('estudios.clave', 'LIKE', '%' . $search['q'] . '%')
                            ->orWhere('estudios.descripcion', 'LIKE', '%' . $search['q'] .'%');
                    })
                    ->get();

        // Trae listas de perfiles
        $perfiles =  User::where('id', Auth::user()->id)->first()
                    ->labs()->first()
                    ->perfiles()->where(function($q) use ($search){
                        $q  ->where('profiles.clave', 'LIKE', '%'. $search['q'] .'%')
                            ->orWhere('profiles.descripcion', 'LIKE', '%'. $search['q'] .'%');
                    })
                    ->get();
        // Trae la lista de imagenologia
        $imagenologia =  User::where('id', Auth::user()->id)->first()
                    ->labs()->first()
                    ->imagen()->where(function($q) use ($search){
                        $q  ->where('pictures.clave', 'LIKE', '%'. $search['q'] .'%')
                            ->orWhere('pictures.descripcion', 'LIKE', '%'. $search['q'] .'%');
                    })
                    ->get();
        // $perfiles = User::where('id', Auth::user()->id)->first()->labs()->first()->perfiles()->where( 'descripcion', 'LIKE', "%{$search['q']}%")->get();

        // $resultados = $estudios->merge($perfiles);
        $resultados['estudios'] = $estudios;
        $resultados['perfiles'] = $perfiles;
        $resultados['imagenologia'] = $imagenologia;


        return $resultados;

    }


    public function get_folios_recepcion(Request $request){

        // Recepcion de los datos
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        // Binding de las columnas que manda jquery datatable
        switch ($orderColumn) {
            case 0:
                $column = 'folio';
                break;
            case 1:
                $column = 'nombre'; 
                break;
            case 2:
                $column = 'edad';
                break;
            case 3:
                $column = 'descripcion'; 
                break;
            default:
                $column = 'folio'; 
                break;
        }

        // Consulta
        $folios = Recepcions::select('recepcions.id', 'recepcions.folio', 'recepcions.id_empresa', 'recepcions.id_paciente')
            ->when($searchValue !== null, function ($query) use ($searchValue){
                $query->where('folio', 'LIKE', "%$searchValue%")
                    ->orWhereHas('paciente', function ($query) use ($searchValue){
                        $query->where('pacientes.nombre', 'LIKE', "%$searchValue%")
                            ->orWhere('pacientes.fecha_nacimiento', 'LIKE', "%$searchValue%");
                    })->orWhereHas('empresas', function ($query) use ($searchValue){
                        $query->where('empresas.descripcion', 'LIKE', "%$searchValue%");
                    });
            })->when(($orderColumn !== null && $orderDir !== null), function ($query) use ($column, $orderDir){
                $query->orderBy($column, $orderDir);
            })->with(['paciente' => function($query){
                $query->select('pacientes.id','pacientes.nombre', 'pacientes.fecha_nacimiento');
            }, 'empresas' => function($query){
                $query->select('empresas.id','empresas.descripcion');
            }])
        ->skip($start)
        ->take($length)
        ->get();

        // Cantidad total de registros (Para la información de las paginaciones):
        $countTotal     = Recepcions::count();
        $countFiltered  = $folios->count();

        // Retorno
        return response()->json([
            "draw"              => intval($draw),
            "recordsTotal"      => $countFiltered,
            "recordsFiltered"   => $countTotal,
            "data"              => $folios,
        ]);
    }

    public function get_estudio(Request $request){
        $search = $request->except('_token');
        $estudios = User::where('id', Auth::user()->id)->first()->labs()->first()->estudios()->where('descripcion', 'LIKE', "%{$search['q']}%")->get();
        return $estudios;
    }

    public function get_profile(Request $request){
        $search = $request->except('_token');
        $profiles = User::where('id', Auth::user()->id)->first()->labs()->first()->perfiles()->where('descripcion', 'LIKE', "%{$search['q']}%")->get();
        return $profiles;
    }

    public function get_estudios(Request $request){ 
        $search = $request->except('_token');

        $estudios = User::where('id', Auth::user()->id)->first()
                    ->labs()->first()
                    ->estudios()->where(function($q) use ($search){
                        $q  ->where('estudios.clave', 'LIKE', '%' . $search['q'] . '%')
                            ->orWhere('estudios.descripcion', 'LIKE', '%' . $search['q'] .'%');
                    })
                    ->get();

        $prueba = User::where('id', Auth::user()->id)->first()
                    ->labs()->first()
                    ->imagen()->where(function($q) use ($search){
                        $q  ->where('pictures.clave', 'LIKE', '%' . $search['q'] . '%')
                            ->orWhere('pictures.descripcion', 'LIKE', '%' . $search['q'] .'%');
                    })
                    ->get();

        return $estudios->merge($prueba);
    }

    public function get_check_analitos(Request $request){ 
        $data = $request->except('_token');

        $estudio = Estudio::where('id', $data['data'])->where('clave', $data['clave'])->first();
        if($estudio){
            $estudios['analitos'] = $estudio->analitos()->orderBy('analitos_has_estudios.orden', 'asc')->get();
            $estudios['formulas'] = $estudio->formula()->get();
        }

        if(! $estudio){
            $estudio = Picture::where('id', $data['data'])->where('clave', $data['clave'])->first();
            $estudios['analitos'] = $estudio->analitos()->orderBy('pictures_has_analitos.orden', 'asc')->get();
        }

        return $estudios;
    }

    public function get_analitos(Request $request){
        $search = $request->except('_token');
        $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();
        $analitos = $laboratorio->analitos()->where(function($q) use ($search){
            $q  ->where('analitos.clave', 'LIKE', '%' . $search['q'] . '%')
                ->orWhere('analitos.descripcion', 'LIKE', '%' . $search['q'] .'%');
        })->get();
        
        return $analitos;
    }

    public function get_folio_clave(Request $request){
        $search = $request->except('_token');
        $recepcions = Recepcions::where(function($q) use ($search){
            $q  ->where('recepcions.folio', 'LIKE', '%' . $search['q'] . '%');
        })->get();
        
        return $recepcions;
    }

    // Get from doctor
    public function getListFromDoctor(){
        $laboratorio = User::where('id', Auth::user()->id)->first()->labo()->first();
        $estudios['estudios'] = User::where('id', Auth::user()->id)->first()->labo()->first()->estudios()->get();
        $estudios['perfiles'] = User::where('id', Auth::user()->id)->first()->labo()->first()->perfiles()->get();
        return $estudios;
    }

    public function getPacientesDoctor(Request $request){
        $search = $request->except('_token');
        $user = User::where('id', Auth::user()->id)->first();
        $paciente = $user->prefolio()->where(function($q) use ($search){
            $q  ->Where('prefolios.nombre', 'LIKE', '%' . $search['q'] .'%');
        })->first();

        return $paciente;
    }


    // Para recepcions - envio de mensajeria via whatsapp
    public function get_paciente_folio(Request $request){
        // Fecha del dia
        $date = Date('dmys');

        $search = $request->only('folio');
        $seleccion = $request->only('seleccion');

        $paciente = Recepcions::where('folio', $search['folio'])->first()->paciente()->first();
        $laboratorio = Recepcions::where('folio', $search['folio'])->first()->sucursales()->first()->laboratorio()->first();

        $all_estudios = [];

        // $usuario        = User::where('id', Auth::user()->id)->first();
        // $laboratorio    = User::where('id', Auth::user()->id)->first()->labs()->first();
        // $sucursal       = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // $folios         = Recepcions::where('folio', $search['folio'])->first();
        // $pacientes      = Recepcions::where('folio', $search['folio'])->first()->paciente()->first();
        // $edad           = Carbon::createFromFormat('d/m/Y', $pacientes->fecha_nacimiento)->age;

        // $doctor = Doctores::where('id', $folios->id_doctor)->first();
        // $valido = User::where('id', $folios->valida_id)->first();
        // $img_valido = base64_encode(Storage::disk('public')->get($valido->firma));

        // Datos del usuario
        $usuario        = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $usuario->labs()->first();
        $folios         = Recepcions::where('folio', $search['folio'])->first();
        $img_valido     = base64_encode(Storage::disk('public')->get($folios->valida()->first()->firma));
        $barcode        = DNS1D::getBarcodeSVG($folios->folio, 'C128', 1.20, 35);
        
        
        
        $patient['telefono'] = $paciente->celular;
        $patient['nombre']   = $paciente->nombre;
        $patient['laboratorio'] = $laboratorio->nombre;
        $patient['url']         = url('public/storage/resultados-completos/F-'. $search['folio'] .'.pdf');

        return $patient;

    }

    public function get_lista_estudios_all(){
        $laboratorio = User::where('id', Auth::user()->id)->first()->labo()->first();
        $estudios['estudios'] = User::where('id', Auth::user()->id)->first()->labo()->first()->estudios()->get();
        $estudios['perfiles'] = User::where('id', Auth::user()->id)->first()->labo()->first()->perfiles()->get();
        $estudios['imagenologia'] = User::where('id', Auth::user()->id)->first()->labo()->first()->imagen()->get();
        return $estudios;
    }

    public function get_estudios_recepcion(Request $request){
        $search = $request->only('data');
        $id_empresa = $request->only('id_empresa');

        $estudio = Estudio::where('id', $search['data'])->first();

        // if($id_empresa){
        //     $descuento = Empresas::where('id', $id_empresa['id_empresa'])->first()->precio()->first();
        //     if(isset($descuento)){
        //         // Busca el estudio y valora si esta en la lista
        //         $lista = Empresas::where('id', $id_empresa['id_empresa'])->first()
        //         ->precio()->where('empresas_has_precios.empresas_id', '=', $id_empresa['id_empresa'])->first()
        //         ->estudios()->where('estudios_has_precios.estudio_id', $estudio->id)->first();
        //         // Si esta en la lista hace todo esto, en caso contrario retorna solo el estudio con el precio base
        //         if(isset($lista)){
        //             $calculo = $estudio->precio - ($estudio->precio / 100 * $descuento->descuento);
        //             $estudio->precio = $calculo;
        //         }else{
        //             return $estudio;
        //         }
        //     }
        // }
        // Si no mando empresa retorna el estudio base
        return $estudio;
        
    }

    public  function get_perfiles_recepcion(Request $request){
        $search = $request->only('data');
        $id_empresa = $request->only('id_empresa');

        $perfil = Profile::where('id', $search['data'])->first();

        if($id_empresa){
            $descuento = Empresas::where('id', $id_empresa['id_empresa'])->first()->precio()->first();

            if(isset($descuento)){
                $lista = Empresas::where('id', $id_empresa['id_empresa'])->first()
                ->precio()->where('empresas_has_precios.empresas_id', '=', $id_empresa['id_empresa'])->first()
                ->profiles()->where('profiles_has_precios.profile_id', $perfil->id)->first();

                if(isset($lista)){
                    $calculo = $perfil->precio - ($perfil->precio / 100 * $descuento->descuento);
                    $perfil->precio = $calculo;
                }
            }else{
                return $perfil;
            }
        }
        return $perfil;
    }

    public function get_imagenologia_recepcion(Request $request){
        $search = $request->only('data');
        $id_empresa = $request->only('id_empresa');

        $perfil = Picture::where('id', $search['data'])->first();

        if($id_empresa){
            $descuento = Empresas::where('id', $id_empresa['id_empresa'])->first()->precio()->first();

            if(isset($descuento)){
                $lista = Empresas::where('id', $id_empresa['id_empresa'])->first()
                ->precio()->where('empresas_has_precios.empresas_id', '=', $id_empresa['id_empresa'])->first()
                ->imagen()->where('pictures_has_precios.picture_id', $perfil->id)->first();

                if(isset($lista)){
                    $calculo = $perfil->precio - ($perfil->precio / 100 * $descuento->descuento);
                    $perfil->precio = $calculo;
                }
            }else{
                return $perfil;
            }
        }
        return $perfil;
    }

    public function get_estudios_clave(Request $request){
        $clave = $request->only('clave');

        $estudio = Estudio::where('clave', $clave['clave'])->first()->load(['recipientes', 'area', 'muestra', 'metodo', 'tecnica' ]);
        return $estudio;
    }

    public function get_analito_clave(Request $request){
        $clave = $request->only('clave');

        $analito = Analito::where('clave', $clave['clave'])->first();

        return $analito;
    }



    public function get_valores_referenciales_clave(Request $request){
        $clave = $request->only('clave');

        $valores = Analito::where('clave', $clave['clave'])->first()->referencias()->get();

        return $valores;
    }

    // public function get_precio(Request $request){
    //     $lista = Lista::

    // }

    public function get_lista_precios(Request $request){
        $search = $request->except('_token');
        // $analitos = User::where('id', Auth::user()->id)->first()->labs()->first()->analitos()->where('descripcion', 'LIKE', "%{$search['q']}%")->get();
        $resultados = User::where('id', Auth::user()->id)->first()->labs()->first()->precios()->where('descripcion', 'LIKE', "%{$search['q']}%")->get();
        return $resultados;
    }

    public function get_lista_empresa(Request $request){
        $empresa = Empresas::where('id', $request->id_empresa)->first();

        $precio = $empresa->precio()->first();

        if($precio !== null){
            $estudios['lista'] = $precio->lista()->get();
            return $estudios;
        }else{
            $estudios['estudios'] = User::where('id', Auth::user()->id)->first()->labs()->first()->estudios()->get();
            $estudios['perfiles'] = User::where('id', Auth::user()->id)->first()->labs()->first()->perfiles()->get();
            $estudios['imagenologia'] = User::where('id', Auth::user()->id)->first()->labo()->first()->imagen()->get();
            return $estudios;
        }
    }

    public function verify_key_studie(Request $request){
        $estudio = Estudio::where('clave', $request->clave)->first();
        $perfil = Profile::where('clave', $request->clave)->first();
        $img = Picture::where('clave', $request->clave)->first();

        $foundMatch = !is_null($estudio) || !is_null($perfil) || !is_null($img);

        return response()->json([
            'success'   => true,
            'data'      => $foundMatch,
        ],201);
    }
    
    public function catalogo_get_lista(Request $request){
        $lista = Precio::where('id', $request->id)->first()->lista()->get();
        return json_encode($lista);
    }

    public function get_empresa_by_patient(Request $request){
        $data = $request->only('id_paciente');
        $paciente = Pacientes::where('id', $data['id_paciente'])->first();
        $empresa = $paciente->empresas()->where('empresas.id', '=', $paciente->id_empresa)->first();
        return $empresa;
    }

    public function catalogo_get_articles(Request $request){
        $search = $request->except('_token');
        // $analitos = User::where('id', Auth::user()->id)->first()->labs()->first()->analitos()->where('descripcion', 'LIKE', "%{$search['q']}%")->get();
        $resultados = Articles::where('nombre', 'LIKE', "%{$search['q']}%")->get();

        return $resultados;
    }

    public function catalogo_get_data_article(Request $request){
        $id = $request->only('idArticle');
        $ubicacion = $request->only('ubicacion');

        // Para solicitudes
        if($request->ubicacion != null){
            // Buscar por ubicación
            $resultado = Inventories::where('id', $id['idArticle'])->where('ubicacion', $ubicacion['ubicacion'])->first();
            //  Busca y coteja del almacen general el mismo articulo
            $almacen_general = Inventories::where('clave', $resultado->clave)->where('ubicacion', 'almacen_general')->first();
            // Buscar articulo para obtener la pieza que entrega
            $unidad_entrega = Articles::where('clave', $resultado->clave)->first();
            // Buscar cuantos estan por surtir
            $surtir = $resultado->request()->where('status', 'pending')->get()->pluck('pivot.cantidad')->sum();
            // Asigno una nueva propiedad que indica lo que contiene almacen general
            $resultado->almacen_general = $almacen_general->cantidad;
            // Asigno una nueva propiedad que indica la pieza que se entrega (caja, pieza, componenente)
            $resultado->unidad = $unidad_entrega->unidad;
            // Asigno una nueva propiedad que indica la cantidad de piezas que no se han surtido
            $resultado->surtir = $surtir;
        }else{
            $resultado = Articles::where('id', $id['idArticle'])->first();
        }

        return $resultado;
    }

    public function get_pacientes_table(Request $request){
        // Recepcion de los datos
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        switch ($orderColumn) {
            case 0:
                $column = 'id';
                break;
            case 1:
                $column = 'nombre'; 
                break;
            case 2:
                $column = 'fecha_nacimiento';
                break;
            default:
                $column = 'id'; 
                break;
        }

        $pacientes = Pacientes::select('pacientes.id', 'pacientes.nombre', 'pacientes.fecha_nacimiento')
            ->when($searchValue !== null, function ($query) use ($searchValue){
                $query->where('id', 'LIKE', "%$searchValue%")
                    ->orWhere('nombre', 'LIKE', "%$searchValue%")
                    ->orWhere('fecha_nacimiento', 'LIKE', "%$searchValue%");
            })->when(($orderColumn !== null && $orderDir !== null), function ($query) use ($column, $orderDir){
                $query->orderBy($column, $orderDir);
            })
            ->skip($start)
            ->take($length)
            ->get();

        $countTotal = Pacientes::count();
        $countFiltered = $pacientes->count();

        // Retorno
        return response()->json([
            "draw"              => intval($draw),
            "recordsTotal"      => $countFiltered,
            "recordsFiltered"   => $countTotal,
            "data"              => $pacientes,
        ]);
    }

     // Recuperar valores para editar
    public function catalogo_recuperar_datos_perfil_estudios(Request $request){
        $clave = $request->only('clave');
        $perfil = Profile::where('clave', $clave['clave'])->first();
        return $perfil;
    }

    public function catalogo_recupera_estudios_to_perfil(Request $request){
        $id = $request->only('id');
        $estudios =  Profile::where('id', $id)->first()->perfil_estudio()->get();
        return $estudios;
    }
    
    public function catalogo_verify_key_estudio(Request $request){
        $dato = $request->only('clave');

        $analito = Estudio::where('clave', $dato['clave'])->first();


        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');   
        if(isset($analito) == true) {
            return json_encode(false);
            // $response = true;
        } elseif(isset($analito) == false) {
            return json_encode(true);
            // $response = false;
        }
    }
    public function catalogo_verify_key_analito(Request $request){
        $dato = $request->only('clave');
        $analito = Analito::where('clave', $dato['clave'])->first();

        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');  
        if(isset($analito) == true) {
            return json_encode(false);
            // $response = true;
        } elseif(isset($analito) == false) {
            return json_encode(true);
            // $response = false;
        }
    
    }

    // Revisar bro
    public function catalogo_verify_key_analito_show(Request $request){
        $dato = $request->only('clave');
        $analito = Analito::where('clave', $dato['clave'])->first();

        return $analito;    
    }

    public function catalogo_verify_key_profile(Request $request){
        $perfil = Profile::where('clave', $request->clave)->first();
        // dd(isset($perfil));

        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');

        if(isset($perfil) == true){
            return json_encode(false);
        }elseif(isset($perfil) == false){
            return json_encode(true);
        }

        
    }

    public function catalogo_verify_key_doctor(Request $request){
        $doctor = Doctores::where('clave', $request->clave)->first();
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');

        if(isset($doctor) == true){
            return json_encode(false);
        }elseif(isset($doctor) == false){
            return json_encode(true);
        }
    }

    public function catalogo_verify_key_empresa(Request $request){
        $empresa = Empresas::where('clave', $request->clave)->first();
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');

        if(isset($empresa) == true){
            return json_encode(false);
        }elseif(isset($empresa) == false){
            return json_encode(true);
        }
    }

    public function catalogo_verify_key_picture(Request $request){
        $img = Picture::where('clave', $request->clave)->first();
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');

        if(isset($img) == true){
            return json_encode(false);
        }elseif(isset($img) == false){
            return json_encode(true);
        }
    }

    public function catalogo_verify_disponibilidad(Request $request){
        $estudio = Estudio::where('clave', $request->estudio )->first();
        $picture = Picture::where('clave', $request->estudio)->first();

        if($estudio && $picture){
            $message = ['response' => false ,'msj' => 'Se ha encontrado coincidencia con un estudio y una imagenologia, por favor revise que la clave no sea similar para poder asignar correctamente los analitos a su estudio correspondiente.'];
            return response($message)->withHeaders([
                "HTTP/1.1 400",
                'Content-Type: application/json',
            ]);
        }elseif($picture){
            $message = ['response' => false ,'msj' => 'Estudio de imagenologia no puede tener formulas.'];
            return response($message)->withHeaders([
                "HTTP/1.1 400",
                'Content-Type: application/json',
            ]);
        }else{
            $message = ['response' => true ,'msj' => 'Permitido'];
            return response($message)->withHeaders([
                "HTTP/1.1 200 OK",
                'Content-Type: application/json',
            ]);
        }
    }

    public function catalogo_get_analitos(){
        $analitos = User::where('id', Auth::user()->id)->first()->labs()->first()->analitos()->get();
        return json_encode($analitos);
    }

    public function catalogo_get_estudios(Request $request){
        // Recepcion de los datos
        $draw = $request->input('draw');
        $start = $request->input('start');
        $length = $request->input('length');
        $searchValue = $request->input('search.value');
        $orderColumn = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        switch ($orderColumn) {
            case 0:
                $column = 'clave';
                break;
            case 1:
                $column = 'descripcion'; 
                break;
            case 2:
                $column = 'condiciones';
                break;
            default:
                $column = 'clave'; 
                break;
        }

        $laboratorio    = User::where('id', Auth::user()->id)->first()->labs()->first();
        
        $estudios = Estudio::select('estudios.clave', 'estudios.descripcion', 'estudios.condiciones')
        ->when($searchValue !== null, function ($query) use ($searchValue){
            $query->where('clave', 'like', "%$searchValue%")
                ->orWhere("descripcion", "like","%$searchValue%")
                ->orWhere("condiciones", 'like', "%$searchValue%");
        })->when(($orderColumn !== null && $orderDir !== null), function ($query) use ($column, $orderDir){
            $query->orderBy($column, $orderDir);
        })->whereRelation(
            'laboratorios', 'estudios_has_laboratories.laboratory_id', '=', $laboratorio->id
        )->skip($start)
        ->take($length)
        ->get();

        $countTotal = User::where('id', Auth::user()->id)->first()->labs()->first()->estudios()->count();
        $countFiltered = $estudios->count();

        return response()->json([
            "draw"              => intval($draw),
            "recordsTotal"      => $countFiltered,
            "recordsFiltered"   => $countTotal,
            "data"              => $estudios,
        ]);
    }

    public function catalogo_get_pacientes(){
        $pacientes = User::where('id', Auth::user()->id)->first()->labs()->first()->pacientes()->get();
        
        return json_encode($pacientes);
    }

    // Setters
    public function set_analito(Request $request){
        $search = $request->except('_token');
        $analito = User::where('id', Auth::user()->id)->first()->labs()->first()->analitos()->where('analito_id', $search['data'])->first();
        return $analito;
    }

    public function delete_analito(Request $request){
        $delete = Analito::where('clave', $request->ID)->delete();
        return ($delete) ? true : false;
    }
    
    // // Para retornar datos acerca del estudio a listar con precios
    // public function catalogo_set_position(Request $request){
    //     $search = $request->except('_token');
    //     $estudio = Estudio::where('id', $search)->first();
    //     return $estudio;
    // }
    

    //ESTUDIOS
    public function catalogo_estudio_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        // Trae listas de estudios
        // $estudios = Estudio::orderBy('id', 'desc')->get();

        // Recogida de datos para el formulario
        // Trae areas creadas
        $areas = User::where('id', Auth::user()->id)->first()->labs()->first()->areas()->get();
        // Trae muestas creadas
        $muestras = User::where('id', Auth::user()->id)->first()->labs()->first()->muestras()->get();
        // Trae recipientes creadas
        $recipientes = User::where('id', Auth::user()->id)->first()->labs()->first()->recipientes()->get();
        // Trae metodos creadas
        $metodos = User::where('id', Auth::user()->id)->first()->labs()->first()->metodos()->get();
        // Trae tecnicas creadas
        $tecnicas = User::where('id', Auth::user()->id)->first()->labs()->first()->tecnicas()->get();
        // Trae equipos creadas
        // $equipos = User::where('id', Auth::user()->id)->first()->labs()->first()->equipos()->get();

        return view('catalogo.estudios.index', [
            'active'        => $active, 
            'sucursales'    => $sucursales, 
            'areas'         =>$areas,
            'muestras'      =>$muestras,
            'recipientes'   =>$recipientes,
            'metodos'       =>$metodos,
            'tecnicas'      =>$tecnicas,
            // 'estudios'      => $estudios,
            // 'equipos'       =>$equipos,
        ]);
    }

    public function catalogo_estudio_store(StoreEstudioRequest $request){
        try {
            $estudio    = $request->validated();
            $this->estudioService->create($estudio);
            return redirect()->route('stevlab.catalogo.estudios');
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()],200);
        }
    }

    public function catalogo_estudio_update(Request $request){
        $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();
        $sucursal = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();

        $identificador = $request->only('identificador');

        $data = $request->only('data');
        // Parseo del serialice array
        $dato = [];
        foreach($data['data'] as $key=>$valor){
            $dato[$valor['name']] = $valor['value'];
        }
        // dd($dato['clave']);
        $old_estudio    = Estudio::where('id', $identificador['identificador'])->first();

        $areas          = $old_estudio->area()->first();

        $update = Estudio::where('id', $identificador['identificador'])->update([
            'clave'         =>$dato['clave'],
            'codigo'        =>$dato['codigo'],
            'descripcion'   =>$dato['descripcion'],
            'condiciones'   =>$dato['condiciones'],
            'aplicaciones'  =>$dato['aplicaciones'],
            'dias_proceso'  =>$dato['dias_proceso'],
            'precio'        =>$dato['precio'],
            'valida_qr'     =>(isset($dato['valida_qr'])) ? $dato['valida_qr'] : null,

        ]);
        
        DB::table('estudios_has_laboratories')->updateOrInsert([ 
            'estudio_id'        =>$identificador['identificador'],
            'laboratory_id'     =>$laboratorio->id,
            'sucursal_id'       =>$sucursal->id,
        ],[
            'area_id'           =>$dato['area'],
            'muestra_id'        =>$dato['muestra'],
            'recipiente_id'     =>$dato['recipiente'],
            'metodo_id'         =>$dato['metodo'],
            'tecnica_id'        =>$dato['tecnica'],
        ]); 

        DB::table('areas_has_estudios')->updateOrInsert([ 
                'area_id'           =>$areas->id,
                'estudio_id'        =>$identificador['identificador'],
            ],[
                'area_id'           =>$dato['area'],
                'estudio_id'        =>$identificador['identificador'],
        ]);

        // Actualizar claves de las listas
        $precio = Lista::where('clave', $old_estudio->clave)->update(['clave' => $dato['clave']]);

        if($laboratorio) {
            $response = true;
        } else {
            $response = false;
        }
    
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        return json_encode($response);
    }

    public function catalogo_estudio_original_delete(Request $request){
        $estudio_clave = $request->only('clave');
        $user = User::where('id', Auth::user()->id)->first(); 
        $query = Estudio::where('clave', $estudio_clave['clave'])->first();

        if ($user->hasPermissionTo('eliminar_estudios')) {
            $query->delete();
            return response()->json([
                'response'  => true ,
                'msj'       => 'Estudio eliminado'
            ],201);
        }else{
            return response()->json([
                'response'  => false ,
                'msj'       => 'Permiso no habilitado para usuario'
            ],401);
        }
    }


    // Catalogo analitos
    public function catalogo_analito_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        return view('catalogo.analitos.index',['active' => $active, 'sucursales'=> $sucursales]);
    }



// Elimina analito del estudio
    public function delete_analito_estudio(Request $request){
        $clave = $request->only('data');
        $idestudio = $request->only('estudio');

        $analito = Analito::where('clave', '=' ,$clave)->first();
        $estudio = Estudio::where('clave', $idestudio['estudio'])->first();
        $picture = Picture::where('clave', $idestudio['estudio'])->first();

        if($estudio && $picture){
            $message = ['response' => false ,'error' => 'Se ha encontrado coincidencia con un estudio y una imagenologia, por favor revise que la clave no sea similar para poder asignar correctamente los analitos a su estudio correspondiente.'];
            // session()->flash('error', 'Se ha encontrado coincidencia con un estudio y una imagenologia, por favor revise que la clave no sea similar para poder asignar correctamente los analitos a su estudio correspondiente.');
            return response($message)->withHeaders([
                "HTTP/1.1 400",
                'Content-Type: application/json',
            ]);
        }else if($estudio){
            $delete = DB::table('analitos_has_estudios')
                ->where('analito_id', $analito->id)
                ->where('estudio_id', $estudio->id)
                ->delete();
            $message = ['response' => true ,'msj' => 'Analito eliminado'];
            return response($message)->withHeaders([
                "HTTP/1.1 200 OK",
                'Content-Type: application/json',
        ]);
        }else if($picture){
            $delete = DB::table('pictures_has_analitos')
                ->where('analito_id', $analito->id)
                ->where('picture_id', $picture->id)
                ->delete();
            $message = ['response' => true ,'msj' => 'Analito eliminado'];
            return response($message)->withHeaders([
                "HTTP/1.1 200 OK",
                'Content-Type: application/json',
            ]);
        }else{
            // session()->flash('error', 'Error, no se encontro estudio o imagenologia.' );
            $message = ['response' => false ,'error' => 'Error, no se encontro estudio o imagenologia'];
            return response($message)->withHeaders([
                "HTTP/1.1 500",
                'Content-Type: application/json',
            ]);
        }

        // if($delete) {
        //     $response = true;
        // } else {
        //     $response = false;
        // }

        // header("HTTP/1.1 200 OK");
        // header('Content-Type: application/json');
        // return json_encode($response);
    }

    // Asigna analito al estudio
    public function asign_estudio_analitos(Request $request){
        $analito = [];
        $numero = 0;
// dd($request);
        // $datos = $request->except('_token');
        $data = $request->only('data');
        $clave = $request->only('estudio');

        $estudio = Estudio::where('clave', $clave)->first();
        $picture = Picture::where('clave', $clave)->first();

        if($estudio && $picture){
            $message = ['response' => false ,'error' => 'Se ha encontrado coincidencia con un estudio y una imagenologia, por favor revise que la clave no sea similar para poder asignar correctamente los analitos a su estudio correspondiente.'];
            return response($message)->withHeaders([
                "HTTP/1.1 400",
                'Content-Type: application/json',
            ]);
        }else if($estudio){
            foreach ($data['data'] as $key=>$value) {
                $analito_id = Analito::where('clave', $value)->first();
                $numero++;
                $analito[$key]['analito_id'] = $analito_id->id;
                $analito[$key]['orden']      = $numero;
                $insercion = DB::table('analitos_has_estudios')->updateOrInsert([  
                                                'analito_id' => $analito[$key]['analito_id'], 
                                                'estudio_id' => $estudio->id
                                            ],[   
                                                'analito_id' => $analito[$key]['analito_id'],
                                                'estudio_id' => $estudio->id,
                                                'orden'      => $numero
                                            ]);
            }
            $message = ['response' => true ,'msj' => 'Analitos asignados correctamente'];
            return response($message)->withHeaders([
                "HTTP/1.1 200 OK",
                'Content-Type: application/json',
            ]);
        }else if($picture){
            foreach ($data['data'] as $key=>$value) {
                $analito_id = Analito::where('clave', $value)->first();
                $numero++;
                $analito[$key]['analito_id'] = $analito_id->id;
                $analito[$key]['orden']      = $numero;
                $insercion = DB::table('pictures_has_analitos')->updateOrInsert([  
                                                'analito_id' => $analito[$key]['analito_id'], 
                                                'picture_id' => $picture->id
                                            ],[   
                                                'analito_id' => $analito[$key]['analito_id'],
                                                'picture_id' => $picture->id,
                                                'orden'      => $numero
                                            ]);
            }
            $message = ['response' => true ,'msj' => 'Analitos asignados correctamente'];
            return response($message)->withHeaders([
                "HTTP/1.1 200 OK",
                'Content-Type: application/json',
            ]);
        }else{
            $message = ['response' => false ,'error' => 'No se ha encontrado estudio o imagenologia a la cual hace referencia. Solicite asistencia.'];
            return response($message)->withHeaders([
                "HTTP/1.1 500",
                'Content-Type: application/json',
            ]);
        }
    }

    public function catalogo_analito_store(StoreAnalitoRequest $request){
        $analito = $request->validated();
        $resultado = $this->analitoService->create($analito);
        
        return response()->json([
            'success'   => true,
            'mensaje'   => 'Analito creado exitosamente',
            'result'    => $resultado
        ]);
    }

    public function catalogo_store_imagen_referencia(Request $request){
        $analito = request()->except('_token');
        $id = intval($analito['analito']); 

        if($request->hasFile('imagen')){
            if(Storage::exists($analito['imagen'])){
                Storage::delete($analito['imagen']);
            }

            $request->file('imagen')->storeAs('public', 'analitos/analito-' . $id .'.png');
            $analito['imagen'] = 'analitos/analito-'. $id.'.png';
        }

        $insert = Analito::where('id', $id)->updateOrInsert(
                                                        ['id' => $id],
                                                        ['imagen'=>$analito['imagen']]
                                                    );
                                                    
        return redirect()->route('stevlab.catalogo.analitos');
        
    }

    public function catalogo_referencia_store(Request $request){
        $estudio = Analito::where('id', $request->analito)->first();

        $data = $request->except('_token');

        if($data['tipo_inicial'] == 'dia'){
            $data['dias_inicio'] = intval($data['edad_inicial']) * 1;
        }else if($data['tipo_inicial'] == 'mes'){
            $data['dias_inicio'] = intval($data['edad_inicial']) * 30;
        }else if($data['tipo_inicial'] == 'año'){
            $data['dias_inicio'] = intval($data['edad_inicial']) * 365;
        }else if($data['tipo_inicial'] == 'semana'){
            $data['dias_inicio'] = intval($data['edad_final']) * 7;
        }

        if($data['tipo_final'] == 'dia'){
            $data['dias_final'] = intval($data['edad_final']) * 1;
        }else if($data['tipo_final'] == 'mes'){
            $data['dias_final'] = intval($data['edad_final']) * 30;
        }else if($data['tipo_final'] == 'año'){
            $data['dias_final'] = intval($data['edad_final']) * 365;
        }else if($data['tipo_final'] == 'semana'){
            $data['dias_final'] = intval($data['edad_final']) * 7;
        }

        $dato = Referencia::create($data);

        $estudio->referencias()->save($dato);

        return $dato;
    }

    // Delete referencia
    public function catalogo_referencia_delete(Request $request){
        $analito = Analito::where('id', $request->analito)->first();

        $dato = $request->except('_token');

        $delete = DB::table('referencias_has_analitos')->where('analito_id', $dato['analito'])->where('referencia_id', $dato['referencia'])->delete();

        $borra = Referencia::where('id', $dato['referencia'])->delete();

        if($delete) {
            $response = true;
        } else {
            $response = false;
        }

        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        return json_encode($response);
    }

    // Edita analito o actualiza
    public function catalogo_update_analitos(Request $request){
        $id = $request->only('identificador');
        $analitos = $request->only('data');

        // Parseo del serialice array
        $dato = [];
        foreach($analitos['data'] as $key=>$valor){
            $dato[$valor['name']] = $valor['value'];
        }

        $actualizar = Analito::where('id', $id['identificador'])->update([
            'clave' => $dato['clave'],
            'descripcion' => $dato['descripcion'],
            'bitacora' => $dato['bitacora'],
            'defecto' => $dato['defecto'],
            'unidad' => $dato['unidad'],
            'digito' => $dato['digito'],
            'tipo_resultado' => $dato['tipo_resultado'],
            'valor_referencia' => $dato['valor_referencia'],
            'tipo_referencia' => $dato['tipo_referencia'],
            'tipo_validacion' => $dato['tipo_validacion'],
            'numero_uno' => $dato['numero_uno'],
            'numero_dos' => $dato['numero_dos'],
            'documento' => $dato['documento'],
            'valida_qr' => (isset($dato['valida_qr'])) ? $dato['valida_qr'] : null,
        ]);

        $response['data'] = Analito::where('id', $id['identificador'])->first();

        if($actualizar) {
            $response['msj'] = true;
        } else {
            $response['msj'] = false;
        }

        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        return json_encode($response);
    }

    // Calculadora de las formulas
    public function save_formulas_estudios(Request $request){
        $data       = $request->only('data');
        $estudio    = $request->only('estudio');

        $estudio = Estudio::where('clave', $estudio['estudio'])->first();
        $picture = Picture::where('clave', $estudio['estudio'])->first();

        if($estudio && $picture){
            $message = ['response' => false ,'error' => 'Se ha encontrado coincidencia con un estudio y una imagenologia, por favor revise que la clave no sea similar para poder asignar correctamente los analitos a su estudio correspondiente.'];
            return response($message)->withHeaders([
                "HTTP/1.1 400",
                'Content-Type: application/json',
            ]);
        }else if($picture){
            $message = ['response' => false ,'error' => 'Estudios de imagenologia no pueden tener formulas- Opción exclusiva de estudios'];
            return response($message)->withHeaders([
                "HTTP/1.1 400",
                'Content-Type: application/json',
            ]);
        }else{
            foreach ($data['data'] as $a => $formula) {
                $query = $estudio->formula()->where('formulas.formula', $formula)->first();
                if(! $query){
                    $create = Formulas::create(['formula'=>$formula]);
                    $enlace = $estudio->formula()->save($create);
                }
            }

            if($create){
                $message = ['response' => true ,'msj' => 'Formulas asignados correctamente'];
                return response($message)->withHeaders([
                    "HTTP/1.1 200 OK",
                    'Content-Type: application/json',
                ]);
            }
        }
    }

    // Elimina formula
    public function delete_true_formula(Request $request){
        $data = $request->only('data');
        $clave = $request->only('estudio');

        $formula = Formulas::where('id', $data['data'])->first();
        $estudio = Estudio::where('clave', $clave['estudio'])->first();

        $picture = Picture::where('clave', $clave['estudio'])->first();

        if($picture){
            $message = ['response' => false ,'error' => 'No se puede eliminar por una similitud en Imagenologias por claves'];
            return response($message)->withHeaders([
                "HTTP/1.1 400",
                'Content-Type: application/json',
            ]);
        }else{
            if($formula && $estudio){
                $detach = $estudio->formula()->detach($formula);
                $delete = Formulas::where('id', $formula->id)->delete();
    
                if($delete){
                    $message = ['response' => true ,'msj' => 'Formula eliminado'];
                    return response($message)->withHeaders([
                        "HTTP/1.1 200 OK",
                        'Content-Type: application/json',
                        ]);
                }else{
                    $message = ['response' => false ,'error' => 'No se ha podido eliminar el analito.'];
                    return response($message)->withHeaders([
                        "HTTP/1.1 400",
                        'Content-Type: application/json',
                    ]);
                }
            }
        }
    }

    // Cambia imagen de analito

    // PERFILES
    public function catalogo_perfiles_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        // Perfiles
        $perfiles = User::Where('id', Auth::user()->id)->first()->labs()->first()->perfiles()->get();


        return view('catalogo.perfiles.index', ['active' => $active, 'sucursales' => $sucursales, 'perfiles'=> $perfiles]);
    }

    public function catalogo_store_perfil(StorePerfilRequest $request){
        $perfil = $request->validated();
        $create = $this->perfilService->create($perfil);

        return response()->json([
            'success' => true,
            'mensaje' => 'Perfil agregado correctamente.',
            'perfil'  => $create
        ],200);
    }

    public function catalogo_perfil_to_estudios(Request $request){
        
        $profile = Profile::where('id', $request->id)->first();
        $this->perfilService->link($profile, $request->only('data'));

        return response()->json([
            'success' => true,
            'mensaje' => 'Estudios agregados correctamente.'
        ],200);
    }

    public function catalogo_actualizar_datos_perfil_estudios(Request $request){
        $perfil = Profile::where('id', $request->only('identificador'))->first();
        $this->perfilService->update($perfil, $request->except('_token', 'identificador'));

        return response()->json([
            'success' => true,
            'mensaje' => "Datos actualizados."
        ],200);
    }
    
    // Perfiles
    public function catalogo_elimina_estudio_perfil(Request $request){
        $perfil = Profile::where('id', $request->perfil)->first();
        $this->perfilService->unlink($perfil, $request->clave);

        return response()->json([
            'success' => true,
            'mensaje' => "Estudio retirado de perfil."
        ]);
    }

    public function catalogo_perfil_delete(Profile $id){
        $this->perfilService->delete($id);

        return redirect()->route('stevlab.catalogo.perfiles');
    }

    // AREAS
    public function catalogo_area_index(){
        // Trae areas creadas
        $areas = User::where('id', Auth::user()->id)->first()->labs()->first()->areas()->get();
        // Trae metodos creadas
        $metodos = User::where('id', Auth::user()->id)->first()->labs()->first()->metodos()->get();
        // Trae recipientes creadas
        $recipientes = User::where('id', Auth::user()->id)->first()->labs()->first()->recipientes()->get();
        // Trae areas creadas
        $muestras = User::where('id', Auth::user()->id)->first()->labs()->first()->muestras()->get();
        // Trae tecnicas creadas
        $tecnicas = User::where('id', Auth::user()->id)->first()->labs()->first()->tecnicas()->get();

        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        return view('catalogo.areas.index', ['active' => $active, 
                                            'sucursales' => $sucursales, 
                                            'areas' =>$areas, 
                                            'metodos'=>$metodos, 
                                            'recipientes'=> $recipientes,
                                            'muestras'=>$muestras,
                                            'tecnicas'=>$tecnicas]);
    }

    public function catalogo_area_store(Request $request){
        // Verificar laboratorio asignado
        $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();

        // Para validar datos de areas
        $areas = request()->validate([
            'descripcion'           => 'required',
            'observaciones'         => 'required',
        ],[
            'descripcion.required'  => 'Ingresa alguna descripcion',
            'observaciones.required'=> 'Ingresa alguna observación',
        ]);

        $area = Area::create($areas);

        $laboratorio->areas()->save($area);

        return redirect()->route('stevlab.catalogo.areas');
    }


    public function catalogo_metodo_store(){
        // Verificar laboratorio asignado
        $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();
        // Para validar datos de metodos
        $metodos = request()->validate([
            'descripcion'           => 'required',
            'observaciones'         => 'required',
        ],[
            'descripcion.required'  => 'Ingresa alguna descripcion',
            'observaciones.required'=> 'Ingresa alguna observación',
        ]);

        $metodo = Metodo::create($metodos);
        $laboratorio->metodos()->save($metodo);
        return redirect()->route('stevlab.catalogo.areas');
    }


    public function catalogo_recipiente_store(){
        // Verificar laboratorio asignado
        $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();

        // Para validar datos de metodos
        $recipientes = request()->validate([
            'descripcion'           => 'required',
            'marca'                 => 'required',
            'capacidad'             => 'required',
            'presentacion'          => 'required',
            'unidad_medida'         => 'required',
            'observaciones'         => 'required',
        ],[
            'descripcion.required'      => 'Ingresa alguna descripcion',
            'marca.required'            => 'Ingresa nombre de marca',
            'capacidad.required'        => 'Ingresa capacidad',
            'presentacion.required'     => 'Ingresa presentación',
            'unidad_medida.required'    => 'Ingresa unidad de medida',
            'observaciones.required'    => 'Ingresa observaciones',
        ]);

        $recipiente = Recipiente::create($recipientes);
        $laboratorio->recipientes()->save($recipiente);

        return redirect()->route('stevlab.catalogo.areas');
    }


    public function catalogo_muestra_store(){
        // Verificar laboratorio asignado
        $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();

        // Para validar datos de metodos
        $muestras = request()->validate([
            'descripcion'           => 'required',
            'observaciones'         => 'required',
        ],[
            'descripcion.required'  => 'Ingresa alguna descripcion',
            'observaciones.required'=> 'Ingresa alguna observación',
        ]);

        $muestra = Muestra::create($muestras);

        $laboratorio->muestras()->save($muestra);

        return redirect()->route('stevlab.catalogo.areas');
    }


    public function catalogo_tecnica_store(){
        
        // Verificar laboratorio asignado
        $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();

        // Para validar datos de metodos
        $tecnicas = request()->validate([
            'descripcion'           => 'required',
            'observaciones'         => 'required',
        ],[
            'descripcion.required'  => 'Ingresa alguna descripcion',
            'observaciones.required'=> 'Ingresa alguna observación',
        ]);

        $tecnica = Tecnica::create($tecnicas);
        $laboratorio->tecnicas()->save($tecnica);

        return redirect()->route('stevlab.catalogo.areas');
    }

    public function catalogo_delete_component($zona, $id){
        switch ($zona) {
            case 'areas':
                $delete = Area::where('id', $id)->delete();
                break;
            case 'metodos':
                $delete = Metodo::where('id', $id)->delete();
                break;
            case 'recipientes':
                $delete = Recipiente::where('id', $id)->delete();
                break;
            case 'muestras':
                $delete = Muestra::where('id', $id)->delete();
                break;
            case 'tecnicas':
                $delete = Tecnica::where('id', $id)->delete();
                break;
            default:
                break;
        }

        if($delete){
            return redirect()->route('stevlab.catalogo.areas')->with('msg', 'Elemento eliminado');
        }else{
            return redirect()->route('stevlab.catalogo.areas')->with('msg', 'Elemento no eliminado, reintente');
        }
    }


    public function catalogo_precio_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
        // Lista de precios disponibles
        $listas = User::where('id', Auth::user()->id)->first()->labs()->first()->precios()->paginate(10);

        return view('catalogo.precios.index', [
            'active'        => $active, 
            'sucursales'    => $sucursales, 
            'listas'        =>$listas
        ]);
    }

    public function catalogo_upload_list_precios(Request $request){
        $file = $request->file('file');
        $precio = $request->input('clave');
        $archivo_temporal = $file->getRealPath();
        // Encola el trabajo para procesar la importación de Excel
        $job = PreciosExcelImport::dispatch($archivo_temporal, $precio);

        return response()->json([
            'message' => 'La importación ha sido iniciada.'
        ], 202);
    }

    public function catalogo_store_list(Request $request){
        $lista = $this->precioService->create([
            'descripcion' => $request->descripcion,
            'descuento'   => 0
        ]);

        if($request->lista !== "ninguno"){
            $this->precioService->link($this->precioService->getPrecio($request->lista), $lista);
        }

        return response()->json([
            'success' => true,
            'mensaje' => 'Lista creada con éxito.',
            'data'    => $lista
        ],200);
    }

    public function catalogo_list_save(Request $request){
        $estudios = $request->input('estudios');

        $precio = $this->precioService->getPrecio($request->clave);

        if(! empty($estudios)){
            $this->precioService->link($precio, $estudios);
        }

        return response()->json([
            'success' => true,
            'mensaje' => 'Lista actualizada.'
        ],200);
    }

    public function catalogo_list_update_name(Request $request){
        $this->precioService->update($this->precioService->getPrecio($request->ID), $request->nombre);

        return response()->json([
            'success' => true,
            'mensaje' => 'Nombre de la lista cambiado correctamente.',
        ], 200);
    }

    public function catalogo_delete_lista($id){
        $query = Precio::whereRelation('empresa', 'empresas_has_precios.precio_id', '=', $id)->first();
        if(! $query){
            $delete = Precio::where('id', $id)->delete();
            $mensaje = 'Precio eliminado';
        }

        $msj = isset($mensaje) ? $mensaje : 'No se puede eliminar. Está lista de precios está asociada con la empresa: ' . $query->descripcion ;
        return redirect()->route('stevlab.catalogo.precios')->with('msj', $msj);
    }

    public function catalogo_estudio_delete(Request $request){
        $this->precioService->trash($this->precioService->getPrecio($request->precio), $request->clave);
        return response()->json([
            'success' => true,
            'mensaje' => 'Estudio eliminado del precio seleccionado.'
        ], 200);
    }

    // public function catalogo_precios_estudios(Request $request){
    //     $data = $request->only('data');
    //     $precio = $request->only('precio_id');

    //     $lista = Precio::where('id', $precio['precio_id'])->first();

    //     foreach($data['data'] as $value){
    //         $estudio = Estudio::where('id', $value)->first();
    //         $insercion = $lista->estudios()->save($estudio);
    //     }

    //     if($insercion) {
    //         $response = true;
    //     } else {
    //         $response = false;
    //     }

    //     header("HTTP/1.1 200 OK");
    //     header('Content-Type: application/json');
    //     return json_encode($response);
    // }

    // public function catalogo_precios_profiles(Request $request){
    //     $data = $request->only('data');
    //     $precio = $request->only('precio_id');

    //     $lista = Precio::where('id', $precio['precio_id'])->first();

    //     foreach($data['data'] as $value){
    //         $estudio = Profile::where('id', $value)->first();
    //         $insercion = $lista->profiles()->save($estudio);
    //     }

    //     if($insercion) {
    //         $response = true;
    //     } else {
    //         $response = false;
    //     }

    //     header("HTTP/1.1 200 OK");
    //     header('Content-Type: application/json');
    //     return json_encode($response);
    // }

    // public function catalogo_precios_elimina_estudio(Request $request){
    //     $estudio = $request->only('estudio');
    //     $precio_id = $request->only('precio');

    //     $eliminar = Estudio::where('id', $estudio['estudio'])->first();
    //     $foranea = Precio::where('id', $precio_id['precio'])->first();

    //     $estatus = $foranea->estudios()->detach($eliminar);
        
    //     if($estatus){
    //         $response = true;
    //     }else{
    //         $response = false;
    //     }

    //     header("HTTP/1.1 200 OK");
    //     header('Content-Type: application/json');
    //     return json_encode($response);
    // }

    // public function catalogo_precios_elimina_profile(Request $request){
    //     $perfil = $request->only('profile');
    //     $precio_id = $request->only('precio');

    //     $eliminar = Profile::where('id', $perfil['profile'])->first();
    //     $foranea = Precio::where('id', $precio_id['precio'])->first();

    //     $estatus = $foranea->profiles()->detach($eliminar);
        
    //     if($estatus){
    //         $response = true;
    //     }else{
    //         $response = false;
    //     }

    //     header("HTTP/1.1 200 OK");
    //     header('Content-Type: application/json');
    //     return json_encode($response);
    // }

    // // Para las tablas

    // public function catalogo_tabla_precios_estudios(Request $request){
    //     $id = $request->except('_token');
    //     $lista = Precio::where('id', $id['data'])->first()->estudios()->get();

    //     return json_encode($lista);
    // }

    // public function catalogo_tabla_precios_profiles(Request $request){
    //     $id = $request->except('_token');
    //     $lista = Precio::where('id', $id['data'])->first()->profiles()->get();

    //     return json_encode($lista);
    // }
    
}
