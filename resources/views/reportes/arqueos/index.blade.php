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
            <li class="breadcrumb-item"> <a href="#">Reportes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Arqueos</li>
        </ol>
    </nav>

    <div class="row">
        <div class="d-md-block col-md-12 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Arqueo</h6>
                    <form action="{{route('stevlab.reportes.make-reporte')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Sucursal</label>
                                    <select class="form-select consultaReportes" name="sucursal" id="selectSucursal">
                                        <option selected value="todo">Todos</option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}">{{$sucursal->sucursal}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Empresa</label>
                                    <select class="form-select consultaReportes" name="empresa" id="selectEmpresa">
                                        <option selected value="todo">Todos</option>
                                        @foreach ($empresas as $empresa)
                                            <option value="{{$empresa->id}}">{{$empresa->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Doctores</label>
                                    <select class="form-select consultaReportes" name="doctor" id="selectDoctor">
                                        <option selected value="todo">Todos</option>
                                        @foreach ($doctores as $doctor)
                                                <option value="{{$doctor->id}}">{{$doctor->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label class="form-label">Usuarios</label>
                                        <select class="form-select consultaReportes" name="usuario" id="selectUsuario">
                                            <option selected value="todo">Todos</option>
                                            @foreach ($usuarios as $usuario)
                                                <option value="{{$usuario->id}}">{{$usuario->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Fecha inicial</label>
                                    <div class="input-group date datepicker consultaReportes" style="padding: 0">
                                        <input type="text" class="form-control" name="inicio" id="selectInicio" data-date-end-date="0d">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Fecha final</label>
                                    <div class="input-group date datepicker consultaReportes" style="padding: 0">
                                        <input type="text" class="form-control" name="final" id="selectFinal" data-date-end-date="0d" >
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary">Generar reporte</button>
                                </div>
                            </div>  
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Resultados --}}

@endsection


@push('plugin-scripts')
<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
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
    <script src="{{ asset('public/stevlab/reportes/arqueo/datepicker.js') }}?v=<?php echo rand();?>"></script>

@endpush
