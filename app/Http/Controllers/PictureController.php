<?php

namespace App\Http\Controllers;

use App\Models\Deparments;
use App\Models\Lista;
use App\Models\Picture;
use App\Models\Recepcions;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PictureController extends Controller
{
    public function get_pictures(Request $request){
        $fecha_inicio = Carbon::parse($request->fecha_inicio);
        $fecha_final = Carbon::parse($request->fecha_final)->addDay();
        // ->orderBy('analitos_has_estudios.orden', 'desc')
        // $count_img = $query->picture()->when($request->areaId != 'todo', function ($query) use ($request){
        //     $query->whereHas('deparment', function ($query) use ($request){
        //         $query->where('deparments_id', $request->areaId);
        //     });
        // })->get();

        $estudios = Recepcions::whereHas('picture')->when($request->area != 'todo', function ($query) use ($request){
            $query->whereHas('picture', function ($query) use ($request){
                $query->where('deparments_id', $request->area);
            });
        })->when($request->sucursal != 'todo', function ($query) use ($request){
            $query->whereHas('sucursales', function ($query) use ($request){
                $query->where('subsidiary_id', $request->sucursal);
            });
        })->whereBetween('recepcions.created_at', [$fecha_inicio, $fecha_final])->orderBy('id', 'desc')->get();


        foreach ($estudios as $key => $value) {
            $value->paciente = $value->paciente()->first() ? $value->paciente()->first()->nombre : 'Sin paciente asignado';
            $value->sucursal = $value->sucursales()->first()->sucursal;
            $value->empresa = $value->empresas()->first()->descripcion;
        }
        
        // if($request->estado == 'todo'){
        //     $estudios = Recepcions::whereRelation(
        //         'sucursales', 'recepcions_has_subsidiaries.subsidiary_id', '=', $request->sucursal
        //     )->whereRelation('picture', 'recepcions_has_deparments.deparments_id', '=', $request->area)
        //     ->whereBetween('recepcions.created_at', [$fecha_inicio, $fecha_final])->orderBy('id', 'desc')->get()
        //     ->load(['sucursales', 'paciente', 'empresas']);
            
        // }else{

        //     $estudios = Recepcions::whereRelation(
        //         'picture', 'recepcions_has_deparments.deparments_id', '=', $request->area
        //     )->whereRelation(
        //         'sucursales', 'recepcions_has_subsidiaries.subsidiary_id', '=', $request->sucursal
        //     )->whereBetween('recepcions.created_at', [$fecha_inicio, $fecha_final])->orderBy('id', 'desc')->get()
        //     ->load(['sucursales', 'paciente', 'empresas']);
        // }
        
        return $estudios;

    }

    public function get_folio(Request $request){
        $folio = $request->except('_token');
        $count = Recepcions::where('folio', $folio)->first()->picture()->get();
        return $count;
    }

    public function get_picture_id(Request $request){
        $id = $request->input('ID');

        $picture = Picture::where('id','=' ,$id)->first();

        $area = $picture->deparment()->first();

        $picture->area = $area->id;


        return $picture;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        $estudios = User::where('id', Auth::user()->id)->first()->labo()->first()->imagen()->get();

        $areas = User::where('id', Auth::user()->id)->first()->labo()->first()->departamento()->get();
        return view('imagenologia.estudios.index',['estudios' => $estudios, 'active' => $active, 'sucursales' => $sucursales, 'areas' => $areas]);
    }

    public function store_imagenologia(Request $request){
        // dd($request);
        // Verificar laboratorio asignado
        $laboratorio = User::where('id', Auth::user()->id)->first()->labo()->first();
        //Verificar sucursal
        $sucursal = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        //Areas
        $area = Deparments::where('id', $request->area)->first();

        // Para validar datos de estudio
        $estudios = request()->validate([
            'clave'             => 'required|unique:pictures',
            'codigo'            => 'nullable',
            'descripcion'       => 'required',
            'condiciones'       => 'nullable',
            'precio'            => 'nullable',
            
        ],[
            'clave.required'        => 'Ingresa clave',
            'descripcion.required'  => 'Ingresa alguna descripcion',
        ]);

        $estudio = Picture::create($estudios);
         // Crea relacion de area al estudio
        $laboratorio->imagen()->save($estudio);

        // Crea relacion
        $area->picture()->save($estudio);

        return redirect()->route('stevlab.catalogo.imagenologia');
    }

    public function update_imagenologia(Request $request){
        $data = $request->data;
        parse_str($data, $data_array);
        // dd($data_array);
        // Crear una instancia de la clase Request y asignar los datos del arreglo
        $request = new Request($data_array);
        
        try {
            $estudios = request()->validate([
                'clave'             => 'fillable|unique:pictures',
                'codigo'            => 'nullable',
                'descripcion'       => 'filled',
                'condiciones'       => 'nullable',
                'precio'            => 'nullable',
                
            ],[
                'clave.required'        => 'Ingresa clave',
                'descripcion.required'  => 'Ingresa alguna descripcion',
            ]);
            $old_data = Picture::where('id', '=', $request->identificador)->first();
            $old_deparment = $old_data->deparment()->first();
            $sus_fk = $old_data->deparment()->detach($old_deparment);
            
            $picture = Picture::where('id', '=', $request->identificador)->update([
                'clave'             => $request->clave,
                'codigo'            => $request->codigo,
                'descripcion'       => $request->descripcion,
                'condiciones'       => $request->condiciones,
                'precio'            => $request->precio,
            ]);

            $precio = Lista::where('clave', $old_data->clave)->update(['clave' => $request->clave]);

            $new_data = Picture::where('id', '=', $request->identificador)->first();
            $new_deparmet = Deparments::where('id', '=', $request->area)->first();
            $add_fk = $new_data->deparment()->attach($new_deparmet);
        
            return response()->json([
                'success' => true,
                'message' => 'Datos del formulario procesados con éxito'
            ], 200);

        } catch (ValidationException $exception) {
            $errors = $exception->validator->errors()->all();
            return response()->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }
    }

    public function areas_index(){
        //Verificar sucursal
        $active = User::where('id', Auth::user()->id)->first()->sucs()->where('estatus', 'activa')->first();
        // Lista de sucursales que tiene el usuario
        $sucursales = User::where('id', Auth::user()->id)->first()->sucs()->orderBy('id', 'asc')->get();

        $estudios = User::where('id', Auth::user()->id)->first()->labo()->first()->departamento()->get();
        return view('imagenologia.areas.index',['estudios' => $estudios, 'active' => $active, 'sucursales' => $sucursales, 'deparments' => $estudios]);
    }

    public function store_areas(Request $request){
        // Verificar laboratorio asignado
        $laboratorio = User::where('id', Auth::user()->id)->first()->labs()->first();

        // Para validar datos de areas
        $areas = request()->validate([
            'descripcion'           => 'required',
            'observaciones'         => 'required',
        ],[
            'descripcion.required'  => 'Ingresa alguna descripcion',
            'observaciones.required'=> 'Ingresa alguna observación',
        ]);

        $area = Deparments::create($areas);

        $laboratorio->departamento()->save($area);

        return redirect()->route('stevlab.catalogo.areas-imagenologia');
    }

    public function captura_index(){         
        $user       = User::where('id', Auth::user()->id)->first();
        //Verificar sucursal
        $active     = $user->sucs()->where('estatus', 'activa')->first();
        $sucursales = $user->sucs()->orderBy('id', 'asc')->get();
        // Areas
        $areas      = $user->labo()->first()->departamento()->get();


        return view('imagenologia.captura.index',[
            'active'        => $active, 
            'sucursales'    => $sucursales, 
            'areas'         => $areas,
        ]);
    }
}
