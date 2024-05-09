<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmpresaRequest;
use App\Models\Doctores;
use App\Models\Laboratory;
use Illuminate\Support\Facades\DB;
use App\Models\Empresas;
use App\Models\Estudio;
use App\Models\Lista;
use App\Models\Precio;
use App\Models\Prefolio;
use App\Models\Profile;
use App\Models\User;
use App\Services\EmpresaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class EmpresasController extends Controller
{
    protected $empresaService;

    public function __construct(EmpresaService $empresaService)
    {
        $this->empresaService = $empresaService;
    }

    public function get_empresas(Request $request){
        $search = $request->except('_token');
        // Trae listas de estudios
        // $empresas = User::where('id', Auth::user()->id)->first()->labs()->first()->empresas()->where('descripcion', 'LIKE', "%{$search['q']}%")->get();
        
        $empresas = User::where('id', Auth::user()->id)->first()
        ->labs()->first()
        ->empresas()->where(function($q) use ($search){
            $q  ->where('empresas.clave', 'LIKE', '%' . $search['q'] . '%')
            ->orWhere('empresas.descripcion', 'LIKE', '%' . $search['q'] .'%');
        })
        ->get();
        
        return $empresas;
    }
    //
    public function empresa_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
        
        $listas = User::where('id', Auth::user()->id)->first()->labs()->first()->empresas()->get(); 
        
        //datos traidos de la base de datos
        $empresas = User::where('id', Auth::user()->id)->first()->labs()->first()->empresas()->get();       
        
        return view('catalogo.empresas.index',[
            'active'    => $active,
            'sucursales'=> $sucursales,
            'empresas'  => $empresas, 
            'listas'    => $listas
        ]);  
    }
    
    public function empresa_guardar(StoreEmpresaRequest $request){
        $arreglo = $request->validated();
        $empresa = $this->empresaService->create($arreglo);
        return redirect()->route('stevlab.catalogo.empresas');
    }
    
    public function get_empresa_edit(Request $request){
        $empresa = $request->except('_token');
        
        $empresas = Empresas::where('clave', $empresa)->first();
        if($empresas){
            $precio = $empresas->precio()->first();
            $empresas['id_lista'] = $precio->id;
            $empresas['nombre_lista'] = $precio->descripcion;
        }else{
            $empresas['id_lista'] = 1;
            $empresas['nombre_lista'] = 'Particular';
        }
        return $empresas;
    }
    
    public function empresa_actualizar(StoreEmpresaRequest $request){
        $arreglo = $request->validated();
        $this->empresaService->update($this->empresaService->getEmpresa($request->id), $arreglo);

        return response()->json([
            'success' => true,
            'mensaje' => 'Empresa actualizada',
        ],200);
    }
    
    public function empresa_eliminar($id){
        $transaction = $this->empresaService->delete($this->empresaService->getEmpresa($id));
        return redirect()->route('stevlab.catalogo.empresas')->with('msj', $transaction);
    }
    
    public function store_empresa_recepcion(StoreEmpresaRequest $request){
        $arreglo = $request->validated();
        $this->empresaService->create($arreglo);
        return response()->json([
            'success' => true,
            'mensaje' => 'Empresa guardada'
        ],200);
    }
    
    public function index_create_user($id){
        $user           = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $user->labo()->first();
        //Verificar sucursal
        $active         = $user->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales     = $user->sucs()->orderBy('id', 'asc')->get();
        $empresa           = Empresas::where('id', $id)->first();
        return view('catalogo.empresas.upload', ['active' => $active, 'sucursales'=>$sucursales, 'empresa' => $empresa]);
    }
    
    public function store_user_factory(Request $request){
        $factory        = Empresas::where('id',$request->id)->first();
        
        $user           = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $user->labo()->first();
        
        $validate = $request->validate([
            'name'         => 'required',
            'email'        => ['required', 'unique:users', 'email:rfc,dns'],
            'username'     => 'required | unique:users',
            'password'     => ['required', RulesPassword::min(8)],
            'cedula'       => 'required',
            'universidad'  => 'required',
        ]);
        
        $validate['password'] = bcrypt($request->password);
        $validate['status'] = 'activo';
        
        $empresario = User::create($validate);
        
        if($empresario){
            $laboratorio->usuario()->save($empresario);
            $enlace = $factory->users()->save($empresario);
            
            if($enlace){
                $role = $empresario->assignRole('Empresa');
                return redirect()->route('stevlab.catalogo.empresas')->with('msg', 'Usuario empresa guardado correctamente.');
            }else{
                $delete = User::where('id', $empresario->id)->delete();
                return redirect()->route('stevlab.catalogo.empresas')->with('msg', 'No se pudo enlazar el nuevo usuario, reintente por favor.');
            }
        }else{
            return redirect()->route('stevlab.catalogo.empresas')->with('msg', 'No se pudo guardar nuevo usuario, revise por favor.');
        }
    }
    
    public function user_empresa_update($id){
        $empresa          = Empresas::where('id', $id)->first();
        $user_edit        = $empresa->users()->first();
        
        $user           = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $user->labo()->first();
        $active         = $user->sucs()->where('estatus', 'activa')->first();
        $sucursales     = $user->sucs()->orderBy('id', 'asc')->get();
        
        return view('catalogo.empresas.edit', ['active' => $active, 'sucursales'=>$sucursales, 'empresa' => $user_edit]);
    }
    
    public function user_empresa_store_update(Request $request){
        $empresa            = User::where('id',$request->id)->first();
        // dd($doc->hasRole('Administrador'));
        $user           = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $user->labo()->first();
        
        $validate = $request->validate([
            'name'         => 'required',
            'email'        => ['required', 'email:rfc,dns'],
            'username'     => 'required',
            'password'     => ['required', RulesPassword::min(8)],
            'cedula'       => 'required',
            'universidad'  => 'required',
        ]);
        
        $validate['password'] = bcrypt($request->password);
        
        // dd($doc->id == $user->id);
        if($empresa->id == $user->id || $empresa->hasRole('Administrador') == true){
            return redirect()->route('stevlab.catalogo.doctores')->with('msg', 'No puedes editar al usuario propietario o al usuario actual.');
        }else{
            $edit_doctor = User::where('id', $request->id)->update($validate);
            if($edit_doctor){
                return redirect()->route('stevlab.catalogo.empresas')->with('msg', 'Empresa actualizado correctamente.');
            }else{
                return redirect()->route('stevlab.catalogo.empresas')->with('msg', 'No se puede actualizar el usuario, por favor reintente o solicite asistencia técnica.');
            }
        }
    }
    
    // Rutas de empresa en dashboard
    public function index(){
        $empresa = User::where('id', Auth::user()->id)->first();
        $lista  = $empresa->prefolio()->orderBy('id', 'desc')->get();
        $texto = 'Hola solicito información acerca de la aplicación Docbook.';
        $url = 'https://api.whatsapp.com/send?phone=5219932771814&text=' . urlencode($texto);
        return view('empresa.recepcion.index', ['listas' => $lista, 'url' => $url]);  
    }
    
    public function prefolio_index(){
        $texto = 'Hola solicito información acerca de la aplicación Docbook.';
        $url = 'https://api.whatsapp.com/send?phone=5219932771814&text=' . urlencode($texto);
        return view('empresa.prefolio.index', ['url' => $url]);
    }
    
    public function prefolio_store(Request $request){
        $referencia     = $request->referencia;
        $user           = User::where('id', Auth::user()->id)->first();
        $laboratorio    = $user->labo()->first();
        $memb           = "data:image/jpeg;base64," . base64_encode(Storage::disk('public')->get($laboratorio->membrete));
        
        $estudios = $request->lista;
        $perfiles = $request->perfiles;
        
        $dato = [];
        foreach($request->data as $key=>$valor){
            $dato[$valor['name']] = $valor['value'];
        }
        
        
        if(empty($estudios) && empty($perfiles)){
            return false;
        }else{
            
            $prefolio = Prefolio::create([
                'prefolio'        => Str::random(6),
                'nombre'          => $dato['nombre'],
                'observaciones'   => $dato['observaciones'],
                'doctor'          => $dato['id_doctor'],
                'referencias'     => $referencia,
                'estado'          => 'activo',
            ]);
            
            if($prefolio){
                // Asigna los laboratorios y el user que lo cargo al sistema
                $prefolio->user()->attach($user->id, ['laboratory_id' => $laboratorio->id]);
                
                $lista_estudios = [];
                $lista_perfiles = [];
                
                if(!empty($estudios)){
                    foreach($estudios as $a => $estudio){
                        $consulta = Lista::where('clave', $estudio)->first();
                        $consulta->prefolio()->save($prefolio);
                        $lista_estudios[$a] = $consulta;
                    }
                }
                
                if(!empty($perfiles)){
                    foreach($perfiles as $a => $perfil){
                        $consulta = Lista::where('clave', $perfil)->first();
                        $consulta->prefolio()->save($prefolio);
                        $lista_perfiles[$a] = $consulta;
                        
                    }
                }
                
                $pdf        = Pdf::loadView('invoices.prefolios.prefolio', [
                    'nombre'       => $dato['nombre'],
                    'observaciones'=> $dato['observaciones'],
                    'estudios'     => $lista_estudios,
                    'perfiles'     => $lista_perfiles,
                    'prefolio'     => $prefolio,
                    'laboratorio'  => $laboratorio,
                ]);
                $pdf->setPaper('letter', 'portrait');
                $path       = 'public/prefolios/F-pdf.pdf';
                $pathSave   = Storage::put($path, $pdf->output());
                $response['pdf']    = ['prefolio' => '/../public/storage/prefolios/F-pdf.pdf'];
                
                if($prefolio) {
                    $response['id']       = $prefolio->id;
                    $response['response'] = true;
                } else {
                    $response['response'] = false;
                }
                
                header("HTTP/1.1 200 OK");
                header('Content-Type: application/json');
                return json_encode($response);
                
            }else{
                return false;
            }
        }
    }
    
    public function prefolio_store_file(Request $request){
        $id = $request->identificador; 
        $archivo = $request->file('file');
        
        // Path para adjuntar el archivo
        $path = 'adjuntos/file_' . $id . "." . $archivo->extension();
        
        if($request->hasFile('file')){
            if(Storage::exists($path)){
                Storage::delete($path);
            }
            Storage::putFileAs('public', $request->file('file'), $path);
        }
        
        // Insertar la ruta del archivo adjunto
        $insert = Prefolio::where('id', $id)->update(['adjunto' => $path ]);
        
        return redirect()->route('stevlab.empresa.prefolio');
    }
    
    public function send_prefolio_msg(Request $request){
        $nombre        = $request->only('nombre');
        $observaciones = $request->only('observaciones');
        $estudios      = $request->only('estudios');
        $perfiles      = $request->only('perfiles');
        $number        = $request->only('telefono'); 
        
        $user             = User::where('id', Auth::user()->id)->first();
        $laboratorio      = $user->labo()->first();
        $lista_estudios   = '';
        $lista_perfiles   = '';
        if(isEmpty($estudios['estudios'])){
            foreach ($estudios['estudios'] as $key => $estudio) {
                $consulta  = Estudio::where('clave', $estudio['clave'])->first()->condicion;
                $condicion = (isset($consulta)) ? $consulta : '';
                $lista_estudios .= "*". $estudio['descripcion'] . "*\n*" . $condicion . "*\n\n"; 
            }
        }
        
        if(isEmpty($perfiles['perfiles'])){
            foreach ($perfiles['perfiles'] as $key => $perfil) {
                $consulta = Profile::where('clave', $perfil['clave'])->first()->observaciones;
                $condicion = (isset($consulta)) ? $consulta : '';
                $lista_perfiles .= "*". $perfil['descripcion'] . "*\n*" . $condicion . "*\n\n"; 
            }
        }
        
        if(empty($estudios) && empty($perfiles)){
            return false;
        }else{
            
            $prefolio = Prefolio::create([
                'prefolio'        =>Str::random(6),
                'nombre'          =>$request->nombre,
                'observaciones'   =>$request->observaciones,
                'doctor'          =>$request->id_doctor[0],
                'estado'          =>'activo',
            ]);
            
            if($prefolio){
                // Asigna los laboratorios y el user que lo cargo al sistema
                $prefolio->user()->attach($user->id, ['laboratory_id' => $laboratorio->id]);
                
                if(!empty($estudios)){
                    foreach($estudios as $a => $estudio){
                        $consulta = Lista::where('clave', $estudio)->first();
                        $consulta->prefolio()->save($prefolio);
                    }
                }
                
                if(!empty($perfiles)){
                    foreach($perfiles as $a => $perfil){
                        $consulta = Lista::where('clave', $perfil)->first();
                        $consulta->prefolio()->save($prefolio);
                    }
                }
                
                if($prefolio) {
                    $response['id']       = $prefolio->id;
                    $response['msg'] = true;
                } else {
                    $response['msg'] = false;
                }
                
                $mensaje = 'Hola estimado(a) ' . $request->nombre . ', *' . $laboratorio->nombre . '* le envia su prefolio con la asignación: *' . $prefolio->prefolio . "*\n\n" . $lista_estudios . $lista_perfiles . "\nObservaciones anexas: *" . $observaciones['observaciones'] . "*\n".  "Sin más por el momento, quedamos a sus ordenes." ;
                $response['url'] = 'https://api.whatsapp.com/send?phone=' . '' . $number['telefono'] . '&text=' . urlencode($mensaje);
                return $response;
                
            }else{
                return false;
            }
        }
    }
}