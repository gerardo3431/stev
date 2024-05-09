<?php $__env->startPush('plugin-styles'); ?>
    <link href="<?php echo e(asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/dropify/css/dropify.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.dashboard')); ?>">StevLab</a></li>
            <li class="breadcrumb-item"> <a href="#">Reportes</a></li>
            <li class="breadcrumb-item active" aria-current="page">Ventas</li>
        </ol>
    </nav>

    <div class="row">
        <div class="d-md-block col-md-12 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Reporte de ventas</h6>
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Fecha inicial</label>
                                <div class="input-group date datepicker consultaEstudios" style="padding: 0">
                                    <input type="text" class="form-control" id="selectInicio">
                                    <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Fecha final</label>
                                <div class="input-group date datepicker consultaEstudios" style="padding: 0">
                                    <input type="text" class="form-control" id="selectFinal" >
                                    <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Doctores</label>
                                <div>
                                    <a class="btn btn-outline-primary" data-bs-toggle="collapse" href="#collapseDoctors" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="mdi mdi-arrow-down-drop-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Empresas</label>
                                <div>
                                    <a class="btn btn-outline-primary" data-bs-toggle="collapse" href="#collapseEmpresa" role="button" aria-expanded="false" aria-controls="collapseExample">
                                        <i class="mdi mdi-arrow-down-drop-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6 col-xl-6">
                            <div class="collapse" id="collapseDoctors">
                                <div class="mb-3">
                                    <label for="listDoctors" class="form-label">Doctor</label>
                                    <select name="listDoctors" id="listDoctors" class="js-example-basic-multiple form-select" multiple='multiple' data-width="100%">
                                    </select>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'listDoctors']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'listDoctors']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6 col-xl-6">
                            <div class="collapse" id="collapseEmpresa">
                                <div class="mb-3">
                                    <label for="listEmpresas" class="form-label">Empresa</label>
                                    <select name="listEmpresas" id="listEmpresas" class="js-example-basic-multiple form-select" multiple='multiple' data-width="100%">
                                    </select>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'listEmpresas']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'listEmpresas']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3">
                            <button id="addForm"  type="submit" class="btn btn-success">
                                <span id='showAddForm' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                                Buscar
                            </button>
                            <button onclick="window.print();" id="generateReport"  type="submit" class="btn btn-primary">
                                <span id='showGenReport' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                                Generar reporte
                            </button>
                        </div>
                    </div>
                    <hr>
                    <h6 class="card-title">Generar reporte</h6>
                    <div class="row">
                        <div class="mb-3">
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Doctores</h4>
                    <div class="table-responsive">
                        <table  class="table table-hover nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <td>Doctor</td>
                                    <td>Total ventas</td>
                                    <td>Comisión %</td>
                                    <td>Total comisión</td>
                                </tr>
                            </thead>
                            <tbody id="renderDoc">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Empresas</h4>
                    <div class="table-responsive">
                        <table  class="table table-hover nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <td>Empresa</td>
                                    <td>Total ventas</td>
                                    <td>Comisión %</td>
                                    <td>Total comisión</td>
                                </tr>
                            </thead>
                            <tbody id="renderEmp">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Folios</h4>
                    <div class="table-responsive">
                        <table  class="table table-hover nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <td>Folio</td>
                                    <td>Paciente</td>
                                    <td>Doctor</td>
                                    <td>Empresa</td>
                                    <td>Pago</td>
                                    <td>Descuento</td>
                                    <td>Adeudo</td>
                                    <td>Total</td>
                                </tr>
                            </thead>
                            <tbody id="renderFol">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

<?php $__env->stopSection(); ?>


<?php $__env->startPush('plugin-scripts'); ?>
<script src="<?php echo e(asset('public/assets/js/axios.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/select2/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/moment/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/dropify/js/dropify.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/ckeditor5-build-classic/ckeditor.js')); ?>" ></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('custom-scripts'); ?>
    <script src="<?php echo e(asset('public/stevlab/reportes/ventas/functions.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/reportes/ventas/select2.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/reportes/ventas/datepicker.js')); ?>?v=<?php echo rand();?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/reportes/ventas/index.blade.php ENDPATH**/ ?>