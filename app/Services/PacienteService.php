<?php
namespace App\Services;

use App\Models\Laboratory;
use App\Models\Pacientes;

class PacienteService{

    /**
     * Return a patient with a id
     * @param Int $id
     * @return mixed
     */
    public function getPaciente(Int $id){
        $paciente =  Pacientes::findOrFail($id);
        // dd($paciente);
        // Añadir empresa
        if($paciente->empresas()->first()){
            $paciente->empresa = $paciente->empresas()->first()->descripcion;
            $paciente->id_empresa = $paciente->empresas()->first()->id;
        }
        
        return $paciente;
    }

    /**
     * Create the patient 
     * @param Array $arreglo
     * @return mixed
     */
    public function create(Array $arreglo){
        $paciente = Pacientes::create($this->adjust($arreglo));
        $this->asociarPaciente($paciente);
        return $paciente;
    }

    /**
     * Update the patient with the new information
     * @param Model $paciente
     * @param Array $arreglo
     * @return void
     */
    public function update(Pacientes $paciente, Array $arreglo){
        unset($paciente->empresa);
        $paciente->update($arreglo);
    }

    /**
     * Delete a patient
     * @param Model $paciente
     * @return void
     */
    public function delete(Pacientes $paciente){
        $paciente->delete();
    }

    /**
     * Associate the patient to Laboratory
     * @param Model $paciente
     * @return void 
     */
    protected function asociarPaciente(Pacientes $paciente){
        $laboratorio = Laboratory::first();
        $laboratorio->pacientes()->save($paciente);
    }

    /**
     * Adjust the id_empresa to Int, and save correctly
     * @param Array $arreglo
     * @return Array
     */
    protected function adjust(Array $arreglo){
        
        // Arreglo dentro del campo empresa
        if (isset($arreglo['id_empresa'])) {
            $arreglo['id_empresa'] = intval($arreglo['id_empresa']);
        } 
        return $arreglo;
    }
}