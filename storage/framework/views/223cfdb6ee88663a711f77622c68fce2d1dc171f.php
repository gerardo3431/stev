<?php $__env->startPush('plugin-styles'); ?>
    <link href="<?php echo e(asset('public/assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    

<div class="row">
    <div class="d-md-block col-md-6 col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Rol</h4>
                <div class="row">
                    <div class="col-md-12">
                        <label for="" class="form-label">Rol asignado</label>
                        <div class="mb-3">
                            <?php if($usuario->roles()): ?>
                                <span class="badge bg-light text-dark"><?php echo e($usuario->roles()->first() ? $usuario->roles()->first()->name : ''); ?></span>
                            <?php else: ?>
                                <span class="badge badge-danger bg-danger">No rol asignado</span>
                            <?php endif; ?>

                            
                        </div>
                    </div>
                </div>
                <form action="<?php echo e(route('stevlab.administracion.update-user-roles')); ?>" method="post" >
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Asignar o revocar rol</label>
                                <input type="hidden" name="user" value="<?php echo e($usuario->id); ?>">
                                
                                <select name="permisos" id="permisos" class="form-select js-example-basic-multiple" data-width="100%">
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(auth()->user()->hasRole(['Administrador', 'Contador'])): ?>
                                            <option value="<?php echo e($rol->id); ?>"><?php echo e($rol->name); ?></option>
                                        <?php else: ?>
                                            <?php if(!in_array($rol->name, ['Doctor', 'Empresa'])): ?>
                                                <option <?php echo e($usuario->hasRole($rol) ? 'selected' : ''); ?> value="<?php echo e($rol->id); ?>">
                                                    <?php echo e($rol->name); ?>

                                                </option>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary">Actualizar rol</button>
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
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/administracion/usuarios/roles.blade.php ENDPATH**/ ?>