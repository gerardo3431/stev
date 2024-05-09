<?php

namespace App\Http\Controllers;

use App\Models\Laboratory;
use App\Models\Subsidiary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

// use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    public $token;
    public $estados;

    // Metodo privado
    // Private function HttpResponse(){
    //     // return Http: tofavla cadena ;
    // }

    // Metodos GET
    public function getStates(Request $request){
        // Estados
        $pais = $request->only('pais');
        
        $response = Http::withHeaders([
            "Accept"=> "application/json",
            "api-token"=> "fu0hmBKCw2b-aw9nkutaIDVRcI9bcxibv5lRYOxq3AhHGelLL8N_n6FzCQlpapk8FDQ",
            "user-email"=> "henry_garcia1996@hotmail.com"
        ])->get('https://www.universal-tutorial.com/api/getaccesstoken');

        $this->token = $response->json('auth_token');

        // Estados
        $estados = Http::withHeaders([
            "Authorization"=> "Bearer ". $this->token,
            "Accept"=> "application/json"
        ])->get('https://www.universal-tutorial.com/api/states/'. $pais['pais']);
        return $estados->json();
    }

    public function getCities(Request $request){
        $ciudad = $request->only('ciudad');
        
        $response = Http::withHeaders([
            "Accept"=> "application/json",
            "api-token"=> "fu0hmBKCw2b-aw9nkutaIDVRcI9bcxibv5lRYOxq3AhHGelLL8N_n6FzCQlpapk8FDQ",
            "user-email"=> "henry_garcia1996@hotmail.com"
        ])->get('https://www.universal-tutorial.com/api/getaccesstoken');

        $this->token = $response->json('auth_token');
        
        // Ciudades
        $ciudades = Http::withHeaders([
            "Authorization"=> "Bearer ". $this->token,
            "Accept"=> "application/json"
        ])->get('https://www.universal-tutorial.com/api/cities/'. $ciudad['ciudad']);
        return $ciudades->json();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('auth.register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Create a new registered user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Laravel\Fortify\Contracts\CreatesNewUsers  $creator
     * @return \Laravel\Fortify\Contracts\RegisterResponse
     */
    public function store(Request $request){
        $datos = request()->validate([
            'name'                  => 'required',
            'email'                 => ['required', 'email','unique:users,email'], 
            'username'              => 'required |unique:users',
            'password'              => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()]
        ],[
            'name.required'         => 'Ingresa tu nombre',
            'username.unique'       => 'Usuario ya existente, escoja otro nombre de usuario',
            'email.email'           => 'Ingresa un correo electronico valido',
            'password.required'     => 'Contraseña debe ser mayor a 8 caracteres',

        ]);
        $datos['password'] = Hash::make($request->password);

        $query = User::create($datos);
        Auth::login($query);
                            // Hash::make($request->newPassword)
        // return redirect()->route('registro.regSucursal');
        return redirect()->route('registro.regProfesion');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function regProfesion(){
        return view('registro.profesion.index');
    }

    public function storeProfesion(Request $request){
        $personal = request()->validate([
            'cedula'                => 'required',
            'universidad'           => 'required',
            'firma'                 => 'required | image | mimes:jpeg,png,png,jpg,svg | max: 2048',
        ],[
            'cedula.required'       => 'Ingresa cedula.',
            'universidad.required'  => 'Ingresa universidad o institución que otorgó titulo.',
            'firma.required'        => 'Revise que la firma sea tipo imagen para poder ser cargada.'
        ]);

        if($request->hasFile("firma")){
            $personal['firma'] = $request->file('firma')->storeAs('public', "personal_laboratorio/user_". Auth::user()->id . "/firma_" . Auth::user()->id . ".png");
            $personal['firma'] = "personal_laboratorio/user_". Auth::user()->id . "/firma_" . Auth::user()->id . ".png";
        }
        $query = User::where('id', Auth::user()->id)->update($personal);

        return redirect()->route('registro.regSucursal');
    }

    public function regSucursal(){
        // Generar response
        $response = Http::withHeaders([
            "Accept"=> "application/json",
            "api-token"=> "fu0hmBKCw2b-aw9nkutaIDVRcI9bcxibv5lRYOxq3AhHGelLL8N_n6FzCQlpapk8FDQ",
            "user-email"=> "henry_garcia1996@hotmail.com"
        ])->get('https://www.universal-tutorial.com/api/getaccesstoken');

        $this->token = $response->json('auth_token');

        // Países
        $paises = Http::withHeaders([
            "Authorization"=> "Bearer ". $this->token,
            "Accept"=> "application/json"
        ])->get('https://www.universal-tutorial.com/api/countries/')->json();


        return view('registro.sucursal.index', ['paises' => $paises]);
    }


    public function storeSucursal(Request $request){
        $empresa = request()->validate([
            'nombre'                    => 'required',
            'razon_social'              => 'required',
            'direccion'                 => 'required',
            'pais'                      => 'required',
            'estado'                    => 'required',
            'ciudad'                    => 'required',
            'cp'                        => 'required',
            'email'                     => 'required',
            'telefono'                  => 'required',
            'logotipo'                  => 'required | image | mimes:jpeg,png,jpg,svg | max:2048',
        ],[
            'name.required'             => 'Ingresa el nombre de la empresa',
            'razon_social.required'     => 'Ingresa razón social',
            'direccion.required'        => 'Ingresa dirección',
            'pais.required'             => 'Ingresa país',
            'estado.required'           => 'Ingresa estado',
            'ciudad.required'           => 'Ingresa ciudad',
            'cp.required'               => 'Ingresa Código Postal',
            'username.required'         => 'Ingresa un username valido',
            'email.required'            => 'Ingresa correo',
            'telefono.required'         => 'Ingresa télefono',
            'logotipo.required'         => 'Añade logotipo',
        ]);

        $nombre = str_replace(" ", "_", $empresa['nombre']);
        // Convertimos imagen logotipo
        if($request->hasFile("logotipo")){
            $empresa['logotipo'] = $request->file('logotipo')->storeAs('public', "logos_laboratorios/logotipo_" . $nombre . date('dmy') . ".png");
            $empresa['logotipo'] = "logos_laboratorios/logotipo_" . $nombre . date('mdy') . ".png";
        }

        // Para almacenar el membrete
        if($request->hasFile("membrete")){
            $empresa['membrete'] = $request->file('membrete')->storeAs('public', "membrete_laboratorios/membrete" . $nombre . date('dmy') . ".png");
            $empresa['membrete'] = "membrete_laboratorios/membrete" . $nombre . date('mdy') . ".png";
            // $empresa['membrete_base64'] = "membrete_laboratorios/membrete" . $nombre . date('mdy') . ".png";
        }

        $identidad = User::where('id', Auth::user()->id)->first();

        // Crea nombre de la empresa + sucursal principal osea que sera la matriz de la empresa
        $empresa['sucursal'] = $empresa['nombre']. ' - MATRIZ';

        // Crea dato del laboratorio
        $labo = Laboratory::create($empresa);
        $sucu = Subsidiary::create($empresa);

        // $matriz = Laboratory::latest('id')->first();
        // $subsidiaria = Subsidiary::latest('id')->first();

        $labo->subsidiary()->save($sucu);
        // Crea relación entre usuarios + laboratorios + sucursales
        $identidad->laboratorio()->attach($labo->id, ['subsidiary_id' => $sucu->id, 'user_id'=> $identidad->id, 'estatus'=>'activa' ]);

        return redirect()->route('dashboard');
    }
}
