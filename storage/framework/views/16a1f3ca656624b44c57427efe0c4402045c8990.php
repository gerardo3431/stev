<?php $__env->startPush('plugin-styles'); ?>
    <link href="<?php echo e(asset('public/assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    

<div class="row">
    <div class="d-md-block col-md-6 col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Sucursales</h4>
                <div class="row">
                    <div class="col-md-12">
                        <label for="" class="form-label">Sucursales asignadas:</label>
                        <div class="mb-3">
                            <?php $__empty_1 = true; $__currentLoopData = $usuario->sucursal()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sucursal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <span class="badge bg-light text-dark"><?php echo e($sucursal->sucursal); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <span class="badge badge-danger bg-danger">No sucursales asignadas</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <form action="<?php echo e(route('stevlab.administracion.update-user-subsidiaries')); ?>" method="post" >
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Asignar o revocar sucursales</label>
                                <input type="hidden" name="user" value="<?php echo e($usuario->id); ?>">
                                
                                <select multiple='multiple' name="permisos[]" id="permisos" class="form-select js-example-basic-multiple" data-width="100%">
                                    <?php $__currentLoopData = $subsidiaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sucursal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($usuario->sucursal()->where('subsidiary_id', $sucursal->id)->first()): ?>
                                            <option selected value="<?php echo e($sucursal->id); ?>"><?php echo e($sucursal->sucursal); ?></option>
                                        <?php else: ?>
                                            <option value="<?php echo e($sucursal->id); ?>"><?php echo e($sucursal->sucursal); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary">Actualizar sucursales</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('plugin-scripts'); ?>
    <script src="<?php echo e(asset('public/assets/plugins/select2/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/js/axios.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('custom-scripts'); ?>
    <script src="<?php echo e(asset('public/stevlab/administracion/usuarios/select2.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/administracion/usuarios/subsidiaries.blade.php ENDPATH**/ ?>