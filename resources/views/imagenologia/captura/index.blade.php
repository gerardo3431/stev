@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/dropzone/dropzone.min.css')}}" rel="stylesheet" >

@endpush

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
        <li class="breadcrumb-item"> <a href="#">Imagenologia</a></li>
        <li class="breadcrumb-item active" aria-current="page">Captura de resultados</li>
    </ol>
</nav>

<div class="row">
    <div class="d-md-block col-md-12 col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Busqueda de estudios</h6>
                <div class="row">
                    <div class="col-md-4 col-lg-2">
                        <div class="mb-3">
                            <label class="form-label">Fecha inicial</label>
                            <div class="input-group date datepicker consultaEstudios" style="padding: 0">
                                <input type="text" class="form-control" id="selectInicio">
                                <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="mb-3">
                            <label class="form-label">Fecha final</label>
                            <div class="input-group date datepicker consultaEstudios" style="padding: 0">
                                <input type="text" class="form-control" id="selectFinal" >
                                <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="mb-3">
                            <label class="form-label">Sucursal</label>
                            <select class="form-select consultaEstudios" id="selectSucursal">
                                @foreach ($sucursales as $sucursal)
                                    <option value="{{$sucursal->id}}">{{$sucursal->sucursal}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="mb-3">
                            <div class="mb-3">
                                <label class="form-label">Area</label>
                                <select class="form-select consultaEstudios" id="selectArea">
                                    <option value="todo">Todos</option>
                                    @foreach ($areas as $area)
                                        <option value="{{$area->id}}">{{$area->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    
    <div class="col-md-12 col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Solicitudes</h4>
                <div class="table-responsive">
                    <table id="dataTableMetodos" class="table table-hover nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Nombre</th>
                                <th>Sucursal</th>
                                <th>Empresa</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody id="listEstudios">
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- Modal -->

<div class="modal fade" id="modalEstudio"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEstudio" aria-hidden="true">
    {{-- .modal-fullscreen para poner la pantalla completa del modal --}}
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEstudio">Captura de resultados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            {{-- https://wa.me/1XXXXXXXXXX?text=Me%20interesa%20el%20auto%20que%20estás%20vendiendo --}}
            <div  class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="captura-tab" data-bs-toggle="tab" data-bs-target="#captura" role="tab" aria-controls="captura" aria-selected="true">Captura de resultados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="maquila-tab" data-bs-toggle="tab" data-bs-target="#maquila" role="tab" aria-controls="maquila" aria-selected="false">Maquila</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0 p-3" id="myComponent">
                    <div class="tab-pane fade show active" id="captura" role="tabpanel" aria-labelledby="captura-tab">
                        <div class="row">
                            <div class="col-md-12 col-lg-8">
                                <h6 class="card-title">Membrete designado</h6>
                                <p class="text-muted mb-3">Puede revisar los membretes cargados en el menu utilerias, opción multimembrete. Por favor revise que tenga cargado el membrete al seleccionar alguno de las opciones.</p>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input seleccion" value="imagenologia" name="radio_membrete"  checked="checked">
                                        <label class="form-check-label" for="radio_membrete">
                                            Imagenologia
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input seleccion" value="principal" name="radio_membrete" >
                                        <label class="form-check-label" for="radio_membrete">
                                            Principal
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input seleccion" value="secundario" name="radio_membrete" >
                                        <label class="form-check-label" for="radio_membrete">
                                            Secundario
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input seleccion" value="terciario" name="radio_membrete"  >
                                        <label class="form-check-label" for="radio_membrete">
                                            Terciario
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4 ">
                                <h6 class="card-title">Archivos de maquila</h6>
                                <p class="text-muted mb-3">
                                    Si hay un archivo maquilado para este archivo, puede obtener el archivo, dando click en el siguiente botón.
                                </p>
                                <div class="mb-3"  id='maquilaFile'>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="appendComponente" class="col-sm-12 col-md-12 col-lg-12">
                        </div>
                    </div>
                    <div class="tab-pane fade" id="maquila" role="tabpanel" aria-labelledby="maquila-tab">
                        <h6 class="card-title">Cargar archivo</h6>
                        @csrf
                        <div class="row">
                            <div class="col-md-12 col-lg-12">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6 mb-3">
                                        <label class="form-label">Cargar archivo</label>
                                        <input type="file" class="" data-height="300" id="archivo" name="archivo" data-allowed-file-extensions="pdf"/>
                                    </div>
                                    <div class="col-md-12 col-lg-6 mb-3">
                                        <label class="form-label">Cargar imagen</label>
                                        <input type="file" class="" data-height="300" id="imagen" name="imagen" data-allowed-formats="portrait" data-allowed-file-extensions="png"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <button id='maquilar_archivos' type="submit" class="btn btn-primary float-md-end">
                                    <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                                    Maquilar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                {{-- <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-whatsapp "></i> Otras opciones
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <a onclick='send_email(this)' type="button" class="dropdown-item" href="#">Enviar a correo del paciente. </a>
                        <a href="#" type="button" class="dropdown-item" onclick="open_modal_correo(this)">Enviar a correo</a>
                        <a onclick='open_modal_sms(this)' type="button" class="dropdown-item" href="#">Enviar a cuenta de WhatsApp del paciente.</a>
                    </div>
                </div> --}}
                <button class="btn btn-outline-primary" type="button" onclick="pdf_all()">
                    <i class="mdi mdi-file-multiple"></i> Impresión
                </button> 
                <button class="btn btn-primary" type="button" onclick="delivery()">
                    <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                    <i class="mdi mdi-file-check"></i> Entregar resultados
                </button>
                {{-- <div class="btn-group" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-file-multiple"></i> Impresión
                    </button>
                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <a onclick="pdf_all()" type="button" class="dropdown-item" href="#">Imprimir sin membrete </a>
                    <a onclick="pdf_all_membrete(this)" type="button" class="dropdown-item" href="#"> Imprimir con membrete</a>
                    </div>
                </div> --}}
                {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button> --}}
            </div>
        </div>
    </div>
</div>

<!-- Modal para enviar resultados por whatsapp -->
<div class="modal fade" id="modalWhatsapp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="1" aria-labelledby="modalWhatsapp" aria-hidden='true'> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEstudio">Envio de resultados por WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="paciente">Paciente</label>
                            <input type="text" id="sms_paciente" name="sms_paciente" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="telefono">Teléfono</label>
                            <input type="text" id="sms_phone_number" name="sms_phone_number" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="mb-3">
                            <label for="mensaje">Mensaje</label>
                            <textarea name="sms_message" id="sms_message" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" onclick="genera_link()" class="btn btn-primary"> <i class="mdi mdi-email"></i> Enviar mensaje</button>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
{{-- Modal correo --}}
<div class="modal fade" id="modal_correo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="1" aria-labelledby="modal_correo" aria-hidden='true'> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEstudio">Envio correo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id='correo_form'>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="correo">Doctor</label>
                                <input type="email" class="form-control" id='correo' name='correo' placeholder="Correo del doctor">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="correo">Empresa</label>
                                <input type="email" class="form-control" id='correo' name='correo' placeholder="Correo de la empresa">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="correo">Otro</label>
                                <input type="email" class="form-control" id='correo' name='correo' placeholder="Correo alterno">
                            </div>
                        </div>
                    </div>
                </form>
                <button type="submit" onclick="genera_correo()" class="btn btn-primary"> <i class="mdi mdi-email"></i> Enviar correo</button>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------------------------------------>
<div class="modal fade" id="modal_delivery" tabindex="-1" data-bs-keyboard="true" tabindex="-1" aria-labelledby="modalDelivery" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content static">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGeneraEtiqueta">Entrega de resultados</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label class="form-label">Archivos</label>
                    <input type="hidden" id="folio_archivos">
                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="skill_check" class="form-check-input" id="captura_file">
                            <label class="form-check-label" for="checkInline1">
                                Resultados
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="skill_check" class="form-check-input" id="img_file">
                            <label class="form-check-label" for="checkInline3">
                                Imagenologia
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="skill_check" class="form-check-input" id="maquila_file">
                            <label class="form-check-label" for="checkInline2">
                                Maquila (resultados)
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" name="skill_check" class="form-check-input" id="maquila_img">
                            <label class="form-check-label" for="checkInline3">
                                Maquila (imagenologia)
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" onclick="sendingPatient('archivo')">Obtener archivo</button>
                        @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
                            <button type="submit" class="btn btn-success" onclick="sendingPatient('whatsapp')">Enviar por whatsapp</button>
                            <button type="submit" class="btn btn-secondary" onclick="sendingPatient('correo')">Enviar por correo</button>                            
                        @endif
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                
            </div>
        </div>
        
    </div>
</div>
@endsection
@push('plugin-scripts')
    <script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/dropzone/dropzone.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/ckeditor5-build-classic/ckeditor.js')}}" ></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('public/stevlab/imagenologia/recepcion/functions.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/imagenologia/recepcion/captura.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/imagenologia/recepcion/documento.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/imagenologia/recepcion/mailer.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/imagenologia/recepcion/sms.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/imagenologia/recepcion/dropzone.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/imagenologia/recepcion/componente.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/imagenologia/recepcion/maquila.js')}}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/captura/dropify.js')}}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/captura/datepicker.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/captura/observacion.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/captura/textarea.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/captura/verificacion.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/captura/delivery.js') }}?v=<?php echo rand();?>"></script>

@endpush