<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pacientes extends Model
{
    use SoftDeletes;
    use HasFactory;
    public $fillable = ['nombre',
                        'domicilio', 
                        'colonia', 
                        'sexo', 
                        'fecha_nacimiento',
                        'edad',
                        'celular', 
                        'email', 
                        // 'empresa', 
                        'seguro_popular',
                        'vigencia_inicio', 
                        'vigencia_fin', 
                        'id_empresa'
                        ]; 

    public function getAge(){
        try {
            return Carbon::createFromFormat('d/m/Y', $this->fecha_nacimiento)->age;
            // $instance = Carbon::createFromFormat('d/m/Y', $this->fecha_nacimiento);
            // return $instance->y . ' años ' . $instance->m . ' meses' ;
        } catch (\Throwable $th) {
            return $this->edad;
        }
    }

    public function evalueAge(){
        return Carbon::createFromFormat('d/m/Y', $this->fecha_nacimiento);
    }

    public function specificAge(){
        $birthday =  $this->evalueAge();
        $currentDate = Carbon::now();

        if($birthday instanceof Carbon){
            $age = $birthday->diff($currentDate);
            $years = $age->y; //años desde la fecha especificada
            $months = $age->m; //meses desde la fecha especificada
            $days = $age->d;

            return $years . " año(s), " . $months . " mes(es), " . $days . " dia(s).";
        }else{
            return $birthday . " años.";
        }
    }


    // Funcion para retornar el nombre completo sin tener que concatenar en vista
    // public function all_name(){
    //     return "{$this->nombre} {$this->ap_paterno} {$this->ap_materno}";
    // }

    public function laboratory(){
        return $this->belongsToMany(Laboratory::class, 'pacientes_has_laboratories');
    }
    
    public function recepcions(){
        return $this->belongsToMany(Recepcions::class, 'recepcions_has_paciente'); 
    }
    
    public function empresas(){
        return $this->belongsTo(Empresas::class, 'id_empresa'); 
    }    
}
