<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Models\Doctores;
use App\Models\Estudio;
use App\Models\Lista;
use App\Models\Pacientes;
use App\Models\Prefolio;
use App\Models\Profile;
use App\Models\Recepcions;
use App\Models\User;
use App\Services\DoctorService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Milon\Barcode\DNS1D;

use function PHPUnit\Framework\isEmpty;

class DoctoresController extends Controller
{
   protected $doctorService;

   public function __construct(DoctorService $doctorService)
   {
      $this->doctorService = $doctorService;
   }

   public function get_medicos(Request $request){ 
      $search = $request->except('_token');

      $doctores = User::where('id', Auth::user()->id)->first()
         ->labs()->first()
         ->doctores()->where(function($q) use ($search){
            $q ->where('doctores.nombre', 'LIKE', '%'. $search['q'] .'%')
               ->orWhere('doctores.clave', 'LIKE', '%'. $search['q'] .'%');
         })
      ->get();
      
      return $doctores;
   }

   public function get_medicos_all(Request $request){
      $search = $request->except('_token');

      $doctores = Doctores::where(function($q) use ($search){
            $q ->where('doctores.nombre', 'LIKE', '%'. $search['q'] .'%')
               ->orWhere('doctores.clave', 'LIKE', '%'. $search['q'] .'%');
         })
      ->get();
      
      return $doctores;
   }
    //
   public function doctores_index(Request $request){ 
   //Verificar sucursal
      $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
   // Lista de sucursales que tiene el usuario
      $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get(); 

      $listas = User::where('id', Auth::user()->id)->first()->labs()->first()->doctores()->get();

   //datos traidos de la base de datos
      $doctores = User::where('id', Auth::user()->id)->first()->labs()->first()->doctores()->get();
      
      return view('catalogo.doctores.index',
      ['active'=> $active,'sucursales'=> $sucursales,
      'doctores'=> $doctores, 'listas' => $listas]);  
   }

   public function doctores_guardar(StoreDoctorRequest $request){
      $arreglo = $request->validated();
      $this->doctorService->create($arreglo);
      return redirect()->route('stevlab.catalogo.doctores');
   }

   public function get_doctor_edit(Request $request){
      $doctor = $request->except('_token');
      $doctors = Doctores::where('clave', $doctor['data'])->first();
      return $doctors;
   }

   public function doctor_actualizar(StoreDoctorRequest $request){
      $arreglo = $request->validated();
      $this->doctorService->update($this->doctorService->getDoctor($request->id), $arreglo);
      return redirect()->route('stevlab.catalogo.doctores');
   }

   public function doctor_eliminar($id){
      $transact = $this->doctorService->delete($this->doctorService->getDoctor($id));
      $message = $transact === true ? "Doctor eliminado"  : "Doctor no eliminado, presente en: " . $transact . " folios." ;
      return redirect()->route('stevlab.catalogo.doctores')->with('msj', $message);
   }

   public function doctor_user_create($id){
      $user           = User::where('id', Auth::user()->id)->first();
      $laboratorio    = $user->labo()->first();
      //Verificar sucursal
      $active         = $user->sucs()->where('estatus', 'activa')->first();
      // Lista de sucursales que tiene el usuario
      $sucursales     = $user->sucs()->orderBy('id', 'asc')->get();
      $doctor = Doctores::where('id', $id)->first();
      return view('catalogo.doctores.upload', ['active' => $active, 'sucursales'=>$sucursales, 'doctor' => $doctor]);
   }

