@extends('layout.master')

@push('plugin-styles') 
<link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endpush


@section('content') 
{{-- Inicio breadcrumb caja --}}
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
        <li class="breadcrumb-item active" aria-current="page"> <a href="">Catalogo</a> </li>
        <li class="breadcrumb-item active" aria-current="page"> <a href="">Pacientes</a> </li>
    </ol>
</nav>

{{-- Fin breadcrumb recepcion --}}
{{-- Inicia panel's detalle --}}
{{-- @dd(Auth::user()->first()) --}}

<!------------------------------------------------------------------------------------------------>

<div class="row">
    @if (session('msj'))

        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <i data-feather="alert-circle"></i>
            <strong>Aviso!</strong> {{ session('msj') }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
    @else
    @endif
    @can('crear_pacientes')
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Formulario de alta</h5>
                    <form method="post" action="{{route('stevlab.catalogo.paciente_guardar')}}">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-8 col-xl-8">
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{old('nombre')}}"type="text" placeholder="Nombre completo">
                                    @error('nombre')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label class="form-label">Sexo</label>
                                    <select class="js-example-basic-single form-select @error('sexo') is-invalid @enderror" name="sexo" data-width="100%" value="{{old('sexo')}}">
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2 col-lg-2 col-xl-3">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Nacimiento</label>
                                    <div class="input-group date datepicker" id="fecha-nacimiento" style="padding: 0">
                                        <input type="text" class="fecha_nacimiento form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" value="{{old('fecha_nacimiento')}}">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2 col-lg-2 col-xl-3">
                                <div class="mb-3">
                                    <label class="form-label">Edad</label>
                                    <input type="number" class="form-control" id="edad_or" name="edad" value="{{old('edad')}}" placeholder="Edad">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-4 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Celular</label>
                                    <input type="number" class="form-control" name="celular" value="{{old('celular')}}" placeholder="Número telefono">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label">Domicilio</label>
                                    <input class="form-control  @error('domicilio') is-invalid @enderror" name="domicilio" value="{{old('domicilio')}}" type="text" placeholder="Domicilio">
                                    @error('domicilio')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-4 col-xl-8">
                                <div class="mb-3">
                                    <label class="form-label">Colonia</label>
                                    <input type="text" class="form-control  @error('colonia') is-invalid @enderror" name="colonia" value="{{old('colonia')}}" placeholder="Colonia">
                                    @error('colonia')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label class="form-label">No. Seguro</label>
                                    <input type="text" class="form-control" name="seguro_popular" value="{{old('seguro_popular')}}" placeholder="NSS">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 col-md-3 col-lg-4 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Vigencia inicio</label>
                                    <div class="input-group date datepicker" id="vigencia-inicio" style="padding: 0">
                                        <input type="text" class="form-control" name="vigencia_inicio" value="{{old('vigencia_inicio')}}">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-4 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Vigencia fin</label>
                                    <div class="input-group date datepicker" id="vigencia-fin" style="padding: 0">
                                        <input type="text" class="form-control" name="vigencia_fin" value="{{old('vigencia_fin')}}">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-6 col-xl-8">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{old('email')}}" placeholder="Correo electrónico">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-12">
                                <div class="mb-3">
                                    <div class="row">
                                        <label class="form-label">Empresa</label>               
                                        <div class="col-sm-10 col-10">
                                            <select class="js-example-basic-multiple form-select form-control  @error('id_empresa') is-invalid @enderror" multiple='multiple' id="id_empresa" name="id_empresa[]" data-width="100%" value="{{old('id_empresa')}}">
                                            </select>
                                            @error('id_empresa')
                                                <span class="invalid-feedback">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-sm-2 col-2">
                                            <button type="button" class="btn btn-xs btn-success"  data-bs-toggle="modal" data-bs-target="#modal_empresa_nueva">
                                                <i class="mdi mdi-factory"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>                    
                        <div class="row">
                        </div>
                        <div class="row">
                            
                        </div>
                        <button type="submit" onclick="showSwal('mixin')" class="btn btn-primary">Guardar</button>
                        {{-- <button type="button" class="btn btn-secondary empre" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl">Nueva empresa</button>            --}}
                    </form>
                </div>
            </div>
        </div>
    @endcan
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 m-md-block">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tabla de pacientes</h5>
                <div class="mb-3">
                    <div class="table-responsive">
                        <table id="dataTablePacientes" class="table table-sm table-hover nowrap display" style="width:100%" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Fecha de nacimiento</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead> 
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
<!---------------------------------------------------------------------------------------------->

<!-- Modal empresa nueva -->
<div class="modal fade " tabindex="-1" aria-labelledby="modal_nueva_empresa" aria-hidden="true" id='modal_empresa_nueva'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id='guardar_dato_empresa'>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Clave</label>
                                <input class="form-control @error('clave') is-invalid @enderror" name="clave" value="{{old('clave')}}"type="text" placeholder="Clave">
                                @error('clave')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">RFC</label>
                                <input class="form-control" name="rfc" value="" type="text" placeholder="RFC">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control"name="descripcion" placeholder="Nombre empresa">
                                    {{-- <textarea id="maxlength-textarea" class="form-control" id="defaultconfig-4" maxlength="500" rows="1" name="descripcion" placeholder="Nombre empresa"></textarea> --}}
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-8">
                            <div class="mb-3">
                                <label class="form-label">Calle</label>
                                <input class="form-control" name="calle" value="" type="text" placeholder="Calle">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Colonia</label>
                                <input type="text" class="form-control" name="colonia" value="" placeholder="Colonia">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Ciudad</label>
                                <input type="text" class="form-control" name="ciudad" value="" placeholder="Ciudad">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-5">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input class="form-control" name="email" value="" type="email" placeholder="Correo electrónico">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Télefono</label>
                                <input type="number" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{old('telefono')}}" placeholder="Télefono">
                                @error('telefono')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Contacto</label>
                                <input type="text" class="form-control @error('contacto') is-invalid @enderror" name="contacto" value="{{old('contacto')}}" placeholder="Contacto">
                                @error('contacto')
                                <span class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Lista de precio</label>
                                <select class="js-example-basic-multiple form-select form-control" multiple='multiple' id="lista_precio" name="lista_precio" data-width="100%" value="{{old('lista_precio')}}">
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-----------modal------------------------------------------------------------------------------>
@can('editar_pacientes')
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditar" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditar">Editar pacientes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('stevlab.catalogo.paciente_actualizar')}}" method="post">
                        @csrf
                        <input class="form-control" name="id" value="" type="hidden" id="id">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Nombre Completo</label>
                                    <input class="form-control" name="nombre" value="" type="text" id="nombre" placeholder="Nombre completo">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Sexo</label>
                                    <select class="js-example-basic-single form-select" name="sexo" data-width="100%" value="" id="sexo">
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Nacimiento</label>
                                    <div class="input-group date datepicker" id="fecha-nacimiento-edit">
                                        <input type="text" class=" form-control @error('fecha_nacimiento') is-invalid @enderror" id='fecha_nacimiento_edit' name="fecha_nacimiento">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label class="form-label">Edad</label>
                                    <input type="number" class="form-control" name="edad" value="" id="edad">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Celular</label>
                                    <input type="number" class="form-control" name="celular" value="" id="celular">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Domicilio</label>
                                    <input class="form-control" name="domicilio" value="" type="text" id="domicilio">
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Colonia</label>
                                    <input type="text" class="form-control" name="colonia" value="" id="colonia">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">No. Seguro popular</label>
                                    <input type="text" class="form-control" name="seguro_popular" value="" id="seguro_popular">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Vigencia inicio</label>
                                    {{-- <input type="date" class="form-control" name="vigencia_inicio" value="" id="vigencia_inicio"> --}}
                                    <div class="input-group date datepicker" id="vigencia-inicio-edit">
                                        <input type="text" class="form-control" name="vigencia_inicio" value="{{old('vigencia_inicio')}}">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Vigencia fin</label>
                                    {{-- <input type="date" class="form-control" name="vigencia_fin" value="" id="vigencia_fin"> --}}
                                    <div class="input-group date datepicker" id="vigencia-fin-edit">
                                        <input type="text" class="form-control" name="vigencia_fin" value="{{old('vigencia_fin')}}">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="" id="email">
                                </div>
                            </div>
                            
                        </div>
                        <div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Empresa</label>
                                    <select class="js-example-basic-multiple form-select form-control  @error('id_empresa') is-invalid @enderror" multiple='multiple' id="id_empresa_edit" name="id_empresa" data-width="100%" value="{{old('id_empresa_edit')}}">
                                    </select>
                                    @error('id_empresa')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label for="id_empresa_edit">Empresa</label>
                                    <select class="js-example-basic-multiple form-select form-control  @error('id_empresa_edit') is-invalid @enderror" multiple='multiple' id="id_empresa_edit" name="id_empresa_edit" data-width="100%" value="{{old('id_empresa')}}">
                                    </select>
                                    @error('id_empresa')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success">Actualizar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endcan

@endsection

@push('plugin-scripts')
<script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('public/assets/js/data-table.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/pacientes/swee-alert.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/pacientes/functions.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/pacientes/datepicker.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/pacientes/select2.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/pacientes/form-validation.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/pacientes/data-table.js') }}?v=<?php echo rand();?>"></script>


@endpush