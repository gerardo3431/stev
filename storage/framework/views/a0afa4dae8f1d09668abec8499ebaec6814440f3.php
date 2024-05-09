<?php $__env->startPush('plugin-styles'); ?> 

<link href="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/prismjs/prism.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css')); ?>" rel="stylesheet" />


<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.dashboard')); ?>">StevLab</a></li>
        <li class="breadcrumb-item active" aria-current="page"> <a href="<?php echo e(route('stevlab.recepcion.index')); ?>">Recepcion</a> </li>
    </ol>
</nav>



<!----------------------------------------------------------------------------------------------------->

<!---------------------------------------------------------------------------------------------------->
<?php if(session('status') == 'Debes aperturar caja antes de empezar a trabajar.'): ?>

<div class="alert alert-secondary alert-dismissible fade show" role="alert">
    <i data-feather="alert-circle"></i>
    <strong>Aviso!</strong> <?php echo e(session('status')); ?> <a href="<?php echo e(route('stevlab.caja.index')); ?>" class="alert-link">Click aquí</a>. 
</div>
<?php elseif(session('status')== 'Caja cerrada automáticamente...'): ?>

<?php else: ?>
    <?php if(session('idpaciente')): ?>
        <div class="alert alert-warning">
            <p>Valores añadidos</p>
        </div>
        <input type="hidden" id="data_id_paciente" name="data_id_paciente" class="form-control" value="<?php echo e(session('idpaciente')); ?>">
        <input type="hidden" id="data_id_doctor" name="data_id_doctor" class="form-control" value="<?php echo e(session('iddoctor')); ?>">
        <input type="hidden" id="data_observaciones" name="data_observaciones" class="form-control" value="<?php echo e(session('observaciones')); ?>">
        <input type="hidden" id="data_prefolio" name="data_prefolio" class="form-control" value="<?php echo e(session('idprefolio')); ?>">
    <?php endif; ?>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <form id='signupForm' class="form-sample">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-2 col-lg-1">
                            <div class="mb-3">
                                <label class='form-label' for="prefolio">Prefolio:</label>
                                <input  class="form-control <?php $__errorArgs = ['prefolio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id='prefolio' name="prefolio" type="text" readonly="readonly" value="<?php echo e(session('prefolio')); ?>">
                                
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2 col-lg-2">
                            <div class="mb-3">
                                <label class="form-label">Folio:</label>
                                <input  class="form-control <?php $__errorArgs = ['folio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id='folio' name="folio" type="text" readonly="readonly" value="">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">F.Flebotomia:</label>
                                <div class="input-group date datepicker" id="datePickerExample" style='padding:0;'>
                                    <input type="text" class="form-control" id="f_flebotomia" name="f_flebotomia">
                                    <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">H.Flebotomia:</label>
                                <div class="input-group date datepicker" id="flebo_time" data-target-input="nearest" style='padding:0;'>
                                    <input type="text" id='h_flebotomia' name="h_flebotomia" class="form-control datetimepicker-input" data-target="#flebo_time"/>
                                    <div class="input-group-append" data-target="#flebo_time" data-toggle="datetimepicker">
                                        <span class="input-group-text input-group-addon"><i data-feather="clock"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Fecha de entrega</label>
                                <div class="input-group date datepicker" style="padding: 0">
                                    <input type="text" class="form-control " id="fecha_entrega" name="fecha_entrega" data-date-start-date="0d">
                                    <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nombre de paciente:</label>
                                <div class="row">
                                    <div class="col-sm-10 col-10">
                                        <select class="js-example-basic-multiple form-control" multiple='multiple' id='id_paciente' name="id_paciente" data-width="100%">
                                        </select>
                                    </div>
                                    <div class="col-sm-2 col-2">
                                        <button type="button" class="btn btn-xs btn-success" onclick="abre_modal_pacientes()">
                                            <i class="mdi mdi-account-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Empresa:</label>
                                <div class="row">
                                    <div class="col-sm-10 col-10">
                                        <select class="js-example-basic-multiple form-control" multiple='multiple' id='id_empresa' name="id_empresa">
                                        </select>
                                    </div>
                                    <div class="col-sm-2 col-2">
                                        <button type="button" class="btn btn-xs btn-success" onclick="abre_modal_empresa()">
                                            <i class="mdi mdi-factory"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Tipo de paciente:</label>
                                <select class="form-select" id='tipPasiente' name="tipPasiente" data-width="100%">
                                    <option disabled>Seleccione</option>
                                    <option selected value="Lab.Clinico">Lab. Clinico</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Turno:</label>
                                <select class="form-select" name="turno" data-width="100%">
                                    <option disabled>Seleccione</option>
                                    <option selected value="Matutino">Matutino</option>
                                    <option value="Vespertino">Vespertino</option>
                                    <option value="Nocturno">Nocturno</option>
                                    <option value="Fines de semana">Fines de semana</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Servicio:</label>
                                <select class="form-select" name="servicio" data-width="100%">
                                    <option disabled>Seleccione</option>
                                    <option selected value="Lab.Clinico">Lab. Clinico</option>
                                    <option value="Urgencias">Urgencias</option>
                                    <option value="Urgencias">Clinicas y hosp</option>
                                    <option value="Urgencias">Pacientes ext</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Medico:</label>
                                <div class="row">
                                    <div class="col-sm-10 col-10">
                                        <select class="js-example-basic-multiple form-control" multiple='multiple' id='id_doctor' name="id_doctor">
                                        </select>
                                    </div>
                                    <div class="col-sm-2 col-2">
                                        <button type="button" class="btn btn-xs btn-success" onclick="abre_modal_doctor()">
                                            <i class="mdi mdi-stethoscope"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="mb-3">
                                <a data-bs-toggle="collapse" href="#colapse_registro" role="button" aria-expanded="" aria-controls="advanced-ui">
                                    <span>Datos de seguimiento</span>
                                    <i class="mdi mdi-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="collapse " id="colapse_registro">
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label class="form-label">No. Cama:</label>
                                    <input class="form-control" id='numCama' name="numCama" value="<?php echo e(old('numCama')); ?>" type="number">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label class="form-label">Peso:</label>
                                    <input class="form-control" id='peso' name="peso"value="" type="text">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label class="form-label">Talla:</label>
                                    <input class="form-control" id="talla" name="talla"value="" type="text">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label class="form-label">FUR:</label>
                                    <input class="form-control" id='fur' name="fur" type="text">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Pais destino:</label>
                                    <input type="text" class="form-control" id="pais_destino" name="pais_destino">
                                </div>
                            </div>
                            
                            
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Aerolinea:</label>
                                    <input type="text" class="form-control" id="aerolinea" name="aerolinea">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="mb-3">
                                    <label class="form-label">No. vuelo:</label>
                                    <input type="text" class="form-control" id="num_vuelo" name="num_vuelo">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Medicamento:</label>
                                    <input class="form-control mb-1 mb-md-0" id="medicamento" name="medicamento"value="" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Diagnostico:</label>
                                    <input class="form-control mb-1 mb-md-0" id="diagnostico" name="diagnostico"value="" type="text">
                                </div>
                                
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="mb-3">
                                <label for="defaultconfig-4" class="form-label">Observaciones:</label>
                                <textarea class="form-control" maxlength="500" rows="3" id="observaciones" name="observaciones"></textarea>
                            </div>
                        </div>
                        
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Estudios:</label>
                                <select name="listEstudio" id="listEstudio" class="js-example-basic-multiple form-select" multiple='multiple' data-width="100%">
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive-md">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Clv</th>
                                                        <th>Descrip</th>
                                                        <th>Tip</th>
                                                        <th>Cost</th>
                                                        <th>Conforme</th>
                                                        <th><i class="mdi mdi-wrench"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody id='tablelistEstudios'>
                                                </tbody>
                                                <tbody id="tablelistPerfiles">
                                                </tbody>
                                                <tbody id="tablelistImagenologia">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Total:</label>
                                <input hidden class="form-control" id="num_total" name="num_total" type="number">
                                <input disabled class="form-control fs-1" id="total" name="total" type="text" placeholder="$00.00" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Formatos de consentimiento</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="check_sangre" class="form-check-input" id="check_sangre">
                                        <label class="form-check-label" for="check_sangre">
                                            Extracción de sangre
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="check_vih" class="form-check-input" id="check_vih">
                                        <label class="form-check-label" for="check_vih">
                                            Serologia para detección de VIH
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="check_exudado" class="form-check-input" id="check_exudado">
                                        <label class="form-check-label" for="check_exudado">
                                            Microbiologia
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <button id="guardar_folio"  type="submit" class="btn btn-success">
                        <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                        Guardar
                    </button>
                    <button onclick="borra_form()" type="button" class="btn btn-danger">Borrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!---------------------------------------------- NUEVO PACIENTE------------------------------------------------------>
