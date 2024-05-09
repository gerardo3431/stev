<?php $__env->startPush('plugin-styles'); ?>
    <link href="<?php echo e(asset('public/assets/plugins/dropify/css/dropify.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.dashboard')); ?>">StevLab</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.recepcion.index')); ?>">Recepcion</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="<?php echo e(route('stevlab.captura.importacion')); ?>">Importacion</a> </li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-4 grid-margin">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <form action="<?php echo e(route('stevlab.recepcion.import')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <div class="card-body">
                                <h6 class="card-title">Procesamiento</h6>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="mb-3">
                                        <label class='form-label' for="clave">Area del documento:</label>
                                        <select id="area" name="area" class="js-example-basic-multiple form-select" data-width="100%" aria-label="size 2">
                                            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($area->id); ?>"><?php echo e($area->descripcion); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="mb-3">
                                        <label for="file">Carga de archivos</label>
                                        <p class="text-muted">La aplicación de escritorio genera el archivo en: <br> 
                                            <strong>
                                                C:\Users\~~\Documents\ 
                                            </strong>
                                            <br> Donde <strong>~~</strong> es el usuario de la maquina actual.
                                        </p>
                                        <input type="file" id="file" name="file" class="<?php echo e($errors->has('file' ? 'is-invalid' : '')); ?>" data-allowed-file-extensions="xlsx" data-default-file="#">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" type="submit">Procesar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('plugin-scripts'); ?>
    <script src="<?php echo e(asset('public/assets/plugins/dropify/js/dropify.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/select2/select2.min.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('custom-scripts'); ?>
    <script src="<?php echo e(asset('public/stevlab/recepcion/importacion/importacion.js')); ?>?v=<?php echo rand();?>"></script>
    

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/recepcion/importacion/index.blade.php ENDPATH**/ ?>