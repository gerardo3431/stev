@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('public/stevlab/catalogo/analitos/sortable.css')}}">
    <link rel="stylesheet" href="{{asset('public/stevlab/catalogo/analitos/calc.css')}}">
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="#">Catálogo</a></li>
        <li class="breadcrumb-item active" aria-current="page">Analitos</li>
        
    </ol>
</nav>

@can('crear_analitos')
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <!-- Button trigger modal -->
            <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalAnalito">
                Añadir analito
            </button>
        </div>
    </div>
@endcan
@can('organizar_analitos')
    <div class="row">
        <div class="col-md-8 col-lg-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Selecciona estudio</h4>
                    <div class="mb-3" id='estudioData'>
                        <select id="selectEstudio" class="js-example-basic-multiple form-select" multiple='multiple' data-width="100%">
                        </select>
                        <input id='estudioId' type="hidden" value=''>
                    </div>
                    <div id='setAnalito' class="mb-3" style="display: none;">
                        <h4 class="card-title">Añade analito</h4>
                        <select id='selectAnalito' class="js-example-basic-multiple form-select" multiple='multiple' data-width="100%">
                        </select>
                    </div>
                    <div class="mb-5">
                        <h4 class="card-title">Estudios de perfil</h4>
                        <p class="text-muted mb-3">Ordenamiento (Según el orden de impresión)</p>
                        <div class='col-sm-12'>
                            <div class="row">
                                <div class="col-md-4">
                                    <ul class="list-group mb-3" id="analitos-list"> 
                                    </ul>
                                    <button onclick="sendAnalitos()"  class="btn btn-primary">Guardar analitos</button>
                                </div>
                                <div class="col-md-8">
                                    <div id="calculadora"  style="display: none;">
                                        <h4 class="card-title">Calculadora</h4>
                                        <!-- Top of the Calculator -->
                                        <div class="container calc-top mb-3">
                                            <!-- 3 themes options -->
                                            <div class="row justify-content-end">
                                                <span class="col-1">1</span>
                                                <span class="col-1">2</span>
                                                <span class="col-1">3</span>
                                            </div>
                
                                            <!-- Theme toggle options  -->
                                            <div class="calc-top row">
                                                <h3 class="col-6"></h3>
                                                <h4 class="col-3">tema</h4>
                                                <div class="col-3 toggle">
                                                    <div class="btn-group">
                                                        <input type="range" id="btnTheme" min="1" max="3" value="1" onchange="myFunction_set(this.value);">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Input to put the results  -->
                                            <div class="calc-top-result row">
                                                <input type="text" class="col-12" id="result" placeholder="0" disabled></input>
                                            </div>
                                        </div>
                                        <!-- Bottom of the Calculator -->
                                        <div class="calc-keys mb-3">
                                            <!-- All the Keys/Buttons for the Calculator Works -->
                                            <div class="container">
                                                <div class="row">
                                                    <input class="col" type="button" value="7" onclick="input('7')">
                                                    <input class="col" type="button" value="8" onclick="input('8')">
                                                    <input class="col" type="button" value="9" onclick="input('9')">
                                                    <input class="col" type="button" value="DEL" id="del" onclick="del()">
                                                    <input class="col" type="button" value="%" onclick="input('%')">
                                                </div>
                                                <div class="row">
                                                    <input class="col" type="button" value="4" onclick="input('4')">
                                                    <input class="col" type="button" value="5" onclick="input('5')">
                                                    <input class="col" type="button" value="6" onclick="input('6')">
                                                    <input class="col" type="button" value="*" onclick="input('*')">
                                                    <input class="col" type="button" value="/" onclick="input('/')">
                                                </div>
                                                <div class="row">
                                                    <input class="col" type="button" value="1" onclick="input('1')">
                                                    <input class="col" type="button" value="2" onclick="input('2')">
                                                    <input class="col" type="button" value="3" onclick="input('3')">
                                                    <input class="col" type="button" value="+" onclick="input('+')">
                                                    <input class="col" type="button" value="-" onclick="input('-')">
                                                </div>
                                                <div class="row">
                                                    <input class="col" type="button" value="0" onclick="input('0')">
                                                    <input class="col" type="button" value="." onclick="input('.')">
                                                    <input class="col" type="button" value="^" onclick="input('^')">
                                                    <input class="col" type="button" value="(" onclick="input('(')">
                                                    <input class="col" type="button" value=")" onclick="input(')')">
                                                </div>
                                                <div class="row">
                                                    <input class="col" type="button" value="RESET" id="reset" onclick="reset()">
                                                    <input class="col" type="button" value="=" id="equals" onclick="input('=')" > <!-- onclick="calc()" -->
                                                    <input class="col" type="button" value="AGREGAR" onclick="saveFormula()">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="mb-3">
                                                    <h4 class="card-title">Formulas</h4>
                                                    <p class="text-muted mb-3">Lista de formulas</p>
                                                    <ul class="list-group" id="analitos-checklist-list"> 
                                                    </ul>
                                                </div>
                                                <div class="mb-3">
                                                    <button onclick="sendFormulas()"  class="btn btn-secondary">Guardar formulas</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcan
    <div class="row">
        <div class="d-md-block col-md-12 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tabla de analitos</h4>
                    
                    <div class="table-responsive">
                        <table id="dataTableAnalitos" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>Clave</th>
                                    <th>Descripcion</th>
                                    <th>Tipo resultado</th>
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

