<?php

namespace App\Http\Controllers;

use App\Models\Laboratory;
use App\Models\Recepcions;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class LaboratoryController extends Controller
{
    // 
    public function check_inventario(Request $request){
        $estado = $request->input('estado');
        $user = User::where('id', Auth::user()->id)->first();
        $lab  = $user->labs()->first();

        $query = Laboratory::where('id', '=', $lab->id)->update(['inventario_inicial' => $estado]);

        return response()->json([
            'response'  => true,
        ], 200);
    }
    //
    public function update_membrete(Request $request){
        $img = $request->validate([
            'membrete' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
        // Trae la clinica en la que esta registrado el usuario
        $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();

        $nombre = str_replace(' ', '-', $laboratorio->nombre);
        // Verificamos si existe una imagen en el campo de la base de datos
        if($request->hasFile('membrete')){
            if(Storage::exists($img['membrete'])){
                Storage::delete($img['membrete']);
            }

            $img['membrete'] = $request->file('membrete')->storeAs("public", "membrete_laboratorios/membrete_".$nombre .".png");
            $img['membrete'] = "membrete_laboratorios/membrete_" . $nombre . ".png";

            // // Optimize
            // $optimizerChain = OptimizerChainFactory::create();
            // $compress = $optimizerChain->optimize(Storage::disk('public')->get($img['membrete']));
            
            
        }
        Laboratory::where('id', $laboratorio->id)->update($img);
        return redirect()->route('stevlab.utils.papeleria');
    }

    public function update_membrete_secondary(Request $request){
        $img = $request->validate([
            'membrete_secundario' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
        // Trae la clinica en la que esta registrado el usuario
        $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();
        $nombre = str_replace(' ', '-', $laboratorio->nombre);

        // Verificamos si existe una imagen en el campo de la base de datos
        if($request->hasFile('membrete_secundario')){
            if(Storage::exists($img['membrete_secundario'])){
                Storage::delete($img['membrete_secundario']);
            }

            $img['membrete_secundario'] = $request->file('membrete_secundario')->storeAs("public", "membrete_laboratorios/membrete_". $nombre ."-secundario.png");
            $img['membrete_secundario'] = "membrete_laboratorios/membrete_" . $nombre . "-secundario.png";
        }
        Laboratory::where('id', $laboratorio->id)->update($img);
        return redirect()->route('stevlab.utils.papeleria');
    }

    public function update_membrete_terciary(Request $request){
        $img = $request->validate([
            'membrete_terciario' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
        // Trae la clinica en la que esta registrado el usuario
        $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();
        $nombre = str_replace(' ', '-', $laboratorio->nombre);


        // Verificamos si existe una imagen en el campo de la base de datos
        if($request->hasFile('membrete_terciario')){
            if(Storage::exists($img['membrete_terciario'])){
                Storage::delete($img['membrete_terciario']);
            }

            $img['membrete_terciario'] = $request->file('membrete_terciario')->storeAs("public", "membrete_laboratorios/membrete_".$nombre ."-terciario.png");
            $img['membrete_terciario'] = "membrete_laboratorios/membrete_" . $nombre . "-terciario.png";
        }
        Laboratory::where('id', $laboratorio->id)->update($img);
        return redirect()->route('stevlab.utils.papeleria');
    }

    public function update_membrete_img(Request $request){
        $img = $request->validate([
            'membrete_img' => 'required|image|mimes:png',
        ]);
        
        // Trae la clinica en la que esta registrado el usuario
        $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();
        $nombre = str_replace(' ', '-', $laboratorio->nombre);


        // Verificamos si existe una imagen en el campo de la base de datos
        if($request->hasFile('membrete_img')){
            if(Storage::exists($img['membrete_img'])){
                Storage::delete($img['membrete_img']);
            }

            $img['membrete_img'] = $request->file('membrete_img')->storeAs("public", "membrete_laboratorios/membrete_".$nombre ."-img.png");
            $img['membrete_img'] = "membrete_laboratorios/membrete_" . $nombre . "-img.png";
        }
        Laboratory::where('id', $laboratorio->id)->update($img);
        return redirect()->route('stevlab.utils.papeleria');
    }

    public function update_recibo_pago(Request $request){
        $img = $request->validate([
            'recibo_pago' => 'required|image|mimes:png,svg',
        ]);
        
        // Trae la clinica en la que esta registrado el usuario
        $string = 'RECIBO-DE-PAGO.png';


        // Verificamos si existe una imagen en el campo de la base de datos
        if($request->hasFile('recibo_pago')){
            if(Storage::disk('public')->exists('membrete_laboratorios/' . $string )){
                Storage::disk('public')->delete('membrete_laboratorios/' . $string);
            }

            $request->file('recibo_pago')->storeAs("public", 'membrete_laboratorios/' . $string);
        }
        // Laboratory::where('id', $laboratorio->id)->update($img);
        return redirect()->route('stevlab.utils.papeleria');
    }

    public function update_logotipo(Request $request){
        $img = $request->validate([
            'logotipo' => 'required|image|mimes:png,svg'
        ]);

        $string = 'labs.png';

        if($request->hasFile('logotipo')){
            if(Storage::disk('public')->exists(('logos_laboratorios/'. $string))){
                Storage::disk('public')->delete('logos_laboratorios/'. $string);
            }

            $request->file('logotipo')->storeAs("public", "logos_laboratorios/" . $string);
        }

        return redirect()->route('stevlab.utils.papeleria');
    }

    public function update_cache(){
            //    Artisan::call('config:clear');
        //        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        echo "Cache regenerada";
        Artisan::call('route:clear');
        echo "Caché de rutas restablecida";
        //        Artisan::call('optimize');
        //        Artisan::call('queue:restart');
        return redirect()->route('stevlab.utils.papeleria');
    }

    public function link_storage(){
        Artisan::call('storage:link');
        echo "Enlace simbolico";
        return redirect()->route('stevlab.utils.papeleria');

    }

    // 
    public function data_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
        return view('utils.data.index', [
            'active'        => $active, 
            'sucursales'    => $sucursales,
        ]);
    }

    public function data_patch(){
        $recepcions = Recepcions::all();
        foreach ($recepcions as $a => $recepcion) {
            $estudios = $recepcion->estudios()->get();
            foreach($estudios as $b => $estudio){
                $area = $estudio->area()->first();
                try {
                    $detach = $recepcion->estudios()->detach($estudio);
                    $path   = $recepcion->estudios()->attach($estudio, [ 'area_id' => $area->id]);
                } catch (\Throwable $th) {
                    // throw $th;
                }
            }
        }
    }

    public function get_comments(Request $request){
        $folio = Recepcions::where('folio', $request->folio)->first();

        if($folio) {
            $response = $folio->comentarios()->orderBy('id', 'desc')->get();

            return response()->json([
                'response'  => true,
                'data'      => $response,
                'msj'       => 'Comentarios cargados.',
            ], 200);
        } else {
            return response()->json([
                'response'  => false,
                'msj'       => 'No hay observaciones o simplemente no es folio',
                'note'      => 'No hay comentarios que satisfagan a la consulta del folio o simplemente no es folio:' . $request->folio , 
            ], 400);
        }
    }
}
