@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/datatables-net-bs5/scroller.bootstrap5.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />

@endpush

@section('content')

<div class="row">
    @if (session('msj'))

        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <i data-feather="alert-circle"></i>
            <strong>Aviso!</strong> {{ session('msj') }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
    @else
    @endif
    @can('crear_listas')
        <div class=" col-sm-12 col-md-6 col-lg-4 grid-margin stretch-car">
            <div class="card">
                <div class="card-body">
                    <form id='formList'  class="forms-sample">
                        @csrf
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" autocomplete="off" placeholder="Descripción">
                        </div>
                        {{-- <div class="mb-3">
                            <label for="descuento" class="form-label">Descuento (porcentaje)</label>
                            <input type="number" value='0' min="0" max="100" maxlength="3" id='descuento' name="descuento" class="form-control" placeholder="Descuento en %">
                        </div> --}}
                        <div class="mb-3">
                            <label for="lista" class="form-label">Usar precios de lista: <span class="badge bg-primary">Opcional</span></label>
                            <select  class="form-control" name="lista" id="lista">
                                @forelse ($listas as $lista)
                                <option value="{{$lista->id}}">{{$lista->descripcion}}</option>
                                @empty
                                
                                @endforelse
                                <option value="ninguno" selected>Ninguno</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Guardar</button>
                    </form>
                </div>
            </div>
            
        </div>
    @endcan
    <div class="d-md-block col-sm-12 col-md-6 col-lg-6 grid-margin stretch-car">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lista de precios</h4>
                
                <div class="table-responsive">
                    
                    <table id="dataTablePrecios" class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descripcion</th>
                                <th>Descuento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id='listPrecios'>
                            @forelse ($listas as $lista)
                            <tr>
                                <th id="claveLista">{{$lista->id}}</th>
                                <th id="nombreLista">{{$lista->descripcion}}</th>
                                <th id='descuentoLista'>{{$lista->descuento}} % </th>
                                <th>
                                    @can('editar_estudios_lista')
                                        <a onclick='detailList(this, {{$lista->id}})' class="btn btn-primary btn-icon btn-xs"><i class="mdi mdi-note-plus"></i></a>
                                    @endcan
                                    @can('editar_listas')
                                        <a onclick='editList(this, {{$lista->id}})' class="btn btn-success btn-icon btn-xs"><i class="mdi mdi-pencil"></i></a>
                                    @endcan
                                    @can('eliminar_listas')
                                        <a href="{{ route('stevlab.catalogo.delete-lista', $lista->id)}}" class="btn btn-danger btn-icon btn-xs"><i class="mdi mdi-delete"></i></a>
                                    @endcan
                                </th>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                    {{ $listas->links() }}
                </div>
            </div>
        </div>
        
    </div>
    
</div>

<!-- Modal -->
<div class="modal fade" id="detailList" tabindex="-1" aria-labelledby="detailListModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailListLabel"> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="clave" name="clave" class="form-control">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="search" class="form-label">Importar lista (excel)</label>
                            <input type="file" class="" data-height="100" id="archivo" name="archivo" data-allowed-file-extensions="xlsx"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="search" class="form-label">Buscar y agregar estudio</label>
                            <select class="js-example-basic-multiple form-select" multiple='multiple' name="list_estudios[]" id="list_estudios" data-width="100%">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="search" class="form-label">Buscar estudio agregado</label>
                            <input id="searchTerm" type="text" onkeyup="doSearch()"  class="form-control" placeholder="Buscar estudio">
                        </div>
                    </div>
                </div>
                
                <div class="row overflow-auto" style="max-height: 500px;">
                    {{-- Cadena a buscar <input id="searchTerm" type="text" onkeyup="doSearch()" /> --}}
                    <div class="mb-3 table-responsive">
                        <table id="dataTableEstudios" class="table table-sm table-hover nowrap">
                            <thead>
                                <tr>
                                    <th>Clave</th>
                                    <th>Descripcion</th>
                                    <th>Tipo</th>
                                    <th>Costo</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody id="listPreciosEstudios" >
                            </tbody>
                            <tbody id="listPreciosProfiles">
                            </tbody>
                            <tbody id="listPreciosImagenologia">
                            </tbody>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="guardaLista()" type="button" class="btn btn-primary" id='saveList'>
                    <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                    Guardar
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editList" tabindex="-1" aria-labelledby="editListModal" aria-hidden="true">
    <div class="modal-dialog modal-xs">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lista </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="list_id" name="list_id" class="form-control">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="new_nombre" class="form-label">Nuevo nombre</label>
                            <input id="new_nombre" type="text" class="form-control" placeholder="Nuevo nombre">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="guardaNewNameLista()" type="button" class="btn btn-primary" id='saveList'>
                    <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                    Guardar
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.scroller.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>


@endpush

@push('custom-scripts')
<script src="{{ asset('public/stevlab/catalogo/precios/form-validation.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/precios/functions.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/precios/data-table.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/precios/select2.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/precios/dropify.js') }}?v=<?php echo rand();?>"></script>

@endpush