<!-- Modal -->
<div class="modal fade" id="modalAnalito" data-bs-backdrop="static" tabindex="-1" aria-labelledby="mostrarModalAnalito" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear analito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id='regisAnalito' class="form-sample" action="{{ route('stevlab.catalogo.store-analito') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Clave</label>
                                <input type="text" name='clave' class="form-control {{ $errors->has('clave') ? 'is-invalid' : '' }}" placeholder="Clave">
                                <x-jet-input-error for="clave"></x-jet-input-error>
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-9">
                            <div class="mb-3">
                                <label class="form-label">Descripción</label>
                                <input type="text" name="descripcion" class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" placeholder="Descripción">
                                <x-jet-input-error for="descripcion"></x-jet-input-error>
                            </div>
                        </div><!-- Col -->
                        
                    </div><!-- Row -->
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Bitacora</label>
                                <input type="text" name="bitacora" class="form-control {{ $errors->has('bitacora') ? 'is-invalid' : '' }}" placeholder="Bitacora">
                                <x-jet-input-error for="bitacora"></x-jet-input-error>
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-9">
                            <div class="mb-3">
                                <label class="form-label">Resultado por defecto</label>
                                <input type="text" name="defecto" class="form-control {{ $errors->has('defecto') ? 'is-invalid' : '' }}" placeholder="Resultado">
                                <x-jet-input-error for="defecto"></x-jet-input-error>
                            </div>
                        </div><!-- Col -->
                        
                    </div><!-- Row -->
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Unidad</label>
                                <input type="text" name="unidad" class="form-control {{ $errors->has('unidad') ? 'is-invalid' : '' }}" placeholder="Unidad">
                                <x-jet-input-error for="unidad"></x-jet-input-error>
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Dígitos</label>
                                <input type="number" name="digito" min='0' class="form-control {{ $errors->has('digito') ? 'is-invalid' : '' }}" placeholder="Digitos">
                                <x-jet-input-error for="digito"></x-jet-input-error>
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Tipo resultado</label>
                                <select id='tipo_resultado' onchange="displayValues()" name="tipo_resultado" class="js-example-basic-single form-select" data-width="100%">
                                    <option selected disabled>Seleccione</option>
                                    <option value="subtitulo">Subtitulo</option>
                                    <option value="texto">Texto</option>
                                    <option value="numerico">Númerico</option>
                                    <option value="documento">Documento</option>
                                    <option value="referencia">Valor referenciado</option>
                                    <option value="imagen">Imagen</option>
                                </select>
                            </div>
                        </div><!-- Col -->
                    </div>
                    <div class="row" id="showReferencia" style="display: none;">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Referencia</label>
                                <input type="text" name="valor_referencia" class="form-control" placeholder="Referencia">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="showEstado" style="display: none;">
                        <div class="col-sm-6">
                            <div class="mb-4">
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" value="abierto" name='tipo_referencia' id="tipo_referencia1">
                                    <label name='tipo_referencia'class="form-check-label" for="radioInline">
                                        Abierto
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" value="restringido" name='tipo_referencia' id="tipo_referencia2">
                                    <label class="form-check-label" for="radioInline1">
                                        Restringido
                                    </label>
                                </div>
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->
                    <div class="row" id="showTipoValidacion" style="display: none;">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Tipo validación</label>
                                <input type="text" name="tipo_validacion" class="form-control" placeholder="Tipo validación">
                            </div>
                        </div>
                    </div>
                    <div class="row" id='showNumerico' style="display: none;">
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label class="form-label">Número 1</label>
                                    <input type="number" name="numero_uno" min='0' class="form-control" placeholder="Número 1">
                                </div>
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label">Número 2</label>
                                <input type="number" name="numero_dos" min='0' class="form-control" placeholder="Número 2">
                            </div>
                        </div>
                    </div>
                    <div class="row" id="showDocumento" style="display: none;">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Documento</label>
                                <textarea class="form-control" name="documento" id="documentExample" cols="30" rows="1" placeholder="Documento"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label">Validación</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" name="valida_qr" class="form-check-input" id="valida_qr">
                                    <label class="form-check-label" for="valida_qr">
                                    Disponible para validar
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary submit">Guardar</button>
                </form>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-primary">Guardar analito</button> --}}
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> --}}
            </div>
        </div>
    </div>
