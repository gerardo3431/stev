@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('public/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />

@endpush
{{-- <img src="data:image/jpg;base64, {{$membrete}}" alt=""> --}}
@section('content')
{{-- Inicio breadcrumb caja --}}
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Dashboard </li>
    </ol>
</nav>
@if (session('status'))

    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
        <i data-feather="alert-circle"></i>
        <strong>Aviso!</strong> {{ session('status') }} <a href="{{route('stevlab.caja.index')}}" class="alert-link">Click aquí</a>. 
    </div>
@else
    {{-- @dd(active_class()) --}}
    {{-- @dd(active_class('stevlab.dashboard')) --}}
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <i data-feather="alert-circle"></i>
        <strong>Aviso!</strong> Caja en uso.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
    </div>

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Bienvenido al inicio</h4>
        </div>
    </div>
    {{-- @dd(url()->current()) --}}
    @can('ver_tiles')
        @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
            <div class="row text-white">
                <div class="col-12 col-xl-12 stretch-card">
                    <div class="row flex-grow-1">
                        <div class="col-sm-4 col-md-4 col-lg-4 grid-margin stretch-card">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">Solicitudes</h6>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h3 class="mb-2">{{$solicitudes}}</h3>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="customersChart" class="mt-md-3 mt-xl-0">
                                                <i data-feather="file" class="icon-xl"></i> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4 grid-margin stretch-card">
                            <div class="card bg-danger">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">Solicitudes pendientes</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h3 class="mb-2">{{$solicitudes_pend}}</h3>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="growthChart" class="mt-md-3 mt-xl-0">
                                                <i data-feather="file-minus" class="icon-xl"></i> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4 grid-margin stretch-card">
                            <div class="card bg-success">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">Solicitudes validados</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h3 class="mb-2">{{$solicitudes_vali}}</h3>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="ordersChart" class="mt-md-3 mt-xl-0">
                                                <i data-feather="file-plus" class="icon-xl"></i> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div> <!-- row -->


            <div class="row text-white">
                <div class="col-12 col-xl-12 stretch-card">
                    <div class="row flex-grow-1">
                        <div class="col-sm-4 col-md-4 col-lg-4 grid-margin stretch-card">
                            <div class="card bg-primary">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">Ingresos</h6>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h3 class="mb-2">$ {{$ingreso}}</h3>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="customersChart" class="mt-md-3 mt-xl-0">
                                                {{-- bar-chart --}}
                                                <i data-feather="bar-chart" class="icon-xl"></i> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4 grid-margin stretch-card">
                            <div class="card bg-danger">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">Egresos</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h3 class="mb-2">$ {{$egreso}}</h3>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="ordersChart" class="mt-md-3 mt-xl-0">
                                                <i data-feather="bar-chart-2" class="icon-xl"></i> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4 grid-margin stretch-card">
                            <div class="card bg-success">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                        <h6 class="card-title mb-0">Ganancias</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <h3 class="mb-2">$ {{$balance}}</h3>
                                        </div>
                                        <div class="col-sm-4">
                                            <div id="growthChart" class="mt-md-3 mt-xl-0">
                                                {{-- bar-chart-2 --}}
                                                <i data-feather="bar-chart-2" class="icon-xl"></i> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- row -->
        @endif

        <div class="row {{ (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == "completo") ? "text-white" : "" }}">
            <div class="col-12 col-xl-12 stretch-card">
                <div class="row flex-grow-1">
                    <div class="col-sm-4 col-md-4 col-lg-4 grid-margin stretch-card">
                        <div class="card {{ (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == "completo") ? "bg-primary" : "" }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Estudios solicitados</h6>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h3 class="mb-2">{{$solicitados}}</h3>
                                    </div>
                                    <div class="col-sm-4">
                                        <div id="customersChart" class="mt-md-3 mt-xl-0">
                                            <i data-feather="plus" class="icon-xl"></i> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4 grid-margin stretch-card">
                        <div class="card {{ (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == "completo") ? "bg-success" : "" }} ">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Estudios validados</h6>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h3 class="mb-2">{{$validados}}</h3>
                                    </div>
                                    <div class="col-sm-4">
                                        <div id="growthChart" class="mt-md-3 mt-xl-0">
                                            <i data-feather="check" class="icon-xl"></i> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4 grid-margin stretch-card">
                        <div class="card {{ (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == "completo") ? "bg-secondary" : "" }}">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Estudios capturados</h6>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h3 class="mb-2">{{$capturados}}</h3>
                                    </div>
                                    <div class="col-sm-4">
                                        <div id="ordersChart" class="mt-md-3 mt-xl-0">
                                            <i data-feather="edit-2" class="icon-xl"></i> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div> <!-- row -->
    @endcan

    @can('ver_listas')
        <div class="row">
            <div class="col-sm-6 col-md-6 grid-margin stretch-card">
                <div class="card rounded">
                    <div class="card-body">
                        <h6 class="card-title">10 más solicitados</h6>
                        @forelse ($mostWanted as $key=>$estudio)
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    {{-- <i class="img-xs rounded-circle"></i>  --}}
                                    {{-- <img class="img-xs rounded-circle" src="{{ url('https://via.placeholder.com/37x37') }}" alt="">													 --}}
                                    <div class="ms-2">
                                        <p>{{$key+1}} - {{$estudio->descripcion}}</p>
                                        <p class="tx-11 text-muted">{{$estudio->clave}}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            
                        @endforelse
                        
                    </div>
                </div>
            </div>
    
            <div class="col-sm-6 col-md-6 grid-margin stretch-card">
                <div class="card rounded">
                    <div class="card-body">
                        <h6 class="card-title">10 menos solicitados</h6>
                        @forelse ($leastWanted as $key=>$estudio)
                            <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                <div class="d-flex align-items-center hover-pointer">
                                    {{-- <i class="img-xs rounded-circle"></i>  --}}
                                    {{-- <img class="img-xs rounded-circle" src="{{ url('https://via.placeholder.com/37x37') }}" alt="">													 --}}
                                    <div class="ms-2">
                                        <p>{{$key+1}} - {{$estudio->descripcion}}</p>
                                        <p class="tx-11 text-muted">{{$estudio->clave}}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('ver_graficas')
        <div class="row">
            <div class="col-sm-12 col-lg-6 col-xl-6 grid-margin stretch-card">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                            <h6 class="card-title mb-0">Pacientes</h6>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="patientsChart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6 col-xl-6 grid-margin stretch-card">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                            <h6 class="card-title mb-0">Solicitudes</h6>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div id="solicitudesChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- row -->
        
        <div class="row">
            <div class="col-12 col-xl-12 grid-margin stretch-card">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                            <h6 class="card-title mb-0">Ingresos</h6>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="eye" class="icon-sm me-2"></i> <span class="">View</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="edit-2" class="icon-sm me-2"></i> <span class="">Edit</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="trash" class="icon-sm me-2"></i> <span class="">Delete</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="printer" class="icon-sm me-2"></i> <span class="">Print</span></a>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i data-feather="download" class="icon-sm me-2"></i> <span class="">Download</span></a>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-start mb-2">
                            <div class="col-md-7">
                                <p class="text-muted tx-13 mb-3 mb-md-0">Los ingresos son los ingresos que una empresa tiene de sus actividades comerciales normales, generalmente de la venta de bienes y servicios a los clientes.</p>
                            </div>
                            <div class="col-md-5 d-flex justify-content-md-end">
                                <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
                                    <button data-id="today" onclick="muestraGrafica(this)" type="button" class="btn-charts btn btn-primary">Hoy</button>
                                    @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
                                        <button data-id="week" onclick="muestraGrafica(this)" type="button" class="btn-charts btn btn-outline-primary d-none d-md-block">Semana</button>
                                        <button data-id="month" onclick="muestraGrafica(this)" type="button" class="btn-charts btn btn-outline-primary">Mes</button>
                                        <button data-id="period" onclick="muestraGrafica(this)" type="button" class="btn-charts btn btn-outline-primary">Periodo</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="charts" id="todayChart">
                            {!! $chartToday->container() !!}
                            <script src="{{ $chartToday->cdn() }}"></script>
                            {{ $chartToday->script() }}
                        </div>
                        @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
                            <div class="charts" id="weekChart" style="display:none">
                                {{-- {!! $chartWeek->container() !!}
                                <script src="{{ $chartWeek->cdn() }}"></script>
                                {{ $chartWeek->script() }} --}}
                            </div>
                            <div class="charts" id="monthChart" style="display:none">
                                <div class="row">
                                    <div id="monthChartResponse"></div>
                                </div>
                            </div>
                            <div class="charts" id="periodChart" style="display:none">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="">Fecha inicial</label>
                                            <div class="input-group date datepicker" style="padding: 0;">
                                                <input type="text" class="form-control fecha_chart_period" id="fecha_inicial" name="fecha_inicial" data-date-end-date="0d">
                                                <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="">Fecha final</label>
                                            <div class="input-group date datepicker" style="padding: 0;">
                                                <input type="text" class="form-control fecha_chart_period" id="fecha_final" name="fecha_final" data-date-end-date="0d">
                                                <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="periodChartResponse"></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div> <!-- row -->
    @endcan



@endif

@endsection

@push('plugin-scripts')
<script src="{{ asset('public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/moment/moment.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('public/stevlab/dashboard/dashboard.js') }}"></script>
<script src="{{ asset('public/stevlab/dashboard/datepicker.js') }}"></script>
<script src="{{ asset('public/stevlab/dashboard/functions.js') }}"></script>

@endpush