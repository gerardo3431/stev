<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEstudioRequest extends FormRequest
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
            'clave'             => 'required|unique:estudios|alpha_num:ascii',
            'codigo'            => 'nullable',
            'descripcion'       => 'required',
            'area'              => 'required',
            'muestra'           => 'required',
            'recipiente'        => 'required',
            'metodo'            => 'required',
            'tecnica'           => 'required',
            'condiciones'       => 'nullable',
            'aplicaciones'      => 'nullable',
            'dias_proceso'      => 'nullable',
            'precio'            => 'nullable',
            'valida_qr'         => 'nullable',  
        ];
    }


    public function messages()
    {
        return [
            'clave.required'        => 'Ingresa clave',
            'descripcion.required'  => 'Ingresa alguna descripcion',
            'area.required'         => 'Selecciona tipo área',
            'muestra.required'      => 'Selecciona tipo muestra',
            'recipiente.required'   => 'Selecciona tipo recipiente',
            'metodo.required'       => 'Selecciona tipo método',
            'tecnica.required'      => 'Selecciona tipo tecnica',
        ];
    }
}