</div>  

<!-- Modal añadir referencias -->
<div class="modal fade" id="modalReferencia" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalReferenciaLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReferenciaLabel">Valor referenciado</h5>
                <button onclick='cerrarModal()' type="button" class="btn-close" ></button>
                {{-- data-bs-dismiss="modal" aria-label="btn-close" --}}
            </div>
            <div class="modal-body">
                <form id="referenciaAnalito" class="form-sample">
                    @csrf
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Edad inicial</label>
                                <input name='edad_inicial' type="number" class="form-control" placeholder="Edad inicial">
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Tipo</label>
                                <select name='tipo_inicial' class='js-example-basic-single form-select'id="">
                                    <option selected disabled>Seleccione</option>
                                    <option value="año">Año</option>
                                    <option value="mes">Mes</option>
                                    <option value="semana">Semana</option>
                                    <option value="dia">Dias</option>
                                </select>
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Edad final</label>
                                <input name='edad_final' type="number" class="form-control" placeholder="Edad final">
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Tipo</label>
                                <select name="tipo_final" class='js-example-basic-single form-select'id="">
                                    <option selected disabled>Seleccione</option>
                                    <option value="año">Año</option>
                                    <option value="mes">Mes</option>
                                    <option value="semana">Semana</option>
                                    <option value="dia">Dias</option>
                                </select>
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-4">
                                <div class="form-check form-check-inline">
                                    <input  type="radio" class="form-check-input" name='sexo' value='masculino' id="sexo1">
                                    <label class="form-check-label" for="radioInline">
                                        Masculino
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" name="sexo" value="femenino" id="sexo2">
                                    <label class="form-check-label" for="radioInline1">
                                        Femenino
                                    </label>
                                </div>
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="mb-3">
                                <label class="form-label">Referencia inicial</label>
                                <input name='referencia_inicial' type="number" class="form-control" placeholder="Referencia inicial">
                            </div>
                        </div><!-- Col -->
                        <div class="col-sm-5">
                            <div class="mb-3">
                                <label class="form-label">Referencia final</label>
                                <input name="referencia_final" type="number" class="form-control" placeholder="Referencia final">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
                <div class="table-responsive">
                    <table id="dataTableAreas" class="table">
                        <thead>
                            <tr>
                                <th>Edad inicial</th>
                                <th>Tipo</th>
                                <th>Edad final</th>
                                <th>Tipo</th>
                                <th>Sexo</th>
                                <th>Ref. inicial</th>
                                <th>Ref. final</th>
                                <th>Dias ini</th>
                                <th>Dias fin</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="valoresReferencias">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>

