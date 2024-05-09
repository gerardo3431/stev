<?php
namespace App\Services;

use App\Models\Estudio;
use App\Models\Laboratory;
use App\Models\Profile;

class PerfilService{

    /**
     * Receives the profile validated
     * @param Array $perfil
     * @return mixed
     */
    public function create(array $perfil){
        $create = Profile::create($perfil);
        $this->asociarPerfil($create);
        return $create;
    }

    /**
     * Update the profile with the new data
     * @param Model $profile
     * @param Array $perfil
     * @return void
     */
    public function update(Profile $profile, array $perfil){
        $actualizar = $profile->update([
            'codigo' => $perfil['codigo'],
            'descripcion' => $perfil['descripcion'],
            'observaciones' => $perfil['observaciones'],
            'precio'        => $perfil['precio'],
        ]);
    }

    /**
     * Soft delete a entry profile
     * @param Model $profile
     * @return void
     */
    public function delete(Profile $profile){
        $profile->delete();
    }

    /**
     * Receives massive list of studies to link profile
     * @param Model $profile
     * @param Array $estudios
     * @return void
     */
    public function link(Profile $profile, array $estudios){
        $keys = Estudio::whereIn('clave', $estudios['data'])->pluck('id')->toArray();
        $profile->perfil_estudio()->sync($keys);
    }

    /**
     * Unlink unique study from profile
     * @param Model $profile
     * @param String $estudio
     * @return void
     */
    public function unlink(Profile $profile, String $estudio){
        $elemento = Estudio::where('clave', $estudio)->first();
        $profile->perfil_estudio()->detach($elemento);
    }

    /** 
     * Associate the perfil into laboratory
     * @param Model $perfil
     * @return void
    */
    protected function asociarPerfil(Profile $perfil){
        $laboratorio = Laboratory::first();
        $laboratorio->perfiles()->save($perfil);
    }

}