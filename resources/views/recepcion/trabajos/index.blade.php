@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="{{route('stevlab.captura.listas')}}">Listas de trabajo</a> </li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="d-md-block col-md-8 col-lg-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Busqueda de solicitudes</h6>
                    <form id='formJob'>
                        @csrf
                        <div class="row">
                            <div class="col-md-4 col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Fecha inicial</label>
                                    <div class="input-group date datepicker consultaEstudios" style="padding: 0">
                                        <input type="text" class="form-control" name="selectInicio" id="selectInicio" data-date-end-date="0d">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Fecha final</label>
                                    <div class="input-group date datepicker consultaEstudios" style="padding: 0">
                                        <input type="text" class="form-control" name="selectFinal" id="selectFinal"  data-date-end-date="0d">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Sucursal</label>
                                    <select class="form-select consultaEstudios" name="selectSucursal" id="selectSucursal">
                                        <option selected value="todo">Todos</option>
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{$sucursal->id}}">{{$sucursal->sucursal}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-2">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label class="form-label">Area</label>
                                        <select class="form-select consultaEstudios" name="selectArea" id="selectArea">
                                            <option selected value="todo">Todos</option>
                                            @foreach ($areas as $area)
                                                <option value="{{$area->id}}">{{$area->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-lg-2">
                                <div class="mb-3">
                                    <button id='sending' type="submit" class="btn btn-xs btn-success">
                                        {{-- <i class="mdi mdi-search"></i> --}}
                                        <span id='search' class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                                        Generar reporte
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!---------------------------------------------- NUEVO PACIENTE------------------------------------------------------>

<!---------------------------------------------- NUEVO MEDICO------------------------------------------------------>

@endsection

@push('plugin-scripts')
    <script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/ckeditor5-build-classic/ckeditor.js')}}" ></script>

@endpush

@push('custom-scripts')
    <script src="{{ asset('public/stevlab/recepcion/trabajos/datepicker.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/recepcion/trabajos/form-validation.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/recepcion/trabajos/functions.js') }}?v=<?php echo rand();?>"></script>
    {{-- <script src="{{ asset('public/stevlab/recepcion/prefolios/functions.js') }}"></script>
    <script src="{{ asset('public/stevlab/recepcion/prefolios/select2.js') }}"></script>
    <script src="{{ asset('public/stevlab/recepcion/prefolios/form-validation.js') }}"></script>
    <script src="{{ asset('public/stevlab/recepcion/prefolios/datepicker.js') }}"></script>
    <script src="{{ asset('public/stevlab/recepcion/prefolios/ckeditor.js') }}"></script> --}}
@endpush