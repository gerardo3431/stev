<?php $__env->startPush('plugin-styles'); ?>
    <link href="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.dashboard')); ?>">StevLab</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="#">Catálogo</a></li>
        <li class="breadcrumb-item active" aria-current="page">Estudios</li>
        
    </ol>
</nav>
<div class="row">
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear_estudios')): ?>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Estudios</h4>
                    <form id="registro_estudios" action="<?php echo e(route('stevlab.catalogo.store-studio')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-6">
                                    <label for="clave" class="form-label">Clave</label>
                                    <input type='text' class="form-control <?php echo e($errors->has('clave') ? 'is-invalid' : ''); ?>" name="clave"  placeholder="Clave" value='<?php echo e(old('clave')); ?>'>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'clave']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'clave']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="codigo" class="form-label">Código</label>
                                    <input type="text" class="form-control <?php echo e($errors->has('codigo') ? 'is-invalid' : ''); ?>" name="codigo"  placeholder="Código" value='<?php echo e(old('codigo')); ?>'>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'codigo']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'codigo']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripcion</label>
                                    <textarea class='form-control <?php echo e($errors->has('descripcion') ? 'is-invalid' : ''); ?>' name="descripcion" rows="3" placeholder="Descripción" value='<?php echo e(old('descripcion')); ?>'></textarea>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'descripcion']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'descripcion']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="area" class="form-label">Área</label>
                                    <select class="form-select <?php echo e($errors->has('area') ? 'is-invalid' : ''); ?>" name="area" value='<?php echo e(old('area')); ?>'>
                                        <?php $__empty_1 = true; $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($area->id); ?>"><?php echo e($area->descripcion); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'area']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'area']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="muestra" class="form-label">Tipo muestra</label>
                                    <select class="form-select <?php echo e($errors->has('muestra') ? 'is-invalid' : ''); ?>" name="muestra" value='<?php echo e(old('muestra')); ?>'>
                                        <?php $__empty_1 = true; $__currentLoopData = $muestras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $muestra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($muestra->id); ?>"><?php echo e($muestra->descripcion); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'muestra']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'muestra']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="recipiente" class="form-label">Recipiente</label>
                                    <select class="form-select <?php echo e($errors->has('recipiente') ? 'is-invalid' : ''); ?>" name="recipiente" value='<?php echo e(old('recipiente')); ?>'>
                                        <?php $__empty_1 = true; $__currentLoopData = $recipientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recipiente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($recipiente->id); ?>"> <?php echo e($recipiente->descripcion); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'recipiente']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'recipiente']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="metodo" class="form-label">Método</label>
                                    <select class="form-select <?php echo e($errors->has('metodo') ? 'is-invalid' : ''); ?>" name="metodo" value='<?php echo e(old('metodo')); ?>'>
                                        <?php $__empty_1 = true; $__currentLoopData = $metodos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metodo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($metodo->id); ?>"> <?php echo e($metodo->descripcion); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'metodo']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'metodo']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="tecnica" class="form-label">Técnica</label>
                                    <select class="form-select <?php echo e($errors->has('tecnica') ? 'is-invalid' : ''); ?>" name="tecnica" value='<?php echo e(old('tecnica')); ?>'>
                                        <?php $__empty_1 = true; $__currentLoopData = $tecnicas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tecnica): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($tecnica->id); ?>"> <?php echo e($tecnica->descripcion); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                        
                                    </select>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'tecnica']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'tecnica']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                
                                <div class="mb-3 col-sm-12">
                                    <label for="condiciones" class="form-label">Condiciones del paciente</label>
                                    <textarea class='form-control <?php echo e($errors->has('condiciones') ? 'is-invalid' : ''); ?>' name="condiciones" rows="3"placeholder='Condiciones' value='<?php echo e(old('condiciones')); ?>'></textarea>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'condiciones']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'condiciones']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3 col-sm-12">
                                    <label for="aplicaciones" class="form-label">Aplicaciones</label>
                                    <textarea class='form-control <?php echo e($errors->has('aplicaciones') ? 'is-invalid' : ''); ?>' name="aplicaciones" rows="3"placeholder='Aplicaciones' value='<?php echo e(old('aplicaciones')); ?>'></textarea>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'aplicaciones']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'aplicaciones']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="dias_proceso" class="form-label">Días de proceso</label>
                                    <input type="number" class="form-control <?php echo e($errors->has('dias_proceso') ? 'is-invalid' : ''); ?>" name="dias_proceso" placeholder='Días de proceso' value='<?php echo e(old('dias_proceso')); ?>'>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'dias_proceso']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'dias_proceso']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="number" class="form-control <?php echo e($errors->has('precio') ? 'is-invalid' : ''); ?>" name="precio" placeholder='$' value='<?php echo e(old('precio')); ?>'>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'precio']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'precio']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Validación</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="valida_qr" class="form-check-input" id="valida_qr">
                                            <label class="form-check-label" for="valida_qr">
                                            Validar con qr
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 d-md-block grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tabla de estudio</h4>
                <div class="mb-3">
                    <div class="table-responsive">
                        <table id="dataTableEstudios" class="table table-sm table-hover nowrap" width="100%">
                            <thead>
                                <tr> 
                                    <th>Clave</th>
                                    <th>Descripcion</th>
                                    <th>Condiciones</th>
                                    <th>Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-ver-estudio" tabindex="-1" aria-labelledby="verModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarModalLabel">Ver estudio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="card-body" id="cuerpo_ver">
                
            </div>               
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar modal</button>
            </div>
        </div>
    </div>
