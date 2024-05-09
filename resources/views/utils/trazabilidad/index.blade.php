@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />

@endpush

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
        <li class="breadcrumb-item"> <a href="#">Utils</a></li>
        <li class="breadcrumb-item active" aria-current="page">Trazabilidad</li>
    </ol>
</nav>

@if (session('msj'))

<div class="alert alert-secondary alert-dismissible fade show" role="alert">
    <i data-feather="alert-circle"></i>
    <strong>Aviso!</strong> {{ session('msj') }} 
</div>
@endif
<div class="row">
    <div class="d-md-block col-md-12 col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Busqueda</h4>
                <div class="row">
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Usuario</label>
                            <select class="form-select consultaFechas" id="selectUsuario">
                                <option selected value="todo">Todos</option>
                                @foreach ($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Fecha inicial</label>
                            <div class="input-group date datepicker consultaFechas" style="padding: 0">
                                <input type="text" class="form-control" id="selectInicio" data-date-end-date="0d">
                                <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-4">
                        <div class="mb-3">
                            <label class="form-label">Fecha final</label>
                            <div class="input-group date datepicker consultaFechas" style="padding: 0">
                                <input type="text" class="form-control" id="selectFinal"  data-date-end-date="0d">
                                <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-md-block col-md-12 col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Historial de acciones</h4>
                <div class="mb-3">
                    <div class="table-responsive">
                        <table id="dataTableTrazabilidad" class="table table-sm table-hover nowrap" width="100%">
                            <thead>
                                <tr> 
                                    <th>Nombre log</th>
                                    <th>Descripcion</th>
                                    <th>Modelo Objetivo</th>
                                    <th>Modelo id</th>
                                    <th>Usuario</th>
                                    <th>Usuario id</th>
                                    <th>Propiedades</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            {{-- {{$folios->links()}} --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-comentarios" tabindex="-1" aria-labelledby="modal-comentarios-label" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">Comentarios acerca del folio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body" >
                <ul id='bloqueComentarios'></ul>

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
    <script src="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/ckeditor5-build-classic/ckeditor.js')}}" ></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('public/stevlab/utils/trazabilidad/datepicker.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/utils/trazabilidad/functions.js') }}?v=<?php echo rand();?>"></script>

@endpush