<div class="modal fade" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" id="modal_paciente">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPaciente">Nuevo pacientes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="storePatientForm" >
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input class="form-control " name="nombre" type="text" placeholder="Nombre completo">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-2">
                                    <div class="mb-3">
                                        <label class="form-label">Sexo</label>
                                        <select class="js-example-basic-single form-select " name="sexo" data-width="100%">
                                            <option value="masculino">Masculino</option>
                                            <option value="femenino">Femenino</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Fecha Nacimiento</label>
                                        <div class="input-group date datepicker" style="padding: 0">
                                            <input type="text" class="form-control " id="fecha_nacimiento" name="fecha_nacimiento" data-date-end-date="0d" >
                                            <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Edad</label>
                                        <input type="number" class="form-control" id="edad" name="edad" placeholder="Edad del paciente">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Celular</label>
                                        <input type="number" class="form-control" name="celular" placeholder="Número de telefono con código de área">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-5">
                                    <div class="mb-3">
                                        <label class="form-label">Domicilio</label>
                                        <input class="form-control" name="domicilio" type="text" placeholder="Domicilio">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Colonia</label>
                                        <input type="text" class="form-control" name="colonia" placeholder="Colonia">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">No. Seguro</label>
                                        <input type="text" class="form-control" name="seguro_popular" placeholder="NSS">
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Vigencia inicio</label>
                                        <div class="input-group date datepicker"  style="padding: 0">
                                            <input type="text" class="form-control" id="vigencia_inicio" name="vigencia_inicio">
                                            <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label">Vigencia fin</label>
                                        <div class="input-group date datepicker" style="padding: 0" >
                                            <input type="text" class="form-control" id="vigencia_fin" name="vigencia_fin" >
                                            <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Correo electrónico">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label">Empresa</label>   
                                        <select class="js-example-basic-multiple form-control" multiple='multiple' id='id_empresa_paciente' name="id_empresa" data-width="100%">
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
</div>


