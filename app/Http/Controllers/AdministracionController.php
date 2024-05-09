<?php

namespace App\Http\Controllers;

use App\Models\Analito;
use App\Models\Doctores;
use App\Models\Estudio;
use App\Models\Laboratory;
use App\Models\Log;
use App\Models\Pacientes;
use App\Models\Picture;
use App\Models\Precio;
use App\Models\Profile;
use App\Models\Recepcions;
use App\Models\Subsidiary;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\hasRole;

class AdministracionController extends Controller
{

    // Gettter
    public function get_trazabilidad(Request $request){
        $usuario        = $request->input('usuario');
        $fecha_inicial  = Carbon::createFromFormat('d/m/Y', $request->input('fecha_inicio'))->startOfDay();
        $fecha_final    = Carbon::createFromFormat('d/m/Y', $request->input('fecha_final'))->endOfDay();

        $consulta = Activity::when($request->usuario !== 'todo', function ($query) use ($request){
            $query->where('causer_id', $request->input('usuario'));
        })
        ->whereBetween('created_at', [$fecha_inicial, $fecha_final])
        ->get();

        return $consulta;
        // $consulta = Activity::when($request->usuario !== null, function ($query) use ($request){
        //     $query->causedBy($request->usuario);
        // })
        // $query = Log::query();

        // // si se proporciona un ID de usuario, filtrar por ese usuario
        // if (is_numeric($usuario)) {
        //     $query->where('user_id', $usuario);
        // }else if($usuario === 'todo'){
        //     // No realizar accion
        // }else{
        //     return response()->json([
        //         'response'  => false,
        //         'note'       => 'Dato ingresado al buscador no es tipo de dato admisible',
        //     ], 400);
        // }
        
        // // Agregar filtro para usuarios con roles diferentes a "admin" o "superadmin"
        // $query->join('model_has_roles', 'logs.user_id', '=', 'model_has_roles.model_id')
        // ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        // ->where('roles.name', '<>', 'admin')
        // ->where('roles.name', '<>', 'superadmin')
        // ->select('logs.*')
        // ->orderBy('id', 'desc');
        
        // $query->whereNotNull('srce_model')
        // ->whereNotNull('srce_id')
        // ->whereNotNull('trgt_model')
        // ->whereNotNull('trgt_id')
        // ->whereBetween('logs.created_at', [$fecha_inicial, $fecha_final]);
    
        // $logs = $query->get();

        // foreach ($logs as $log) {
        //     if($log->srce_model == 'Estudio'){
        //         $log->clave = Estudio::where('id', $log->srce_id)->first()->clave;
        //     }elseif ($log->srce_model == 'Perfil') {
        //         $log->clave = Profile::where('id', $log->srce_id)->first()->clave;
        //     }elseif ($log->srce_model == 'Imagenologia') {
        //         $log->clave = Picture::where('id', $log->srce_id)->first()->clave;
        //     }
            
        //     if ($log->srce_model == 'Folios') {
        //         $log->folio = Recepcions::where('id', $log->srce_id)->first()->folio;
        //     }

        //     if ($log->trgt_model == 'Folios') {
        //         $log->folio = (Recepcions::where('id', $log->trgt_id)->first() != null ) ? Recepcions::where('id', $log->trgt_id)->first()->folio : 'getException target: ' . $log ;
        //     }
        // }
        // return $logs;
    }
    
    // Cambiar sucursal
    public function administracion_change_sucursal(Request $request){
        $mensaje = [];
        // Verificar y contar caja del usuario
        $active = User::where('id', Auth::user()->id)->first()->caja()->where('estatus', 'abierta')->first();
        
        if($active){
            $mensaje['caja'] = 'Caja existente sin cerrar';
            return $mensaje;
        }else{
            $sucursal = $request['sucursal'];

            $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->where('subsidiaries.id', $sucursal )->first();
            $user = User::where('id', Auth::user()->id)->first();
    
            $inactive = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->update(['estatus'=>'inactiva']);
            $active = User::where('id', Auth::user()->id)->first()->sucs()->where('subsidiary_id', $sucursales->id)->update(['estatus'=>'activa']);
    
            if($active){
                $mensaje['status'] = true;
                return $mensaje;
            }else{
                $mensaje['status'] = false;
                return $mensaje;
            }
        }
        
    }

    public function administracion_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        // Laboratorio
        $laboratorio    = User::where('id', Auth::user()->id)->first()->labo()->first();
        // Conseguir todas las sucursales que tiene el laboratorio
        $subsidiaries = $laboratorio->subsidiary()->get();

