<?php
namespace App\Services;

use App\Models\Recepcions;
use App\Models\User;
use App\Models\Folios;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Utils;
use App\Models\Estudio;
use App\Models\Lista;
use App\Models\Pacientes;
use App\Models\Picture;
use App\Models\Precio;
use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Milon\Barcode\Facades\DNS2DFacade;

class FolioService{
    protected $analitoService;

    public function __construct(AnalitoService $analitoService)
    {
        $this->analitoService = $analitoService;
    }
    /**
     * Return a folio recepcions with a id
     * @param Int $id
     * @return mixed
     */
    public function getFolioByID(Int $id){
        return Recepcions::findOrFail($id);
    }
    /**
     * Create the bauche for the identifier
     * @param Array $arreglo
     * @return mixed
     */
    public function create(Array $arreglo){
        $create = Recepcions::create($this->asignTokenFolio($arreglo));
        $this->asociarRecepcion($create);
        return $create;
    }

    public function update(Array $arreglo){
        $create = Recepcions::update($arreglo);
        return $create;
    }

    /**
     * This function assignate token and folio
     * @param Array $arreglo
     * @return Array
     */
    protected function asignTokenFolio(Array $arreglo){
        
        $folio = $this->getFolio();

        $token = new Utils();        
        $arreglo['token'] = $token->tokenizer(5);

        $turno = Date('ymd') . str_pad($this->sucursalActual()->id, 2, '0', STR_PAD_LEFT) . str_pad($folio, 6, '0', STR_PAD_LEFT);
        $arreglo['folio'] = $turno;

        $arreglo['user_id'] = User::where('id', Auth::user()->id)->first()->id;

        $this->createFolio($turno);
        
        return $arreglo;
    }

    /**
     * Link the recepcions identifier to Laboratory
     * @param Model $recepcion
     * @return void
     */
    protected function asociarRecepcion(Model $recepcion){
        $sucursal_activa    = $this->sucursalActual();
        $paciente           = $this->patient($recepcion->id_paciente);

        $sucursal_activa->folios()->save($recepcion);
        $recepcion->paciente()->save($paciente);
    }

    
    public function linkPrecios(Model $recepcion, Array $lista = null){
        $empresa = $recepcion->empresas()->first();
        $precio  = $empresa->precio()->first();

        $new_lista = Lista::whereIn('clave', $lista)
            ->whereHas('precio', function ($query) use ($precio){
                $query->where('precios_has_listas.precio_id', '=', $precio->id);
            })->get();

        $recepcion->lista()->attach($new_lista);
        // Para obtener los estudios, perfiles, imagenologias y guardarlos igual
        // Creo que seria mejor omitirlos de una vez

        // Para que lista de precios sea el unico que despliegue asocia
        foreach ($new_lista as $key => $estudio) {
            // dd($estudio);
            $this->linkStudies($recepcion, $estudio);
        }

        return true;
    }

    public function linkPreciosUpdate(Model $recepcion, Array $lista = null){
        $empresa = $recepcion->empresas()->first();
        $precio  = $empresa->precio()->first();

        // Obtener ya asociados para restar las claves no asociadas
        $consulta = $recepcion->lista()->whereIn('clave', $lista)->get()->pluck('clave')->toArray();
        $diff = array_diff($lista, $consulta);

        $precios = $precio->lista()->whereIn('clave', $diff)->get();
        // dd($precios);
        $recepcion->lista()->attach($precios);

        // Para obtener los estudios, perfiles, imagenologias y guardarlos igual
        foreach ($precios as $key => $estudio) {
            // dd($estudio);
            $this->linkStudies($recepcion, $estudio);
        }

        return true;
    }
    
    /**
     * Receives the array to link "folio" 
     * @param Model $recepcions
     * @param Model $precio_id
     * @return void
     */ 
    public function linkStudies(Model $recepcions, Model $estudio){
        switch ($estudio->tipo) {
            case 'Estudio':
                $this->asociarEstudios($recepcions, $estudio->clave);
                break;
            case 'Perfil':
                $this->asociarPerfiles($recepcions, $estudio->clave);
                break;
            case 'Imagenologia':
                $this->asociarImagenologia($recepcions, $estudio->clave);
                break;
            default:
                return 'Option not available. Retry query...';
                break;
        }
    }