<!------------------------------------------------- NUEVA EMPRESA ------------------------------------------------->
<div class="modal fade" tabindex="-1" aria-labelledby="empresaModalLabel" aria-hidden="true" id="modal_empresa">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="storeEmpresaForm">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="mb-3">
                                <label class="form-label">Clave</label>
                                <input class="form-control" id='clave' name="clave" value="<?php echo e(old('clave')); ?>" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">RFC</label>
                                <input class="form-control" id="rfc" name="rfc" value="" type="text">
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="mb-3">
                                <label class="form-label">Descripcion</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="mb-3">
                                <label class="form-label">Calle</label>
                                <input class="form-control" id="calle" name="calle" value="" type="text">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Colonia</label>
                                <input type="text" class="form-control" id="colonia" name="colonia" value="">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" name="ciudad" value="">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id='email' name="email" value="" >
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="mb-3">
                                <label class="form-label">Telefono</label>
                                <input type="number" class="form-control" name="telefono" value="<?php echo e(old('telefono')); ?>">
                                
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Contacto</label>
                                <input type="text" class="form-control" name="contacto" value="<?php echo e(old('contacto')); ?>">
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label class="form-label">Lista de precios</label>
                                <select name="lista_precio" id="lista_precio" class="form-select js-example-basic-multiple" multiple="multiple"  data-width="100%">
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar empresa</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!---------------------------------------------- NUEVO MEDICO------------------------------------------------------>
<div class="modal fade " tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" id='modal_doctor'>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo medico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id='storeDoctorForm'>
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="mb-3">
                                        <label class="form-label">Clave</label>
                                        <input class="form-control" name="clave" value="<?php echo e(old('clave')); ?>"type="text" placeholder="Clave doctor">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input class="form-control" name="nombre" value="<?php echo e(old('nombre')); ?>" type="text" placeholder="Nombre completo">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Telefono</label>
                                        <input type="number" class="form-control" name="telefono" value="<?php echo e(old('telefono')); ?>" placeholder="Número de télefono">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="mb-3">
                                        <label class="form-label">Celular</label>
                                        <input type="number" class="form-control" name="celular" value="<?php echo e(old('celular')); ?>" placeholder="Número de celular">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" placeholder="Correo electrónico">
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
</div>

