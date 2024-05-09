<?php
namespace App\Helpers;

class ConsultaIdModelo{
    /**
     *  Obtain the correct model.
     *
     * @param Int $id
     * @param String $modelo
     * @return mixed
     */
    public function obtenerIdModelo(Int $id, String $modelo){
        return $modelo::findOrFail($id);
    }
}