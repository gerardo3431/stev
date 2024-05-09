<?php
namespace App\Services;

use App\Models\Estudio;
use App\Models\Historial;
use App\Models\Laboratory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use Milon\Barcode\Facades\DNS2DFacade;

class ResultadoService{
    protected $referenciaService;
    protected $folioService;

    public function __construct(ReferenciaService $referenciaService, FolioService $folioService)
    {
        $this->referenciaService    = $referenciaService;
        $this->folioService         = $folioService;
    }

    /**
     * return a studies/profiles data collection from folio
     * @param model $folio
     * @return mixed
     */
    public function getDataStudie(Model $folio, Model $estudio = null){
        if($estudio !== null){
            $queryEstudios = collect([$folio->estudios()->where('recepcions_has_estudios.estudio_id', $estudio->id)->first()]);
        }else{
            $queryEstudios = $folio->estudios()
                ->where('recepcions_has_estudios.status', 'validado')
                ->whereNotIn('recepcions_has_estudios.estudio_id', function ($subquery) use ($folio){
                    $subquery->select('estudio_id')
                        ->from('profiles_has_estudios')
                        ->whereIn('profile_id', $folio->recepcion_profiles()->pluck('profiles.id')->toArray());
                })->get();
        }

        $estudios = $this->folioService->loadInformation($folio, $queryEstudios);
        // $estudios = $this->serializeData($queryEstudios, $folio);

        if($estudios){
            // // Filtrar los estudios con resultado_esperado
            // $queryEstudiosFiltrados = $estudios->filter(function ($estudio) {
            //     return $estudio->analitos->contains(function ($analito) {
            //         return $analito->resultado_esperado !== null;
            //     });
            // });
            
            // Agrupar los estudios filtrados por áreas
            $estudiosAgrupados = $estudios->groupBy(function ($estudio) {
                return $estudio->areas()->first()->descripcion;
            });

            return (! $estudiosAgrupados->isEmpty()) ? $estudiosAgrupados : null;
        }
    }

    /**
     * return a studies/profiles data collection from folio
     * @param model $folio
     * @return mixed
     */
    public function getDataProfile(Model $folio)
    {
        // Obtener los perfiles
        $queryPerfiles = $folio->recepcion_profiles()->get();
        foreach ($queryPerfiles as $keyPerfil => $perfil) {
            $query =  $folio->estudios()
                ->whereIn('recepcions_has_estudios.estudio_id', function ($subquery) use ($perfil) {
                    $subquery->select('estudio_id')
                        ->from('profiles_has_estudios')
                        ->where('profile_id', $perfil->id);
                })
                ->where('recepcions_has_estudios.status', 'validado')
                ->get();
                
            $estudios = $this->folioService->loadInformation($folio, $query);
            // Filtrar los estudios con resultado_esperado
            // $perfil->estudios = $estudios->filter(function ($estudio) {
            //     return $estudio->analitos->contains(function ($analito) {
            //         return $analito->resultado_esperado !== null;
            //     });
            // });
            // Agrupar los estudios filtrados por áreas
            $perfil->estudios = $estudios->groupBy(function ($estudio) {
                return $estudio->areas()->first() ? $estudio->areas()->first()->descripcion : 'SIN AREA';
            });
            
        }

        return (! $queryPerfiles->isEmpty()) ? $queryPerfiles : null;
    }

    /**
     * return a img data collection from folio
     * @param model $folio
     * @return mixed
     */
    public function getDataImg(Model $folio)
    {

    }

    public function getBarcode(Model $folio){
        return DNS1D::getBarcodeSVG($folio->folio, 'C128', 1.20, 30, 'black', false);
    }

    public function getSign(Model $laboratorio){
        return Storage::disk('public')->get($laboratorio->firma_sanitario) ? base64_encode(Storage::disk('public')->get($laboratorio->firma_sanitario)) : null;

    }

    // public function obtainWatermark(string $seleccion){
    //     $laboratorio = Laboratory::first();

    //     switch ($seleccion) {
    //         case 'principal':
    //             $fondo = $laboratorio->getMembrete($laboratorio->membrete);
    //             break;
    //         case 'secundario':
    //             $fondo = $laboratorio->getMembrete($laboratorio->membrete_secundario);
    //             break;
    //         case 'terciario':
    //             $fondo = $laboratorio->getMembrete($laboratorio->membrete_terciario);
    //             break;
    //         default:
    //             $fondo = $laboratorio->getMembrete($laboratorio->membrete);
    //             break;
    //     }

    //     return $fondo ? $fondo : null;

    // }

    /**
     * Make a collection to the medic document
     * @param collection $estudio
     * @param model $folio
     * @return mixed
     */
    protected function serializeData(Collection $estudios, Model $folio)
    {
        $queryEstudios = $estudios;
        foreach ($queryEstudios as $key => $estudio) {
            $estudio->analitos          = $estudio->analitos()->orderBy('analitos_has_estudios.orden', 'asc')->get();
            $estudio->completo          = $estudio->historial()->get()->isEmpty() ? false : true;
            $estudio->area              = $estudio->areas()->first()->descripcion;
            $estudio->conteo_analito    = $estudio->analitos->count();

            foreach ($estudio->analitos as $key => $analito) {
                $historial = Historial::where('historials.clave', $analito->clave)
                    ->where('historials.estatus', 'validado')
                    ->whereHas('recepcions', function ($query) use ($estudio, $folio){
                        $query->where('recepcions_id', $folio->id)->where('estudio_id', $estudio->id);
                    })
                    ->latest()->first();

                if($historial){
                    $analito->estado                = true;
                    $analito->resultado_esperado    = $historial->valor;
                    $analito->resultado_abs         = $historial->valor_abs;
                }else{
                    $analito->estado                = false;
                    $analito->resultado_esperado    = null;
                    $analito->resultado_abs         = null;
                }

                if($analito->tipo_resultado === 'referencia'){
                    $analito->referencias = $this->referenciaService->get($folio, $analito);
                }
                
                if($estudio->valida_qr === 'on' && $analito->valida_qr){
                    $pathQr         = URL::to('/') . '/resultados/valida/' . $folio->folio . '/' . $estudio->clave;
                    $analito->qr    = base64_encode(DNS2DFacade::getBarcodeSVG($pathQr, 'QRCODE',5,5 ));
                }
            }

        }

        return (! $queryEstudios->isEmpty()) ? $queryEstudios : null;

    }
}