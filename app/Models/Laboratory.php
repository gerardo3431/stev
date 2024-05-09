<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Foundation\Auth\User;

class Laboratory extends Model
{
    protected $fillable = [
        'nombre',
        'razon_social',
        'ciudad',
        'estado',
        'pais',
        'cp',
        'email',
        'telefono',
        'rfc',
        'logotipo',
        'membrete',
        'membrete_secundario',
        'membrete_terciario',
        'membrete_img',

        'responsable_sanitario',
        'firma_sanitario',
        'cedula_sanitario',
        'responsable_img',
        'firma_img',
        'cedula_img',
    ];

    use HasFactory;

    public function getMembrete($membrete){
        if(Storage::disk('public')->exists($membrete)){
            return Storage::disk('public')->get($membrete);
        }else{
            return false;
        }
    }

    // public function getAge(){
    //     return Carbon::createFromFormat('d/m/Y', $this->fecha_nacimiento)->age;
    // }
    // // cajas- sucursales- usuarios
    // public function cajas(){
    //     return $this->belongsToMany(Caja::class, 'cajas_has_subsidiaries')->withPivot('sucursal_id', 'usuario_id');
    // }

    // public function sucursales(){
    //     return $this->belongsToMany(Subsidiary::class, 'cajas_has_subsidiaries')->withPivot('caja_id', 'usuario_id');
    // }

    // public function usuarios(){
    //     return $this->belongsToMany(User::class, 'cajas_has_subsidiaries')->withPivot('caja_id', 'sucursal_id');
    // }

    // users_has_laboratories
    public function user(){
        return $this->belongsToMany(User::class, 'users_has_laboratories')->withPivot('subsidiary_id');
    }

    public function sucursal(){
        return $this->belongsToMany(Subsidiary::class, 'users_has_laboratories')->withPivot('user_id');
    }

    // User has laboratory
    public function usuario(){
        return $this->belongsToMany(User::class, 'user_has_laboratory');
    }

    // subsidiaries has laboratories
    public function subsidiary(){
        return $this->belongsToMany(Subsidiary::class, 'subsidiaries_has_laboratories', 'laboratorio_id', 'sucursal_id');
    }

    // Recupera usuarios adjuntos a la clinica
    public function users(){
        return $this->belongsToMany(User::class, 'users_has_laboratories',  'laboratorio_id','usuario_id',);
    }

    // Areas
    // Estudios
    public function estudios(){
        return $this->belongsToMany(Estudio::class, 'estudios_has_laboratories');
    }

    // estudios_has_laboratories  
    // No he implementado estas  funciones en sus respectivos modelos, 
    // revisar o implementar pronto
    public function estdy(){
        return $this->belongsToMany(Estudio::class, 'estudios_has_laboratories')->withPivot('sucursal_id', 'area_id', 'muestra_id', 'recipiente_id', 'metodo_id');
    }

    public function sucursl(){ 
        return $this->belongsToMany(Subsidiary::class, 'estudios_has_laboratories')->withPivot('estudio_id', 'area_id', 'muestra_id', 'recipiente_id', 'metodo_id' );
    }

    public function area(){
        return $this->belongsToMany(Area::class, 'estudios_has_laboratories')->withPivot('sucursal_id', 'estudio_id', 'muestra_id', 'recipiente_id', 'metodo_id');
    }

    public function muestr(){
        return $this->belongsToMany(Muestra::class, 'estudios_has_laboratories')->withPivot('sucursal_id', 'estudio_id', 'area_id', 'recipiente_id', 'metodo_id');
    }

    public function recipnte(){
        return $this->belongsToMany(Recipiente::class, 'estudios_has_laboratories')->withPivot('sucursal_id', 'estudio_id', 'area_id', 'muestra_id', 'metodo_id');
    }

    public function mtodo(){
        return $this->belongsToMany(Metodo::class, 'estudios_has_laboratories')->withPivot('sucursal_id', 'estudio_id', 'area_id', 'muestra_id', 'recipiente');
    }


    // Areas (de los estudios)
    public function areas(){
        return $this->belongsToMany(Area::class, 'areas_has_laboratories');
    }
    // Analitos 
    public function analitos(){
        return $this->belongsToMany(Analito::class, 'analitos_has_laboratories');
    }
    // Muestras de los estudios
    public function muestras(){
        return $this->belongsToMany(Muestra::class, 'muestras_has_laboratories');
    }

    //Recipientes de los estudios
    public function recipientes(){
        return $this->belongsToMany(Recipiente::class, 'recipientes_has_laboratories');
    } 

    // Metodos de los estudios
    public function metodos(){
        return $this->belongsToMany(Metodo::class, 'metodos_has_laboratories');
    }

    // Tecnicas de los estudios
    public function tecnicas(){
        return $this->belongsToMany(Tecnica::class, 'tecnicas_has_laboratories');
    }

    // Equipos de los estudios
    public function equipos(){
        return $this->belongsToMany(Equipo::class, 'equipos_has_laboratories');
    }


    // Precios de los laboratorios
    public function precios(){
        return $this->belongsToMany(Precio::class, 'precios_has_laboratories');
    }
    
    //Pacientes 
    public function pacientes(){
        return $this->belongsToMany(Pacientes::class, 'pacientes_has_laboratories');
    }
    //Empresas 
    public function empresas(){
        return $this->belongsToMany(Empresas::class, 'empresas_has_laboratories');
    }
    //Doctores 
    public function doctores(){
        return $this->belongsToMany(Doctores::class, 'doctores_has_laboratories');
    }


    // //Recepcion 
    // public function recepcions(){
    //     return $this->belongsToMany(Recepcions::class, 'recepcions_has_laboratories');
    // }
    

    // perfiles has laboratories
    public function perfiles(){
        return $this->belongsToMany(Profile::class, 'profiles_has_laboratories');
    }
    

    public function folios(){
        return $this->belongsToMany(Folios::class, 'folios_has_laboratories');
    }

    // Prefolios 
    public function prefolios(){
        return $this->belongsToMany(Prefolio::class, 'prefolios_has_laboratories')->withPivot('user_id');
    }

    public function user_prefolio(){
        return $this->belongsToMany(User::class, 'prefolios_has_laboratories')->withPivot('prefolio_id');
    }

    // Imagenologia
    public function imagen(){
        return $this->belongsToMany(Picture::class,'pictures_has_laboratories');
    }

    // Areas de imagenologia 
    public function departamento(){
        return $this->belongsToMany(Deparments::class,'deparments_has_laboratories');
    }

    public function paquete(){
        return $this->belongsToMany(Paquetes::class, 'laboratories_has_paquetes');
    }

}
