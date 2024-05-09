<?php

namespace App\Http\Controllers;

use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PersonalController extends Controller
{
    //
    
    public function user_index(){
        // User
        $usuario = User::where('id', Auth::user()->id)->first();
        //Verificar sucursal
        $active = $usuario->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = $usuario->sucs()->orderBy('id', 'asc')->get();
        return view('utils.personal.index', [
            'active'        => $active, 
            'sucursales'    => $sucursales,
            'usuario'       => $usuario,
        ]);
    }

    public function user_update(Request $request){
        $id = $request->only('id');
        $usuario = request()->validate([
            'name'      => 'required',
            'cedula'    => 'required',
            'firma'     => 'required|file|mimes:png|max:2048',
        ]);

        $user = User::where('id', $id)->first();
        $path ="personal_laboratorio/user_". $user->id . "/firma_" . $user->id . ".png";

        if($request->hasFile('firma')){
            if (Storage::exists($path)) {
                Storage::delete($path);
            }

            $request->file('firma')->storeAs('public', $path);
            $usuario['firma'] = $path;
        }

        $query = User::where('id', $id['id'])->update($usuario);

        return redirect()->route('stevlab.utils.user');
    }

    public function fitosanitario_index(){
         // User
        $usuario = User::where('id', Auth::user()->id)->first();
        $laboratorio = $usuario->labs()->first();
        //Verificar sucursal
        $active = $usuario->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = $usuario->sucs()->orderBy('id', 'asc')->get();
        return view('utils.fitosanitario.index', [
            'active'        => $active, 
            'sucursales'    => $sucursales,
            'laboratorio'   => $laboratorio,
        ]);
    }

    public function fitosanitario_update(Request $request){
        $id = $request->only('id');
        $usuario = request()->validate([
            'responsable_sanitario' => 'required',
            'cedula_sanitario'      => 'required',
            'firma_sanitario'       => 'required|file|mimes:png|max:2048',
        ]);

        $lab = Laboratory::where('id', $id)->first();
        $path ="responsables/fitosanitario_". $lab->id . "/firma_" . $lab->id . ".png";

        if($request->hasFile('firma_sanitario')){
            if (Storage::exists($path)) {
                Storage::delete($path);
            }

            $request->file('firma_sanitario')->storeAs('public', $path);
            $usuario['firma_sanitario'] = $path;
        }

        $query = Laboratory::where('id', $id['id'])->update($usuario);

        return redirect()->route('stevlab.utils.fitosanitario');
    }


    public function fitosanitario_img_update(Request $request){
        $id = $request->only('id');
        $usuario = request()->validate([
            'responsable_img' => 'required',
            'cedula_img'      => 'required',
            'firma_img'       => 'required|file|mimes:png|max:2048',
        ]);

        $lab = Laboratory::where('id', $id)->first();
        $path ="responsables/img_". $lab->id . "/firma_" . $lab->id . ".png";

        if($request->hasFile('firma_img')){
            if (Storage::exists($path)) {
                Storage::delete($path);
            }

            $request->file('firma_img')->storeAs('public', $path);
            $usuario['firma_img'] = $path;
        }

        $query = Laboratory::where('id', $id['id'])->update($usuario);

        return redirect()->route('stevlab.utils.fitosanitario');
    }

    
    public function segurity_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        $inventario = User::where('id', Auth::user()->id)->first()->labs()->first()->inventario_inicial;
        return view('utils.segurity.index', [
            'active'        => $active, 
            'sucursales'    => $sucursales,
            'estado'        => $inventario,
        ]);
    }
    public function papeleria_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        $laboratorio    = User::where('id', Auth::user()->id)->first()->labs()->first();

        return view('utils.papeleria.index', [
            'active'        => $active, 
            'sucursales'    => $sucursales,
            'laboratorio'   => $laboratorio,
        ]);
    }
}
