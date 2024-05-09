<?php

namespace App\Models;

use GrahamCampbell\ResultType\Success;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    // Spatie
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];


    // Cajas-laboratorios-sucursales
    public function cajas(){
        return $this->belongsToMany(Caja::class, 'cajas_has_subsidiaries')->withPivot('sucursal_id');
    }

    public function sucursales(){
        return $this->belongsToMany(Subsidiary::class, 'cajas_has_subsidiaries')->withPivot('caja_id');
    }


    // Users has laboratories
    public function laboratorio(){ 
        return $this->belongsToMany(Laboratory::class, 'users_has_laboratories')->withPivot('subsidiary_id');
    }

    public function sucursal(){
        return $this->belongsToMany(Subsidiary::class, 'users_has_laboratories')->withPivot('laboratory_id');
    }

    // Para que me traiga las relaciones de usuarios registrados a laboratorios
    public function labs(){
        return $this->belongsToMany(Laboratory::class, 'users_has_laboratories');
    }
    
    // Para que me traiga las relaciones de usuarios asignados a las sucursales
    public function sucs(){
        return $this->belongsToMany(Subsidiary::class, 'users_has_laboratories');
    }
    
    // user_has_laboratorios
    public function labo(){
        return $this->belongsToMany(Laboratory::class, 'user_has_laboratory');
    }
    
    // Trae las cajas abiertas por el usuario en Vista Cajas
    public function caja(){
        return $this->belongsToMany(Caja::class, 'cajas_has_subsidiaries', 'user_id');
    }

    
    // Para que me traiga las  relaciones de caja con usuario
    //Pagos_has_user
    public function pago(){
        return $this->belongsToMany(Pago::class, 'pagos_has_users');
    }

    // Subsidiaries has users
    public function locales(){
        return $this->belongsToMany(Subsidiary::class, 'subsidiary_has_user');
    }


    // recepcions
    public function folio_captura(){
        return $this->belongsToMany(Recepcions::class, 'captura_id');
    }
    public function folio_valida(){
        return $this->belongsToMany(Recepcions::class, 'valida_id');
    }

    // Retiros_has_cajas
    public function caja_retiro(){
        return $this->belongsToMany(Caja::class, 'retiros_has_cajas')->withPivot('retiro_id');
    }

    public function retiros(){
        return $this->belongsToMany(Retiro::class, 'retiros_has_cajas')->withPivot('caja_id');
    }

    // Prefolio
    public function laboratorio_prefolio(){
        return $this->belongsToMany(Laboratory::class, 'prefolios_has_laboratories')->withPivot('prefolio_id');
    }
    
    public function prefolio(){
        return $this->belongsToMany(Prefolio::class, 'prefolios_has_laboratories')->withPivot('laboratory_id');
    }

    // Doctores user
    
    public function doctor(){
        return $this->belongsToMany(Doctores::class, 'doctores_has_users');
    }

    // Empresas has users
    public function empresas_users(){
        return $this->belongsToMany(Empresas::class, 'empresas_has_users');
    }
}
