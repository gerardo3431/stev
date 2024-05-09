<?php

namespace App\Models;

// use App\Models\User as ModelsUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Foundation\Auth\User;

class Subsidiary extends Model
{
    
    protected $fillable = [
        'sucursal', 'direccion', 'telefono',
    ];
    
    use HasFactory;

    
// caja-sucursal-usuarios
    public function cajas(){
        return $this->belongsToMany(Caja::class, 'cajas_has_subsidiaries')->withPivot('user_id');
    }


    // SUCURSAL TIENE LOS FOLIOS
    public function folios(){
        return $this->belongsToMany(Recepcions::class, 'recepcions_has_subsidiaries');
    }

    // QUe usuario abre la caja
    public function usuarios(){
        return $this->belongsToMany(User::class, 'cajas_has_subsidiaries')->withPivot('caja_id');
    }


    // users has laboratories
    public function laboratorio(){
        return $this->belongsToMany(Laboratory::class, 'users_has_laboratories')->withPivot('user_id');
    }

    public function usuario(){
        return $this->belongsToMany(User::class, 'users_has_laboratories')->withPivot('laboratory_id');
    }
    // Para traer a los usuarios asignados al laboratorio
    public function users(){
        return $this->belongsToMany(User::class, 'users_has_laboratories', 'subsidiary_id', 'user_id');
    }

    
    // subsidiaries has laboratories
    public function laboratory(){
        return $this->belongsToMany(Laboratory::class, 'subsidiaries_has_laboratories');
    }
    

    // Pagos_has_subisidiaries
    public function pago(){
        return $this->belongsToMany(Pago::class, 'pagos_has_subsidiaries');
    }


    // Users has subsidiaries
    public function empleados(){
        return $this->belongsToMany(User::class, 'subsidiary_has_user');
    }
}
