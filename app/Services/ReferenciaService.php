<?php

namespace App\Services;

use App\Models\Analito;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ReferenciaService{

    /**
     * Obtain the referencial data from patient into $folio
     * @param model $folio
     * @return string
     */
    public function get(Model $folio, Model $analito){
        $paciente = $folio->paciente()->first();
        $birthday =  $paciente->evalueAge();
        $currentDate = Carbon::now();

        if($birthday instanceof Carbon){
            $ageDifference = $birthday->diff($currentDate);

            $years = $ageDifference->y; //años desde la fecha especificada
            $months = $ageDifference->m; //meses desde la fecha especificada
            $days = $ageDifference->d; //dias desde la fecha especificada
            $weeks = floor($ageDifference->days / 7); //Semanas desde el inicio de la fecha
            // dd("Tienes $years años, $months meses, $days días y han pasado $weeks semanas desde tu nacimiento.");
            $valores = Analito::where('clave', $analito->clave)->first()
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
            $valores = $analito->referencias()
                ->where('edad_inicial', '<=', intval($birthday))
                ->where('edad_final', '>', intval($birthday))
                ->where('tipo_inicial', '=', 'año')
                ->where('tipo_final', '=', 'año')
                ->where('sexo', '=', $paciente->sexo)
                ->first();
        }
        
        return $valores ? $valores->edad_inicial . ' ' . $valores->tipo_inicial . ' a ' . $valores->edad_final . ' ' . $valores->tipo_final . ': ' . $valores->referencia_inicial . ' - ' . $valores->referencia_final  : 'Sin datos';
    }
}