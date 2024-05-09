<?php
namespace App\Services;

use App\Models\Doctores;
use App\Models\Laboratory;
use App\Models\Recepcions;

class DoctorService{

    public function getDoctor($id){
        return Doctores::findOrFail($id);
    }

    /**
     * Create a Doctor
     * @param Array $arreglo
     * @return mixed
     */
    public function create(Array $arreglo){
        $doctor = Doctores::create($arreglo);
        $this->asociarDoctor($doctor);
        return $doctor;
    }

    /**
     * Update the data from doctor
     * @param Model $doctor
     * @param Array $arreglo
     * @return void
     */
    public function update(Doctores $doctor, Array $arreglo){
        $doctor->update($arreglo);
    }

    /**
     * Delete the doctor
     * @param Model $doctor
     * @return void
     */
    public function delete(Doctores $doctor){
        $query = Recepcions::whereRelation('doctores', 'recepcions.id_doctor', $doctor->id)->count();
        if($query === 0){
            $doctor->delete();
            $delete = true;
        }
        return isset($delete) ? true : $query;

    }


    /**
     * Associate the doctor with the laboratory
     * @param Model $doctor
     * @return void
     */
    protected function asociarDoctor(Doctores $doctor){
        $laboratorio = Laboratory::first();
        $laboratorio->doctores()->save($doctor);
    }
}