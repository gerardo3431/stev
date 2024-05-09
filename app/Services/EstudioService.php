<?php
namespace App\Services;

use App\Models\Estudio;
use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ConsultaIdModelo;
use App\Models\Area;
use App\Models\Metodo;
use App\Models\Muestra;
use App\Models\Recipiente;
use App\Models\Tecnica;
use Illuminate\Database\Eloquent\Model;

class EstudioService{
    
    /**
     * Receives the previously validated arrangement.
     *
     * @param array $estudio
     * @return mixed
     */
    public function create(array $estudio){
        $create     = Estudio::create($estudio);

        $this->crearRelacion($create, $estudio);

        return $create;
    }

    /**
     *  It associate the study with other relationships.
     *
     * @param Estudio $estudio
     * @return void
     */
    protected function crearRelacion(Model $create, array $estudio){

        $laboratorio= Laboratory::first();
        $sucursal   = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        
        // $instancia  = new ConsultaIdModelo();
        $area       = Area::findOrFail($estudio['area']);
        $metodo     = Metodo::findOrFail($estudio['metodo']);
        $muestra    = Muestra::findOrFail($estudio['muestra']);
        $recipiente = Recipiente::findOrFail($estudio['recipiente']);
        $tecnica    = Tecnica::findOrFail($estudio['tecnica']);
        // $area       = $instancia->obtenerIdModelo($estudio['area'], 'App\Models\Area');
        // $metodo     = $instancia->obtenerIdModelo($estudio['metodo'], 'App\Models\Metodo');
        // $muestra    = $instancia->obtenerIdModelo($estudio['muestra'], 'App\Models\Muestra');
        // $recipiente = $instancia->obtenerIdModelo($estudio['recipiente'], 'App\Models\Recipiente');
        // $tecnica    = $instancia->obtenerIdModelo($estudio['tecnica'], 'App\Models\Tecnica');

        $laboratorio->estdy()->attach($create->id, [
            'sucursal_id'   => $sucursal->id,
            'area_id'       => $area->id, 
            'muestra_id'    => $muestra->id, 
            'recipiente_id' => $recipiente->id, 
            'metodo_id'     => $metodo->id, 
            'tecnica_id'    => $tecnica->id,
        ]);

        $area->estudios()->save($create);
    }

}