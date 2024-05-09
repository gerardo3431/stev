<?php
namespace App\Services;

use App\Models\Historial;
use App\Models\Recepcions;
use Illuminate\Support\Facades\Auth;
use Stichoza\GoogleTranslate\GoogleTranslate;
class ImportacionService{

    /**
     * Import a array where firts position it's folio
     * @param mixed $folio
     * @param mixed $fila
     * @return mixed
     */

    public function import(mixed $collection, mixed $area)
    {
        $array = $this->formatArray($collection);
        $massiveCreate = $this->save($array, $area);
        return $massiveCreate;
    }

    public function getFolio(string $folio)
    {
        return Recepcions::where("folio", $folio)->first();
    }

    public function getStudies(mixed $folio, mixed $area)
    {
        return $folio->estudios()->whereRelation('area', 'estudios_has_laboratories.area_id', '=', $area->id)->get() 
            ? $folio->estudios()->whereRelation('area', 'estudios_has_laboratories.area_id', '=', $area->id)->get() 
            : null ;
    }

    private function getProfiles(mixed $folio)
    {
        return $folio->recepcion_profiles()->get() ? $folio->recepcion_profiles()->get() : null;
    }

    private function getParams(mixed $estudio, string $key)
    {
        return $estudio->analitos()->where('descripcion', 'LIKE', '%'. $key . '%')->get();
    }

    private function formatArray(mixed $collection)
    {
        $array = [];
        foreach ($collection[0] as $key => $fila) {
            $clave = $fila[0];
            $array[$clave] = array_key_exists($clave, $array) ? [...$array[$clave], $fila->toArray()] : [$fila->toArray()];
        }
        $new_array = $this->searchParams($array);
        return $new_array;
    }

    private function searchParams(array $array)
    {
        $masterArray = [];
        foreach ($array as $keyGrupo => $grupo) {
            $masterArray[$keyGrupo]['folio'] = $keyGrupo;
            $paramArray = [];
            foreach ($grupo as $keyFila => $fila) {
                $resultado = $this->procesingData($fila);
                $analitoString = $resultado['analito'];
                if(!isset($paramArray[$analitoString])){
                    $paramArray[$analitoString] = [];
                }
                $paramArray[$analitoString][] = $resultado;
            }
            $masterArray[$keyGrupo]['parametros'] = $paramArray;
        }

        return $masterArray;
    }

    private function procesingData(array $fila)
    {
        $valorNumerico = null;
        $analitoString = null;

        $valorNumericoIndex = null;

        for($i = count($fila) - 1 ; $i>=0; $i--){
            if (preg_match('/^[\d.]+$/', $fila[$i])) {
                $valorNumericoIndex = $i;
                break;
            }
        }

        if($valorNumericoIndex !== null && $valorNumericoIndex >=2){
            $analitoString = $fila[$valorNumericoIndex-2];
            $valorNumerico = $fila[$valorNumericoIndex];
        }

        return [
            'analito'  => $analitoString,
            'valor'    => $valorNumerico
        ];
    }

    private function save(array $array, mixed $area)
    {
        $remaintArray = [];
        foreach ($array as $a => $folio) {
            $recepcions = $this->getFolio($folio['folio']);
            // $prefolies = $this->getProfiles($recepcions)
            foreach ($folio['parametros'] as $key => $value) {
                if($recepcions != null && $this->getStudies($recepcions, $area) != null){
                    $this->saveStudies($value, $area, $this->getStudies($recepcions, $area), $recepcions);
                }

                if($recepcions != null && $this->getProfiles($recepcions) != null){
                    foreach ($this->getProfiles($recepcions) as $key => $profile) {
                        $estudios = $profile->perfil_estudio()->whereRelation('area', 'estudios_has_laboratories.area_id', '=', $area->id)->get();
                        if($recepcions != null && $estudios != null){
                            $this->saveStudies($value, $area, $estudios, $recepcions);
                        }
                    }
                }

                
            }

            if($recepcions === null){
                $remaintArray[] = $folio;
            }
        }

        return $remaintArray;
    }

