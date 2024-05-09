@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />

@endpush
@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Almacen </li>
            <li class="breadcrumb-item active" aria-current="page"> Inventarios </li>
        </ol>
    </nav>

    @if (session('status') == 'Debes aperturar caja antes de empezar a trabajar.')

        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
            <i data-feather="alert-circle"></i>
            <strong>Aviso!</strong> {{ session('status') }} <a href="{{route('stevlab.caja.index')}}" class="alert-link">Click aquí</a>. 
        </div>

    @elseif(session('status')== 'Caja cerrada automáticamente...')

        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
            <i data-feather="alert-circle"></i>
            <strong>Aviso!</strong> {{ session('status') }} <a href="{{route('stevlab.caja.index')}}" class="alert-link">Click aquí</a> 
        </div>

    @else
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

        {{-- @if(session('msj'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('msj') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            </div>
        @endif --}}
        <div id='notifications' class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none">
            <ul id='errors'>
            </ul>
            <button type="button" class="btn-close" aria-label="btn-close"></button>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Consulta</h4>
                        <div class="row mb-3">
                            <div class="col-md-12 col-lg-6">
                                <label for="folio" class="form-label">Folio</label>
                                <select name="folio" id="folio" class="js-example-basic-multiple form-select consultaSolicitudes" multiple='multiple' data-width="100%">
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Fecha inicial</label>
                                    <div class="input-group date datepicker consultaSolicitudes" style="padding: 0">
                                        <input type="text" class="form-control" id="selectInicio">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Fecha final</label>
                                    <div class="input-group date datepicker consultaSolicitudes" style="padding: 0">
                                        {{-- data-date-end-date="0d" --}}
                                        <input type="text" class="form-control" id="selectFinal" >
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Estado del folio</label>
                                    <select class="form-select consultaSolicitudes" id="selectEstado">
                                        <option selected value="todo">Todos</option>
                                        <option value="pending">Pendientes</option>
                                        <option value="approved">Aprobados</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3">
                                <div class="mb-3 mt-4">
                                    <input id='search' class="btn btn-primary search" type="submit" value="Buscar">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 d-md-block grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Reporte de movimientos</h4>
                        <div class="mb-3">
                            <div class="table-responsive">
                                <table id="dataTableMovimientos" class="table table-sm table-hover nowrap" width="100%">
                                    <thead>
                                        <tr> 
                                            <th>Clave</th>
                                            <th>Descripción</th>
                                            <th>Ubicación</th>
                                            <th>Cantidad</th>
                                            <th>Usuario que solicita</th>
                                            <th>Usuario que aprueba</th>
                                            <th>Fecha</th>
                                            {{-- <th>Acciones</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center">
                                    {{-- {{ $articulos->links() }} --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
{{-- <th>#</th> --}}
{{-- <th>Cantidad</th> --}}
{{-- <th>Usuario que solicita</th> --}}
{{-- <th>Usuario que aprueba</th> --}}
{{-- <th>Estado</th> --}}
    @endif

@endsection

@push('plugin-scripts')
    <script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('public/stevlab/almacen/movimientos/functions.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/almacen/movimientos/data-table.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/almacen/movimientos/select2.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/almacen/movimientos/datepicker.js') }}?v=<?php echo rand();?>"></script>
@endpush