</div>

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('editar_estudios')): ?>
    <div class="modal fade" id="modal-editar-estudio" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarModalLabel">Editar estudio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="identificador">
                    <form id="edit_registro_estudios"  method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-6">
                                    <label for="clave" class="form-label">Clave</label>
                                    <input type='text' class="form-control" id='edit_clave' name="clave"  placeholder="Clave">
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="codigo" class="form-label">Código</label>
                                    <input type="text" class="form-control" id="edit_codigo" name="codigo"  placeholder="Código">
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripcion</label>
                                    <textarea class='form-control' id="edit_descripcion" name="descripcion" rows="3" placeholder="Descripción"></textarea>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="area" class="form-label">Área</label>
                                    <select class="form-select " id='area' name="area">
                                        <?php $__empty_1 = true; $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($area->id); ?>"><?php echo e($area->descripcion); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="muestra" class="form-label">Tipo muestra</label>
                                    <select class="form-select" id='muestra' name="muestra">
                                        <?php $__empty_1 = true; $__currentLoopData = $muestras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $muestra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($muestra->id); ?>"><?php echo e($muestra->descripcion); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="recipiente" class="form-label">Recipiente</label>
                                    <select class="form-select" id='recipiente' name="recipiente">
                                        <?php $__empty_1 = true; $__currentLoopData = $recipientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recipiente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($recipiente->id); ?>"> <?php echo e($recipiente->descripcion); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="metodo" class="form-label">Método</label>
                                    <select class="form-select" id='metodo' name="metodo">
                                        <?php $__empty_1 = true; $__currentLoopData = $metodos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metodo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($metodo->id); ?>"> <?php echo e($metodo->descripcion); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="tecnica" class="form-label">Técnica</label>
                                    <select class="form-select" id='tecnica' name="tecnica">
                                        <?php $__empty_1 = true; $__currentLoopData = $tecnicas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tecnica): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <option value="<?php echo e($tecnica->id); ?>"> <?php echo e($tecnica->descripcion); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <?php endif; ?>
                                        
                                    </select>
                                </div>
                                <div class="mb-3 col-sm-12">
                                    <label for="condiciones" class="form-label">Condiciones del paciente</label>
                                    <textarea class='form-control' id="edit_condiciones" name="condiciones" rows="3"placeholder='Condiciones'></textarea>
                                </div>
                                <div class="mb-3 col-sm-12">
                                    <label for="aplicaciones" class="form-label">Aplicaciones</label>
                                    <textarea class='form-control' id="edit_aplicaciones" name="aplicaciones" rows="3"placeholder='Aplicaciones'></textarea>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="dias_proceso" class="form-label">Días de proceso</label>
                                    <input type="number" class="form-control" id="edit_dias_proceso" name="dias_proceso" placeholder='Días de proceso'>
                                </div>
                                <div class="mb-3 col-sm-6">
                                    <label for="precio" class="form-label">Precio</label>
                                    <input type="number" class="form-control" id="edit_precio" name="precio" placeholder='$'>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Validación</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" name="valida_qr" class="form-check-input" id="edit_valida_qr">
                                            <label class="form-check-label" for="valida_qr">
                                            Validar con qr
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Guardar">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar modal</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('plugin-scripts'); ?>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/jquery-validation/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/axios/axios.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('custom-scripts'); ?>

<script src="<?php echo e(asset('public/stevlab/catalogo/estudios/data-table.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/estudios/functions.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/estudios/componente.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/estudios/form-validation.js')); ?>?v=<?php echo rand();?>"></script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/catalogo/estudios/index.blade.php ENDPATH**/ ?>