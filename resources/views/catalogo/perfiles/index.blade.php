@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="#">Catálogo</a></li>
            <li class="breadcrumb-item active" aria-current="page">Perfiles</li>
        </ol>
    </nav>
    <div class="row">
        @can('crear_perfiles')
            <div class="col-md-12 col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Perfiles de estudios</h6>
                        <form id='regisPerfiles' class="forms-sample" action='#'>
                            @csrf
                            <div class="row">
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="mb-3">
                                            <label for="">Clave</label>
                                            <input type="text" id="" name="clave" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6">
                                        <div class="mb-3">
                                            <label for="">Código</label>
                                            <input type="text" id="" name="codigo" class="form-control">
                                        </div>
                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-5 col-xl-6">
                                    <div class="mb-3">
                                        <label for="">Descripción</label>
                                        <input type="text" id='' name="descripcion" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-5 col-xl-6">
                                    <div class="mb-3">
                                        <label for="">Precio</label>
                                        <input class="form-control" type="number" id="precio" name="precio" placeholder="$">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="">Observaciones</label>
                                        <textarea name="observaciones" id="" cols="30" rows="5" class="form-control"></textarea>
                                        {{-- <input type="text" id="" name="" class="form-control"> --}}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                    <label class="form-label" for="">Estudio</label>
                                    <select id='estudio' class="js-example-basic-single form-select" data-width="100%">
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="responsive">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <table class="table text-center">
                                                <thead>
                                                    <tr>
                                                        <th>Clave</th>
                                                        <th>Descripción</th>
                                                        <th>Condiciones</th>
                                                        <th><i class="mdi mdi-wrench"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody id='listEstudios'>
        
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            
                            <button  type="submit" class="btn btn-primary me-2">Guardar</button>
                            {{-- <button class="btn btn-secondary">Cancel</button> --}}
                        
                        </form>
                    </div>
                </div>
            </div>
        @endcan
        <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tabla de perfiles</h4>
                    
                    <div class="table">
                        <div class="table-responsive">
                            <table id="dataTablePerfiles" class="table text-center" width="100%">
                                <thead>
                                    <tr>
                                        <th>Clave</th>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($perfiles as $item)
                                        <tr >
                                            <td>
                                                <span>
                                                    {{$item->clave}}
                                                </span>
                                            </td>
                                            <td>{{$item->descripcion}}</td>
                                            <td >
                                                {{-- <a onclick="verPerfil(this)" class='btn btn-icon btn-xs btn-primary' href="#"><i class="mdi mdi-eye"></i></a> --}}
                                                @can('editar_perfiles') 
                                                    <a onclick="editarPerfil(this)" class="btn btn-icon btn-xs btn-success" href="#"><i class="mdi mdi-pencil"></i></a>
                                                @endcan
                                                @can('editar_estudios_perfil')
                                                    <a onclick="asignarEstudios({{$item->id}})" class="btn btn-icon btn-xs btn-secondary" href="#"><i class="mdi mdi-chemical-weapon"></i></a>
                                                @endcan
                                                @can('eliminar_perfiles')
                                                    <a href="{{ route('stevlab.catalogo.delete-profile', $item->id) }}" class="btn btn-icon btn-xs btn-danger"><i class="mdi mdi-delete"></i></a>
                                                @endcan
                                            </td>
                                        </tr>
                                    @empty
                                        
                                    @endforelse
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- Editar perfil --}}
<div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar perfil de estudio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="edit_regisPerfiles" class="forms-sample" action="#">
                    <input type="hidden" data-id='' id="identificador" name="identificador" class="form-control">
                    @csrf
                    <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Clave</label>
                                    <input type="text" id="edit_clave" name="clave" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Código</label>
                                    <input type="text" id="edit_codigo" name="codigo" class="form-control">
                                </div>
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-5 col-xl-6">
                            <div class="mb-3">
                                <label for="">Descripción</label>
                                <input type="text" id='edit_descripcion' name="descripcion" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-5 col-xl-6">
                            <div class="mb-3">
                                <label for="">Precio</label>
                                <input class="form-control" type="number" id="edit_precio" name="precio" placeholder="$">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="">Observaciones</label>
                                <textarea id="edit_observaciones" name="observaciones" id="" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                            <label class="form-label" for="">Estudio</label>
                            <select id='edit_estudio' class="js-example-basic-single form-select" data-width="100%">
                            </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>Clave</th>
                                            <th>Descripción</th>
                                            <th>Condiciones</th>
                                            <th><i class="mdi mdi-wrench"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody id='edit_listEstudios'>
    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> --}}
                    <button  type="submit" class="btn btn-primary">Actualizar cambios</button>
                </form>
                {{-- <button class="btn btn-secondary">Cancel</button> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar modal</button>
                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>
{{-- Agregar editar estudios de perfil --}}
<div class="modal fade" id="asignarModal" tabindex="-1" aria-labelledby="asignarModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="asignarModalLabel">Asignar estudios a perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="edit_estudios" class="forms-sample" action="#">
                    <input type="hidden" id="identificador" name="identificador" class="form-control">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                            <label class="form-label" for="">Estudio</label>
                            <select id='edit_estudio' class="js-example-basic-multiple form-select" multiple='multiple' data-width="100%">
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>Clave</th>
                                            <th>Descripción</th>
                                            <th>Condiciones</th>
                                            <th><i class="mdi mdi-wrench"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody id='edit_listEstudios'>
    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <button  onclick="guardarEstudios()" type="submit" class="btn btn-primary">Actualizar cambios</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar modal</button>
            </div>
        </div>
    </div>
</div>
@endsection



@push('plugin-scripts')
<script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/axios/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush


@push('custom-scripts')
<script src="{{ asset('public/stevlab/catalogo/perfiles/select2.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/perfiles/form-validation.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/perfiles/functions.js') }}?v=<?php echo rand();?>"></script>

@endpush