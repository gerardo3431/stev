<?php

namespace App\Services;

use App\Models\Laboratory;
use App\Models\Lista;
use App\Models\Precio;
use GuzzleHttp\Psr7\Request;

class PrecioService{
    
    /**
     * Get the list from a key
     * @param Int $id
     * @return mixed
     */
    public function getPrecio(Int $id){
        return Precio::findorFail($id);
    }

    /**
     * Create the list
     * @param Array $precio
     * @return mixed
     */
    public function create(array $precio){
        $objeto = Precio::create($precio);
        $this->asociarPrecio($objeto);
        return $objeto;
    }

    /**
     * Update the name of list
     * @param Model $precio
     * @param String $nombre
     * @return void
     */
    public function update(Precio $precio, String $nombre){
        $precio->update(['descripcion' => $nombre]);
    }

    /**
     * Delete a specific studie from a list.
     * @param Model $precio
     * @param String $clave
     * @return void
     */
    public function trash(Precio $precio, String $clave){
        $elemento = $precio->lista()->where('clave', $clave)->first();
        if(! empty($elemento)){
            $precio->lista()->detach($elemento);
        }
    }

    /**
     * Copy all the studies from previous list to new list [old -> new]
     * @param Model $precio
     * @param Model $lista
     * @return void
     */
    public function prelink(Precio $precio, Precio $lista){
        $query = $precio->lista()->pluck('listas.id')->toArray();
        $lista->lista()->sync($query);
    }

    /**
     * Sync the list of studies, profiles and image studies to the model
     * @param Model $precio
     * @param Array $lista
     * @return void
     */
    public function link(Precio $precio, array $lista){
        foreach ($lista as $key => $estudio) {
            $query = $precio->lista()->where('listas.clave', '=', $estudio['clave'])->first();
            if($query){
                $query->update(['precio' => $estudio['precio']]);
            }else{
                $insercion = Lista::create($estudio);
                $precio->lista()->save($insercion);
            }
        }
    }

    /** 
     * Associate the list to laboratory
     * @param Model $precio
     * @return void
    */
    protected function asociarPrecio(Precio $precio){
        $laboratorio = Laboratory::first();
        $laboratorio->precios()->save($precio);
    }

}