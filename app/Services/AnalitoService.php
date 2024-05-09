<?php

namespace App\Services;

use App\Models\Analito;
use App\Models\Laboratory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AnalitoService{
    /**
     * Obtain the references values from analito
     * @param model $paciente
     * @param string $clave
     * @return mixed
     */
    public function getReferencial(Model $paciente, $clave){
        $birthday =  $paciente->evalueAge();
        $currentDate = Carbon::now();

        // $paciente = $folio->paciente()->first();
        // $birthday =  $paciente->evalueAge();
        // $currentDate = Carbon::now();

        $analito = Analito::where('clave', $clave)->first();
         
        if($birthday instanceof Carbon){
            $ageDifference = $birthday->diff($currentDate);

            $years = $ageDifference->y; //años desde la fecha especificada
            $months = $ageDifference->m; //meses desde la fecha especificada
            $days = $ageDifference->d; //dias desde la fecha especificada
            $weeks = floor($ageDifference->days / 7); //Semanas desde el inicio de la fecha
            // dd("Tienes $years años, $months meses, $days días y han pasado $weeks semanas desde tu nacimiento.");
            // dd(intval($years), $years);
            
            $valoresPorSexo = $analito
                ->referencias()
                ->where('referencias_has_analitos.analito_id', $analito->id)
                ->where('sexo', $paciente->sexo)
                ->get();

            // Aplicar condiciones adicionales utilizando filter() y comparaciones
            $resultadosFiltrados = $valoresPorSexo->filter(function ($item) use ($years, $months, $days) {
                return ($years === 0 && $months === 0 && $item->edad_inicial <= $days && $item->edad_final >= $days && $item->tipo_inicial === 'dia' && $item->tipo_final === 'dia')
                    || ($years === 0 && $months !== 0 && $item->edad_inicial <= $months && $item->edad_final >= $months && $item->tipo_inicial === 'mes' && $item->tipo_final === 'mes')
                    || ($years !== 0 && $item->edad_inicial <= $years && $item->edad_final >= $years && $item->tipo_inicial === 'año' && $item->tipo_final === 'año');
            });

            
            $valores= $resultadosFiltrados->first();
        }else{
            $valores = $analito
                ->referencias()
                ->where('edad_inicial', '<=', intval($birthday))
                ->where('edad_final', '>=', intval($birthday))
                ->where('sexo', $paciente->sexo)
                ->when($birthday === 0, function ($query){
                    $query->where('tipo_inicial', 'dia')
                        ->orWhere('tipo_final',  'dia');
                })->when($birthday !== 0, function ($query){
                    $query->where('tipo_inicial', 'año')
                        ->orWhere('tipo_final', 'año');
                })
                ->first();
        }
        
        
        return $valores;
    }
    /** 
     * Receives the params (previously validated)
     * 
     * @param Array $analito
     * @return mixed
    */
    public function create(array $analito){
        $create = Analito::create($analito);
        $this->asociarAnalito($create);
        return $create;
    }

    /**
     * Associate the data into laboratory
     * 
     * @param Model $analito
     * @return void
     */
    private function asociarAnalito(Analito $analito){
        $laboratorio  = Laboratory::first();
        $laboratorio->analitos()->save($analito);
    }
    
}