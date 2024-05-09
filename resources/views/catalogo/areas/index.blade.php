@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="#">Catálogo</a></li>
        <li class="breadcrumb-item active" aria-current="page">Áreas de estudio</li>
        
    </ol>
</nav>
@if (session('msg'))

    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i data-feather="alert-circle"></i>
        <strong>Aviso!</strong> {{ session('msg') }}. 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
    </div>
@endif
<div class="mb-3">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item ">
            <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#areas" role="tab" aria-expanded="" aria-controls="advanced-ui" aria-selected="true">
                <i class="mdi mdi-human"></i>
                <span class="link-title">Areas</span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#metodos" role="tab" aria-expanded="" aria-controls="advanced-ui" aria-selected="false">
                <i class="mdi mdi-flask-outline"></i>
                <span class="link-title">Metodos</span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#recipientes" role="tab" aria-expanded="" aria-controls="advanced-ui" aria-selected="false">
                <i class="mdi mdi-glass-stange"></i>
                <span class="link-title">Recipientes</span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#muestras" role="tab" aria-expanded="" aria-controls="advanced-ui" aria-selected="false">
                <i class="mdi mdi-biohazard"></i>
                <span class="link-title">Muestras</span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tecnicas" role="tab" aria-expanded="" aria-controls="advanced-ui" aria-selected="false">
                <i class="mdi mdi-stethoscope"></i>
                <span class="link-title">Tecnicas</span>
            </a>
        </li>
    </ul>
    <div class="tab-content border border-top-0 p-3" id="myTabContent">
        <div class="tab-pane fade show active" id="areas">
            {{-- d-none d-md-block col-md-4 col-xl-3 left-wrapper --}}
            <div class="row">
                @can('crear_areas')
                    <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                
                                <h6 class="card-title">Áreas</h6>
                                
                                <form class="forms-sample" action="{{route('stevlab.catalogo.store-area')}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <input type="text" name='descripcion' class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" autocomplete="off" placeholder="Descripción">
                                        <x-jet-input-error for="descripcion"></x-jet-input-error>
                                    </div>
                                    <div class="mb-3">
                                        <label for="observaciones" class="form-label">Observaciones</label>
                                        <textarea name="observaciones" rows="3" class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" placeholder="Observaciones"></textarea>
                                        <x-jet-input-error for="observaciones"></x-jet-input-error>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2">Guardar</button>
                                    {{-- <button class="btn btn-secondary">Cancel</button> --}}
                                </form>
                                
                            </div>
                        </div>
                    </div>
                @endcan
                <div class="col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tabla de áreas</h4>
                            <div class="table-responsive">
                                <table id="dataTableAreas" class="table">
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Observaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($areas as $area)
                                        <tr>
                                            <td style="white-space: pre-wrap">{{$area->descripcion}}</td>
                                            <td style="white-space: pre-wrap">{{$area->observaciones}}</td>
                                            <td>
                                                {{-- <button type='submit' onclick='editarAnalito(this)' class='btn btn-xs btn-icon btn-primary' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Editar analito'><i class='mdi mdi-pencil'></i> </button>  --}}
                                                @can('eliminar_areas')
                                                    <a href="{{route('stevlab.catalogo.delete-component', ['zona' => 'areas', 'id' => $area->id])}}" type='button' class='btn btn-danger btn-xs btn-icon' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Eliminar area'"><i class='mdi mdi-delete'></i></a> 
                                                @endcan
                                            </td>
                                        </tr>
                                        @empty
                                            <tr>
                                                <td class="text-center" colspan="3">
                                                    No data allowed
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="metodos">
            <div class="row">
                {{-- d-none d-md-block col-md-4 col-xl-3 left-wrapper --}}
                <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            
                            <h6 class="card-title">Métodos</h6>
                            
                            <form class="forms-sample" action="{{route('stevlab.catalogo.store-metodo')}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <input type="text" name='descripcion' class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" autocomplete="off" placeholder="Descripción">
                                    <x-jet-input-error for="descripcion"></x-jet-input-error>
                                </div>
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea name="observaciones" rows="3" class="form-control {{ $errors->has('observaciones') ? 'is-invalid' : '' }}" placeholder="Observaciones"></textarea>
                                    <x-jet-input-error for="observaciones"></x-jet-input-error>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                {{-- <button class="btn btn-secondary">Cancel</button> --}}
                            </form>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tabla de metodos</h4>
                            <div class="table-responsive">
                                <table id="dataTableMetodos" class="table">
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Observaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($metodos as $metodo)
                                        <tr>
                                            <td style="white-space: pre-wrap">{{$metodo->descripcion}}</td>
                                            <td style="white-space: pre-wrap">{{$metodo->observaciones}}</td>
                                            <td>
                                                <a href="{{route('stevlab.catalogo.delete-component', ['zona' => 'metodos', 'id' => $metodo->id])}}" type='button' class='btn btn-danger btn-xs btn-icon' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Eliminar area'"><i class='mdi mdi-delete'></i></a> 
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td>
                                                No data allowed
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        <div class="tab-pane fade" id="recipientes">
            <div class="row">
                <div class="col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Recipientes</h6>
                            <form class="forms-sample" action="{{route('stevlab.catalogo.store-recipiente')}}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Descripcion</label>
                                            <input name='descripcion' type="text" class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" placeholder="Descripción">
                                            <x-jet-input-error for="descripcion"></x-jet-input-error>
                                        </div>
                                    </div><!-- Col -->
                                </div><!-- Row -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Marca</label>
                                            <input name='marca' type="text" class="form-control {{ $errors->has('marca') ? 'is-invalid' : '' }}" placeholder="Marca">
                                            <x-jet-input-error for="marca"></x-jet-input-error>
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Capacidad</label>
                                            <input name='capacidad' type="text" class="form-control {{ $errors->has('capacidad') ? 'is-invalid' : '' }}" placeholder="Capacidad">
                                            <x-jet-input-error for="capacidad"></x-jet-input-error>
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Presentación</label>
                                            <input name='presentacion' type="text" class="form-control {{ $errors->has('presentacion') ? 'is-invalid' : '' }}" placeholder="Presentación">
                                            <x-jet-input-error for="presentacion"></x-jet-input-error>
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Unidad medida</label>
                                            <input name='unidad_medida' type="text" class="form-control {{ $errors->has('unidad_medida') ? 'is-invalid' : '' }}" placeholder="Unidad medida">
                                            <x-jet-input-error for="unidad_medida"></x-jet-input-error>
                                        </div>
                                    </div><!-- Col -->
                                </div><!-- Row -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Observaciones</label>
                                            <textarea name="observaciones" class="form-control {{ $errors->has('observaciones') ? 'is-invalid' : '' }}" rows="3" placeholder="Observaciones"></textarea>
                                            <x-jet-input-error for="observaciones"></x-jet-input-error>
                                        </div>
                                    </div><!-- Col -->
                                </div><!-- Row -->
                                <button type="submit" class="btn btn-primary submit">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="d-md-block col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tabla de recipientes</h4>
                            <div class="table-responsive">
                                <table id="dataTableRecipientes" class="table">
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Observaciones</th>
                                            <th>Capacidad</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recipientes as $recipiente)
                                        <tr>
                                            <td style="white-space: pre-wrap">{{$recipiente->descripcion}}</td>
                                            <td style="white-space: pre-wrap">{{$recipiente->observaciones}}</td>
                                            <td>{{$recipiente->capacidad}}</td>
                                            <td>
                                                <a href="{{route('stevlab.catalogo.delete-component', ['zona' => 'recipientes', 'id' => $recipiente->id])}}" type='button' class='btn btn-danger btn-xs btn-icon' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Eliminar area'"><i class='mdi mdi-delete'></i></a> 

                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td>No data allowed</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="muestras">
            <div class="row">
                <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            
                            <h6 class="card-title">Muestras</h6>
                            
                            <form class="forms-sample" action="{{route('stevlab.catalogo.store-muestra')}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
                                    <div class="col-sm-12">
                                        <input type="text" name='descripcion' class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" placeholder="Descripción">
                                        <x-jet-input-error for="descripcion"></x-jet-input-error>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="observaciones" class="col-sm-3 col-form-label">Observaciones</label>
                                    <div class="col-sm-12">
                                        <textarea name='observaciones' class="form-control {{ $errors->has('observaciones') ? 'is-invalid' : '' }}" placeholder="Observaciones" cols="5" rows="3"></textarea>
                                        {{-- <input type="text" > --}}
                                        <x-jet-input-error for="observaciones"></x-jet-input-error>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tabla de muestras</h4>
                            <div class="table-responsive">
                                <table id="dataTableMuestras" class="table">
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Observaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($muestras as $muestra)
                                        <tr>
                                            <td style="white-space: pre-wrap">{{$muestra->descripcion}}</td>
                                            <td style="white-space: pre-wrap">{{$muestra->observaciones}}</td>
                                            <td>
                                            <a href="{{route('stevlab.catalogo.delete-component', ['zona' => 'muestras', 'id' => $muestra->id])}}" type='button' class='btn btn-danger btn-xs btn-icon' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Eliminar area'"><i class='mdi mdi-delete'></i></a> 

                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td>
                                                No data allowed
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="tecnicas">
            <div class="row">
                {{-- d-none d-md-block col-md-4 col-xl-3 left-wrapper --}}
                <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            
                            <h6 class="card-title">Técnicas</h6>
                            
                            <form class="forms-sample" action="{{route('stevlab.catalogo.store-tecnica')}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <input type="text" name='descripcion' class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" autocomplete="off" placeholder="Descripción">
                                    <x-jet-input-error for="descripcion"></x-jet-input-error>
                                </div>
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea name="observaciones" rows="3" class="form-control {{ $errors->has('observaciones') ? 'is-invalid' : '' }}" placeholder="Observaciones"></textarea>
                                    <x-jet-input-error for="observaciones"></x-jet-input-error>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                {{-- <button class="btn btn-secondary">Cancel</button> --}}
                            </form>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tabla de técnicas</h4>
                            <div class="table-responsive">
                                <table id="dataTableTecnicas" class="table">
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Observaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($tecnicas as $tecnica)
                                        <tr>
                                            <td style="white-space: pre-wrap">{{$tecnica->descripcion}}</td>
                                            <td style="white-space: pre-wrap">{{$tecnica->observaciones}}</td>
                                            <td>
                                            <a href="{{route('stevlab.catalogo.delete-component', ['zona' => 'tecnicas', 'id' => $area->id])}}" type='button' class='btn btn-danger btn-xs btn-icon' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Eliminar area'"><i class='mdi mdi-delete'></i></a> 

                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td>
                                                No data allowed
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('public/stevlab/catalogo/areas/data-table.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/metodos/data-table.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/recipientes/data-table.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/muestras/data-table.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/tecnicas/data-table.js') }}?v=<?php echo rand();?>"></script>

@endpush