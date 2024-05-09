@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="#">Catálogo</a></li>
        <li class="breadcrumb-item active" aria-current="page">Estudios</li>
        
    </ol>
</nav>
<div class="row">
    @can('crear_estudios')
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Estudios</h4>
                    <form id="registro_estudios" action="{{route('stevlab.catalogo.store-studio')}}" method="POST">
                        @csrf
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-6">
                                    <label for="clave" class="form-label">Clave</label>
                                    <input type='text' class="form-control {{ $errors->has('clave') ? 'is-invalid' : '' }}" name="clave"  placeholder="Clave" value='{{old('clave')}}'>
                                    <x-jet-input-error for="clave"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="codigo" class="form-label">Código</label>
                                    <input type="text" class="form-control {{ $errors->has('codigo') ? 'is-invalid' : '' }}" name="codigo"  placeholder="Código" value='{{old('codigo')}}'>
                                    <x-jet-input-error for="codigo"></x-jet-input-error>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripcion</label>
                                    <textarea class='form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}' name="descripcion" rows="3" placeholder="Descripción" value='{{old('descripcion')}}'></textarea>
                                    <x-jet-input-error for="descripcion"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="area" class="form-label">Área</label>
                                    <select class="form-select {{ $errors->has('area') ? 'is-invalid' : '' }}" name="area" value='{{old('area')}}'>
                                        @forelse ($areas as $area)
                                        <option value="{{$area->id}}">{{$area->descripcion}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="area"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="muestra" class="form-label">Tipo muestra</label>
                                    <select class="form-select {{ $errors->has('muestra') ? 'is-invalid' : '' }}" name="muestra" value='{{old('muestra')}}'>
                                        @forelse ($muestras as $muestra)
                                        <option value="{{$muestra->id}}">{{$muestra->descripcion}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="muestra"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="recipiente" class="form-label">Recipiente</label>
                                    <select class="form-select {{ $errors->has('recipiente') ? 'is-invalid' : '' }}" name="recipiente" value='{{old('recipiente')}}'>
                                        @forelse ($recipientes as $recipiente)
                                        <option value="{{$recipiente->id}}"> {{$recipiente->descripcion}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="recipiente"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="metodo" class="form-label">Método</label>
                                    <select class="form-select {{ $errors->has('metodo') ? 'is-invalid' : '' }}" name="metodo" value='{{old('metodo')}}'>
                                        @forelse ($metodos as $metodo)
                                        <option value="{{$metodo->id}}"> {{$metodo->descripcion}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="metodo"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="tecnica" class="form-label">Técnica</label>
                                    <select class="form-select {{ $errors->has('tecnica') ? 'is-invalid' : '' }}" name="tecnica" value='{{old('tecnica')}}'>
                                        @forelse ($tecnicas as $tecnica)
                                        <option value="{{$tecnica->id}}"> {{$tecnica->descripcion}}</option>
                                        @empty
                                        @endforelse
                                        
                                    </select>
                                    <x-jet-input-error for="tecnica"></x-jet-input-error>
                                </div>
                                {{-- <div class="mb-3 col-sm-6">
                                    <label for="equipo" class="form-label">Equipo</label>
                                    <select class="form-select {{ $errors->has('equipo') ? 'is-invalid' : '' }}" name="equipo" >
                                        @forelse ($equipos as $equipo)
                                        <option value="{{$equipo->id}}"> {{$equipo->descripcion}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="equipo"></x-jet-input-error>
                                </div> --}}
                                <div class="mb-3 col-sm-12">
                                    <label for="condiciones" class="form-label">Condiciones del paciente</label>
                                    <textarea class='form-control {{ $errors->has('condiciones') ? 'is-invalid' : '' }}' name="condiciones" rows="3"placeholder='Condiciones' value='{{old('condiciones')}}'></textarea>
                                    <x-jet-input-error for="condiciones"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-12">
                                    <label for="aplicaciones" class="form-label">Aplicaciones</label>
                                    <textarea class='form-control {{ $errors->has('aplicaciones') ? 'is-invalid' : '' }}' name="aplicaciones" rows="3"placeholder='Aplicaciones' value='{{old('aplicaciones')}}'></textarea>
                                    <x-jet-input-error for="aplicaciones"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="dias_proceso" class="form-label">Días de proceso</label>
                                    <input type="number" class="form-control {{ $errors->has('dias_proceso') ? 'is-invalid' : '' }}" name="dias_proceso" placeholder='Días de proceso' value='{{old('dias_proceso')}}'>
                                    <x-jet-input-error for="dias_proceso"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="number" class="form-control {{ $errors->has('precio') ? 'is-invalid' : '' }}" name="precio" placeholder='$' value='{{old('precio')}}'>
                                    <x-jet-input-error for="precio"></x-jet-input-error>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Validación</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="valida_qr" class="form-check-input" id="valida_qr">
                                            <label class="form-check-label" for="valida_qr">
                                            Validar con qr
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
    @endcan
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 d-md-block grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de estudio</h4>
                <div class="mb-3">
                    <div class="table-responsive">
                        <table id="dataTableEstudios" class="table table-sm table-hover nowrap" width="100%">
                            <thead>
                                <tr> 
                                    <th>Clave</th>
                                    <th>Descripcion</th>
                                    <th>Condiciones</th>
                                    <th>Opciones</th>
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

<div class="modal fade" id="modal-ver-estudio" tabindex="-1" aria-labelledby="verModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Ver estudio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="card-body" id="cuerpo_ver">
                
            </div>               
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar modal</button>
            </div>
        </div>
    </div>
</div>
{{-- Editar estudio --}}
@can('editar_estudios')
    <div class="modal fade" id="modal-editar-estudio" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Editar estudio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="identificador">
                    <form id="edit_registro_estudios"  method="POST">
                        @csrf
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-6">
                                    <label for="clave" class="form-label">Clave</label>
                                    <input type='text' class="form-control" id='edit_clave' name="clave"  placeholder="Clave">
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="codigo" class="form-label">Código</label>
                                    <input type="text" class="form-control" id="edit_codigo" name="codigo"  placeholder="Código">
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripcion</label>
                                    <textarea class='form-control' id="edit_descripcion" name="descripcion" rows="3" placeholder="Descripción"></textarea>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="area" class="form-label">Área</label>
                                    <select class="form-select " id='area' name="area">
                                        @forelse ($areas as $area)
                                        <option value="{{$area->id}}">{{$area->descripcion}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="muestra" class="form-label">Tipo muestra</label>
                                    <select class="form-select" id='muestra' name="muestra">
                                        @forelse ($muestras as $muestra)
                                        <option value="{{$muestra->id}}">{{$muestra->descripcion}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="recipiente" class="form-label">Recipiente</label>
                                    <select class="form-select" id='recipiente' name="recipiente">
                                        @forelse ($recipientes as $recipiente)
                                        <option value="{{$recipiente->id}}"> {{$recipiente->descripcion}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="metodo" class="form-label">Método</label>
                                    <select class="form-select" id='metodo' name="metodo">
                                        @forelse ($metodos as $metodo)
                                        <option value="{{$metodo->id}}"> {{$metodo->descripcion}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="tecnica" class="form-label">Técnica</label>
                                    <select class="form-select" id='tecnica' name="tecnica">
                                        @forelse ($tecnicas as $tecnica)
                                        <option value="{{$tecnica->id}}"> {{$tecnica->descripcion}}</option>
                                        @empty
                                        @endforelse
                                        
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-12">
                                    <label for="condiciones" class="form-label">Condiciones del paciente</label>
                                    <textarea class='form-control' id="edit_condiciones" name="condiciones" rows="3"placeholder='Condiciones'></textarea>
                                </div>
                                <div class="mb-3 col-sm-12">
                                    <label for="aplicaciones" class="form-label">Aplicaciones</label>
                                    <textarea class='form-control' id="edit_aplicaciones" name="aplicaciones" rows="3"placeholder='Aplicaciones'></textarea>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="dias_proceso" class="form-label">Días de proceso</label>
                                    <input type="number" class="form-control" id="edit_dias_proceso" name="dias_proceso" placeholder='Días de proceso'>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="number" class="form-control" id="edit_precio" name="precio" placeholder='$'>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Validación</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="valida_qr" class="form-check-input" id="edit_valida_qr">
                                            <label class="form-check-label" for="valida_qr">
                                            Validar con qr
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Guardar">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar modal</button>
                </div>
            </div>
        </div>
    </div>
@endcan
@endsection

@push('plugin-scripts')
<script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/axios/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

@endpush

@push('custom-scripts')
{{-- <script src="{{ asset('public/stevlab/catalogo/estudios.js') }}"></script> --}}
<script src="{{ asset('public/stevlab/catalogo/estudios/data-table.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/estudios/functions.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/estudios/componente.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/estudios/form-validation.js') }}?v=<?php echo rand();?>"></script>

@endpush