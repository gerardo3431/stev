<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre'            => 'required',
            'sexo'              => 'required', 
            'fecha_nacimiento'  => 'nullable',
            'edad'              => 'required',
            'celular'           => 'nullable', 
            'domicilio'         => 'nullable', 
            'colonia'           => 'nullable',
            'seguro_popular'    => 'nullable',
            'vigencia_inicio'   => 'nullable', 
            'vigencia_fin'      => 'nullable',
            'email'             => 'nullable|email:rfc,dns,spoof,filter',
            'id_empresa'        => 'required', //Esto es solo para registrar al paciente con la empresa, validado aqui para mayor comodidad.
        ];
    }

    public function messages()
    {
        return [
            'nombre'            => 'Nombre es requerido',
            'sexo'              => 'Sexo es requerido', 
            'domicilio'         => 'Domicilio es requerido', 
            'colonia'           => 'Colonia es requerida',
            'id_empresa'        => 'Debe asignar empresa'
        ];
    }
}