{{-- Modal imagen --}}
<!-- Modal -->
<div class="modal fade" id="targetImagen" data-bs-backdrop="static" tabindex="-1" aria-labelledby="targetImagenLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Guardar imagen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('stevlab.catalogo.store-imagen-analito')}}" class="form-sample mb-3" id='formImagen' enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="col-sm-12 mb-3">
                        <label  for="imagen" class="form-label">Cargar imagen</label>
                        <input name='imagen' type="file" id="dropImagen" data-allowed-file-extensions="jpg jpeg png" data-default-file="{{ asset('../public/storage/analitos/stock.jpg')}}" />
                    </div>
                    <button type="submit" class="btn btn-primary submit">Guardar imagen</button>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- Editar analito --}}
@can('editar_analitos')
    <div class="modal fade" id="modal-editar-analito" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Editar analito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="identificador">
                    {{-- <form id="edit_registro_estudios" action="#" method="POST">
                    </form> --}}
                    <form id='edit_regisAnalito' class="form-sample" method="POST" enctype="multipart/form-data">
                        {{-- @csrf --}}
                        
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Clave</label>
                                    <input type="text"  id='edit_clave' name='clave' class="form-control " placeholder="Clave">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-9">
                                <div class="mb-3">
                                    <label class="form-label">Descripción</label>
                                    <input type="text"  id='edit_descripcion' name="descripcion" class="form-control" placeholder="Descripción">
                                </div>
                            </div><!-- Col -->
                            
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Bitacora</label>
                                    <input type="text"  id='edit_bitacora' name="bitacora" class="form-control" placeholder="Bitacora">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-9">
                                <div class="mb-3">
                                    <label class="form-label">Resultado por defecto</label>
                                    <input type="text"  id='edit_defecto' name="defecto" class="form-control" placeholder="Resultado">
                                </div>
                            </div><!-- Col -->
                            
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Unidad</label>
                                    <input type="text"  id='edit_unidad' name="unidad" class="form-control" placeholder="Unidad">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-3">
                                <div class="mb-3">
                                    <label class="form-label">Dígitos</label>
                                    <input type="number"  id='edit_digito' name="digito" min='0' class="form-control " placeholder="Digitos">
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Tipo resultado</label>
                                    <select id='edit_tipo_resultado' onchange="edit_displayValues()" name="tipo_resultado" class="js-example-basic-single form-select" data-width="100%">
                                        <option selected disabled>Seleccione</option>
                                        <option value="subtitulo">Subtitulo</option>
                                        <option value="texto">Texto</option>
                                        <option value="numerico">Númerico</option>
                                        <option value="documento">Documento</option>
                                        <option value="referencia">Valor referenciado</option>
                                        <option value="imagen">Imagen</option>
                                    </select>
                                </div>
                            </div><!-- Col -->
                        </div>
                        <div class="row" id="edit_showReferencia" style="display: none;">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Referencia</label>
                                    <input type="text" id="edit_valor_referencia" name="valor_referencia" class="form-control" placeholder="Referencia">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="edit_showEstado" style="display: none;">
                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" value="abierto" name='tipo_referencia' id="edit_tipo_referencia1">
                                        <label class="form-check-label" for="radioInline">
                                            Abierto
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input" value="restringido" name='tipo_referencia' id="edit_tipo_referencia2">
                                        <label class="form-check-label" for="radioInline1">
                                            Restringido
                                        </label>
                                    </div>
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row" id="edit_showTipoValidacion" style="display: none;">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Tipo validación</label>
                                    <input type="text" id="edit_tipo_validacion" name="tipo_validacion" class="form-control" placeholder="Tipo validación">
                                </div>
                            </div>
                        </div>
                        <div class="row" id='edit_showNumerico' style="display: none;">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <div class="mb-3">
                                        <label class="form-label">Número 1</label>
                                        <input type="number" id="edit_numero_uno" name="numero_uno" min='0' class="form-control" placeholder="Número 1">
                                    </div>
                                </div>
                            </div><!-- Col -->
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Número 2</label>
                                    <input type="number" id='edit_numero_dos' name="numero_dos" min='0' class="form-control" placeholder="Número 2">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="edit_showDocumento" style="display: none;">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Documento</label>
                                    <textarea class="form-control" name="documento" id="edit_documentExample" cols="30" rows="3" placeholder="Documento"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Validación</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="valida_qr" class="form-check-input" id="edit_valida_qr">
                                        <label class="form-check-label" for="valida_qr">
                                        Disponible para validar
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary submit">Guardar</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar modal</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>
@endcan