   public function doctor_user_store(Request $request){
      $doc            = Doctores::where('id',$request->id)->first();
      
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

      $doctor = User::create($validate);

      if($doctor){
         $laboratorio->usuario()->save($doctor);
         $enlace = $doc->user()->save($doctor);
         if($enlace){
            $role = $doctor->assignRole('Doctor');
            return redirect()->route('stevlab.catalogo.doctores')->with('msg', 'Doctor guardado correctamente.');
         }else{
            $delete = User::where('id', $doctor->id)->delete();
            return redirect()->route('stevlab.catalogo.doctores')->with('msg', 'No se pudo enlazar el nuevo usuario, reintente por favor.');
         }
      }else{
         return redirect()->route('stevlab.catalogo.doctores')->with('msg', 'No se pudo guardar nuevo usuario, revise por favor.');
      }

   }

   public function user_doctor_edit($id){
      $doctor           = Doctores::where('id', $id)->first();
      $user_edit        = $doctor->user()->first();
      
      $user           = User::where('id', Auth::user()->id)->first();
      $laboratorio    = $user->labo()->first();
      $active         = $user->sucs()->where('estatus', 'activa')->first();
      $sucursales     = $user->sucs()->orderBy('id', 'asc')->get();

      return view('catalogo.doctores.edit', ['active' => $active, 'sucursales'=>$sucursales, 'doctor' => $user_edit]);
   }

   public function user_doctor_update(Request $request){
      $doc            = User::where('id',$request->id)->first();
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
      if($doc->id == $user->id || $doc->hasRole('Administrador') == true){
         return redirect()->route('stevlab.catalogo.doctores')->with('msg', 'No puedes editar al usuario propietario o al usuario actual.');
      }else{
         $edit_doctor = User::where('id', $request->id)->update($validate);
         if($edit_doctor){
            return redirect()->route('stevlab.catalogo.doctores')->with('msg', 'Doctor actualizado correctamente.');
         }else{
            return redirect()->route('stevlab.catalogo.doctores')->with('msg', 'No se puede actualizar el usuario, por favor reintente o solicite asistencia técnica.');
         }
      }
   }

   public function store_doctor_recepcion(StoreDoctorRequest $request){
      $arreglo = $request->validated();
      $doctor = $this->doctorService->create($arreglo);

      return response()->json([
         'success' => true,
         'mensaje' => 'Doctor guardado con éxito.',
         'data'    => $doctor
      ],200);
   }


   public function index(){
      $doctor = User::where('id', Auth::user()->id)->first();
      $lista = $doctor->prefolio()->orderBy('id', 'desc')->get();
      $texto = 'Hola solicito información acerca de la aplicación Docbook.';
      $url = 'https://api.whatsapp.com/send?phone=5219932771814&text=' . urlencode($texto);

      return view('doctor.recepcion.index', ['listas' => $lista, 'url' => $url]);  
   }

   public function showPacientesDoctor(Request $request){
      // dd($request);
      $data = $request->only('data');

      $dato = [];
      foreach($data['data'] as $key=>$valor){
         $dato[$valor['name']] = $valor['value'];
      }

      $fecha_inicio = Carbon::parse($dato['inicio']);
      $fecha_final = Carbon::parse($dato['final'])->addDay();

      $user = User::where('id', Auth::user()->id)->first();

      $paciente_nombre = Pacientes::where('id', $dato['paciente'])->first();
      $prefolio_paciente =  $paciente_nombre ? $paciente_nombre->nombre : null ;

      $paciente = $user->prefolio()->when($dato['folio'] != null, function($query) use ($dato){
            $query->where('prefolio', '=', $dato['folio']);
         })->when($prefolio_paciente != null, function($query) use ($prefolio_paciente){
            $query->where('nombre', '=', $prefolio_paciente);
         })->whereBetween('prefolios.created_at',[$fecha_inicio, $fecha_final])
         ->get();
      
      return $paciente;
   }

