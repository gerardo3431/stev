<?php $__env->startPush('plugin-styles'); ?>
    <link href="<?php echo e(asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/lunar/css/lunar.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet" />
    
    
    <link href="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" />

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.doctor.dashboard')); ?>">StevLab</a></li>
            <li class="breadcrumb-item"> <a href="#">Doctor</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard doctor</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Bienvenido <?php echo e(auth()->user()->name); ?></h4>
        </div>
    </div>
    <ul class="nav justify-content-center  nav-tabs">
        <li class="nav-item ">
            <a class="nav-link" data-bs-toggle="collapse" href="#prefolios_tab" role="button" aria-expanded="" aria-controls="advanced-ui">
                <i class="mdi mdi-human"></i>
                <span class="link-title">Buscar por prefolios</span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" data-bs-toggle="collapse" href="#general_tab" role="button" aria-expanded="" aria-controls="advanced-ui">
                <i class="mdi mdi-flask-outline"></i>
                <span class="link-title">Busqueda general</span>
            </a>
        </li>
    </ul>
    
    <div class="row collapse" id="prefolios_tab">
        <div class="d-md-block col-md-12 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Busqueda por prefolios</h6>
                        <div class="row">
                            <form id='searchPatient'>
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-md-4 col-lg-4 col-xl-2">
                                        <div class="mb-3">
                                            <label class="form-label">Prefolio</label>
                                            <input onkeyup="searchPatient(this)" type="text" class="form-control" id="folio" name="folio" placeholder="folio">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-8 col-xl-4">
                                        <div class="mb-3">
                                            <label class="form-label">Paciente</label>
                                            <select name="paciente" id="paciente" class="form-select js-example-basic-multiple" multiple="multiple"  data-width="100%">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-3">
                                        <div class="mb-3">
                                            <label class="form-label">Fecha inicial</label>
                                            <div class="input-group date datepicker consultaEstudios" style="padding: 0">
                                                <input type="text" class="form-control" id="selectInicio" name="inicio">
                                                <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-3">
                                        <div class="mb-3">
                                            <label class="form-label">Fecha final</label>
                                            <div class="input-group date datepicker consultaEstudios" style="padding: 0">
                                                <input type="text" class="form-control" id="selectFinal" name="final" >
                                                <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-13 col-lg-12 ">
                                <div class="mb-3">
                                    <button onclick="search_patient()" type="submit" class="btn btn-success"><i class="mdi mdi-account-search"></i>Buscar</button>
                                </div>
                            </div>  
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Historial de pacientes</h4>
                    <div class="table-responsive">
                        <table id="dataTableMetodos" class="table table-hover nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Nombre</th>
                                    <th>Observaciones</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="listPacientes">
                            </tbody>
                        </table>
                    </div>
                </div>
                
                
                
            </div>
        </div>
    </div>  
    
    <div class="row collapse" id="general_tab">
        <div class="d-md-block col-md-12 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Busqueda general</h6>
                        <div class="row">
                            <div class="col-md-4 col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Folio</label>
                                    <input onkeyup="searchPatient(this)" type="number" class="form-control" id="folio_general" name="folio_general" placeholder="folio">
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Paciente</label>
                                    <select name="paciente_general" id="paciente_general" class="form-select js-example-basic-multiple" multiple="multiple"  data-width="100%">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12 ">
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-danger btn-xs btn-icon"><i class="mdi mdi-delete-sweep"></i></button>
                                </div>
                            </div>  
                        </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Resultados</h6>
                    <div class="table-responsive-md">
                        <table id='dataTableFolioGeneral' class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Folio</th>
                                    <th>Paciente</th>
                                    <th>Sucursal</th>
                                    <th>Empresa</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody id='listFolios'>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <pre>
        
    </pre>

    
    <div class="modal fade "   id="demoModal"  tabindex="-1" role="dialog" aria-labelledby="demoModal" aria-hidden="true">
        <div class="modal-dialog modal-lg  modal-dialog-centered  " role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="btn-close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="container-fluid" style="padding-left: 0; padding-right: 0;">
                    <div class="row">
                        <div class="col-md-12 bg-img">
                            
                            <a target="_blank" href="<?php echo e($url); ?>"><img src="<?php echo e(asset('public/assets/images/images/window.png')); ?>" width="100%" height="100%"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('plugin-scripts'); ?>
    
    
    <script src="<?php echo e(asset('public/assets/plugins/bootstrap/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/lunar/js/lunar.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/select2/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/moment/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('custom-scripts'); ?>
    <script src="<?php echo e(asset('public/stevlab/doctor/dashboard/data-table.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/empresa/dashboard/popup.js')); ?>?v=<?php echo rand();?>"></script>

    <script src="<?php echo e(asset('public/stevlab/doctor/dashboard/select2.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/doctor/dashboard/datepicker.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/doctor/dashboard/functions.js')); ?>?v=<?php echo rand();?>"></script>

    
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.master4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/doctor/recepcion/index.blade.php ENDPATH**/ ?>