    /**
     * Retrieve studies from multiples models of Folio
     * @param Model $folio
     * @param Request $request
     * @return mixed
     */
    public function recover_estudios(Model $folio, Request $request){
        // Areas de estudios para los resultados de acuerdo a los areas
        $estudios   = $this->get_estudies_area($folio, $request);
        $perfiles   = $this->get_profiles_area($folio, $request);
        $imagen     = $this->get_imagenologia_area($folio, $request);

        $arreglo['estudios'] = $estudios;
        $arreglo['perfiles'] = $perfiles;
        $arreglo['imagenologia'] = $imagen;

        return $arreglo;
    }

    /**
     * Query model Folio to retrieving info about the all searchs
     * @param Request $request
     * @return mixed
     */
    public function recoverInformation(Request $request){
        $fecha_inicio = Carbon::parse($request->fecha_inicio)->startOfDay();
        $fecha_final = Carbon::parse($request->fecha_final)->addDay();

        $folios = $this->query_builder($request, $fecha_inicio, $fecha_final);

        foreach ($folios as $key => $estudio) {
            $estudio->sucursal  = $estudio->sucursales()->first()->sucursal;
            $estudio->paciente  = ($estudio->paciente()->first() !== null) ? $estudio->paciente()->first()->nombre : 'Paciente eliminado';
            $estudio->empresa   = ($estudio->empresas()->first() !== null) ? $estudio->empresas()->first()->descripcion : 'Empresa eliminada';
            $estudio->doctor    = ($estudio->doctores()->first() !== null) ? $estudio->doctores()->first()->nombre : 'Doctor eliminado';
            $estudio->contador  = $estudio->getContador();
            $estudio->validado  = $estudio->getEstado();
        }

        return $folios;
    }

    /**
     * Retrieving information from a query builder
     * @param Request $request
     * @param Carbon $fecha_inicio
     * @param Carbon $fecha_final
     * @return mixed
     */
    public function query_builder(Request $request, Carbon $fecha_inicio, Carbon $fecha_final){
        

        $folios = Recepcions::when($request->area !== 'todo', function($query) use ($request){
            $query->whereHas('areas', function($query) use ($request){
                $query->where('area_id', $request->area);
            });
        })->when($request->estado !== 'todo', function($query) use ($request){
            $query->whereHas('estudios', function($query) use ($request){
                $query->where('status', $request->estado);
            });
        })->when($request->sucursal !== 'todo', function($query) use ($request){
            $query->whereHas('sucursales', function($query) use ($request){
                $query->where('subsidiary_id', $request->sucursal);
            });
        })->where(function( $query ){
            $query->whereDoesntHave('pictures')->orWhere(function ($query){
                $query->whereHas('estudios');
            });
        })->select('recepcions.id', 'recepcions.folio', 'recepcions.created_at', 'recepcions.id_empresa', 'recepcions.id_paciente', 'recepcions.id_doctor')
        ->whereBetween('recepcions.created_at', [$fecha_inicio, $fecha_final])->orderBy('id', 'desc')->get();

        return $folios;
    }

    /**
     * Retrieve the last identifier folio + 1
     * @param void
     * @return mixed
     */
    protected function getFolio(){
        $recibe_folio = $this->usuarioActual()->labs()->first()->folios()->latest()->first();
        return $recibe_folio !== null ? ($recibe_folio->id + 1) : 1;
    }

    /**
     * Retrieve the user that make the request
     * @param void
     * @return mixed
     */
    protected function usuarioActual(){
        return  User::where('id', Auth::user()->id)->first();
    }

    /**
     * Retrieve the actual subsidiary from the user position
     * @param void
     * @return mixed 
     */
    protected function sucursalActual(){
        return $this->usuarioActual()->sucs()->where('estatus', 'activa')->first();
    }

    /**
     * Return a patient from recepcions id
     * @param Int $id
     * @return mixed
     */
    protected function patient(Int $id){
        return Pacientes::findOrFail($id);

    }


    protected function createFolio(String $turno){
        $reservacion = Folios::create([
            'folio'     => $turno,
            'estatus'   => 'solicitado',
        ]);

        $this->usuarioActual()->labs()->first()->folios()->save($reservacion);

    }

