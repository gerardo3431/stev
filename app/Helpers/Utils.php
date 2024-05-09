<?php
namespace App\Helpers;

use Illuminate\Support\Str;

class Utils{

    /**
     * Return a token with a petition
     * @param String $longitud
     * @return char
     */
    public function tokenizer(String $longitud){
        return Str::random($longitud);
    }
}