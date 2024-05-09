<?php $__env->startPush('plugin-styles'); ?>
    <link href="<?php echo e(asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>" rel="stylesheet" />

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.dashboard')); ?>">StevLab</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="<?php echo e(route('stevlab.recepcion.pendientes')); ?>">Pendientes de pago</a> </li>
        </ol>
    </nav>
    <?php if(session('status') == 'Debes aperturar caja antes de empezar a trabajar.'): ?>

    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
        <i data-feather="alert-circle"></i>
        <strong>Aviso!</strong> <?php echo e(session('status')); ?> <a href="<?php echo e(route('stevlab.caja.index')); ?>" class="alert-link">Click aquí</a>. 
    </div>

    <?php elseif(session('status')== 'Caja cerrada automáticamente...'): ?>

    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
        <i data-feather="alert-circle"></i>
        <strong>Aviso!</strong> <?php echo e(session('status')); ?> <a href="<?php echo e(route('stevlab.caja.index')); ?>" class="alert-link">Click aquí</a> 
    </div>

    <?php else: ?>
        <div class="row">
            <div class="d-md-block col-md-12 col-lg-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Busqueda folios pendientes de pago</h6>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Sucursal</label>
                                    <select class="form-select consultaEstudios" id="select_sucursal">
                                        <option selected value="todo">Todo</option>
                                        <?php $__currentLoopData = $sucursales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$sucursal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sucursal->id); ?>"><?php echo e($sucursal->sucursal); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Fecha inicial</label>
                                    <div class="input-group date datepicker consultaEstudios" >
                                        <input type="text" class="form-control" id="select_inicio">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div><!-- Col -->
                        </div><!-- Row -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Fecha final</label>
                                    <div class="input-group date datepicker consultaEstudios" >
                                        <input type="text" class="form-control" id="select_final" >
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div><!-- Col -->
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-9 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Folios</h4>
                        <div class="table-responsive">
                            <table id="dataTableMetodos" class="table table-hover nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Folio</th>
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody id="listPendientes">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="modal fade" id="modal_pago" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="1" aria-labelledby="modal_pago" aria-hidden='true'> 
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPago">Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="identificador_folio" name="identificador_folio" class="form-control" value="">
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="total_restante">Pago restante (actualizado)</label>
                                <span class="input-symbol-dollar">
                                    <input type="text" placeholder="$00.00" id="total_restante" name='total_restante' class="form-control fs-2">
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="">Descuento</label>
                                <span class="input-symbol-dollar">
                                    <input onkeyup="calcula_cobro()"  value="0" type="number" id="solicitud_descuento" name="solicitud_descuento" class="form-control fs-2" placeholder="$00.00">
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="">Subtotal</label>
                                <span class="input-symbol-dollar">
                                    <input disabled type="text" placeholder="$00.00" id="solicitud_subtotal" name="solicitud_subtotal" class="form-control fs-2">
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="">Metodo de pago</label>
                                <select class="js-example-basic-single form-control fs-2" name="solicitud_metodo" id="solicitud_metodo">
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
                                <input onkeyup="calcula_cambio()" type="number" id="solicitud_pago" name="solicitud_pago" class="form-control fs-2" placeholder="$00.00" value="0">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label" for="">Cambio</label>
                                <input disabled type="text" placeholder="$00.00" id="solicitud_cambio" name="solicitud_cambio" class="form-control fs-2">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Observaciones</label>
                                <textarea name="solicitud_observaciones" id="solicitud_observaciones" cols="30" rows="3" class="form-control"></textarea>
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
                                        <input value="hoja" type="radio" class="form-check-input" name="factura_radio" id="factura2" checked>
                                        <label class="form-check-label" for="factura2" >
                                            Hoja
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <button type="submit" onclick="genera_venta()" class="btn btn-primary"> <i class="mdi mdi-cash"></i>Pagar</button>
                    
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('plugin-scripts'); ?>
    <script src="<?php echo e(asset('public/assets/js/axios.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/moment/moment.min.js')); ?>"></script>



<?php $__env->stopPush(); ?>

<?php $__env->startPush('custom-scripts'); ?>
    <script src="<?php echo e(asset('public/stevlab/recepcion/pendientes/datepicker.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/recepcion/pendientes/functions.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/recepcion/pendientes/caja.js')); ?>?v=<?php echo rand();?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/recepcion/pendientes/index.blade.php ENDPATH**/ ?>