    /**
     * Link studies to recepcions identifier
     * @param Model $recepcions
     * @param String $clave
     * @return void
     */
    protected function asociarEstudios(Recepcions $recepcions, String $clave){
        $estudio = Estudio::where('clave', $clave)->first();
        $recepcions->estudios()->save($estudio);
    }

    /**
     * Link profiles to recepcions identifier
     * @param Model $recepcions
     * @param String $clave
     * @return void
     */
    protected function asociarPerfiles(Recepcions $recepcions, String $clave){
        $profile = Profile::where('clave', $clave)->first();

        $recepcions->recepcion_profiles()->save($profile);
        
        $estudios = $profile->perfil_estudio()->pluck('clave')->toArray(); 

        foreach ($estudios as $key => $value) {
            $this->asociarEstudios($recepcions, $value);
        }


        // if($arreglo){
        //     $cv_profiles = Profile::whereIn('clave', $arreglo)->get();
        //     $recepcions->recepcion_profiles()->saveMany($cv_profiles);
        //     // Para linkear estudios
        //     foreach ($cv_profiles as $profile) {
        //         $estudios = $profile->perfil_estudio()->pluck('clave'); 
        //         $resultados = $estudios->toArray();

        //         $this->asociarEstudios($recepcions, $resultados);
        //     }
        // }
    }

    /**
     * Link imaging to recepcions identifier
     * @param Model $recepcions
     * @param Array $arreglo
     * @return void
     */
    protected function asociarImagenologia(Recepcions $recepcions, String $clave){
        $imagen = Picture::where('clave', $clave)->first();
        $area = $imagen->deparment()->first();
        $recepcions->picture()->attach($imagen->id, ['deparments_id' => $area->id]);
    }


    protected function get_estudies_area(Model $folio, Request $request){
        // dd($folio->recepcion_profiles()->pluck('profiles.id')->toArray());
        $filtro = $folio->lista()->where('tipo', 'Estudio')->get()->pluck('clave');
        $consulta = $folio
            ->estudios()
            ->whereIn('clave', $filtro)
            ->when($request->areaId !== 'todo', function ($query) use ($request){
                $query->whereHas('area', function($query) use ($request){
                    $query->where('area_id', $request->areaId);
                });
            })
            ->whereNotIn('recepcions_has_estudios.estudio_id', function ($subquery) use ($folio){
                $subquery->select('estudio_id')
                    ->from('profiles_has_estudios')
                    ->whereIn('profile_id', $folio->recepcion_profiles()->pluck('profiles.id')->toArray());
            })
            ->get();
            // dd($consulta);
        $reload = $this->loadInformation($folio, $consulta);
        return $reload;
    }

    protected function get_profiles_area(Model $folio, Request $request){
        // Obtienes todos los perfiles
        $filtro = $folio->lista()->where('tipo', 'Perfil')->get()->pluck('clave');

        $consulta =  $folio->recepcion_profiles()->whereIn('clave', $filtro)->get();
        foreach($consulta as $key=>$perfil){
            // Prevenir estudios sin agregar al perfil o estudios eliminados de perfiles
            $this->preventInformation($folio, $perfil->perfil_estudio()->get()->pluck('clave'));
            // Buscar estudios
            $perfil->estudios = $this->loadInformation($folio, $perfil->perfil_estudio()->get());
        }
        return $consulta;
    }
    // protected function get_imagenologia_area(Model $folio, Request $request){
    //     $imagenologia = $folio->picture()->when($request->areaId != 'todo', function ($query) use ($request){
    //         $query->whereHas('deparment', function ($query) use ($request){
    //             $query->where('deparments_id', $request->areaId);
    //         });
    //     })->get();

    //     foreach ($imagenologia as $key => $img) {
    //         $img->analitos = $img->analitos()->orderBy('pictures_has_analitos.orden', 'asc')->get();
    //     }

    //     return $imagenologia;
    // }
    protected function get_imagenologia_area(Model $folio, Request $request){
        $consulta = $folio->picture()->when($request->areaId != 'todo', function ($query) use ($request){
            $query->whereHas('deparment', function ($query) use ($request){
                $query->where('deparments_id', $request->areaId);
            });
        })->get();

        $imagenologia = $this->loadInformationImg($folio, $consulta);

        return $imagenologia;
    }

