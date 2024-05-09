<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmpresaRequest extends FormRequest
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
            'rfc'           => 'nullable',
            'descripcion'   => 'required',
            'calle'         => 'nullable', 
            'colonia'       => 'nullable',
            'ciudad'        => 'nullable',
            'email'         => 'nullable | email',
            'telefono'      => 'nullable | numeric',
            'contacto'      => 'nullable',
            'lista_precio'  => 'required' //solo para obtener la lista de precios y que tambien sea validada 
        ];

        if($id){
            $rules['clave'] = 'required';
        }else{
            $rules['clave'] = 'required | unique:empresas';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'clave.required'=> 'Clave es requerida.',
            'clave.unique'  => 'Clave ya existe.',
            'rfc'           => 'RFC es requerido',
            'descripcion'   => 'Descripcion o nombre de la empresa requerido',
            'calle'         => 'Calle requerida', 
            'colonia'       => 'Colonia requerida',
            'ciudad'        => 'Ciudad requerida',
            'email'         => 'Correo requerido',
            'telefono'      => 'Telefono requerido',
            'contacto'      => 'Nombre del contacto requerido',
            'lista_precio'  => 'Lista de precio requerida',
        ];
    }
}
