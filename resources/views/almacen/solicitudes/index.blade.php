@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Almacen </li>
            <li class="breadcrumb-item active" aria-current="page"> Solicitud de material </li>
        </ol>
    </nav>
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
                    <h4 class="card-title">Solicitud de material</h4>
                    <form id="addArticulo" action="{{--{{route('stevlab.almacen.articulos-store')}}--}}" >
                        @csrf
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-lg-6 col-xl-4">
                                    <label for="listSolicitudes" class="form-label">Buscar solicitud</label>
                                    <select name="listSolicitudes" id="listSolicitudes" class="js-example-basic-multiple form-select" multiple='multiple' data-width="100%">
                                    </select>
                                    <x-jet-input-error for="listSolicitudes"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6 col-lg-4 col-xl-2 ">
                                    <label for="estatus" class="form-label">Estado</label>
                                    <select disabled class="form-select {{ $errors->has('estatus') ? 'is-invalid' : '' }}" id='estatus' name="estatus" value='{{old('departamento')}}'>
                                        <option selected value="nuevo"></option>
                                        <option value="abierto">Abierto</option>
                                        <option value="cerrado">Cerrado</option>
                                    </select>
                                    <x-jet-input-error for="estatus"></x-jet-input-error>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-6 col-lg-3 col-xl-4 ">
                                    <label for="folio" class="form-label">Folio</label>
                                    <select name="folio" id="folio" class="js-example-basic-multiple form-select" multiple='multiple' data-width="100%">
                                    </select>
                                    {{-- <input type='text' class="form-control {{ $errors->has('folio') ? 'is-invalid' : '' }}" id="folio" name="folio"  placeholder="Folio" value='{{old('folio')}}'> --}}
                                    <x-jet-input-error for="folio"></x-jet-input-error>
                                </div>

                                <div class="mb-3 col-sm-6 col-lg-5 col-xl-3">
                                    <label for="ubicacion" class="form-label">Area</label>
                                    <select class="form-select {{ $errors->has('ubicacion') ? 'is-invalid' : '' }}" id='ubicacion' name="ubicacion" value='{{old('ubicacion')}}'>
                                        <option value="">Seleccione</option>
                                        <option value="almacen_general">Almacen general</option>
                                        <option value="serologia">Serologia</option>
                                        <option value="inmunohematologia">Inmunohematologia</option>
                                        <option value="fraccionamiento">Fraccionamiento</option>
                                        <option value="sangrado">Sangrado</option>
                                        <option value="toma_muestra">Toma de muestra</option>
                                        <option value="recepcion">Recepcion</option>
                                        <option value="entrevista">Entrevistas</option>
                                    </select>
                                    <x-jet-input-error for="ubicacion"></x-jet-input-error>
                                </div>
                                {{-- <div class="mb-3 col-sm-6 col-lg-4 col-xl-2 ">
                                    <label for="departamento" class="form-label">Departamento</label>
                                    <select disabled class="form-select {{ $errors->has('departamento') ? 'is-invalid' : '' }}" id='departamento' name="departamento" value='{{old('departamento')}}'>
                                        <option selected disabled value="">Seleccione ubicación</option>
                                    </select>
                                    <x-jet-input-error for="departamento"></x-jet-input-error>
                                </div> --}}
                                <div class="mb-3 col-sm-6 col-lg-4 col-xl-2">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <div class="input-group date datepicker" style="padding: 0">
                                        <input disabled type="text" class="form-control " id="fecha" name="fecha" data-date-end-date="0d">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                    {{-- <input type='text' class="form-control {{ $errors->has('nombre_corto') ? 'is-invalid' : '' }}" name="nombre_corto"  placeholder="Nombre corto" value='{{old('nombre_corto')}}'> --}}
                                    <x-jet-input-error for="fecha"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-12 col-lg-4 col-xl-3">
                                    <label for="usuario" class="form-label">Usuario</label>
                                    <input disabled type='text' class="form-control {{ $errors->has('usuario') ? 'is-invalid' : '' }}" id="usuario" name="usuario"  placeholder="Usuario" value='{{auth()->user()->username}}'>
                                    <x-jet-input-error for="usuario"></x-jet-input-error>
                                </div>
                            </div>
                        </div>
                        {{-- <button id="addMaterial"  type="submit" class="btn btn-success">
                            <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                            Añadir
                        </button> --}}
                        {{-- <input class="btn btn-primary" type="submit" value="Guardar"> --}}
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 d-md-block grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Solicitud</h4>
                    <form id="addSolicitud" action="{{--{{route('stevlab.almacen.articulos-store')}}--}}" method="POST">
                        @csrf
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-6 col-lg-3 col-xl-2 ">
                                    <label for="clave" class="form-label">Clave</label>
                                    <input type='text' class="form-control {{ $errors->has('clave') ? 'is-invalid' : '' }}" id="clave" name="clave"  placeholder="Clave" value='{{old('clave')}}'>
                                    <x-jet-input-error for="clave"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-12 col-lg-6 col-xl-4">
                                    <label for="listArticles" class="form-label">Articulo</label>
                                    <select name="listArticles" id="listArticles" class="js-example-basic-multiple form-select" multiple='multiple' data-width="100%">
                                    </select>
                                    <x-jet-input-error for="listArticles"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6 col-lg-3 col-xl-2 ">
                                    <label for="cantidad" class="form-label">Cantidad</label>
                                    <input type='text' class="form-control {{ $errors->has('cantidad') ? 'is-invalid' : '' }}" id="cantidad" name="cantidad"  placeholder="Cantidad" value='{{old('cantidad')}}'>
                                    <x-jet-input-error for="cantidad"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6 col-lg-3 col-xl-2 ">
                                    <label for="unidad" class="form-label">Unidad a entregar</label>
                                    <input type='text' class="form-control {{ $errors->has('unidad') ? 'is-invalid' : '' }}" id="unidad" name="unidad"  placeholder="Unidad" value='{{old('unidad')}}'>
                                    <x-jet-input-error for="unidad"></x-jet-input-error>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-6 col-lg-3 col-xl-2 ">
                                    <label for="existencia_general" class="form-label">Existencias en Alm. General</label>
                                    <input disabled type='text' class="form-control {{ $errors->has('existencia_general') ? 'is-invalid' : '' }}" id="existencia_general" name="existencia_general"  placeholder="Existencia en Alm. General" value='{{old('existencia_general')}}'>
                                    <x-jet-input-error for="existencia_general"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6 col-lg-3 col-xl-2 ">
                                    <label for="existencia" class="form-label">Existencias</label>
                                    <input disabled type='text' class="form-control {{ $errors->has('existencia') ? 'is-invalid' : '' }}" id="existencia" name="existencia"  placeholder="Existencias" value='{{old('existencia')}}'>
                                    <x-jet-input-error for="existencia"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6 col-lg-3 col-xl-2 ">
                                    <label for="solicitud" class="form-label">Por surtir</label>
                                    <input disabled type='text' class="form-control {{ $errors->has('solicitud') ? 'is-invalid' : '' }}" id="solicitud" name="solicitud"  placeholder="Solicitud" value='{{old('solicitud')}}'>
                                    <x-jet-input-error for="solicitud"></x-jet-input-error>
                                </div>
                            </div>
                            <button id="addMaterial"  type="submit" class="btn btn-sm btn-success">
                                <i class="mdi mdi-plus"></i>
                            </button>
                            <div class="row">
                                <div class="mb-3">
                                    <table class="table table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Clave</th>
                                                <th>Articulo</th>
                                                <th>Unidad a entregar</th>
                                                <th>JD</th>
                                                <th>Area</th>
                                                <th>Cantidad</th>
                                                <th>Existencias</th>
                                                <th>Por surtir</th>
                                                <th><i class="mdi mdi-wrench"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody id='tableListArticles'>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-6 col-lg-3 col-xl-2 ">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <input type='text' class="form-control {{ $errors->has('observaciones') ? 'is-invalid' : '' }}" id="observaciones" name="observaciones"  placeholder="Observaciones" value='{{old('observaciones')}}'>
                                    <x-jet-input-error for="observaciones"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6 col-lg-3 col-xl-2 ">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select {{ $errors->has('estado') ? 'is-invalid' : '' }}" id='estado' name="estado" value='{{old('estado')}}'>
                                        <option value="abierto">ABIERTO</option>
                                        <option value="cerrado">CERRADO</option>
                                    </select>
                                    <x-jet-input-error for="estado"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6 col-lg-3 col-xl-2 ">
                                    <label for="tipo" class="form-label">Por surtir</label>
                                    <select class="form-select {{ $errors->has('tipo') ? 'is-invalid' : '' }}" id='tipo' name="tipo" value='{{old('tipo')}}'>
                                        <option value="normal">NORMAL</option>
                                    </select>
                                    <x-jet-input-error for="tipo"></x-jet-input-error>
                                </div>
                            </div>
                            <button id="addRequest"  type="submit" class="btn btn-success">
                                <span id='showAddRequest' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                                Terminar
                            </button>
                            <button id="printMaterial"  type="submit" class="btn btn-info">
                                <span id='showPrintRequest' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                                Imprimir
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>
    {{-- <script src="{{ asset('public/assets/js/axios.min.js') }}"></script> --}}
    <script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('public/stevlab/almacen/solicitudes/functions.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/almacen/solicitudes/datepicker.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/almacen/solicitudes/select2.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/almacen/solicitudes/form-validation.js') }}?v=<?php echo rand();?>"></script>
@endpush