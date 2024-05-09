<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Recepcions extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected static $recordEvents = ['created', 'updated','deleted'];

    public $fillable = ['folio', 
                        'h_flebotomia', 
                        'f_flebotomia', 
                        'numRegistro',
                        'id_paciente', 
                        'id_empresa', 
                        'fecha_entrega',
                        'tipPasiente', 
                        'turno', 
                        'id_doctor',
                        'numCama', 
                        'peso', 
                        'talla', 
                        'fur',
                        'medicamento', 
                        'diagnostico',
                        'observaciones', 
                        'listPrecio', 
                        'num_total',
                        'descuento',
                        'num_vuelo', 
                        'pais_destino',
                        'aerolinea',
                        'token',
                        'user_id',
                        'res_file',
                        'res_file_img',
                        'maq_file',
                        'maq_file_img',
                        'patient_file',
                        'estado'

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['updated_at', 'deleted'])
            ->useLogName('recepcion')
            ->setDescriptionForEvent(fn(string $eventName) => "Folio {$eventName}");
    }

    public function getContador(){
        
        $total = $this->estudios()->count();
        $validados = count($this->estudios()->where('status', 'validado')->get());
        // return $validados . " de " . $total;
        return $validados . " validados." ;

    }

    public function getEstado(){
        if(count($this->estudios()->where('status', 'validado')->get()) === count($this->estudios()->get()) ){
            return 'validado';
        }elseif(count($this->estudios()->where('status', 'capturado')->get()) === count($this->estudios()->get()) || count($this->estudios()->where('status', 'capturado')->get())  !== 0 ){
            return 'capturado';
        }else{
            return 'solicitado';
        }
    }

    public function getNamePatient(){
        return $this->paciente()->first()->nombre;
    }

    public function getNameDoctor(){
        return $this->doctores()->first()->nombre;
    }

    public function getNameEmpresa(){
        return $this->empresas()->first()->descripcion;
    }
    
    public function getAnticipos(){
        return ($this->pago()->count() == 1 && $this->estado == 'no pagado' ) ? "$ " . $this->pago()->first()->importe : "$ 0" ;
    }

    public function empresas(){
        return $this->belongsTo(Empresas::class, 'id_empresa'); 
    }
    
    public function doctores(){
        return $this->belongsTo(Doctores::class, 'id_doctor');
    }

    public function captura(){
        return $this->belongsTo(User::class, 'captura_id');
    }

    public function valida(){
        return $this->belongsTo(User::class, 'valida_id');
    }

    public function sucursales(){
        return $this->belongsToMany(Subsidiary::class, 'recepcions_has_subsidiaries');
    }
    
    // Recepcions_has_paciente  
    public function paciente(){
        return $this->belongsToMany(Pacientes::class, 'recepcions_has_paciente');
    }

    // Recepcions_has_areas
    public function areas(){
        return $this->belongsToMany(Area::class, 'recepcions_has_areas');
    }

    // Recepcion has estudios
    public function estudios(){
        return $this->belongsToMany(Estudio::class, 'recepcions_has_estudios');
    }

    // public function areas(){
    //     return $this->belongsToMany(Area::class, 'recepcions_has_estudios')->withPivot('estudio');
    // }
    // // 
    // historial has recepcions
    // Estudios
    public function historials(){
        return $this->belongsToMany(Historial::class, 'historials_has_recepcions')->withPivot('estudio_id');
    }

    public function estudio(){
        return $this->belongsToMany(Estudio::class, 'historials_has_recepcions')->withPivot('historial_id');
    }

    // Estudios de imagenologia
    public function historials_pictures(){
        return $this->belongsToMany(Historial::class, 'historials_has_recepcions')->withPivot('picture_id');
    }

    public function pictures(){
        return $this->belongsToMany(Picture::class, 'historials_has_recepcions')->withPivot('historial_id');
    }

    // 
    // Profiles has recepcions
    public function recepcion_profiles(){
        return $this->belongsToMany(Profile::class, 'recepcions_has_profiles');
    }

    // Pagos_has_recepcions
    public function pago(){
        return $this->belongsToMany(Pago::class, 'pagos_has_recepcions');
    }

    // Observaciones para cada estudio
    public function estudio_obs(){
        return $this->belongsToMany(Estudio::class, 'observaciones_has_estudios')->withPivot('observaciones_id');
    }

    public function observaciones(){
        return $this->belongsToMany(Observaciones::class, 'observaciones_has_estudios')->withPivot('estudio_id');
    }

    // Prefolios has recepcions
    public function prefolio(){
        return $this->belongsToMany(Prefolio::class, 'prefolios_has_recepcions');
    }

    public function picture(){
        return $this->belongsToMany(Picture::class, 'recepcions_has_deparments')->withPivot('deparments_id');
    }

    public function deparment(){
        return $this->belongsToMany(Deparments::class, 'recepcions_has_deparments')->withPivot('picture_id');
    }

    public function comentarios(){
        return $this->belongsToMany(Observaciones::class, 'recepcions_has_observaciones')->withPivot('observaciones_id');
    }

    // public function precios(){
    //     return $this->belongsToMany(Precio::class, 'recepcions_has_precios')->withPivot('lista_id');
    // }

    public function lista(){
        return $this->belongsToMany(Lista::class, 'recepcions_has_precios');
    }
}
