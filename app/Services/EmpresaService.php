<?php
namespace App\Services;

use App\Models\Empresas;
use App\Models\Laboratory;
use App\Models\Precio;
use App\Models\Recepcions;
use App\Models\User;

class EmpresaService{

    /**
     * Return a factory (empresa)
     * @param Int $id
     * @return mixed
     */
    public function getEmpresa(Int $id){
        return Empresas::findOrFail($id);
    }

    /**
     * Create a factory and to link the price list to factory.
     * @param Array $arreglo
     * @return mixed
     */
    public function create(Array $arreglo){
        $empresa = Empresas::create($arreglo);
        $this->asociarEmpresa($empresa, $arreglo['lista_precio']);
        return $empresa;
    }

    /**
     * Update the data to factory
     * @param Model $empresa
     * @param Array $arreglo
     * @return void
     */
    public function update(Empresas $empresa, Array $arreglo){
        $empresa->update($arreglo);
        $this->updateAsociacion($this->getEmpresa($empresa->id), $arreglo['lista_precio']);
    }

    /**
     * Delete the factory
     * @param Model $empresa
     * @return void
     */
    public function delete(Empresas $empresa){
        $query_empresa = Recepcions::whereRelation('empresas', 'recepcions.id_empresa', $empresa->id)->count();
        $query_precio = Precio::whereRelation('empresa', 'empresas_has_precios.empresas_id', $empresa->id)->count();
        $query_user = User::whereRelation('empresas_users', 'empresas_has_users.empresas_id', $empresa->id)->count();
        if($query_empresa === 0 && $query_precio === 0 && $query_user === 0){
            $empresa->delete();
            $response = "Empresa eliminada";
        }
        $msj = "Empresa no eliminada, cuenta con " . $query_empresa . " registros asignados en folios, " . $query_precio . " lista asociada y " . $query_user . " usuario registrado. Favor de revisar.";

        return isset($response) ? $response : $msj;
    }

    /**
     * Associate the factory with the laboratory and the list to the $empresa
     * @param Model $empresa
     * @param String $precio
     * @return void
     */
    protected function asociarEmpresa(Empresas $empresa, String $precio){
        $precio = Precio::where('id', $precio)->first();
        $laboratorio = Laboratory::first();

        $precio->empresa()->save($empresa);
        $laboratorio->empresas()->save($empresa);
    }

/**
     * Associate the factory with the laboratory and the list to the $empresa
     * @param Model $empresa
     * @param String $precio
     * @return void
     */
    protected function updateAsociacion(Empresas $empresa, String $precio){
        $precio = Precio::where('id', $precio)->first();
        $laboratorio = Laboratory::first();

        $empresa->precio()->detach();
        $precio->empresa()->save($empresa);
    }
}