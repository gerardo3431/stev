<?php $__env->startPush('plugin-styles'); ?>
    <link href="<?php echo e(asset('public/assets/plugins/dropify/css/dropify.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.dashboard')); ?>">StevLab</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Utilerias </li>
            <li class="breadcrumb-item active" aria-current="page"> Fitosanitario </li>
        </ol>
    </nav>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
    <?php endif; ?>

    <?php if(session('msj')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('msj')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Responsable sanitario</h4>
                    <form enctype="multipart/form-data" id="registro_estudios" action="<?php echo e(route('stevlab.utils.fitosanitario-update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type='hidden' class="form-control <?php echo e($errors->has('id') ? 'is-invalid' : ''); ?>" name="id"  placeholder="Identificador" value='<?php echo e(old('id', $laboratorio->id)); ?>'>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="responsable_sanitario" class="form-label">Responsable sanitario</label>
                                    <input type='text' class="form-control <?php echo e($errors->has('responsable_sanitario') ? 'is-invalid' : ''); ?>" name="responsable_sanitario"  placeholder="Nombre" value='<?php echo e(old('responsable_sanitario', $laboratorio->responsable_sanitario)); ?>'>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'responsable_sanitario']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'responsable_sanitario']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="cedula_sanitario" class="form-label">Cedula</label>
                                    <input type='number' class="form-control <?php echo e($errors->has('cedula_sanitario') ? 'is-invalid' : ''); ?>" name="cedula_sanitario"  placeholder="Cedula" value='<?php echo e(old('cedula_sanitario', $laboratorio->cedula_sanitario)); ?>'>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'cedula_sanitario']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'cedula_sanitario']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="firma_sanitario" class="form-label">Firma</label>
                                    
                                    <input type="file" class="" id="firma_sanitario" name="firma_sanitario"  data-default-file="<?php echo e(asset('public/storage/' . $laboratorio->firma_sanitario)); ?>"  data-allowed-file-extensions="png"/>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'firma_sanitario']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'firma_sanitario']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Responsable imagenologia</h4>
                    <form enctype="multipart/form-data" id="registro_estudios" action="<?php echo e(route('stevlab.utils.fitosanitario-img-update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <input type='hidden' class="form-control <?php echo e($errors->has('id') ? 'is-invalid' : ''); ?>" name="id"  placeholder="Identificador" value='<?php echo e(old('id', $laboratorio->id)); ?>'>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="responsable_img" class="form-label">Responsable sanitario</label>
                                    <input type='text' class="form-control <?php echo e($errors->has('responsable_sanitario') ? 'is-invalid' : ''); ?>" name="responsable_img"  placeholder="Nombre" value='<?php echo e(old('responsable_img', $laboratorio->responsable_img)); ?>'>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'responsable_img']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'responsable_img']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="cedula_img" class="form-label">Cedula</label>
                                    <input type='number' class="form-control <?php echo e($errors->has('cedula_img') ? 'is-invalid' : ''); ?>" name="cedula_img"  placeholder="Cedula" value='<?php echo e(old('cedula_sanitario', $laboratorio->cedula_img)); ?>'>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'cedula_img']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'cedula_img']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="firma_img" class="form-label">Firma</label>
                                    
                                    <input type="file" class="" id="firma_img" name="firma_img"  data-default-file="<?php echo e(asset('public/storage/' . $laboratorio->firma_img)); ?>"  data-allowed-file-extensions="png"/>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'firma_img']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'firma_img']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('plugin-scripts'); ?>
    <script src="<?php echo e(asset('public/assets/plugins/dropify/js/dropify.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('custom-scripts'); ?>
    <script src="<?php echo e(asset('public/stevlab/utils/fitosanitario/dropify.js')); ?>?v=<?php echo rand();?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/utils/fitosanitario/index.blade.php ENDPATH**/ ?>