    public function loadInformation(Model $folio, Mixed $estudios){
        foreach ($estudios as $key => $estudio) {
            // dd($estudios);
            $estudio->analitos = $estudio->analitos()->orderBy('analitos_has_estudios.orden', 'asc')->get();
            $estudio->formulas = $estudio->formula()->get();
            foreach ($estudio->analitos as $key => $analito) {

                if($analito->tipo_resultado === 'referencia'){
                    $analito->referencia = $this->analitoService->getReferencial($folio->paciente()->first(), $analito->clave);
                }

                $consulta_historial = $folio
                    ->historials()
                    ->where('historials_has_recepcions.estudio_id', $estudio->id)
                    ->where('historials.clave', $analito->clave)
                    ->first();

                if($consulta_historial){
                    $analito->id_valor_captura = $consulta_historial->id;
                    $analito->valor_captura = $consulta_historial->valor;
                    $analito->valor_captura_abs = $consulta_historial->valor_abs !== null ? $consulta_historial->valor_abs : null;
                    // $analito->propiedad = true;
                }
                if($estudio->valida_qr === 'on' && $analito->valida_qr==='on'){
                    $pathQr         = URL::to('/') . '/resultados/valida/' . $folio->folio . '/' . $estudio->clave;
                    $analito->qr    = base64_encode(DNS2DFacade::getBarcodeSVG($pathQr, 'QRCODE',5,5 ));
                }
            }

            $obs = $estudio
                ->observaciones()
                ->where('observaciones_has_estudios.recepcions_id', $folio->id)
                ->where('observaciones_has_estudios.estudio_id', $estudio->id)->first() 
                    ? $estudio->observaciones()
                        ->where('observaciones_has_estudios.recepcions_id', $folio->id)
                        ->where('observaciones_has_estudios.estudio_id', $estudio->id)->first() 
                    : null;
            $estudio->observaciones = $obs ? $obs->observacion : 'Sin observaciones';

            $estudio->validacion = $folio->estudios()->where('estudio_id', $estudio->id)->value('recepcions_has_estudios.status');
        }

        return $estudios;
    }

    public function loadInformationImg(Model $folio, Mixed $estudios){
        foreach ($estudios as $key => $estudio) {
            $estudio->analitos = $estudio->analitos()->orderBy('pictures_has_analitos.orden', 'asc')->get();
            foreach ($estudio->analitos as $key => $analito) {
                $consulta_historial = $folio->historials()->where('historials_has_recepcions.picture_id', $estudio->id)
                    ->where('historials.clave', $analito->clave)
                    ->first();
                
                if($consulta_historial){
                    $analito->id_valor_captura = $consulta_historial->id;
                    $analito->valor_captura = $consulta_historial->valor;
                }

                $estudio->validacion = $folio->picture()->where('picture_id', $estudio->id)->value('recepcions_has_deparments.estatus_area');
            }

        }
        
        return $estudios;
    }

    protected function preventInformation(Model $folio, Mixed $estudios){
        // dd($folio);
        foreach ($estudios as $key => $clave) {
            $query = $folio->estudios()->where('clave', $clave)->first();
            if(! $query){
                $estudio = Estudio::where('clave', $clave)->first();
                $folio->estudios()->save($estudio);
            }
        }
        // Obtén todas las relaciones relacionadas con el modelo folio
        // $relacionesEnConsulta = $folio->estudios()->whereIn('clave', $estudios)->get();

        // Filtra las relaciones que ya se encuentran en la consulta y las que no
        // $relacionesEnConsulta = $folio->estudios()->whereIn('clave', $estudios)->get();

        // Asigna las relaciones no encontradas al modelo folio
        // foreach ($relacionesNoEncontradas as $relacion) {
        //     $folio->estudios()->save($relacion);
        // }

        // // Vuelve a ejecutar la consulta original
        // $recepcion = $folio->estudios()->whereIn('clave', $estudios)->get();

        // Muestra el resultado
        // dd($recepcion->toArray());

    }



}