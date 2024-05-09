<?php $__env->startPush('plugin-styles'); ?>
<link href="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css')); ?>" rel="stylesheet" />

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.dashboard')); ?>">StevLab</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="#">Catálogo</a></li>
        <li class="breadcrumb-item active" aria-current="page">Áreas de estudio</li>
        
    </ol>
</nav>
<?php if(session('msg')): ?>

    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i data-feather="alert-circle"></i>
        <strong>Aviso!</strong> <?php echo e(session('msg')); ?>. 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
    </div>
<?php endif; ?>
<div class="mb-3">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item ">
            <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#areas" role="tab" aria-expanded="" aria-controls="advanced-ui" aria-selected="true">
                <i class="mdi mdi-human"></i>
                <span class="link-title">Areas</span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#metodos" role="tab" aria-expanded="" aria-controls="advanced-ui" aria-selected="false">
                <i class="mdi mdi-flask-outline"></i>
                <span class="link-title">Metodos</span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#recipientes" role="tab" aria-expanded="" aria-controls="advanced-ui" aria-selected="false">
                <i class="mdi mdi-glass-stange"></i>
                <span class="link-title">Recipientes</span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#muestras" role="tab" aria-expanded="" aria-controls="advanced-ui" aria-selected="false">
                <i class="mdi mdi-biohazard"></i>
                <span class="link-title">Muestras</span>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" data-bs-toggle="tab" data-bs-target="#tecnicas" role="tab" aria-expanded="" aria-controls="advanced-ui" aria-selected="false">
                <i class="mdi mdi-stethoscope"></i>
                <span class="link-title">Tecnicas</span>
            </a>
        </li>
    </ul>
    <div class="tab-content border border-top-0 p-3" id="myTabContent">
        <div class="tab-pane fade show active" id="areas">
            
            <div class="row">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear_areas')): ?>
                    <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                
                                <h6 class="card-title">Áreas</h6>
                                
                                <form class="forms-sample" action="<?php echo e(route('stevlab.catalogo.store-area')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <input type="text" name='descripcion' class="form-control <?php echo e($errors->has('descripcion') ? 'is-invalid' : ''); ?>" autocomplete="off" placeholder="Descripción">
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
                                    <div class="mb-3">
                                        <label for="observaciones" class="form-label">Observaciones</label>
                                        <textarea name="observaciones" rows="3" class="form-control <?php echo e($errors->has('descripcion') ? 'is-invalid' : ''); ?>" placeholder="Observaciones"></textarea>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'observaciones']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'observaciones']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary me-2">Guardar</button>
                                    
                                </form>
                                
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tabla de áreas</h4>
                            <div class="table-responsive">
                                <table id="dataTableAreas" class="table">
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Observaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td style="white-space: pre-wrap"><?php echo e($area->descripcion); ?></td>
                                            <td style="white-space: pre-wrap"><?php echo e($area->observaciones); ?></td>
                                            <td>
                                                
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('eliminar_areas')): ?>
                                                    <a href="<?php echo e(route('stevlab.catalogo.delete-component', ['zona' => 'areas', 'id' => $area->id])); ?>" type='button' class='btn btn-danger btn-xs btn-icon' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Eliminar area'"><i class='mdi mdi-delete'></i></a> 
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <tr>
                                                <td class="text-center" colspan="3">
                                                    No data allowed
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="metodos">
            <div class="row">
                
                <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            
                            <h6 class="card-title">Métodos</h6>
                            
                            <form class="forms-sample" action="<?php echo e(route('stevlab.catalogo.store-metodo')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <input type="text" name='descripcion' class="form-control <?php echo e($errors->has('descripcion') ? 'is-invalid' : ''); ?>" autocomplete="off" placeholder="Descripción">
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
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea name="observaciones" rows="3" class="form-control <?php echo e($errors->has('observaciones') ? 'is-invalid' : ''); ?>" placeholder="Observaciones"></textarea>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'observaciones']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'observaciones']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                
                            </form>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tabla de metodos</h4>
                            <div class="table-responsive">
                                <table id="dataTableMetodos" class="table">
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Observaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $metodos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metodo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td style="white-space: pre-wrap"><?php echo e($metodo->descripcion); ?></td>
                                            <td style="white-space: pre-wrap"><?php echo e($metodo->observaciones); ?></td>
                                            <td>
                                                <a href="<?php echo e(route('stevlab.catalogo.delete-component', ['zona' => 'metodos', 'id' => $metodo->id])); ?>" type='button' class='btn btn-danger btn-xs btn-icon' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Eliminar area'"><i class='mdi mdi-delete'></i></a> 
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td>
                                                No data allowed
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        <div class="tab-pane fade" id="recipientes">
            <div class="row">
                <div class="col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Recipientes</h6>
                            <form class="forms-sample" action="<?php echo e(route('stevlab.catalogo.store-recipiente')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Descripcion</label>
                                            <input name='descripcion' type="text" class="form-control <?php echo e($errors->has('descripcion') ? 'is-invalid' : ''); ?>" placeholder="Descripción">
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
                                    </div><!-- Col -->
                                </div><!-- Row -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Marca</label>
                                            <input name='marca' type="text" class="form-control <?php echo e($errors->has('marca') ? 'is-invalid' : ''); ?>" placeholder="Marca">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'marca']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'marca']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Capacidad</label>
                                            <input name='capacidad' type="text" class="form-control <?php echo e($errors->has('capacidad') ? 'is-invalid' : ''); ?>" placeholder="Capacidad">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'capacidad']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'capacidad']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Presentación</label>
                                            <input name='presentacion' type="text" class="form-control <?php echo e($errors->has('presentacion') ? 'is-invalid' : ''); ?>" placeholder="Presentación">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'presentacion']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'presentacion']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </div>
                                    </div><!-- Col -->
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="form-label">Unidad medida</label>
                                            <input name='unidad_medida' type="text" class="form-control <?php echo e($errors->has('unidad_medida') ? 'is-invalid' : ''); ?>" placeholder="Unidad medida">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'unidad_medida']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'unidad_medida']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </div>
                                    </div><!-- Col -->
                                </div><!-- Row -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label class="form-label">Observaciones</label>
                                            <textarea name="observaciones" class="form-control <?php echo e($errors->has('observaciones') ? 'is-invalid' : ''); ?>" rows="3" placeholder="Observaciones"></textarea>
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'observaciones']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'observaciones']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </div>
                                    </div><!-- Col -->
                                </div><!-- Row -->
                                <button type="submit" class="btn btn-primary submit">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="d-md-block col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tabla de recipientes</h4>
                            <div class="table-responsive">
                                <table id="dataTableRecipientes" class="table">
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Observaciones</th>
                                            <th>Capacidad</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $recipientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recipiente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td style="white-space: pre-wrap"><?php echo e($recipiente->descripcion); ?></td>
                                            <td style="white-space: pre-wrap"><?php echo e($recipiente->observaciones); ?></td>
                                            <td><?php echo e($recipiente->capacidad); ?></td>
                                            <td>
                                                <a href="<?php echo e(route('stevlab.catalogo.delete-component', ['zona' => 'recipientes', 'id' => $recipiente->id])); ?>" type='button' class='btn btn-danger btn-xs btn-icon' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Eliminar area'"><i class='mdi mdi-delete'></i></a> 

                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td>No data allowed</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="muestras">
            <div class="row">
                <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            
                            <h6 class="card-title">Muestras</h6>
                            
                            <form class="forms-sample" action="<?php echo e(route('stevlab.catalogo.store-muestra')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
                                    <div class="col-sm-12">
                                        <input type="text" name='descripcion' class="form-control <?php echo e($errors->has('descripcion') ? 'is-invalid' : ''); ?>" placeholder="Descripción">
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
                                </div>
                                <div class="mb-3">
                                    <label for="observaciones" class="col-sm-3 col-form-label">Observaciones</label>
                                    <div class="col-sm-12">
                                        <textarea name='observaciones' class="form-control <?php echo e($errors->has('observaciones') ? 'is-invalid' : ''); ?>" placeholder="Observaciones" cols="5" rows="3"></textarea>
                                        
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'observaciones']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'observaciones']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tabla de muestras</h4>
                            <div class="table-responsive">
                                <table id="dataTableMuestras" class="table">
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Observaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $muestras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $muestra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td style="white-space: pre-wrap"><?php echo e($muestra->descripcion); ?></td>
                                            <td style="white-space: pre-wrap"><?php echo e($muestra->observaciones); ?></td>
                                            <td>
                                            <a href="<?php echo e(route('stevlab.catalogo.delete-component', ['zona' => 'muestras', 'id' => $muestra->id])); ?>" type='button' class='btn btn-danger btn-xs btn-icon' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Eliminar area'"><i class='mdi mdi-delete'></i></a> 

                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td>
                                                No data allowed
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="tab-pane fade" id="tecnicas">
            <div class="row">
                
                <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            
                            <h6 class="card-title">Técnicas</h6>
                            
                            <form class="forms-sample" action="<?php echo e(route('stevlab.catalogo.store-tecnica')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción</label>
                                    <input type="text" name='descripcion' class="form-control <?php echo e($errors->has('descripcion') ? 'is-invalid' : ''); ?>" autocomplete="off" placeholder="Descripción">
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
                                <div class="mb-3">
                                    <label for="observaciones" class="form-label">Observaciones</label>
                                    <textarea name="observaciones" rows="3" class="form-control <?php echo e($errors->has('observaciones') ? 'is-invalid' : ''); ?>" placeholder="Observaciones"></textarea>
                                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'observaciones']]); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['for' => 'observaciones']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                </div>
                                <button type="submit" class="btn btn-primary me-2">Submit</button>
                                
                            </form>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Tabla de técnicas</h4>
                            <div class="table-responsive">
                                <table id="dataTableTecnicas" class="table">
                                    <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Observaciones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__empty_1 = true; $__currentLoopData = $tecnicas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tecnica): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td style="white-space: pre-wrap"><?php echo e($tecnica->descripcion); ?></td>
                                            <td style="white-space: pre-wrap"><?php echo e($tecnica->observaciones); ?></td>
                                            <td>
                                            <a href="<?php echo e(route('stevlab.catalogo.delete-component', ['zona' => 'tecnicas', 'id' => $area->id])); ?>" type='button' class='btn btn-danger btn-xs btn-icon' data-bs-toggle='tooltip' data-bs-placement='top' data-bs-title='Eliminar area'"><i class='mdi mdi-delete'></i></a> 

                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td>
                                                No data allowed
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('plugin-scripts'); ?>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/js/axios.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('custom-scripts'); ?>
<script src="<?php echo e(asset('public/stevlab/catalogo/areas/data-table.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/metodos/data-table.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/recipientes/data-table.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/muestras/data-table.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/tecnicas/data-table.js')); ?>?v=<?php echo rand();?>"></script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/catalogo/areas/index.blade.php ENDPATH**/ ?>