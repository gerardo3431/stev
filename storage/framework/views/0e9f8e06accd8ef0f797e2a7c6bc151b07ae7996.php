<?php $__env->startPush('plugin-styles'); ?>
    <link href="<?php echo e(asset('public/assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    

<div class="row">
    <div class="d-md-block col-sm-12 col-md-12 col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Permisos de: <?php echo e($usuario->name); ?></h4>
                <p class="text-muted mb-3">Asignar o revocar permisos</p>
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="checkedAll" name="checkedAll" >
                    <label class="form-check-label" for="checkedAll">
                        Seleccionar todos los permisos
                    </label>
                </div>
                <form id="permisosForm" action="<?php echo e(route('stevlab.administracion.update-permissions')); ?>" method="post" >
                    <hr>
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="hidden" name="user" value="<?php echo e($usuario->id); ?>">
                                <div class="mb-4">
                                    <?php $__currentLoopData = $permissions->chunk(ceil($permissions->count() / 3))[0]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $permiso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="permiso<?php echo e($permiso->id); ?>" name="permisos[]" value="<?php echo e($permiso->id); ?>" <?php echo e($usuario->hasPermissionTo($permiso->id) ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="permiso<?php echo e($permiso->id); ?>">
                                                <?php echo e($permiso->description); ?>

                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="hidden" name="user" value="<?php echo e($usuario->id); ?>">
                                <div class="mb-4">
                                    <?php $__currentLoopData = $permissions->chunk(ceil($permissions->count() / 3))[1]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $permiso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="permiso<?php echo e($permiso->id); ?>" name="permisos[]" value="<?php echo e($permiso->id); ?>" <?php echo e($usuario->hasPermissionTo($permiso->id) ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="permiso<?php echo e($permiso->id); ?>">
                                                <?php echo e($permiso->description); ?>

                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="hidden" name="user" value="<?php echo e($usuario->id); ?>">
                                <div class="mb-4">
                                    <?php $__currentLoopData = $permissions->chunk(ceil($permissions->count() / 3))[2]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $permiso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="permiso<?php echo e($permiso->id); ?>" name="permisos[]" value="<?php echo e($permiso->id); ?>" <?php echo e($usuario->hasPermissionTo($permiso->id) ? 'checked' : ''); ?>>
                                            <label class="form-check-label" for="permiso<?php echo e($permiso->id); ?>">
                                                <?php echo e($permiso->description); ?>

                                            </label>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <button class="btn btn-primary">Actualizar permisos</button>
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
    <script src="<?php echo e(asset('public/stevlab/administracion/usuarios/functions.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/administracion/usuarios/permission.blade.php ENDPATH**/ ?>