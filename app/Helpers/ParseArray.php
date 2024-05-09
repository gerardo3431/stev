<?php
namespace App\Helpers;

class ParseArray{
    public function parseArray(array $serializeArray){
        $dato = [];
        foreach($serializeArray['data'] as $key=>$valor){
            $dato[$valor['name']] = $valor['value'];
        }

        return $dato;
    }
    
}