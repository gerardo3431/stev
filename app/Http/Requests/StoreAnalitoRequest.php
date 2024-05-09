<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnalitoRequest extends FormRequest
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
            'clave'             => 'required|unique:analitos|alpha_num:ascii|min:3',
            'descripcion'       => 'required',
            'bitacora'          => 'nullable',
            'defecto'           => 'nullable',
            'unidad'            => 'nullable',
            'digito'            => 'nullable',
            'tipo_resultado'    => 'required',
            'valor_referencia'  => 'nullable',
            'tipo_referencia'   => 'nullable',
            'tipo_validacion'   => 'nullable',
            'numero_uno'        => 'nullable',
            'numero_dos'        => 'nullable',
            'documento'         => 'nullable',
            'imagen'            => 'nullable',
            'valida_qr'         => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'clave.required'        => 'Clave es requerida.',
            'clave.unique'          => 'Clave ya utilizada.',
            'clave.alpha_num'       => 'Clave no debe utilizar simbolos.',
            'clave.min'             => 'Clave debe tener al menos 3 caracteres.',
            'descripcion.required'  => 'Descripción debe ser agregada,'
        ];
    }
}
