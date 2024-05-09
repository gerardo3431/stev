@extends('layout.master')

@push('plugin-styles')
@endpush
@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Almacen </li>
            <li class="breadcrumb-item active" aria-current="page"> Articulos </li>
        </ol>
    </nav>
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
    @endif

    @if(session('msj'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('msj') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Articulos</h4>
                    <form id="registro_estudios" action="{{route('stevlab.almacen.articulos-store')}}" method="POST">

                        @csrf
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-6 col-lg-3 col-xl-2 ">
                                    <label for="clave" class="form-label">Clave</label>
                                    <input type='text' class="form-control {{ $errors->has('clave') ? 'is-invalid' : '' }}" name="clave"  placeholder="Clave" value='{{old('clave')}}'>
                                    <x-jet-input-error for="clave"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6 col-lg-3 col-xl-2 ">
                                    <label for="clave" class="form-label">Clave salud</label>
                                    <input type='text' class="form-control {{ $errors->has('clave_salud') ? 'is-invalid' : '' }}" name="clave_salud"  placeholder="Clave" value='{{old('clave_salud')}}'>
                                    <x-jet-input-error for="clave_salud"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-12 col-lg-6 col-xl-8 ">
                                    <label for="clave" class="form-label">Nombre</label>
                                    <input type='text' class="form-control {{ $errors->has('nombre') ? 'is-invalid' : '' }}" name="nombre"  placeholder="Nombre" value='{{old('nombre')}}'>
                                    <x-jet-input-error for="nombre"></x-jet-input-error>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-6 col-lg-4 col-xl-4">
                                    <label for="clave" class="form-label">Nombre corto</label>
                                    <input type='text' class="form-control {{ $errors->has('nombre_corto') ? 'is-invalid' : '' }}" name="nombre_corto"  placeholder="Nombre corto" value='{{old('nombre_corto')}}'>
                                    <x-jet-input-error for="nombre_corto"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6 col-lg-4 col-xl-4">
                                    <label for="clave" class="form-label">Tipo material</label>
                                    <select class="form-select {{ $errors->has('tipo_material') ? 'is-invalid' : '' }}" name="tipo_material" value='{{old('tipo_material')}}'>
                                        <option value="reactivos_quimicos">Reactivos químicos</option>
                                        <option value="consumibles">Consumibles de laboratorio</option>
                                        <option value="equipos">Equipos de laboratorio</option>
                                        <option value="dispositivos">Dispositivos médicos</option>
                                        <option value="limpieza">Suministros de limpieza</option>
                                    </select>
                                    <x-jet-input-error for="tipo_material"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6 col-lg-4 col-xl-4">
                                    <label for="clave" class="form-label">Unidad</label>
                                    <select class="form-select {{ $errors->has('unidad') ? 'is-invalid' : '' }}" id="unidad" name="unidad" value='{{old('unidad')}}'>
                                        <option value="pieza">Pieza</option>
                                        <option value="caja">Caja</option>
                                    </select>
                                    <x-jet-input-error for="unidad"></x-jet-input-error>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-6 col-lg-5 col-xl-3">
                                    <label for="clave" class="form-label">Pieza</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" id="pieza" name="pieza" class="form-check-input" disabled>
                                        </div>
                                    </div>
                                    <x-jet-input-error for="pieza"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-4 col-lg-4 col-xl-3">
                                    <label for="clave" class="form-label">Cantidad</label>
                                    <input type='text' class="form-control {{ $errors->has('cantidad') ? 'is-invalid' : '' }}" id="cantidad" name="cantidad"  placeholder="Cantidad" value='{{old('cantidad')}}' disabled>
                                    <x-jet-input-error for="cantidad"></x-jet-input-error>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-6 col-lg-4 col-xl-4">
                                    <label for="clave" class="form-label">Referencia</label>
                                    <input type='text' class="form-control {{ $errors->has('referencia') ? 'is-invalid' : '' }}" name="referencia"  placeholder="Referencia" value='{{old('referencia')}}'>
                                    <x-jet-input-error for="referencia"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6 col-lg-5 col-xl-4">
                                    <label for="clave" class="form-label">Marca</label>
                                    <input type='text' class="form-control {{ $errors->has('marca') ? 'is-invalid' : '' }}" name="marca"  placeholder="Marca" value='{{old('marca')}}'>
                                    <x-jet-input-error for="marca"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-4 col-lg-3 col-xl-3">
                                    <label for="clave" class="form-label">Partida</label>
                                    <input type='text' class="form-control {{ $errors->has('partida') ? 'is-invalid' : '' }}" name="partida"  placeholder="Partida" value='{{old('partida')}}'>
                                    <x-jet-input-error for="partida"></x-jet-input-error>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-6 col-lg-4 col-xl-3">
                                    <label for="clave" class="form-label">Ubicacion</label>
                                    <input type='text' class="form-control {{ $errors->has('ubicacion') ? 'is-invalid' : '' }}" name="ubicacion"  placeholder="Ubicación" value='{{old('ubicacion')}}'>
                                    <x-jet-input-error for="ubicacion"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6 col-lg-4 col-xl-4">
                                    <label for="clave" class="form-label">Presentación</label>
                                    <input type='text' class="form-control {{ $errors->has('presentacion') ? 'is-invalid' : '' }}" name="presentacion"  placeholder="Presentación" value='{{old('presentacion')}}'>
                                    <x-jet-input-error for="presentacion"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6 col-lg-4 col-xl-4">
                                    <label for="clave" class="form-label">Familia</label>
                                    <input type='text' class="form-control {{ $errors->has('familia') ? 'is-invalid' : '' }}" name="familia"  placeholder="Familia" value='{{old('familia')}}'>
                                    <x-jet-input-error for="familia"></x-jet-input-error>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-4 col-lg-3 col-xl-4">
                                    <label for="clave" class="form-label">Ultimo precio</label>
                                    <input type='text' class="form-control {{ $errors->has('ultimo_precio') ? 'is-invalid' : '' }}" name="ultimo_precio"  placeholder="Ultimo precio" value='{{old('ultimo_precio')}}'>
                                    <x-jet-input-error for="ultimo_precio"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-4 col-lg-5 col-xl-4">
                                    <label for="clave" class="form-label">Caducidad</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="caducidad" class="form-check-input">
                                        </div>
                                    </div>
                                    {{-- <input type='text' class="form-control {{ $errors->has('caducidad') ? 'is-invalid' : '' }}" name="caducidad"  placeholder="Caducidad" value='{{old('caducidad')}}'> --}}
                                    <x-jet-input-error for="caducidad"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-4 col-lg-4 col-xl-4">
                                    <label for="clave" class="form-label">Lote</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="lote" class="form-check-input" >
                                        </div>
                                    </div>
                                    {{-- <input type='text' class="form-control {{ $errors->has('lote') ? 'is-invalid' : '' }}" name="lote"  placeholder="Lote" value='{{old('lote')}}'> --}}
                                    <x-jet-input-error for="lote"></x-jet-input-error>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-4 col-lg-3 col-xl-4">
                                    <label for="clave" class="form-label">Stock minimo</label>
                                    <input type='text' class="form-control {{ $errors->has('min_stock') ? 'is-invalid' : '' }}" name="min_stock"  placeholder="Stock minímo" value='{{old('min_stock')}}'>
                                    <x-jet-input-error for="min_stock"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-4 col-lg-4 col-xl-4">
                                    <label for="clave" class="form-label">Stock máximo</label>
                                    <input type='text' class="form-control {{ $errors->has('max_stock') ? 'is-invalid' : '' }}" name="max_stock"  placeholder="Stock máximo" value='{{old('max_stock')}}'>
                                    <x-jet-input-error for="max_stock"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-4 col-lg-2 col-xl-3">
                                    <label for="clave" class="form-label">Punto reorden</label>
                                    <input type='text' class="form-control {{ $errors->has('punto_reorden') ? 'is-invalid' : '' }}" name="punto_reorden"  placeholder="Punto reorden" value='{{old('punto_reorden')}}'>
                                    <x-jet-input-error for="punto_reorden"></x-jet-input-error>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12">
                                    <label for="clave" class="form-label">Observaciones</label>
                                    <input type='text' class="form-control {{ $errors->has('observaciones') ? 'is-invalid' : '' }}" name="observaciones"  placeholder="Observaciones" value='{{old('observaciones')}}'>
                                    <x-jet-input-error for="observaciones"></x-jet-input-error>
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 d-md-block grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tabla de articulos</h4>
                    <div class="mb-3">
                        <div class="table-responsive">
                            <table id="dataTableArticulos" class="table table-sm table-hover nowrap" width="100%">
                                <thead>
                                    <tr> 
                                        <th>#</th>
                                        <th>Clave</th>
                                        <th>Articulo</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($articulos as $articulo)
                                    <tr>
                                        <td>{{$articulo->id}}</td>
                                        <td>{{$articulo->clave}}</td>
                                        <td>{{$articulo->nombre}}</td>
                                        <td>
                                            <a onclick="verEstudio(this)" class='btn  btn-xs btn-icon btn-primary' ><i class="mdi mdi-eye"></i> </a>
                                            <a onclick="editarEstudio(this)" class="btn btn-xs btn-icon  btn-secondary" ><i class="mdi mdi-pencil"></i> </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center; ">No data allowed</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $articulos->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')
    <script src="{{ asset('public/stevlab/almacen/articulos/functions.js') }}?v=<?php echo rand();?>"></script>
@endpush