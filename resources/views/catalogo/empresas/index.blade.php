@extends('layout.master')

@push('plugin-styles') 
<link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush


@section('content') 
{{-- Inicio breadcrumb caja --}}
<nav class="page-breadcrumb"> 
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
        <li class="breadcrumb-item active" aria-current="page"> <a href="">Catalogo</a> </li>
        <li class="breadcrumb-item active" aria-current="page"> <a href="">Empresas</a> </li>
    </ol>
</nav>

{{-- Fin breadcrumb recepcion --}}
{{-- Inicia panel's detalle --}}
{{-- @dd(Auth::user()->first()) --}}

<!------------------------------------------------------------------------------------------------>
<div class="row">
    @if (session('msg'))
        <div class="alert alert-warning">
            {{ session('msg') }}
        </div>
    @endif
</div>
@if (session('msj'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <i data-feather="alert-circle"></i>
            <strong>Aviso!</strong> {{ session('msj') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
@endif
<div class="row">
    @can('crear_empresas')
        <div class="col-md-6 stretch-card">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('stevlab.catalogo.empresa_guardar')}}" enctype="multipart/form-data">
                        @csrf 
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Clave</label>
                                    <input class="form-control @error('clave') is-invalid @enderror" name="clave" value="{{old('clave')}}"type="text" placeholder="Clave">
                                    @error('clave')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-sm-7">
                                <div class="mb-3">
                                    <label class="form-label">RFC</label>
                                    <input class="form-control" name="rfc" value="" type="text" placeholder="RFC">
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <div class="col-lg-3">
                                        <label class="form-label">Nombre</label>
                                    </div>
                                    <div class="col-lg-15">
                                        <textarea id="maxlength-textarea" class="form-control" id="defaultconfig-4" maxlength="500" rows="1" name="descripcion" placeholder="Nombre de la empresa"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Calle</label>
                                    <input class="form-control" name="calle" value="" type="text" placeholder="Calle">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Colonia</label>
                                    <input type="text" class="form-control" name="colonia" value="" placeholder="Colonia">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Ciudad</label>
                                    <input type="text" class="form-control" name="ciudad" value="" placeholder="Ciudad">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input class="form-control" name="email" value="" type="email" placeholder="Correo Electronico">
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Telefono</label>
                                    <input type="number" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{old('telefono')}}" placeholder="Télefono">
                                    @error('telefono')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Contacto</label>
                                    <input type="text" class="form-control @error('contacto') is-invalid @enderror" name="contacto" value="{{old('contacto')}}" placeholder="Contacto">
                                    @error('contacto')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Lista de precio</label>
                                    <select name="lista_precio" id="lista_precio" class="form-select js-example-basic-multiple" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" onclick="showSwal('mixin')" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    @endcan
    <div class="col-md-6 m-md-block">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTableExample" class="table">
                        <thead>
                            <tr>
                                <th>Clave</th>
                                <th>Empresa</th>
                                <th>Contacto</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empresas as $empresa)
                            <tr>
                                <td class="data">{{$empresa->clave}}</td>
                                <td>{{$empresa->descripcion}}</td>
                                <td>{{$empresa->contacto}}</td>
                                <td>
                                    @can('editar_empresas')
                                        <button onclick='mostrarModal(this)' type="button" class="btn btn-xs btn-icon btn-success">
                                            <i data-feather="edit"></i></a>
                                        </button>
                                    @endcan
                                    
                                    @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
                                        @if ($empresa->users()->first() !== null)
                                            @can('editar_usuarios')
                                                <a type='button' href="{{route('stevlab.catalogo.edit-user-empresa', $empresa->id)}}" class='btn btn-xs btn-secondary btn-icon'>
                                                    <i data-feather='user-check'></i>
                                                </a>
                                            @endcan
                                        @else
                                            @can('crear_usuarios')
                                                <a type='button' href="{{route('stevlab.catalogo.upload-empresa', $empresa->id)}}" class='btn btn-xs btn-info btn-icon'>
                                                    <i data-feather='users'></i>
                                                </a>
                                            @endcan
                                        @endif
                                        
                                    @endif

                                    @can('eliminar_empresas')
                                        <a type='button' href="{{route('stevlab.catalogo.empresa-eliminar', $empresa->id)}}"  class='btn btn-xs btn-danger btn-icon'>
                                            <i data-feather='trash'></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-----------modal------------------------------------------------------------------------------->
<div class="modal fade bd-example-modal-lg" id="modalEditar" tabindex="-1" aria-labelledby="modalEditar" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditar">Editar empresas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            
            <div class="modal-body">
                <form id="edit_empresa">
                    @csrf
                    <input class="form-control" name="id" value="" type="hidden" id="id">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Clave</label>
                                <input class="form-control" name="clave" value=""type="text" id="clave">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label">RFC</label>
                                <input class="form-control" name="rfc" value="" type="text" id="rfc">
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="mb-3">
                                <div class="col-lg-3">
                                    <label class="form-label">Descripcion</label>
                                </div>
                                <div class="col-lg-15">
                                    <textarea  class="form-control" id="descripcion" maxlength="500" rows="1" name="descripcion"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Calle</label>
                                <input class="form-control" name="calle" value="" type="text" id="calle">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label">Colonia</label>
                                <input type="text" class="form-control" name="colonia" value="" id="colonia">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label">Ciudad</label>
                                <input type="text" class="form-control" name="ciudad" value="" id="ciudad">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input class="form-control" name="email" value="" type="email" id="email">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label">Telefono</label>
                                <input type="number" class="form-control" name="telefono" value="" id="telefono">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label">Contacto</label>
                                <input type="text" class="form-control" name="contacto" value="" id="contacto">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label">Lista de precio a asignar</label>
                                <select name="lista_precio" id="lista_precio_edit" class="form-select js-example-basic-multiple" multiple="multiple" data-width='100%'>
                                    {{-- <option value="1" selected="selected">Particular</option> --}}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success">Actualizar</button>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!---------------------------------------------------------------------------------------------->
@endsection

@push('plugin-scripts')
<script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>


@endpush

@push('custom-scripts')
<script src="{{ asset('public/stevlab/catalogo/empresas/form-validation.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/empresas/functions.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/empresas/sweet-alert.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/empresas/select2.js') }}?v=<?php echo rand();?>"></script>
@endpush