    private function saveStudies(array $array, mixed $area, mixed $estudios, mixed $folio)
    {
        #m:m -> check
        #1:m -> check
        #1:1 -> check
        #m:1 -> unpassed (edit this if)
        foreach ($estudios as $keyEstudio => $estudio) {
            $parametros = $this->getParams($estudio, $array[0]['analito']);
            if(count($array) > 1 && count($parametros) > 1 ){
                foreach ($parametros as $key => $parametro) {
                    $create = $this->saveEntry($parametro, $array[$key]['valor'], $estudio, $folio);
                    if($create){
                        $link = $this->linkInformation($folio, $create, $estudio);
                    }
                }
            }else if(count($array) === 1 && count($parametros) > 1 ){
                foreach ($parametros as $key => $parametro) {
                    $create = $this->saveEntry($parametro, $array[0]['valor'], $estudio, $folio);
                    if($create){
                        $link = $this->linkInformation($folio, $create, $estudio);
                    }
                }
            }else if(count($array) === 1 && count($parametros) === 1 ){
                foreach ($parametros as $key => $parametro) {
                    $create = $this->saveEntry($parametro, $array[0]['valor'], $estudio, $folio);
                    if($create){
                        $link = $this->linkInformation($folio, $create, $estudio);
                    }
                }
            }else if($parametros){
                foreach ($parametros as $key => $parametro) {
                    $create = $this->saveEntry($parametro, $array[0]['valor'], $estudio, $folio, $array[1]['valor']);
                    if($create){
                        $link = $this->linkInformation($folio, $create, $estudio);
                    }
                }
            }else{
                $this->saveRemaints($array);
            }
        }
    }

    private function saveEntry(mixed $parametro, string $valor, mixed $estudio, mixed $folio, string $absoluto = null){
        $consulta = $folio->historials()->where('historials_has_recepcions.estudio_id', $estudio->id)->where('clave', $parametro->clave)->first();
        if(! $consulta){
            $create = Historial::create([
                'clave'         => $parametro->clave,
                'descripcion'   => $parametro->descripcion,
                'valor'         => $valor,
                'absoluto'      => $absoluto != null ? 1 : 0,
                'valor_abs'     => $absoluto
            ]);
        }
        
        return isset($create) ? $create : null;
    }

    private function linkInformation(mixed $folio, mixed $historial, mixed $estudio)
    {
        $historial = $folio->historials()->where('historials_has_recepcions.estudio_id', $estudio->id)->attach($historial->id, [
            'estudio_id' => $estudio->id, 
            'recepcions_id' => $folio->id
        ]);

        if($historial) {
            $folio->update(['captura_id' => Auth::user()->id]);
            $folio->areas()->where('areas.id', $estudio->areas()->first()->id)->update([
                'recepcions_has_areas.estatus_area' => 'capturado'
            ]);
        }

        return true;
    }

