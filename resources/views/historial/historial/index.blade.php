@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item"> <a href="#">Historial</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pacientes</li>
        </ol>
    </nav>

    <div class="row">
        <div class="d-md-block col-md-12 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Buscar</h6>
                        <div class="row">
                            <div class="col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Folio</label>
                                    <input onkeyup="searchPatient(this)" type="number" class="form-control" id="folio" name="folio" placeholder="folio">
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Paciente</label>
                                    <select name="paciente[]" id="paciente" class="form-select js-example-basic-multiple" multiple="multiple"  data-width="100%">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12 ">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-danger btn-xs btn-icon"><i class="mdi mdi-delete-sweep"></i></button>
                                </div>
                            </div>  
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Resultados</h6>
                    <div class="table-responsive-md">
                        <table id='dataTableFolio' class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Paciente</th>
                                    <th>Sucursal</th>
                                    <th>Empresa</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody id='listFolios'>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>

@endpush

@push('custom-scripts')
    {{-- <script src="{{ asset('public/stevlab/reportes/arqueo/datepicker.js') }}"></script> --}}
    <script src="{{ asset('public/stevlab/historial/historial/select2.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/historial/historial/functions.js') }}?v=<?php echo rand();?>"></script>

@endpush
