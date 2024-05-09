<?php $__env->startPush('plugin-styles'); ?> 
    <link href="<?php echo e(asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/dropify/css/dropify.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>





<!----------------------------------------------------------------------------------------------------->
<!----------------------------------------------------------------------------------------------------->

<div class="row">
    <div class="col-sm-12 col-md-7 col-lg-7 col-xl-8">

        <div class="mb-3">
            <div class="row">
                <nav class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.dashboard')); ?>">StevLab</a></li>
                        <li class="breadcrumb-item" aria-current="page"> <a href="<?php echo e(route('stevlab.doctor.dashboard')); ?>">Doctor</a> </li>
                        <li class="breadcrumb-item active" aria-current="page"> <a>Prefolio</a> </li>
                    </ol>
                </nav>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10">
                    <div class="card">
                        <div class="card-body">
                                <form id='formPrefolio' enctype="multipart/form-data">
                                    <div class="row">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'error_list']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'error_list']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Nombre de solicitante:</label>
                                                <input  class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder='Nombre del solicitante' id='nombre' name="nombre" type="text" value="">
                                                <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'nombre']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'nombre']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                            </div>                           
                                        </div>                            
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="defaultconfig-4" class="form-label">Observaciones:</label>
                                                <textarea class="form-control" maxlength="1024" rows="5" placeholder="Observaciones" id="observaciones" name="observaciones"></textarea>
                                            </div>  
                                        </div> 
                                        
                                        <div class="col-md-12">
                                            <div class="mb-3">       
                                                <label class="form-label">Estudios:</label>
                                                <select name="listEstudio" id="listEstudio" multiple='multiple' class="js-example-basic-multiple form-select" data-width="100%">
                                                </select>
                                            </div>                                
                                        </div>
                                        <div class="mb-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="table-responsive-md">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Clv</th>
                                                                        <th>Descrip</th>
                                                                        <th>Tipo</th>
                                                                        <th><i class="mdi mdi-wrench"></i></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id='tablelistEstudios'>
                                                                </tbody>
                                                                <tbody id="tablelistPerfiles">
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <button id='store_prefolio' type="submit" class="btn btn-primary">Generar prefolio</button>                                        
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <div class="input-group mb-3">
                                                    <textarea hidden name="whatsapp" id="whatsapp" cols="30" rows="10"></textarea>
                                                    <input  class="form-control" placeholder='Numero de telefono' id='telefono' name="telefono" type="number" >
                                                    <button onclick="enviar_prefolio()" type="button" class="btn btn-success"><i class="mdi mdi-whatsapp "></i> Enviar por whatsapp</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>        
                </div>    
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4 col-lg-5 col-xl-4">
        <div class="mb-3">
            <div class="col-sm-12 col-md-12  grid-margin stretch-card">
                <a target="_blank" href="<?php echo e($url); ?>"><img src="<?php echo e(asset('public/assets/images/images/sidebanner.png')); ?>"></a>
            </div>
        </div>
    </div>
</div>
<!---->
<div class="modal fade" id="targetImagen" data-bs-backdrop="static" tabindex="-1" aria-labelledby="targetImagenLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adjuntar archivo</h5>
                <button onclick="clear_form()" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('stevlab.doctor.store-file-prefolio')); ?>" class="form-sample mb-3" id='formImagen' enctype="multipart/form-data" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="identificador" name="identificador" value="">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="file">Adjuntar archivo</label>
                            <input class="form-control" type="file" id="file" name="file" data-allowed-file-extensions="pdf docx rar zip png jpg jpeg">
                            <p class="text-muted">* Adjuntar archivo es opcional y no es obligatorio la carga de archivo.</p>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary submit">Guardar imagen</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!----------------------------------------------------------------------------------------------------->

<?php $__env->stopSection(); ?>

<?php $__env->startPush('plugin-scripts'); ?>
    <script src="<?php echo e(asset('public/assets/plugins/jquery-validation/jquery.validate.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/jquery-validation/additional-methods.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net/jquery.dataTables.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/js/axios.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/select2/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/ckeditor5-build-classic/ckeditor.js')); ?>" ></script>
    <script src="<?php echo e(asset('public/assets/plugins/tinymce/tinymce.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/dropify/js/dropify.min.js')); ?>"></script>
    <script src="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('custom-scripts'); ?>
    <script src="<?php echo e(asset('public/stevlab/doctor/prefolio/form-validation.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/doctor/prefolio/select2.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/doctor/prefolio/functions.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/doctor/prefolio/dropify.js')); ?>?v=<?php echo rand();?>"></script>
    <script src="<?php echo e(asset('public/stevlab/doctor/prefolio/textarea.js')); ?>?v=<?php echo rand();?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.master4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/doctor/prefolio/index.blade.php ENDPATH**/ ?>