<?php $__env->startPush('plugin-styles'); ?> 
<link href="<?php echo e(asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.dashboard')); ?>">StevLab</a></li>
        <li class="breadcrumb-item active" aria-current="page"> <a href="">Catalogo</a> </li>
        <li class="breadcrumb-item active" aria-current="page"> <a href="">Doctores</a> </li>
    </ol>
</nav>





<!------------------------------------------------------------------------------------------------>

<div class="row">
<?php if(session('msg')): ?>
    <div class="alert alert-warning">
        <?php echo e(session('msg')); ?>

    </div>
<?php endif; ?>
<?php if(session('msj')): ?>
        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <i data-feather="alert-circle"></i>
            <strong>Aviso!</strong> <?php echo e(session('msj')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
<?php else: ?>
<?php endif; ?>
</div>
    <div class="row">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear_doctores')): ?>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">

                        <form method="post" action="<?php echo e(route('stevlab.catalogo.doctores_guardar')); ?>">
                        <?php echo csrf_field(); ?>  

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                <label class="form-label">Clave</label>
                                <input class="form-control <?php $__errorArgs = ['clave'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="clave" value="<?php echo e(old('clave')); ?>"type="text">
                                <?php $__errorArgs = ['clave'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="mb-3">
                                <label class="form-label">Nombre completo</label>
                                <input class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="nombre" value="<?php echo e(old('nombre')); ?>" type="text">
                                <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                            <label class="form-label">Telefono</label>
                            <input type="number" class="form-control" name="telefono" value="<?php echo e(old('telefono')); ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label class="form-label">Celular</label>
                                <input type="number" class="form-control" name="celular" value="<?php echo e(old('celular')); ?>">
                            </div>
                            </div>
                            
                        </div>
                        <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>">
                            </div>
                        </div>
                        </div>
                        <button type="submit" onclick="showSwal('mixin')" class="btn btn-primary">Guardar</button>
                        </form>
                    </div>
                </div> 
            </div>
        <?php endif; ?>
        <div class="col-md-6  stretch-card grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                <th>Clave</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $doctores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="data"><?php echo e($doctor->clave); ?></td>
                                    <td><?php echo e($doctor->nombre); ?></td>
                                    <td>
                                        <a onclick='mostrarModal(this)' type="button" class="btn btn-xs btn-success btn-icon"><i data-feather="edit"></i></a>
                                        <a type="button" class="btn btn-xs btn-danger btn-icon" href="<?php echo e(route('stevlab.catalogo.doctor_eliminar',$doctor->id)); ?>"><i data-feather="trash-2"></i></a>
                                        <?php if(auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo'): ?>
                                            <?php if($doctor->user()->first() !== null): ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('editar_usuarios')): ?>
                                                    <a type='button' href="<?php echo e(route('stevlab.catalogo.edit-user-doctor', $doctor->id)); ?>" class='btn btn-xs btn-secondary btn-icon'>
                                                        <i data-feather='user-check'></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear_usuarios')): ?>
                                                    <a type='button' href="<?php echo e(route('stevlab.catalogo.upload-doctor', $doctor->id)); ?>" class='btn btn-xs btn-info btn-icon'>
                                                        <i data-feather='users'></i>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!----------------------------Tabla--------------------------------------------------------------->
<div class="row">
    
</div>
<!-----------modal------------------------------------------------------------------------------>
<!-- Button trigger modal -->

<!-- Modal editar-->
<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditar" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="modalEditar">Editar doctores</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
    </div>
    <div class="modal-body">
        <form action="<?php echo e(route('stevlab.catalogo.doctor_actualizar')); ?>" method="post">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-sm-4">
                <input class="form-control" id='id' name="id" value="" type="hidden">
            <div class="mb-3">
                <label class="form-label">Clave</label>
                <input class="form-control" id='clave' name="clave" value="" type="text">
            </div>
            </div>
            <div class="col-sm-8">
            <div class="mb-3">
                <label class="form-label">Nombre completo</label>
                <input class="form-control" name="nombre" value="" type="text" id="nombre">
            </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
            <div class="mb-3">
                <label class="form-label">Telefono</label>
                <input type="number" class="form-control" name="telefono" value="" id="telefono">
            </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                <label class="form-label">Celular</label>
                <input type="number" class="form-control" name="celular" value="" id="celular">
                </div>
            </div>
            
        </div>
        <div class="row">
            <div class="col-sm-12">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="" id="email">
            </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </div>
    
    </form>
    </div>
</div>
</div>
<!------------------------------------------------------------------------------------------------>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('plugin-scripts'); ?>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/js/axios.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('custom-scripts'); ?>
<script src="<?php echo e(asset('public/assets/js/data-table.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/doctores/functions.js')); ?>?v=<?php echo rand();?>"></script>
<?php $__env->stopPush(); ?>






<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/catalogo/doctores/index.blade.php ENDPATH**/ ?>