        return view('administracion.sucursales.index', [
            'active'        => $active,
            'sucursales'    => $sucursales,
            'locales'       => $subsidiaries,
        ]);
    }

    public function administracion_store_sucursal(Request $request){
        $data = request()->validate([
            'sucursal'              => 'required',
            'telefono'              => 'required',
            'direccion'             => 'required',
            
        ]);
        $laboratorio            = User::where('id', Auth::user()->id)->first()->labo()->first();
        // $data['sucursal']       = $laboratorio->nombre . ' - ' . $data['sucursal'];
        $sucursal               = Subsidiary::create($data);
        $laboratorio->subsidiary()->save($sucursal);

        // $user_data = request()->validate([
        //     'name'                  => 'required',
        //     'username'              => 'required | unique:users',
        //     'email'                 => 'required | unique:users',
        //     'password'              => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
        //     'confirmar_contraseña'  => 'required | same:password',
        // ]);

        // Laboratorio
        // Usuario creador
        // $user = User::where('id', Auth::user()->id)->first();
        
        // Nombre de sucursal
        // Encriptacion de contraseña
        // $user_data['password'] = Hash::make($user_data['password']);

        // Crea sucursal
        // Crea usuario
        // $user_new = User::create($user_data);
        

        // Laboratorio - sucursales
        // user has laboratory
        // $user_new->labo()->save($laboratorio);
        // Subsidiaries has users
        // $sucursal->empleados()->save($user);
        // $sucursal->empleados()->save($user_new);

        // Crea relacion entre usuario que crea ´+ nueva sucursal ||| users has laboratories    ||| ara cambiar entre sucursales
        // $user->laboratorio()->attach($laboratorio->id, ['subsidiary_id' => $sucursal->id, 'user_id'=> $user->id]);
        // $user_new->laboratorio()->attach($laboratorio->id, ['subsidiary_id' => $sucursal->id, 'user_id'=> $user_new->id, 'estatus'=>'activa' ]);

        // Añade rol a usuario
        // $user_new->assignRole('Quimico jefe sucursal');

        return redirect()->route('stevlab.administracion.sucursales');
    }


    public function usuarios_index(){
        // / Laboratorio
        $laboratorio    = User::where('id', Auth::user()->id)->first()->labo()->first();
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();
        
        // Lista de usuarios - para tabla completa de usuarios
        $usuarios = Laboratory::where('id', $laboratorio->id)->first()->usuario()->get();
        
        $roles = Role::where('guard_name', 'web')->get();
        
        $permissions = Permission::where('guard_name', 'web')->get();

        // Lista de usuarios - para tabla de la sucursal
        $empleados = Subsidiary::where('id', $active->id)->first()->empleados()->get();
        
        return view('administracion.usuarios.index', [
            'active'        => $active, 
            'sucursales'    => $sucursales, 
            'usuarios'      => $usuarios, 
            'empleados'     => $empleados, 
            'roles'         => $roles, 
            'permissions'   => $permissions
        ]);
    }


    public function usuario_store(Request $request){
        $user_data = request()->validate([
            'name'                  => 'required',
            'username'              => 'required | unique:users',
            'email'                 => 'required | unique:users',
            'password'              => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()],
            'confirmar_contraseña'  => 'required | same:password',
        ]);

        $laboratorio            = Laboratory::first();
        try {
            $user_data['password']  = Hash::make($user_data['password']);
            $create_user            = User::create($user_data);

            // Users has laboratory
            $create_user->labo()->save($laboratorio);

            // Obtén el ID del rol seleccionado del formulario
            $roleID = $request->input('rol');

            // Busca el rol en la base de datos por su ID
            $role = Role::findOrFail($roleID);

            // Asigna el rol al usuario
            $create_user->assignRole($role);

        } catch (\Throwable $th) {
            return response()->json([
                'response'  => false,
                'error'     => $th,
            ], 400);
        }

        return response()->json([
            'response'  => true,
            'message'   => 'Usuario creado con éxito',
        ], 200);
    }

    public function usuario_edit_subsidiary(User $usuario){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        // $user = User::where('id', $usuario)->first();
        $subsidiaries = Subsidiary::all();

        return view('administracion.usuarios.subsidiaries',  ['active' => $active, 'sucursales' => $sucursales, 'usuario'=> $usuario, 'subsidiaries' => $subsidiaries]);

    }

    public function update_user_subsidiarie(Request $request){
        // dd($request);
        $user = $request->only('user');
        $permisos = $request->only('permisos');

        $usuario = User::where('id', $user['user'])->first();
        $laboratorio = auth()->user()->labo()->first();


        $subsidiaries = Subsidiary::whereIn('id',$request->permisos)->get();

        $usuario->locales()->detach($subsidiaries);
        $usuario->locales()->attach($subsidiaries);

        $usuario->sucursal()->detach($subsidiaries);
        foreach ($subsidiaries as $key => $value) {
            $valor = $key===0 ? 'activa' : 'inactiva';
            // dd($valor);
            $usuario->sucursal()->attach($value->id, ['laboratory_id' => $laboratorio->id, 'estatus' => $valor ]);
        }

        return redirect()->route('stevlab.administracion.usuarios');

    }

    public function usuario_edit_rol(User $usuario){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        // $user = User::where('id', $usuario)->first();
        $roles = Role::all();

        // $roles = Role::whereNotIn('name', ['Doctor', 'Empresa', 'Administrador', 'Contador'])->get();

        return view('administracion.usuarios.roles',  ['active' => $active, 'sucursales' => $sucursales, 'usuario'=> $usuario, 'roles' => $roles]);

    }

    public function usuario_update_rol(Request $request){
        $user = $request->only('user');
        $permisos = $request->only('permisos');

        $usuario = User::where('id', $user)->first();
        $role = Role::findOrFail($permisos);

        $usuario->roles()->detach();
        $usuario->assignRole($role);


        return redirect()->route('stevlab.administracion.usuarios');
    }

     // $usuario->roles()->detach();
        // // Asigna el rol al usuario
        // $usuario->assignRole($role);

        // $usuario->roles()->sync([$role->id]);

        // $user_new->assignRole('Quimico jefe sucursal');

    public function usuario_edit_permission($usuario){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        $user = User::where('id', $usuario)->first();

        $permissions = Permission::where('guard_name', 'web')->get();


        return view('administracion.usuarios.permission',  ['active' => $active, 'sucursales' => $sucursales, 'usuario'=> $user, 'permissions' => $permissions]);
    }

    public function usuario_update_permissions(Request $request){
        $user = $request->only('user');
        $permisos = $request->permisos;

        $usuario = User::where('id', $user['user'])->first();
        // $permissions = Permission::where('guard_name', 'web')->whereIn('id', $permisos)->get();

        if (!empty($permisos)) {
            $permissions = Permission::where('guard_name', 'web')->whereIn('id', $permisos)->get();
            $usuario->givePermissionTo($permissions);
        } else {
            // Si no se proporcionan permisos, puedes eliminar todos los permisos existentes del usuario.
            $usuario->revokePermissionTo(Permission::all());
        }

        return redirect()->route('stevlab.administracion.usuarios');
    }

    public function usuario_edit_info($usuario){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        $user = User::where('id', $usuario)->first();


        return view('administracion.usuarios.information', [
            'active'        => $active, 
            'sucursales'    => $sucursales, 
            'usuario'       => $user
        ]);
    }

    public function usuario_edit_update(Request $request){
        $user            = User::where('id',$request->id)->first();
    
        $validate = $request->validate([
            'name'         => 'required',
            'email'        => ['required', 'unique:users', 'email:rfc,dns'],
            'username'     => ['required','unique:users'],
            // 'password'     => ['required'],
            'new_password_1' => ['required', Password::min(8)],
            'new_password_2'  => ['required','same:new_password_1'],
        ]);
        // dd($validate);
        // dd($request);
        // dd(Hash::check($request->password, $user->password));
        // if ($request->password) {
        //     if (!Hash::check($request->password, $user->password)) {
        //         $validate->errors()->add('password', 'La contraseña anterior no es correcta.');
        //     }
        // }

        if ($request->new_password_1) {
            $validate['password'] = Hash::make($request->new_password_1);
        }

        unset($validate['new_password_1']);
        unset($validate['new_password_2']);

        $update = User::where('id',$request->id)->update($validate);

        return redirect()->route('stevlab.administracion.usuarios')->with('msj', 'Usuario actualizado');

    }


    public function trashed_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        // Obtener lista de folios cancelados
        $folios = Recepcions::onlyTrashed()->orderBy('id', 'desc')->paginate(10);

        // Obtener pacientes eliminardo
        $pacientes = Pacientes::onlyTrashed()->orderBy('id', 'desc')->paginate(10);

        // Obtener doctores eliminados
        $doctores = Doctores::onlyTrashed()->orderBy('id', 'desc')->paginate(10);

        // Obtener estudios eliminados
        $estudios = Estudio::onlyTrashed()->orderBy('id', 'desc')->paginate(10);
        
        $analitos = Analito::onlyTrashed()->orderBy('id', 'desc')->paginate(10);

        $listas = Precio::onlyTrashed()->orderBy('id', 'desc')->paginate(10);


        return view('utils.trashed.index', [
            'active'        => $active, 
            'sucursales'    => $sucursales, 
            'folios'        => $folios,
            'pacientes'     => $pacientes,
            'doctores'      => $doctores,
            'estudios'      => $estudios,
            'analitos'      => $analitos,
            'listas'        => $listas,
        ]);
    }

    public function trash_restore_folio($id){
        $sanitize = preg_replace('/[^a-zA-Z0-9\s]/', '', htmlspecialchars($id));

        $query = Recepcions::withTrashed()->find($id);

        $restore = $query->restore();

        if($restore){
            return redirect()->route('stevlab.utils.trashed')->with('msj', 'Folio restaurado con exito.');
        }else{
            return redirect()->route('stevlab.utils.trashed')->with('msj', 'Folio no pudo ser restaurado, no existe o puede estar corrupto, consulte con soporte.');
        }
    }

    public function trash_restore_patient($id){
        $sanitize = preg_replace('/[^a-zA-Z0-9\s]/', '', htmlspecialchars($id));

        $query = Pacientes::withTrashed()->find($id);

        $restore = $query->restore();

        if($restore){
            return redirect()->route('stevlab.utils.trashed')->with('msj', 'Paciente restaurado con exito.');
        }else{
            return redirect()->route('stevlab.utils.trashed')->with('msj', 'Paciente no pudo ser restaurado, no existe o puede estar corrupto, consulte con soporte.');
        }
    }

    public function trash_restore_doctor($id){
        $sanitize = preg_replace('/[^a-zA-Z0-9\s]/', '', htmlspecialchars($id));

        $query = Doctores::withTrashed()->find($id);

        $restore = $query->restore();

        if($restore){
            return redirect()->route('stevlab.utils.trashed')->with('msj', 'Paciente restaurado con exito.');
        }else{
            return redirect()->route('stevlab.utils.trashed')->with('msj', 'Paciente no pudo ser restaurado, no existe o puede estar corrupto, consulte con soporte.');
        }
    }

    public function trash_restore_estudio($id){
        $sanitize = preg_replace('/[^a-zA-Z0-9\s]/', '', htmlspecialchars($id));

        $query = Estudio::withTrashed()->find($id);

        $restore = $query->restore();

        if($restore){
            return redirect()->route('stevlab.utils.trashed')->with('msj', 'Estudio restaurado con exito.');
        }else{
            return redirect()->route('stevlab.utils.trashed')->with('msj', 'Estudio no pudo ser restaurado, no existe o puede estar corrupto, consulte con soporte.');
        }
    }

    public function trash_restore_analito($id){
        $sanitize = preg_replace('/[^a-zA-Z0-9\s]/', '', htmlspecialchars($id));

        $query = Analito::withTrashed()->find($id);

        $restore = $query->restore();

        if($restore){
            return redirect()->route('stevlab.utils.trashed')->with('msj', 'Analito restaurado con exito.');
        }else{
            return redirect()->route('stevlab.utils.trashed')->with('msj', 'Analito no pudo ser restaurado, no existe o puede estar corrupto, consulte con soporte.');
        }
    }

    public function trash_restore_precio($id){
        $sanitize = preg_replace('/[^a-zA-Z0-9\s]/', '', htmlspecialchars($id));

        $query = Precio::withTrashed()->find($id);

        $restore = $query->restore();

        if($restore){
            return redirect()->route('stevlab.utils.trashed')->with('msj', 'Lista de precio restaurado con exito.');
        }else{
            return redirect()->route('stevlab.utils.trashed')->with('msj', 'Lista de precio no pudo ser restaurado, no existe o puede estar corrupto, consulte con soporte.');
        }
    }

    public function index_trazabilidad(){
        // Usuarios
        $excludedRole = ['Administrador', 'Contador'];
        $usuarios = $users = User::whereDoesntHave('roles', function ($query) use ($excludedRole) {
                    $query->where('name', $excludedRole);
                })->get();
        
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        return view('utils.trazabilidad.index', [
            'active'        => $active, 
            'sucursales'    => $sucursales, 
            'usuarios'      => $usuarios,
        ]);
    }
}