<!------------------------------------------- RECIBO DE PAGO ------------------------------------------->
<div class="modal fade" id="modal_cobro" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCobroRecepcion" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content static">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCobroRecepcion">Cobro</h5>
                <button onclick="renueva_recepcion()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="#" id="formVenta">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <a type="button" id='boton-etiquetas' onclick="genera_etiquetas()" class="btn btn-sm btn-success"> <i class="mdi mdi-ticket-account"></i> Generar etiqueta</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div>
                        <div>
                            <div>
                                <input type="hidden" id="identificador_folio" name="identificador_folio" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="">Total</label>
                                <input readonly type="text" placeholder="$00.00" id="solicitud_total" name="total" class="form-control fs-2">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="">Descuento</label>
                                <input onkeyup="calcula_cobro()"  type="number" id="solicitud_descuento" name="descuento" class="form-control fs-2" placeholder="$00.00">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="">Subtotal</label>
                                <input readonly type="text" placeholder="$00.00" id="solicitud_subtotal" name="subtotal" class="form-control fs-2">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="">Metodo de pago</label>
                                <select class="js-example-basic-single form-control fs-2" name="metodo_pago" id="solicitud_metodo">
                                    <option disabled>Seleccione metodo de pago</option>
                                    <option value="efectivo">Efectivo</option>
                                    <option value="tarjeta">Tarjeta</option>
                                    <option value="transferencia">Transferencia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="">Cobro</label>
                                <input onkeyup="calcula_cambio()" type="number" id="solicitud_pago" name="importe" class="form-control fs-2" placeholder="$00.00" value="0">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="">Cambio</label>
                                <input readonly type="text" placeholder="$00.00" value="$00.00" id="solicitud_cambio" name="cambio" class="form-control fs-2">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Observaciones</label>
                                <textarea name="solicitud_observaciones" id="observaciones" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Formato de ticket de venta</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input value="ticket" type="radio" class="form-check-input" name="factura_radio" id="factura1">
                                        <label class="form-check-label" for="factura1">
                                            Ticket
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input value="hoja" checked type="radio" class="form-check-input" name="factura_radio" id="factura2">
                                        <label class="form-check-label" for="factura2">
                                            Hoja
                                        </label>
                                    </div>
                                    
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    

                </form>
                
                <button type="submit" id='boton-pagar' onclick="genera_venta()" class="btn btn-primary"> <i id='casher' class="mdi mdi-cash"></i> 
                    <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                    Generar venta
                </button>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php $__env->startPush('plugin-scripts'); ?>
<script src="<?php echo e(asset('public/assets/plugins/jquery-validation/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/inputmask/jquery.inputmask.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/select2/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/js/axios.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/moment/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('custom-scripts'); ?>

<script src="<?php echo e(asset('public/stevlab/recepcion/registro/select2.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/recepcion/registro/caja.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/recepcion/registro/datepicker.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/recepcion/registro/form-validation.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/recepcion/registro/functions.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/recepcion/registro/inputmask.js')); ?>?v=<?php echo rand();?>"></script>


<?php $__env->stopPush(); ?>


<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/recepcion/registro/index.blade.php ENDPATH**/ ?>