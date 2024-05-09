<?php $__env->startPush('plugin-styles'); ?> 
<link href="<?php echo e(asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/prismjs/prism.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('public/assets/plugins/dropify/css/dropify.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?> 

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo e(route('stevlab.dashboard')); ?>">StevLab</a></li>
        <li class="breadcrumb-item active" aria-current="page"> <a href="">Catalogo</a> </li>
        <li class="breadcrumb-item active" aria-current="page"> <a href="">Pacientes</a> </li>
    </ol>
</nav>





<!------------------------------------------------------------------------------------------------>

<div class="row">
    <?php if(session('msj')): ?>

        <div class="alert alert-primary alert-dismissible fade show" role="alert">
            <i data-feather="alert-circle"></i>
            <strong>Aviso!</strong> <?php echo e(session('msj')); ?>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
    <?php else: ?>
    <?php endif; ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('crear_pacientes')): ?>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Formulario de alta</h5>
                    <form method="post" action="<?php echo e(route('stevlab.catalogo.paciente_guardar')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-8 col-xl-8">
                                <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input class="form-control <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="nombre" value="<?php echo e(old('nombre')); ?>"type="text" placeholder="Nombre completo">
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
                            <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label class="form-label">Sexo</label>
                                    <select class="js-example-basic-single form-select <?php $__errorArgs = ['sexo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="sexo" data-width="100%" value="<?php echo e(old('sexo')); ?>">
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2 col-lg-2 col-xl-3">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Nacimiento</label>
                                    <div class="input-group date datepicker" id="fecha-nacimiento" style="padding: 0">
                                        <input type="text" class="fecha_nacimiento form-control <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo e(old('fecha_nacimiento')); ?>">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2 col-lg-2 col-xl-3">
                                <div class="mb-3">
                                    <label class="form-label">Edad</label>
                                    <input type="number" class="form-control" id="edad_or" name="edad" value="<?php echo e(old('edad')); ?>" placeholder="Edad">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-4 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Celular</label>
                                    <input type="number" class="form-control" name="celular" value="<?php echo e(old('celular')); ?>" placeholder="Número telefono">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="mb-3">
                                    <label class="form-label">Domicilio</label>
                                    <input class="form-control  <?php $__errorArgs = ['domicilio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="domicilio" value="<?php echo e(old('domicilio')); ?>" type="text" placeholder="Domicilio">
                                    <?php $__errorArgs = ['domicilio'];
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
                            <div class="col-sm-12 col-md-5 col-lg-4 col-xl-8">
                                <div class="mb-3">
                                    <label class="form-label">Colonia</label>
                                    <input type="text" class="form-control  <?php $__errorArgs = ['colonia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="colonia" value="<?php echo e(old('colonia')); ?>" placeholder="Colonia">
                                    <?php $__errorArgs = ['colonia'];
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
                            <div class="col-sm-12 col-md-4 col-md-4 col-lg-4 col-xl-4">
                                <div class="mb-3">
                                    <label class="form-label">No. Seguro</label>
                                    <input type="text" class="form-control" name="seguro_popular" value="<?php echo e(old('seguro_popular')); ?>" placeholder="NSS">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 col-md-3 col-lg-4 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Vigencia inicio</label>
                                    <div class="input-group date datepicker" id="vigencia-inicio" style="padding: 0">
                                        <input type="text" class="form-control" name="vigencia_inicio" value="<?php echo e(old('vigencia_inicio')); ?>">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-4 col-xl-6">
                                <div class="mb-3">
                                    <label class="form-label">Vigencia fin</label>
                                    <div class="input-group date datepicker" id="vigencia-fin" style="padding: 0">
                                        <input type="text" class="form-control" name="vigencia_fin" value="<?php echo e(old('vigencia_fin')); ?>">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-6 col-xl-8">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" placeholder="Correo electrónico">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-12">
                                <div class="mb-3">
                                    <div class="row">
                                        <label class="form-label">Empresa</label>               
                                        <div class="col-sm-10 col-10">
                                            <select class="js-example-basic-multiple form-select form-control  <?php $__errorArgs = ['id_empresa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" multiple='multiple' id="id_empresa" name="id_empresa[]" data-width="100%" value="<?php echo e(old('id_empresa')); ?>">
                                            </select>
                                            <?php $__errorArgs = ['id_empresa'];
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
                                        <div class="col-sm-2 col-2">
                                            <button type="button" class="btn btn-xs btn-success"  data-bs-toggle="modal" data-bs-target="#modal_empresa_nueva">
                                                <i class="mdi mdi-factory"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>                    
                        <div class="row">
                        </div>
                        <div class="row">
                            
                        </div>
                        <button type="submit" onclick="showSwal('mixin')" class="btn btn-primary">Guardar</button>
                        
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 m-md-block">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Tabla de pacientes</h5>
                <div class="mb-3">
                    <div class="table-responsive">
                        <table id="dataTablePacientes" class="table table-sm table-hover nowrap display" style="width:100%" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Fecha de nacimiento</th>
                                    <th>Acciones</th>
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


