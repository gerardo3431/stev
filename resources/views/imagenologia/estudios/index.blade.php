@extends('layout.master')

@push('plugin-styles') 
<link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush


@section('content')
    {{-- Inicio breadcrumb caja --}}
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="">Catalogo</a> </li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="">Imagenología</a> </li>
        </ol>
    </nav>

    
<div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Imagenologia</h4>
                <form id="registro_imagenologia" action="{{route('stevlab.catalogo.store-imagenologia')}}" method="POST">
                    @csrf
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="mb-3 col-sm-6">
                                <label for="clave" class="form-label">Clave</label>
                                <input type='text' class="form-control {{ $errors->has('clave') ? 'is-invalid' : '' }}" name="clave"  placeholder="Clave">
                                <x-jet-input-error for="clave"></x-jet-input-error>
                            </div>
                            <div class="mb-3 col-sm-6">
                                <label for="codigo" class="form-label">Código</label>
                                <input type="text" class="form-control {{ $errors->has('codigo') ? 'is-invalid' : '' }}" name="codigo"  placeholder="Código">
                                <x-jet-input-error for="codigo"></x-jet-input-error>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripcion</label>
                                <textarea class='form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}' name="descripcion" rows="3" placeholder="Descripción"></textarea>
                                <x-jet-input-error for="descripcion"></x-jet-input-error>
                            </div>
                            <div class="mb-3 col-sm-6">
                                <label for="area" class="form-label">Área</label>
                                <select class="form-select {{ $errors->has('area') ? 'is-invalid' : '' }}" name="area">
                                    @forelse ($areas as $area)
                                    <option value="{{$area->id}}">{{$area->descripcion}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <x-jet-input-error for="area"></x-jet-input-error>
                            </div>
                            <div class="mb-3 col-sm-12">
                                <label for="condiciones" class="form-label">Condiciones del paciente</label>
                                <textarea class='form-control {{ $errors->has('condiciones') ? 'is-invalid' : '' }}' name="condiciones" rows="3"placeholder='Condiciones'></textarea>
                                <x-jet-input-error for="condiciones"></x-jet-input-error>
                            </div>
                            <div class="mb-3 col-sm-6">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" class="form-control {{ $errors->has('precio') ? 'is-invalid' : '' }}" name="precio" placeholder='$'>
                                <x-jet-input-error for="precio"></x-jet-input-error>
                            </div>
                        </div>
                    </div>
                    <input class="btn btn-primary" type="submit" value="Guardar">
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 d-md-block grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de imagenología</h4>
                <div class="mb-3">
                    <div class="table-responsive">
                        <table id="dataTableEstudios" class="table table-sm table-hover nowrap" >
                            <thead>
                                <tr> 
                                    <th>Clave</th>
                                    <th>Descripcion</th>
                                    <th>Condiciones</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($estudios as $imagen)
                                <tr>
                                    <td style="white-space: inherit">{{$imagen->clave}}</td>
                                    <td style="white-space: inherit">{{$imagen->descripcion}}</td>
                                    <td>{{$imagen->condiciones}}</td>
                                    <td>
                                        <a onclick="editarPicture({{$imagen->id}})" class="btn btn-xs btn-icon  btn-secondary" ><i class="mdi mdi-pencil"></i> </a>
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

<!------------------------------------------------------------------------------------------------>

    <div class="modal fade" id="modalPicture" data-bs-backdrop="static" tabindex="-1" aria-labelledby="mostrarModalPicture" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar estudio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="edit_imagenologia">
                        @csrf
                        <input type="hidden" id='identificador' name="identificador">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-6">
                                    <label for="clave" class="form-label">Clave</label>
                                    <input type='text' class="form-control {{ $errors->has('clave') ? 'is-invalid' : '' }}" id='edit_clave' name="clave"  placeholder="Clave">
                                    <x-jet-input-error for="clave"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="codigo" class="form-label">Código</label>
                                    <input type="text" class="form-control {{ $errors->has('codigo') ? 'is-invalid' : '' }}" id='edit_codigo' name="codigo"  placeholder="Código">
                                    <x-jet-input-error for="codigo"></x-jet-input-error>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripcion</label>
                                    <textarea class='form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}' id="edit_descripcion" name="descripcion" rows="3" placeholder="Descripción"></textarea>
                                    <x-jet-input-error for="descripcion"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="area" class="form-label">Área</label>
                                    <select class="form-select {{ $errors->has('area') ? 'is-invalid' : '' }}" id="edit_area" name="area">
                                        @forelse ($areas as $area)
                                        <option value="{{$area->id}}">{{$area->descripcion}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <x-jet-input-error for="area"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-12">
                                    <label for="condiciones" class="form-label">Condiciones del paciente</label>
                                    <textarea class='form-control {{ $errors->has('condiciones') ? 'is-invalid' : '' }}' id="edit_condiciones" name="condiciones" rows="3"placeholder='Condiciones'></textarea>
                                    <x-jet-input-error for="condiciones"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="number" class="form-control {{ $errors->has('precio') ? 'is-invalid' : '' }}" id='edit_precio' name="precio" placeholder='$'>
                                    <x-jet-input-error for="precio"></x-jet-input-error>
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Guardar">
                    </form>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-primary">Guardar analito</button> --}}
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> --}}
                </div>
            </div>
        </div>
    </div> 
<!------------------------------------------------------------------------------------------------>
@endsection

@push('plugin-scripts')
<script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

@endpush

@push('custom-scripts')
    {{-- <script src="{{ asset('public/assets/js/data-table.js') }}?v=<?php echo rand();?>"></script> --}}
    {{-- <script src="{{ asset('public/stevlab/catalogo/doctores/functions.js') }}?v=<?php echo rand();?>"></script> --}}
    <script src="{{ asset('public/stevlab/imagenologia/areas/functions.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/imagenologia/areas/form-validation.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/imagenologia/areas/data-table.js') }}?v=<?php echo rand();?>"></script>


@endpush





