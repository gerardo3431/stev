<?php
namespace App\Services;

use App\Models\Prefolio;
use Illuminate\Database\Eloquent\Model;

class PrefolioService{
    public function getPrefolioByClave(String $prefolio){
        return Prefolio::where('prefolio',$prefolio)->first();

    }
    public function create(){
    }

    public function asociarRecepcion(String $prefolio, Model $recepcion){
        $prefolio = $this->getPrefolioByClave($prefolio);
        $prefolio->folio()->save($recepcion);
    }
}