    private function saveRemaints(array $array)
    {
        dd($array); #Aqui voy a mandar todo lo que no se ubique en la bd alavrg
    }
    
}
        
    //     $array = $this->procesingData($fila);
        
    //     // TODO: Implementar la lógica de negocio para guardar los datos en BD
    //     $recepcions = Recepcions::where('folio', $fila[0])->first();
    //     if($recepcions->estudios()->get()){
    //         $estudios = $recepcions
    //             ->estudios()
    //             ->whereRelation('area', 'estudios_has_laboratories.area_id', '=', $area->id)
    //             ->get();
                
    //         foreach ($estudios as $key => $estudio) {
    //             $analitos = $estudio->analitos()->where('descripcion', 'LIKE', '%'. $array['analito'] . '%')->get();
    //             if($analitos){
    //                 foreach ($analitos as $key => $analito) {
    //                     $this->createEntry($folio, $estudio, $analito, $this->repairArray($folio, $estudio, $array));
    //                 }
    //             }
    //         }

    //     }

    //     if($recepcions->recepcion_profiles()->first()){
    //         $perfiles = $recepcions
    //             ->recepcion_profiles()
    //             ->first()
    //             ->perfil_estudio()
    //             ->whereRelation('area', 'estudios_has_laboratories.area_id', '=', $area->id)
    //             ->get();
                
                
    //         foreach ($perfiles as $key => $estudio) {
    //             $analitos = $estudio->analitos()->where('descripcion', 'LIKE', '%'. $array['analito'] . '%')->get();
    //             if($analitos){
    //                 foreach ($analitos as $key => $analito) {
    //                     $this->createEntry($folio, $estudio, $analito, $this->repairArray($folio, $estudio, $array));
    //                 }
    //             }
    //         }
            
    //     }

    //     return true;
    // }

    // public function importAjax($array, $analito, $estudio, $folio){
    //     $create = $this->createEntry($folio, $estudio, $analito, $array);
    //     return $create;
    // }

    // private function save($analito, $array){
    //     $create = Historial::create([
    //         'clave'         => $analito->clave,
    //         'descripcion'   => $analito->descripcion,
    //         'valor'         => $array['valor'],
    //         'absoluto'      => 0,
    //         'valor_abs'     => NULL
    //     ]);
    //     return $create;
    // }

    // private function createEntry($folio, $estudio, $analito, $array){
    //     $create = $this->save($analito, $array);
    //     $this->linkInformation($folio, $create, $estudio);
    //     return $create;
    // }

    // // private function traductor(string $texto){
    // //     $tr = new GoogleTranslate('en'); // Translates into English
    // //     $tr->setTarget('es');
    // //     $tr->setClient('webapp');
    // //     return $tr->translate($texto);
    // // }

    // private function repairArray($folio, $estudio, $array){
    //     return [
    //         'folio'          => $folio->id,
    //         'estudio'        => $estudio->id,
    //         'analito'        => $array['analito'],
    //         'valor'          => $array['valorNumero']
    //     ];
    // }

    // private function procesingData(mixed $fila){
    //     $valorNumerico = null;
    //     $analitoString = null;

    //     $filaArray = $fila->toArray();
    //     $valorNumericoIndex = null;

    //     for($i = count($filaArray) - 1 ; $i>=0; $i--){
    //         if (preg_match('/^[\d.]+$/', $filaArray[$i])) {
    //             $valorNumericoIndex = $i;
    //             break;
    //         }
    //     }

    //     if($valorNumericoIndex !== null && $valorNumericoIndex >=2){
    //         $analitoString = $filaArray[$valorNumericoIndex-2];
    //         $valorNumerico = $filaArray[$valorNumericoIndex];
    //     }

    //     return [
    //         'analito'       => $analitoString,
    //         'valorNumero'   => $valorNumerico
    //     ];
    // }

    // private function linkInformation(mixed $folio, mixed $historial,mixed $estudio){
    //     $consulta = $folio->historials()->where('historials_has_recepcions.estudio_id', $estudio->id)->where('clave', $historial->clave)->first();

    //     if(!$consulta){
    //         $folio->historials()->attach($historial->id, [
    //             'estudio_id' => $estudio->id, 
    //             'recepcions_id' => $folio->id
    //         ]);
    //     }else{
    //         $consulta->update([
    //             'valor' => $historial->valor
    //         ]);
    //         $historial->delete();
    //     }

    //     if($historial) {
    //         $folio->update(['captura_id' => Auth::user()->id]);
    //         $folio->areas()->where('areas.id', $estudio->areas()->first()->id)->update([
    //             'recepcions_has_areas.estatus_area' => 'capturado'
    //         ]);
    //     }

    //     return true;
    // }
