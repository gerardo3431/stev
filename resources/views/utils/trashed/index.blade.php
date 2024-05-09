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
        <li class="breadcrumb-item active" aria-current="page">Papeleria de reciclaje</li>
    </ol>
</nav>
@if (session('msj'))

<div class="alert alert-secondary alert-dismissible fade show" role="alert">
    <i data-feather="alert-circle"></i>
    <strong>Aviso!</strong> {{ session('msj') }} 
</div>
@endif
<div class="row">
    <div class="mb-3">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="folio-tab" data-bs-toggle="tab" data-bs-target="#folio" role="tab" aria-controls="folio" aria-selected="true">folio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="paciente-tab" data-bs-toggle="tab" data-bs-target="#paciente" role="tab" aria-controls="paciente" aria-selected="false">paciente</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="doctores-tab" data-bs-toggle="tab" data-bs-target="#doctores" role="tab" aria-controls="doctores" aria-selected="false">doctores</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="estudios-tab" data-bs-toggle="tab" data-bs-target="#estudios" role="tab" aria-controls="estudios" aria-selected="true">estudios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="analitos-tab" data-bs-toggle="tab" data-bs-target="#analitos" role="tab" aria-controls="analitos" aria-selected="false">analitos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="listas-tab" data-bs-toggle="tab" data-bs-target="#listas" role="tab" aria-controls="listas" aria-selected="false">listas</a>
            </li>
        </ul>
        <div class="tab-content border border-top-0 p-3" id="myTabContent">
            <div class="tab-pane fade show active" id="folio" role="tabpanel" aria-labelledby="folio-tab">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tabla de folios cancelados</h4>
                        <div class="mb-3">
                            <div class="table-responsive">
                                <table id="dataTableEstudios" class="table table-sm table-hover nowrap" width="100%">
                                    <thead>
                                        <tr> 
                                            <th>#</th>
                                            <th>Folio</th>
                                            <th>Paciente</th>
                                            <th>Empresa</th>
                                            <th>Fecha (Borrado)</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($folios as $key=>$item)
                                            <tr>
                                                <td style="white-space: pre-wrap">{{$item->id}}</td>
                                                <td style="white-space: pre-wrap">{{$item->folio}}</td>
                                                <td style="white-space: pre-wrap">{{($item->paciente()->first()) ? $item->paciente()->first()->nombre : 'Paciente eliminado'}}</td>
                                                <td style="white-space: pre-wrap">{{($item->empresas()->first()) ? $item->empresas()->first()->descripcion : 'Empresa eliminada'}}</td>
                                                <td style="white-space: pre-wrap">{{$item->deleted_at}}</td>
                                                <td >
                                                    <a href='{{route('stevlab.utils.trash-restore-folio', $item->id)}}' class='btn  btn-xs btn-icon btn-success' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Restaurar folio"><i class="mdi mdi-backup-restore"></i> </a>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                                {{$folios->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="paciente" role="tabpanel" aria-labelledby="paciente-tab">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tabla de pacientes eliminados</h4>
                        <div class="mb-3">
                            <div class="table-responsive">
                                <table id="dataTableEstudios" class="table table-sm table-hover nowrap" width="100%">
                                    <thead>
                                        <tr> 
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Empresa</th>
                                            <th>Fecha (Borrado)</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pacientes as $key=>$paciente)
                                        <tr>
                                            <td style="white-space: pre-wrap">{{$paciente->id}}</td>
                                            <td style="white-space: pre-wrap">{{$paciente->nombre}}</td>
                                            <td style="white-space: pre-wrap">{{($paciente->empresas()->first()) ? $paciente->empresas()->first()->descripcion : 'Empresa eliminada'}}</td>
                                            <td style="white-space: pre-wrap">{{$paciente->deleted_at}}</td>
                                            <td>
                                                <a href='{{route('stevlab.utils.trash-restore-patient', $paciente->id)}}' class='btn  btn-xs btn-icon btn-success' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Restaurar paciente"><i class="mdi mdi-backup-restore"></i> </a>
                                            </td>
                                        </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                    
                                </table>
                                {{$pacientes->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="doctores" role="tabpanel" aria-labelledby="doctores-tab">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tabla de doctores eliminados</h4>
                        <div class="mb-3">
                            <div class="table-responsive">
                                <table id="dataTableEstudios" class="table table-sm table-hover nowrap" width="100%">
                                    <thead>
                                        <tr> 
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Fecha (Borrado)</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($doctores as $key => $doctor)
                                            <tr>
                                                <td style="white-space: pre-wrap">{{$doctor->id}}</td>
                                                <td style="white-space: pre-wrap">{{$doctor->nombre}}</td>
                                                <td style="white-space: pre-wrap">{{$doctor->deleted_at}}</td>
                                                <td>
                                                    <a href='{{route('stevlab.utils.trash-restore-doctor', $doctor->id)}}' class='btn  btn-xs btn-icon btn-success' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Restaurar doctor"><i class="mdi mdi-backup-restore"></i> </a>
                                                </td>
                                            </tr>
                                        @empty
                                            
                                        @endforelse
                                    </tbody>
                                </table>
                                {{$doctores->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="estudios" role="tabpanel" aria-labelledby="estudios-tab">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tabla de estudios eliminados</h4>
                        <div class="mb-3">
                            <div class="table-responsive">
                                <table id="datatableEstudios" class="table table-sm table-hover nowrap" width="100%">
                                    <thead>
                                        <tr> 
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Fecha (Borrado)</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($estudios as $key => $estudio)
                                            <tr>
                                                <td style="white-space: pre-wrap">{{$estudio->id}}</td>
                                                <td style="white-space: pre-wrap">{{$estudio->clave}} - {{$estudio->descripcion}}</td>
                                                <td style="white-space: pre-wrap">{{$estudio->deleted_at}}</td>
                                                <td>
                                                    <a href='{{route('stevlab.utils.trash-restore-estudio', $estudio->id)}}' class='btn  btn-xs btn-icon btn-success' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Restaurar doctor"><i class="mdi mdi-backup-restore"></i> </a>
                                                </td>
                                            </tr>
                                        @empty
                                            
                                        @endforelse
                                    </tbody>
                                    
                                </table>
                                {{-- {{$estudios->appends(request()->except('_token'))->fragment('')->links()}} --}}
                                {{$estudios->links()}}
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="analitos" role="tabpanel" aria-labelledby="analitos-tab">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tabla de Analitos eliminados</h4>
                        <div class="mb-3">
                            <div class="table-responsive">
                                <table id="datatableEstudios" class="table table-sm table-hover nowrap" width="100%">
                                    <thead>
                                        <tr> 
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Fecha (Borrado)</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($analitos as $key => $analito)
                                            <tr>
                                                <td style="white-space: pre-wrap">{{$analito->id}}</td>
                                                <td style="white-space: pre-wrap">{{$analito->clave}} - {{$analito->descripcion}}</td>
                                                <td style="white-space: pre-wrap">{{$analito->deleted_at}}</td>
                                                <td>
                                                    <a href='{{route('stevlab.utils.trash-restore-analito', $analito->id)}}' class='btn  btn-xs btn-icon btn-success' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Restaurar doctor"><i class="mdi mdi-backup-restore"></i> </a>
                                                </td>
                                            </tr>
                                        @empty
                                            
                                        @endforelse
                                    </tbody>
                                    
                                </table>
                                
                                {{$analitos->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="listas" role="tabpanel" aria-labelledby="listas-tab">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Tabla de Listas de Precios eliminados</h4>
                        <div class="mb-3">
                            <div class="table-responsive">
                                <table id="datatableEstudios" class="table table-sm table-hover nowrap" width="100%">
                                    <thead>
                                        <tr> 
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Fecha (Borrado)</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($listas as $key => $lista)
                                            <tr>
                                                <td style="white-space: pre-wrap">{{$lista->id}}</td>
                                                <td style="white-space: pre-wrap">{{$lista->descripcion}}</td>
                                                <td style="white-space: pre-wrap">{{$lista->deleted_at}}</td>
                                                <td>
                                                    <a href='{{route('stevlab.utils.trash-restore-lista', $lista->id)}}' class='btn  btn-xs btn-icon btn-success' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Restaurar doctor"><i class="mdi mdi-backup-restore"></i> </a>
                                                </td>
                                            </tr>
                                        @empty
                                            
                                        @endforelse
                                    </tbody>
                                    
                                </table>
                                
                                {{$listas->links()}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
        {{-- <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de folios cancelados</h4>
                <div class="mb-3">
                    <div class="table-responsive">
                        <table id="dataTableEstudios" class="table table-sm table-hover nowrap" width="100%">
                            <thead>
                                <tr> 
                                    <th>#</th>
                                    <th>Folio</th>
                                    <th>Paciente</th>
                                    <th>Empresa</th>
                                    <th>Fecha (Borrado)</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($folios as $key=>$item)
                                    <tr>
                                        <td style="white-space: pre-wrap">{{$item->id}}</td>
                                        <td style="white-space: pre-wrap">{{$item->folio}}</td>
                                        <td style="white-space: pre-wrap">{{($item->paciente()->first()) ? $item->paciente()->first()->nombre : 'Paciente eliminado'}}</td>
                                        <td style="white-space: pre-wrap">{{($item->empresas()->first()) ? $item->empresas()->first()->descripcion : 'Empresa eliminada'}}</td>
                                        <td style="white-space: pre-wrap">{{$item->deleted_at}}</td>
                                        <td >
                                            <a href='{{route('stevlab.utils.trash-restore-folio', $item->id)}}' class='btn  btn-xs btn-icon btn-success' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Restaurar folio"><i class="mdi mdi-backup-restore"></i> </a>
                                        </td>
                                    </tr>
                                @empty
                                @endforelse
                            </tbody>
                        </table>
                        {{$folios->links()}}
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
        {{-- <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de pacientes eliminados</h4>
                <div class="mb-3">
                    <div class="table-responsive">
                        <table id="dataTableEstudios" class="table table-sm table-hover nowrap" width="100%">
                            <thead>
                                <tr> 
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Empresa</th>
                                    <th>Fecha (Borrado)</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pacientes as $key=>$paciente)
                                <tr>
                                    <td style="white-space: pre-wrap">{{$paciente->id}}</td>
                                    <td style="white-space: pre-wrap">{{$paciente->nombre}}</td>
                                    <td style="white-space: pre-wrap">{{($paciente->empresas()->first()) ? $paciente->empresas()->first()->descripcion : 'Empresa eliminada'}}</td>
                                    <td style="white-space: pre-wrap">{{$paciente->deleted_at}}</td>
                                    <td>
                                        <a href='{{route('stevlab.utils.trash-restore-patient', $paciente->id)}}' class='btn  btn-xs btn-icon btn-success' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Restaurar paciente"><i class="mdi mdi-backup-restore"></i> </a>
                                    </td>
                                </tr>
                                @empty
                                @endforelse
                            </tbody>
                            
                        </table>
                        {{$pacientes->links()}}
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    {{-- <hr> --}}
    <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
        {{-- <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de doctores eliminados</h4>
                <div class="mb-3">
                    <div class="table-responsive">
                        <table id="dataTableEstudios" class="table table-sm table-hover nowrap" width="100%">
                            <thead>
                                <tr> 
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Fecha (Borrado)</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($doctores as $key => $doctor)
                                    <tr>
                                        <td style="white-space: pre-wrap">{{$doctor->id}}</td>
                                        <td style="white-space: pre-wrap">{{$doctor->nombre}}</td>
                                        <td style="white-space: pre-wrap">{{$doctor->deleted_at}}</td>
                                        <td>
                                            <a href='{{route('stevlab.utils.trash-restore-doctor', $doctor->id)}}' class='btn  btn-xs btn-icon btn-success' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Restaurar doctor"><i class="mdi mdi-backup-restore"></i> </a>
                                        </td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>
                        </table>
                        {{$doctores->links()}}
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
        {{-- <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de estudios eliminados</h4>
                <div class="mb-3">
                    <div class="table-responsive">
                        <table id="datatableEstudios" class="table table-sm table-hover nowrap" width="100%">
                            <thead>
                                <tr> 
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Fecha (Borrado)</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($estudios as $key => $estudio)
                                    <tr>
                                        <td style="white-space: pre-wrap">{{$estudio->id}}</td>
                                        <td style="white-space: pre-wrap">{{$estudio->clave}} - {{$estudio->descripcion}}</td>
                                        <td style="white-space: pre-wrap">{{$estudio->deleted_at}}</td>
                                        <td>
                                            <a href='{{route('stevlab.utils.trash-restore-estudio', $estudio->id)}}' class='btn  btn-xs btn-icon btn-success' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Restaurar doctor"><i class="mdi mdi-backup-restore"></i> </a>
                                        </td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>
                            
                        </table>
                        {{$estudios->links()}}
                        
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
        {{-- <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de Analitos eliminados</h4>
                <div class="mb-3">
                    <div class="table-responsive">
                        <table id="datatableEstudios" class="table table-sm table-hover nowrap" width="100%">
                            <thead>
                                <tr> 
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Fecha (Borrado)</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($analitos as $key => $analito)
                                    <tr>
                                        <td style="white-space: pre-wrap">{{$analito->id}}</td>
                                        <td style="white-space: pre-wrap">{{$analito->clave}} - {{$estudio->descripcion}}</td>
                                        <td style="white-space: pre-wrap">{{$analito->deleted_at}}</td>
                                        <td>
                                            <a href='{{route('stevlab.utils.trash-restore-analito', $analito->id)}}' class='btn  btn-xs btn-icon btn-success' data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Restaurar doctor"><i class="mdi mdi-backup-restore"></i> </a>
                                        </td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>
                            
                        </table>
                        
                        {{$analitos->links()}}
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>

@endsection
@push('plugin-scripts')
    <script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    {{-- <script src="{{ asset('public/assets/js/axios.min.js') }}"></script> --}}
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
    <script src="{{ asset('public/stevlab/utils/maquila/dropify.js')}}?v=<?php echo rand();?>"></script>

@endpush