</div>
<!---------------------------------------------------------------------------------------------->

<!-- Modal empresa nueva -->
<div class="modal fade " tabindex="-1" aria-labelledby="modal_nueva_empresa" aria-hidden="true" id='modal_empresa_nueva'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id='guardar_dato_empresa'>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">Clave</label>
                                <input class="form-control <?php $__errorArgs = ['clave'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="clave" value="<?php echo e(old('clave')); ?>"type="text" placeholder="Clave">
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
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="mb-3">
                                <label class="form-label">RFC</label>
                                <input class="form-control" name="rfc" value="" type="text" placeholder="RFC">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" class="form-control"name="descripcion" placeholder="Nombre empresa">
                                    
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-8">
                            <div class="mb-3">
                                <label class="form-label">Calle</label>
                                <input class="form-control" name="calle" value="" type="text" placeholder="Calle">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Colonia</label>
                                <input type="text" class="form-control" name="colonia" value="" placeholder="Colonia">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Ciudad</label>
                                <input type="text" class="form-control" name="ciudad" value="" placeholder="Ciudad">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-5">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input class="form-control" name="email" value="" type="email" placeholder="Correo electrónico">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Télefono</label>
                                <input type="number" class="form-control <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="telefono" value="<?php echo e(old('telefono')); ?>" placeholder="Télefono">
                                <?php $__errorArgs = ['telefono'];
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
                        <div class="col-sm-12 col-md-3 col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Contacto</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['contacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="contacto" value="<?php echo e(old('contacto')); ?>" placeholder="Contacto">
                                <?php $__errorArgs = ['contacto'];
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
                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Lista de precio</label>
                                <select class="js-example-basic-multiple form-select form-control" multiple='multiple' id="lista_precio" name="lista_precio" data-width="100%" value="<?php echo e(old('lista_precio')); ?>">
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-----------modal------------------------------------------------------------------------------>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('editar_pacientes')): ?>
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditar" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditar">Editar pacientes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('stevlab.catalogo.paciente_actualizar')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <input class="form-control" name="id" value="" type="hidden" id="id">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Nombre Completo</label>
                                    <input class="form-control" name="nombre" value="" type="text" id="nombre" placeholder="Nombre completo">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Sexo</label>
                                    <select class="js-example-basic-single form-select" name="sexo" data-width="100%" value="" id="sexo">
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Fecha Nacimiento</label>
                                    <div class="input-group date datepicker" id="fecha-nacimiento-edit">
                                        <input type="text" class=" form-control <?php $__errorArgs = ['fecha_nacimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id='fecha_nacimiento_edit' name="fecha_nacimiento">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="mb-3">
                                    <label class="form-label">Edad</label>
                                    <input type="number" class="form-control" name="edad" value="" id="edad">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-3">
                                    <label class="form-label">Celular</label>
                                    <input type="number" class="form-control" name="celular" value="" id="celular">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Domicilio</label>
                                    <input class="form-control" name="domicilio" value="" type="text" id="domicilio">
                                </div>
                            </div>
                            
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Colonia</label>
                                    <input type="text" class="form-control" name="colonia" value="" id="colonia">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">No. Seguro popular</label>
                                    <input type="text" class="form-control" name="seguro_popular" value="" id="seguro_popular">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Vigencia inicio</label>
                                    
                                    <div class="input-group date datepicker" id="vigencia-inicio-edit">
                                        <input type="text" class="form-control" name="vigencia_inicio" value="<?php echo e(old('vigencia_inicio')); ?>">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label">Vigencia fin</label>
                                    
                                    <div class="input-group date datepicker" id="vigencia-fin-edit">
                                        <input type="text" class="form-control" name="vigencia_fin" value="<?php echo e(old('vigencia_fin')); ?>">
                                        <span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
                                    </div>
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
                        <div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label">Empresa</label>
                                    <select class="js-example-basic-multiple form-select form-control  <?php $__errorArgs = ['id_empresa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" multiple='multiple' id="id_empresa_edit" name="id_empresa" data-width="100%" value="<?php echo e(old('id_empresa_edit')); ?>">
                                    </select>
                                    <?php $__errorArgs = ['id_empresa'];
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
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success">Actualizar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('plugin-scripts'); ?>
<script src="<?php echo e(asset('public/assets/plugins/jquery-validation/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net/jquery.dataTables.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/js/axios.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/moment/moment.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/select2/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/dropify/js/dropify.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('custom-scripts'); ?>
<script src="<?php echo e(asset('public/assets/js/data-table.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/pacientes/swee-alert.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/pacientes/functions.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/pacientes/datepicker.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/pacientes/select2.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/pacientes/form-validation.js')); ?>?v=<?php echo rand();?>"></script>
<script src="<?php echo e(asset('public/stevlab/catalogo/pacientes/data-table.js')); ?>?v=<?php echo rand();?>"></script>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home2/pixelar6/micromed.book-medical.com/resources/views/catalogo/pacientes/index.blade.php ENDPATH**/ ?>