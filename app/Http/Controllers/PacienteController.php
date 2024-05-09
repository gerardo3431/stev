<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Models\Empresas;
use App\Models\Laboratory;
use Illuminate\Support\Facades\DB;
use App\Models\Pacientes;
use App\Models\Recepcions;
use App\Models\User;
use App\Services\PacienteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    protected $pacienteService;
    
    public function __construct(PacienteService $pacienteService)
    {
        $this->pacienteService = $pacienteService;
    }

    public function get_all_patients(){
        $pacientes = User::where('id', Auth::user()->id)->first()->labs()->first()->pacientes()->get();
        return $pacientes;
    }

    public function get_pacientes(Request $request){ 
        $search = $request->except('_token');
        // Trae listas de estudios

        $pacientes = User::where('id', Auth::user()->id)->first()
        ->labo()->first()
        ->pacientes()->where(function($q) use ($search){
            $q ->where('pacientes.nombre', 'LIKE', '%'. $search['q'].'%');
        })
        ->get();

        return $pacientes;
    }

    public function get_index_search_patient(Request $request){
        $search = $request->except('_token');
        // Trae listas de estudios
        $user = User::where('id', Auth::user()->id)->first(); 
        $doctor = $user->doctor()->first();
        $empresa = $user->empresas_users()->first();

        $folios = Recepcions::where(function ($query) use ($search){
            $query->whereRelation('paciente', 'pacientes.nombre', 'LIKE', "%". $search['q'] ."%");
        })->orWhere(function ($query) use ($empresa){
            $query->when($empresa !== null, function ($subquery) use ($empresa){
                $subquery->whereRelation('empresas', 'recepcions.id_empresa', $empresa->id);
            });
        })->orWhere(function ($query) use ($doctor){
            $query->when($doctor !== null, function ($subquery) use ($doctor){
                $subquery->whereRelation('doctores', 'recepcions.id_doctor', $doctor->id);
            });    
        })
        ->pluck('id_paciente')->toArray();


        $pacientes = Pacientes::whereIn('id', $folios)->get();
      
        return $pacientes;
    }
    //
    public function paciente_index(Request $request){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        return view('catalogo.pacientes.index',[
            'active'        =>$active,
            'sucursales'    =>$sucursales,
        ]); 
    }
    // Agregar al otro proyecto
    public function paciente_guardar(StorePatientRequest $request){
        $arreglo = $request->validated();
        $this->pacienteService->create($arreglo);
        return redirect()->route('stevlab.catalogo.pacientes');
    }

    public function get_paciente_edit(Request $request){
        return $this->pacienteService->getPaciente($request->data);
    }

    public function paciente_actualizar(StorePatientRequest $request){
        $arreglo = $request->validated();
        $update = $this->pacienteService->update($this->pacienteService->getPaciente($request->id), $arreglo);
        return redirect()->route('stevlab.catalogo.pacientes');
    }

    public function paciente_eliminar($id){
        $user = User::where('id', Auth()->user()->id)->first();
        if($user->hasPermissionTo('eliminar_pacientes')){
            $query = Recepcions::whereRelation('paciente', 'recepcions_has_paciente.pacientes_id', '=', $id)->count();
            if($query === 0){
                $id = Pacientes::where('id', $id)->delete();
                $string = "Paciente eliminado.";
            }            
            $msj = isset($string) ? $string : 'Paciente no eliminado. Registrado en: ' . $query . " folios";

        }
        return redirect()->route('stevlab.catalogo.pacientes')->with('msj', $msj);
    } 
    

    // Para pacientes en recepcion agregar uno nuevo
    public function store_patient_recepcion(StorePatientRequest $request){
        $arreglo = $request->validated();
        // dd($arreglo);
        $paciente = $this->pacienteService->create($arreglo);

        $paciente->nombre_empresa = Empresas::where('id', $paciente->id_empresa)->first()->descripcion;

        return response()->json([
            'success' => true,
            'mensaje' => 'Paciente creado con exito',
            'data'    => $paciente
        ],200);
    }
}
