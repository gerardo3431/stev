@extends('layout.master')

@push('plugin-styles') 
<link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush


@section('content')
{{-- Inicio breadcrumb caja --}}
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
        <li class="breadcrumb-item active" aria-current="page"> <a href="">Catalogo</a> </li>
        <li class="breadcrumb-item active" aria-current="page"> <a href="">Doctores</a> </li>
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
@if (session('msj'))
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <i data-feather="alert-circle"></i>
            <strong>Aviso!</strong> {{ session('msj') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
@else
@endif
</div>
    <div class="row">
        @can('crear_doctores')
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">

                        <form method="post" action="{{route('stevlab.catalogo.doctores_guardar')}}">
                        @csrf  

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                <label class="form-label">Clave</label>
                                <input class="form-control @error('clave') is-invalid @enderror" name="clave" value="{{old('clave')}}"type="text">
                                @error('clave')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="mb-3">
                                <label class="form-label">Nombre completo</label>
                                <input class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{old('nombre')}}" type="text">
                                @error('nombre')
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
                            <label class="form-label">Telefono</label>
                            <input type="number" class="form-control" name="telefono" value="{{old('telefono')}}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Celular</label>
                                <input type="number" class="form-control" name="celular" value="{{old('celular')}}">
                            </div>
                            </div>
                            
                        </div>
                        <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{old('email')}}">
                            </div>
                        </div>
                        </div>
                        <button type="submit" onclick="showSwal('mixin')" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div> 
            </div>
        @endcan
        <div class="col-md-6  stretch-card grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                <th>Clave</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctores as $doctor)
                                <tr>
                                    <td class="data">{{$doctor->clave}}</td>
                                    <td>{{$doctor->nombre}}</td>
                                    <td>
                                        <a onclick='mostrarModal(this)' type="button" class="btn btn-xs btn-success btn-icon"><i data-feather="edit"></i></a>
                                        <a type="button" class="btn btn-xs btn-danger btn-icon" href="{{ route('stevlab.catalogo.doctor_eliminar',$doctor->id) }}"><i data-feather="trash-2"></i></a>
                                        @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
                                            @if ($doctor->user()->first() !== null)
                                                @can('editar_usuarios')
                                                    <a type='button' href="{{route('stevlab.catalogo.edit-user-doctor', $doctor->id)}}" class='btn btn-xs btn-secondary btn-icon'>
                                                        <i data-feather='user-check'></i>
                                                    </a>
                                                @endcan
                                            @else
                                                @can('crear_usuarios')
                                                    <a type='button' href="{{route('stevlab.catalogo.upload-doctor', $doctor->id)}}" class='btn btn-xs btn-info btn-icon'>
                                                        <i data-feather='users'></i>
                                                    </a>
                                                @endcan
                                            @endif
                                        @endif
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

<!----------------------------Tabla--------------------------------------------------------------->
<div class="row">
    
</div>
<!-----------modal------------------------------------------------------------------------------>
<!-- Button trigger modal -->

<!-- Modal editar-->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditar" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="modalEditar">Editar doctores</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
    </div>
    <div class="modal-body">
        <form action="{{route('stevlab.catalogo.doctor_actualizar')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-sm-4">
                <input class="form-control" id='id' name="id" value="" type="hidden">
            <div class="mb-3">
                <label class="form-label">Clave</label>
                <input class="form-control" id='clave' name="clave" value="" type="text">
            </div>
            </div>
            <div class="col-sm-8">
            <div class="mb-3">
                <label class="form-label">Nombre completo</label>
                <input class="form-control" name="nombre" value="" type="text" id="nombre">
            </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label">Telefono</label>
                <input type="number" class="form-control" name="telefono" value="" id="telefono">
            </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                <label class="form-label">Celular</label>
                <input type="number" class="form-control" name="celular" value="" id="celular">
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-sm-12">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="" id="email">
            </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </div>
    
    </form>
    </div>
</div>
</div>
<!------------------------------------------------------------------------------------------------>
@endsection

@push('plugin-scripts')
<script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('public/assets/js/data-table.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/doctores/functions.js') }}?v=<?php echo rand();?>"></script>
@endpush