   public function extract_result_prefolio(Request $request){
      $preclave = $request->only('data');
      $prefolio = Prefolio::where('prefolio', $preclave)->first();
      $folio = $prefolio->folio()->first();
      if($folio != null){
         $verifica = Recepcions::where('id', $folio->id)->where('estado', 'pagado')->first();
         $capturado = Recepcions::where('id', $folio->id)->first()->historials()->get();
         if ($capturado) {
            $request = ['message' => 'Estudios no listos para su entrega a cliente. Por favor reintente mas tarde.'];
            // session()->flash('message', 'Estudios no listos para su entrega a cliente. Por favor reintente mas tarde.');
            // return redirect()->route('resultados.index');
         }else{
               if($verifica === null){
                  $request = ['message' => 'Registro no pagado, revise su pago por favor. Parada del sistema, reintente por favor'];
   
                  // session()->flash('message', 'Registro no pagado, revise su pago por favor. Parada del sistema, reintente por favor');
               }else{
                  $request = ['pdf' => '/public/storage/'. $folio->patient_file];
                  return $request;
               }

         }
      }else{
         $request = ['message' => 'Prefolio fue procesado, pero no se concluyo el proceso correctamente'];
      }

      return $request;
   }

   public function prefolio_index(){
      $texto = 'Hola solicito información acerca de la aplicación Docbook.';
      $url = 'https://api.whatsapp.com/send?phone=5219932771814&text=' . urlencode($texto);
      return view('doctor.prefolio.index', ['url'=>$url]);
   }

   public function prefolio_store(Request $request){
      $referencia = $request->referencia;
      $user          = User::where('id', Auth::user()->id)->first();
      $laboratorio   = $user->labo()->first();
      $memb          = "data:image/jpeg;base64," . base64_encode(Storage::disk('public')->get($laboratorio->membrete));

      $estudios = $request->lista;
      $perfiles = $request->perfiles;

      $dato = [];
      foreach($request->data as $key=>$valor){
         $dato[$valor['name']] = $valor['value'];
      }

      if(empty($estudios) && empty($perfiles)){
         $response['msg'] = 'Estudios y perfiles estan vacios, no se puede generar prefolio.';
         return json_encode($response);

      }else{
         $prefolio = Prefolio::create([
            'prefolio'        =>Str::random(6),
            'nombre'          =>$dato['nombre'],
            'observaciones'   =>$dato['observaciones'],
            'referencias'     =>$referencia,
            'estado'          =>'activo',
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
               $response['id']  = $prefolio->id;
               $response['msg'] = true;
            } else {
               $response['msg'] = 'Prefolio no pudo ser creado por favor reintente de nuevo.';
            }

            header("HTTP/1.1 200 OK");
            header('Content-Type: application/json');
            return json_encode($response);

         }else{
            $response['msg'] = 'Prefolio no pudo ser creado por favor reintente de nuevo.';
            return json_encode($response);

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
      
      return redirect()->route('stevlab.doctor.prefolio');
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
      if(empty($estudios['estudios']) && empty($perfiles['perfiles'])){
         $response['msg'] = 'Estudios y perfiles estan vacios, no se puede generar prefolio.';
         return $response;
      }else{
         
         $prefolio = Prefolio::create([
            'prefolio'        =>Str::random(6),
            'nombre'          =>$request->nombre,
            'observaciones'   =>$request->observaciones,
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
               $response['id']  = $prefolio->id;
               $response['msg'] = true;
            } else {
               $response['msg'] = 'Prefolio no pudo ser creado por favor reintente de nuevo.';
            }

            $mensaje = 'Hola estimado(a) ' . $request->nombre . ', *' . $laboratorio->nombre . '* le envia su prefolio con la asignación: *' . $prefolio->prefolio . "*\n\n" . $lista_estudios . $lista_perfiles . "\nObservaciones anexas: *" . $observaciones['observaciones'] . "*\n".  "Sin más por el momento, quedamos a sus ordenes." ;
            $response['url'] = 'https://api.whatsapp.com/send?phone=' . $number['telefono'] . '&text=' . urlencode($mensaje);
            return $response;

         }else{
            $response['msg'] = 'Prefolio no pudo ser creado por favor reintente de nuevo.';
            return $response;
         }
      }
   }

}
