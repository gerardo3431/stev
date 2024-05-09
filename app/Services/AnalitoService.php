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

        if($birthday instanceof Carbon){
            $ageDifference = $birthday->diff($currentDate);

            $years = $ageDifference->y; //años desde la fecha especificada
            $months = $ageDifference->m; //meses desde la fecha especificada
            $days = $ageDifference->d; //dias desde la fecha especificada
            $weeks = floor($ageDifference->days / 7); //Semanas desde el inicio de la fecha
            // dd("Tienes $years años, $months meses, $days días y han pasado $weeks semanas desde tu nacimiento.");
            // dd(intval($years), $years);
            $valores = Analito::where('clave', $clave)->first()
                ->referencias()
                ->where('edad_inicial', '<=', $years)
                ->where('edad_final', '>=', $years)
                ->where('sexo', $paciente->sexo)
                ->when($years === 0 && $months === 0, function ($subquery) {
                    $subquery->where('tipo_inicial', 'dia')
                        ->where('tipo_final', 'dia');
                })
                ->when($years === 0 && $months !== 0, function ($subquery){
                    $subquery->where('tipo_inicial', 'mes')
                        ->where('tipo_final', 'mes');
                })
                ->when($years !== 0, function ($subquery){
                    $subquery->where('tipo_inicial', 'año')
                        ->where('tipo_final', 'año');
                })
                ->first();
        }else{
            $valores = Analito::where('clave', $clave)->first()
                ->referencias()
                ->where('edad_inicial', '<=', intval($birthday))
                ->where('edad_final', '>', intval($birthday))
                ->where('tipo_inicial', '=', 'año')
                ->orWhere('tipo_final', '=', 'año')
                ->orWhere('sexo', '=', $paciente->sexo)
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