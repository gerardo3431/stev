<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
        $id = $this->input('id'); 

        $rules =  [
            'nombre'    => 'required', 
            'telefono'  => 'nullable',
            'celular'   => 'nullable', 
            'email'     => 'nullable',
        ];

        if ($id) {
            $rules['clave'] = 'required';
        } else {
            $rules['clave'] = 'required|unique:doctores';
        }
        
        return $rules;
    }

    public function messages()
    {
        return [
            'clave'     => 'Clave es requerida',
            'nombre'    => 'Nombre es requerida', 
            'telefono'  => 'Telefono es requerido',
            'celular'   => 'Celular es requerido', 
            'email'     => 'Correo es requerido',
        ];
    }
}
