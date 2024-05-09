<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePagoRequest extends FormRequest
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
            'descripcion'       => 'nullable',
            'importe'           => 'required',
            'tipo_movimiento'   => 'nullable',
            'metodo_pago'       => 'required',
            'observaciones'     => 'nullable',
    
            'is_factura'        => 'nullable',
            'razon_social'      => 'nullable',
            'rfc'               => 'nullable',
            'domicilio'         => 'nullable',
            'email'             => 'nullable',
    
            'estatus'           => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'descripcion'       => 'Descripcion es requerida',
            'importe'           => 'Importe es requerido',
            'tipo_movimiento'   => 'Tipo de movimiento es requerido',
            'metodo_pago'       => 'Metodo pago es requerido',
            'observaciones'     => 'Observaciones son requeridas',
    
            'is_factura'        => 'Campo requerido.',
            'razon_social'      => 'Campo requerido.',
            'rfc'               => 'Campo requerido.',
            'domicilio'         => 'Campo requerido.',
            'email'             => 'Campo requerido.',
    
            'estatus'           => 'Campo requerido.',
        ];
    }
}
