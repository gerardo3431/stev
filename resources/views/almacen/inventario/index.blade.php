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
                        <h4 class="card-title">Inventario inicial</h4>
                        <form id="addArticulo" action="{{--{{route('stevlab.almacen.articulos-store')}}--}}" method="POST">
                            @csrf
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="mb-3 col-sm-6 col-lg-5 col-xl-3 ">
                                        <label for="ubicacion" class="form-label">Area</label>
                                        <select class="form-select {{ $errors->has('ubicacion') ? 'is-invalid' : '' }}" id='ubicacion' name="ubicacion" value='{{old('ubicacion')}}'>
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
                                    <div class="mb-3 col-sm-6 col-lg-5 col-xl-3 ">
                                        <label for="departamento" class="form-label">Departamento</label>
                                        <select disabled class="form-select {{ $errors->has('departamento') ? 'is-invalid' : '' }}" id='departamento' name="departamento" value='{{old('departamento')}}'>
                                            <option selected disabled value="">Seleccione ubicación</option>
                                        </select>
                                        <x-jet-input-error for="departamento"></x-jet-input-error>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-sm-3 col-lg-3 col-xl-2 ">
                                        <label for="clave" class="form-label">Clave</label>
                                        <input type='text' class="form-control {{ $errors->has('clave') ? 'is-invalid' : '' }}" id="clave" name="clave"  placeholder="Clave" value='{{old('clave')}}'>
                                        <x-jet-input-error for="clave"></x-jet-input-error>
                                    </div>
                                    <div class="mb-3 col-sm-9 col-lg-6 col-xl-4">
                                        <label for="articulo" class="form-label">Articulo</label>
                                        <select name="listArticles" id="listArticles" class="js-example-basic-multiple form-select" multiple='multiple' data-width="100%">
                                        </select>
                                        <x-jet-input-error for="articulo"></x-jet-input-error>
                                    </div>
                                    <div class="mb-3 col-sm-4 col-lg-3 col-xl-2">
                                        <label for="cantidad" class="form-label">Cantidad</label>
                                        <input type='text' class="form-control {{ $errors->has('cantidad') ? 'is-invalid' : '' }}" id='cantidad' name="cantidad"  placeholder="Cantidad" value='{{old('cantidad')}}'>
                                        <x-jet-input-error for="cantidad"></x-jet-input-error>
                                    </div>
                                    <div class="mb-3 col-sm-4 col-lg-3 col-xl-2">
                                        <label for="lote" class="form-label">Lote</label>
                                        <input disabled type='text' class="form-control {{ $errors->has('lote') ? 'is-invalid' : '' }}"  id="lote" name="lote"  placeholder="Lote" value='{{old('lote')}}'>
                                        <x-jet-input-error for="lote"></x-jet-input-error>
                                    </div>
                                    <div class="mb-3 col-sm-4 col-lg-6 col-xl-2">
                                        <label for="caducidad" class="form-label">Caducidad</label>
                                        <div class="input-group date datepicker" style="padding: 0">
                                            <input disabled type="text" class="form-control " id="caducidad" name="caducidad" data-date-start-date="0d">
                                            <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                        </div>
                                        {{-- <input type='text' class="form-control {{ $errors->has('nombre_corto') ? 'is-invalid' : '' }}" name="nombre_corto"  placeholder="Nombre corto" value='{{old('nombre_corto')}}'> --}}
                                        <x-jet-input-error for="caducidad"></x-jet-input-error>
                                    </div>
                                </div>
                            </div>
                            <button id="addArticle"  type="submit" class="btn btn-success">
                                <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                                Añadir
                            </button>
                            {{-- <input class="btn btn-primary" type="submit" value="Guardar"> --}}
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 d-md-block grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Inventario inicial de articulos</h4>
                        <div class="mb-3">
                            <div class="table-responsive">
                                <table id="dataTableArticulos" class="table table-sm table-hover nowrap" width="100%">
                                    <thead>
                                        <tr> 
                                            <th>#</th>
                                            <th>Folio</th>
                                            <th>Fecha</th>
                                            <th>Area</th>
                                            <th>Clave</th>
                                            <th>Articulo</th>
                                            <th>Lote</th>
                                            <th>Caducidad</th>
                                            <th>Existencia</th>
                                            {{-- <th>Opciones</th> --}}
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
        @if (session('estatus'))
        @else
            
        @endif



    @endif

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
    <script src="{{ asset('public/stevlab/almacen/inventarios/datepicker.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/almacen/inventarios/form-validation.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/almacen/inventarios/functions.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/almacen/inventarios/inputmask.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/almacen/inventarios/select2.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/almacen/inventarios/data-table.js') }}?v=<?php echo rand();?>"></script>
@endpush