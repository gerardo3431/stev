<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePerfilRequest extends FormRequest
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
            'clave'         => 'required|unique:profiles|min:3|alpha_num:ascii',
            'descripcion'   => 'required',
            'precio'        => 'required'
        ];
    }

    public function messages()
    {
        return [
            'clave.required'        => 'Clave es requerida.',
            'clave.unique'          => 'Clave debe ser unica.',
            'clave.min'             => 'Clave debe tener un minimo de 3 caracteres.',
            'clave.alpha_num'       => 'Clave no debe contener simbolos y espacios.',
            'descripcion.required'  => 'Descripcion del perfil es obligatoria.',
            'precio.required'       => 'Precio del perfil es obligatorio.'
        ];
    }
}
