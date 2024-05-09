<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFolioRequest extends FormRequest
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
            // 'folio'         => 'nullable', 
            'h_flebotomia'  => 'nullable', 
            'f_flebotomia'  => 'nullable', 
            // 'numRegistro'   => 'required',
            'id_paciente'   => 'required', 
            'id_empresa'    => 'required', 
            'fecha_entrega' => 'required',
            'tipPasiente'   => 'required', 
            'turno'         => 'required', 
            'id_doctor'     => 'required',
            'numCama'       => 'nullable', 
            'peso'          => 'nullable', 
            'talla'         => 'nullable', 
            // 'fur'           => '',
            'medicamento'   => 'nullable', 
            'diagnostico'   => 'nullable',
            'observaciones' => 'nullable', 
            // 'listPrecio'    => 'nullable', 
            'num_total'     => 'required',
            // 'descuento'     => 'nullable',
            'num_vuelo'     => 'nullable', 
            'pais_destino'  => 'nullable',
            'aerolinea'     => 'nullable',
            'token'         => 'nullable',
            'user_id'       => 'nullable',
            'res_file'      => 'nullable',
            'res_file_img'  => 'nullable',
            'maq_file'      => 'nullable',
            'maq_file_img'  => 'nullable',
            'patient_file'  => 'nullable',
            'check_sangre'  => 'nullable',
            'check_vih'     => 'nullable',
            'check_exudado' => 'nullable',
            'estado'        => 'nullable',
        ];

        if ($id) {
            $rules['folio'] = 'required';
        } else {
            $rules['folio'] = 'nullable';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'folio'         => 'Folio es requerido', 
            'h_flebotomia'  => 'Hora de flebotomia es requerida', 
            'f_flebotomia'  => 'Fecha de flebotomia es requerida', 
            // 'numRegistro'   => 'Numero de registro es requerido',
            'id_paciente'   => 'Paciente es requerido', 
            'id_empresa'    => 'Empresa es requerida', 
            'fecha_entrega' => 'Fecha de entrega es requerida',
            'tipPasiente'   => 'Tipo de paciente es requerida', 
            'turno'         => 'Turno es requerida', 
            'id_doctor'     => 'Doctor es requerido',
            'numCama'       => 'Numero de cama es requerido', 
            'peso'          => 'Peso es requerido', 
            'talla'         => 'Talla es requerido', 
            // 'fur'           => '',
            'medicamento'   => 'Medicamento es requerido', 
            'diagnostico'   => 'Diagnostico es requerido',
            'observaciones' => 'Observaciones es requerida', 
            // 'listPrecio'    => 'nullable', 
            'num_total'     => 'Total debe ser asignado',
            // 'descuento'     => 'nullable',
            'num_vuelo'     => 'Vuelo debe ser especificado', 
            'pais_destino'  => 'Pais destino debe ser especificado',
            'aerolinea'     => 'Aerolinea debe ser especificado',
            'token'         => 'Token debe ser asignado',
            'user_id'       => 'Usuario que registra el folio',
            'res_file'      => 'Datos de entrega para el paciente',
            'res_file_img'  => 'Datos de entrega para el paciente',
            'maq_file'      => 'Datos de entrega para el paciente',
            'maq_file_img'  => 'Datos de entrega para el paciente',
            'patient_file'  => 'Datos de entrega para el paciente',
            'check_sangre'  => 'Revise si es necesario.',
            'check_vih'     => 'Revise si es necesario.',
            'check_exudado' => 'Revise si es necesario.',
            'estado'        => 'Revise si es necesario.',
        ];
    }
}