{{-- Editar imagen de analito --}}
<div class="modal fade" id="edit-imagen-analito" data-bs-backdrop="static" tabindex="-1" aria-labelledby="targetImagenLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Guardar imagen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <input type="hidden" id="img_identificador">
            <div class="modal-body">
                <form action="{{route('stevlab.catalogo.store-imagen-analito')}}" class="form-sample mb-3" id='edit_formImagen' enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="col-sm-12 mb-3">
                        <label  for="imagen" class="form-label">Cargar imagen</label>
                        <input name='imagen' type="file" id="edit_dropImagen" data-allowed-file-extensions="jpg jpeg png" data-default-file=""/>
                    </div>
                    <button type="submit" class="btn btn-primary submit">Actualizar imagen</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Ver data de analito --}}
<div class="modal fade" id="modal-ver-analito" tabindex="-1" aria-labelledby="verModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Ver analito</h5>
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


<div class="modal fade" id="targetCalculadora" data-bs-backdrop="static" tabindex="-1" aria-labelledby="targetCalculadoraLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Calculadora</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-6 col-xl-4">
                        <!-- Top of the Calculator -->
                        <div class="container calc-top">
                            <!-- 3 themes options -->
                            <div class="row justify-content-end">
                                <span class="col-1">1</span>
                                <span class="col-1">2</span>
                                <span class="col-1">3</span>
                            </div>

                            <!-- Theme toggle options  -->
                            <div class="calc-top row">
                                <h3 class="col-6">Calculadora</h3>
                                <h4 class="col-3">tema</h4>
                                <div class="col-3 toggle">
                                    <div class="btn-group">
                                        <input type="range" id="btnTheme" min="1" max="3" value="1" onchange="myFunction_set(this.value);">
                                    </div>
                                </div>
                            </div>
                            <!-- Input to put the results  -->
                            <div class="calc-top-result row">
                                <input type="text" class="col-12" id="result" placeholder="0" disabled></input>
                            </div>
                        </div>


                        <!-- Bottom of the Calculator -->
                        <div class="calc-keys">
                            <!-- All the Keys/Buttons for the Calculator Works -->
                            <div class="container">
                                <div class="row">
                                    <input class="col" type="button" value="7" onclick="input('7')">
                                    <input class="col" type="button" value="8" onclick="input('8')">
                                    <input class="col" type="button" value="9" onclick="input('9')">
                                    <input class="col" type="button" value="DEL" id="del" onclick="del()">
                                </div>
                                <div class="row">
                                    <input class="col" type="button" value="4" onclick="input('4')">
                                    <input class="col" type="button" value="5" onclick="input('5')">
                                    <input class="col" type="button" value="6" onclick="input('6')">
                                    <input class="col" type="button" value="+" onclick="input('+')">
                                </div>
                                <div class="row">
                                    <input class="col" type="button" value="1" onclick="input('1')">
                                    <input class="col" type="button" value="2" onclick="input('2')">
                                    <input class="col" type="button" value="3" onclick="input('3')">
                                    <input class="col" type="button" value="-" onclick="input('-')">
                                </div>
                                <div class="row">
                                    <input class="col" type="button" value="." onclick="input('.')">
                                    <input class="col" type="button" value="0" onclick="input('0')">
                                    <input class="col" type="button" value="/" onclick="input('/')">
                                    <input class="col" type="button" value="x" onclick="input('*')">
                                </div>
                                <div class="row">
                                    <input class="col" type="button" value="RESET" id="reset" onclick="reset()">
                                    <input class="col" type="button" value="=" id="equals" onclick="input('=')" > <!-- onclick="calc()" -->
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8 col-lg-6 col-xl-8">
                        Lista de analitos
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
    <script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/sortablejs/Sortable.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/ckeditor5-build-classic/ckeditor.js')}}" ></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('public/stevlab/catalogo/analitos/select2.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/catalogo/analitos/data-table.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/catalogo/analitos/functions.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/catalogo/analitos/form-validation.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/catalogo/analitos/sortablejs.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/catalogo/analitos/tinymce.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/catalogo/analitos/dropify.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/catalogo/analitos/modals-edit.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/catalogo/analitos/textarea.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/catalogo/analitos/calc.js') }}?v=<?php echo rand();?>"></script>

@endpush
