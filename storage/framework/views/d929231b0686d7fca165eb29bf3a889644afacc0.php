<?php $__env->startPush('plugin-styles'); ?>
    <link href="<?php echo e(asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/dropify/css/dropify.min.css')); ?>" rel="stylesheet" />

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.dashboard')); ?>">StevLab</a></li>
        <li class="breadcrumb-item"> <a href="#">Recepcion</a></li>
        <li class="breadcrumb-item active" aria-current="page">Captura de resultados</li>
    </ol>
</nav>

<?php
    // echo DNS1D::getBarcodeSVG('444564565686', 'EAN13');
    // echo DNS1D::getBarcodeHTML('4445645656', 'PHARMA2T');
    // echo DNS1D::getBarcodePNG('4445645656', 'PHARMA2T');

    // echo '<img src="data:image/png,' . DNS1D::getBarcodePNG('4', 'C39+') . '" alt="barcode"   />';
    // echo DNS1D::getBarcodePNGPath('4445645656', 'PHARMA2T');
    // echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG('4', 'C39+') . '" alt="barcode"   />';
?> 

<div class="row">
    <div class="d-md-block col-md-12 col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Busqueda de solicitudes</h6>
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
                                <?php $__currentLoopData = $sucursales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sucursal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($sucursal->id); ?>"><?php echo e($sucursal->sucursal); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="mb-3">
                            <label class="form-label">Estado del estudio</label>
                            <select class="form-select consultaEstudios" id="selectEstudio">
                                <option selected value="todo">Todos</option>
                                <option value="solicitado">Solicitudes</option>
                                <option value="capturado">Capturados</option>
                                <option value="validado">Validados</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="mb-3">
                            <div class="mb-3">
                                <label class="form-label">Area</label>
                                <select class="form-select consultaEstudios" id="selectArea">
                                    <option selected value="todo">Todos</option>
                                    <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($area->id); ?>"><?php echo e($area->descripcion); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                <th>Validados</th>
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






<div class="modal fade" id="modalEstudio" tabindex="-1" aria-labelledby="modalEstudio" aria-hidden="true">
    
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEstudio">Captura de resultados</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            
            <div  class="modal-body">
                
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="captura-tab" data-bs-toggle="tab" data-bs-target="#captura" role="tab" aria-controls="captura" aria-selected="true">Captura de resultados</a>
                    </li>
                    <?php if(auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo'): ?>
                    <li class="nav-item">
                        <a class="nav-link" id="maquila-tab" data-bs-toggle="tab" data-bs-target="#maquila" role="tab" aria-controls="maquila" aria-selected="false">Maquila</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <div class="tab-content border border-top-0 p-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="captura" role="tabpanel" aria-labelledby="captura-tab">
                        <div class="row">
                            <div class="col-md-12 col-lg-8">
                                <h6 class="card-title">Membrete designado</h6>
                                <p class="text-muted mb-3">Puede revisar los membretes cargados en el menu utilerias, opción multimembrete. Por favor revise que tenga cargado el membrete al seleccionar alguno de las opciones.</p>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input seleccion" value="principal" name="radio_membrete"  checked="checked">
                                        <label class="form-check-label" for="radio_membrete">
                                            Principal
                                        </label>
                                    </div>
                                    <?php if(auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo'): ?>
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
                                    <?php endif; ?>
                                    
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4 ">
                                <?php if(auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo'): ?>
                                    <h6 class="card-title">Archivos de maquila</h6>
                                    <p class="text-muted mb-3">
                                        Si hay un archivo maquilado para este archivo, puede obtener el archivo, dando click en el siguiente botón.
                                    </p>
                                    <div class="mb-3"  id='maquilaFile'>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-8">
                                <h6 class="card-title">¿Agregar saltos?</h6>
                                <p class="text-muted mb-3">Agregar saltos puede ocasionar saltos de hoja inesperados.</p>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input seleccion" value="si" name="salto_hoja">
                                        <label class="form-check-label" for="salto_hoja">
                                            Si
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" class="form-check-input seleccion" value="no" name="salto_hoja"  checked="checked"  >
                                        <label class="form-check-label" for="salto_hoja">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div id="appendComponente" class="col-sm-12 col-md-12 col-lg-12">
                            <h3>Folio: <span class="badge bg-secondary folioCaptura" id="folioCaptura"></span></h3>
                            <br>
                            <div class="mb-3">
                                <label class='form-label' for="">Observación general</label>
                                <textarea name="observaciones" id="observaciones" cols="10" rows="3" class='form-control'></textarea>
                            </div>
                        </div>
                    </div>
                    <?php if(auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo'): ?>
                        <div class="tab-pane fade" id="maquila" role="tabpanel" aria-labelledby="maquila-tab">
                            <h6 class="card-title">Cargar archivo</h6>
                                <?php echo csrf_field(); ?>
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
                    <?php endif; ?>
                </div>
                
            </div>
            <div class="modal-footer">
                
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('entrega_resultados')): ?>
                    <button class="btn btn-primary" type="button" onclick="delivery()">
                        <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                        <i class="mdi mdi-file-check"></i> Entregar resultados
                    </button>
                    
                <?php endif; ?>
                <button class="btn btn-info" type="button" onclick="generateExcel()">
                    <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                    <i class="mdi mdi-file-excel"></i> Exportar a Excel
                </button>
                <button class="btn btn-outline-primary" type="button" onclick="pdf_all()">
                    <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                    <i class="mdi mdi-file-multiple"></i> Impresión
                </button>
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
                                <input type="email" class="form-control" id='correo_doctor' name='correo' placeholder="Correo del doctor">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="correo">Empresa</label>
                                <input type="email" class="form-control" id='correo_empresa' name='correo' placeholder="Correo de la empresa">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="correo">Paciente</label>
                                <input type="email" class="form-control" id='correo_paciente' name='correo' placeholder="Correo alterno">
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


<div class="modal fade" id="modal-editar-analito" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Editar analito</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="identificador">
                
                <form id='edit_regisAnalito' class="form-sample" method="POST" enctype="multipart/form-data">
                    
                    
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
                    <button type="submit" class="btn btn-primary submit">Guardar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar modal</button>
                
                
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
                        <?php if(auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo'): ?>
                            <button type="submit" class="btn btn-success" onclick="sendingPatient('whatsapp')">Enviar por whatsapp</button>
                            <button type="submit" class="btn btn-secondary" onclick="sendingPatient('correo')">Enviar por correo</button>                            
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                
            </div>
        </div>
        
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('plugin-scripts'); ?>
    <script src="<?php echo e(asset('public/assets/plugins/jquery-validation/jquery.validate.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/js/axios.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/moment/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/dropify/js/dropify.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/ckeditor5-build-classic/ckeditor.js')); ?>" ></script>
    <script src="<?php echo e(asset('public/assets/plugins/jquery-sparkline/jquery.sparkline.min.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('custom-scripts'); ?>
    <script src="<?php echo e(asset('public/stevlab/captura/analito.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/componentes.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/captura.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/datepicker.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/documento.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/evaluacion.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/functions.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/impresion.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/mailer.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/observacion.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/sms.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/textarea.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/verificacion.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/dropify.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/maquila.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/captura/delivery.js')); ?>?v=<?php echo rand();?>"></script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\laboratorios\resources\views/captura/index.blade.php ENDPATH**/ ?>