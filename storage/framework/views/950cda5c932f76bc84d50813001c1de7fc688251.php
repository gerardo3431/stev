<?php $__env->startPush('plugin-styles'); ?>
    <link href="<?php echo e(asset('assets/plugins/@mdi/css/materialdesignicons.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<nav class="sidebar">
    <div class="sidebar-header">
        <a href="<?php echo e(route('stevlab.dashboard')); ?>" class="sidebar-brand">
            Stev<span>Lab</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Menú</li>
            
            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasAnyRole', 'Administrador|Contador|Quimico principal|Quimico sucursal|Quimico|Recepcion')): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('dashboard')): ?>
                    <li class="nav-item <?php echo e(active_class('stevlab.dashboard')); ?>">
                        <a href="<?php echo e(route('stevlab.dashboard')); ?>" class="nav-link">
                            <i class="link-icon" data-feather="activity"></i>
                            <span class="link-title">Dashboard</span>
                        </a>
                    </li>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('recepcion')): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#recepcion-menu" role="button" aria-expanded="<?php echo e(is_active_route('stevlab.recepcion.*')); ?>" aria-controls="advanced-ui">
                            <i class="link-icon" data-feather="clipboard"></i>
                                <span class="link-title">Recepcion</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse <?php echo e(show_class('stevlab.recepcion.*')); ?>" id="recepcion-menu">
                            <ul class="nav sub-menu">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('recepcion_nuevo')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.recepcion.index')); ?>" class="nav-link <?php echo e(active_class('stevlab.recepcion.index')); ?>">Nuevo</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('recepcion_editar')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.recepcion.editar')); ?>" class="nav-link <?php echo e(active_class('stevlab.recepcion.editar')); ?>">Editar solicitud</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('recepcion_pendiente')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.recepcion.pendientes')); ?>" class="nav-link <?php echo e(active_class('stevlab.recepcion.pendientes')); ?>">Pendientes de pago</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('cotizacion')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.recepcion.cotizacion')); ?>" class="nav-link <?php echo e(active_class('stevlab.recepcion.cotizacion')); ?>">Cotizacion</a>
                                    </li>
                                <?php endif; ?>
                                <?php if(auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo'): ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prefolio')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('stevlab.recepcion.prefolio')); ?>" class="nav-link <?php echo e(active_class('stevlab.recepcion.prefolio')); ?>">Prefolio</a>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>  

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('captura')): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#captura-menu" role="button" aria-expanded="<?php echo e(is_active_route('stevlab.captura.*')); ?>" aria-controls="advanced-ui">
                            <i class="link-icon" data-feather="save"></i>
                            <span class="link-title">Captura</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse <?php echo e(show_class('stevlab.captura.*')); ?>" id="captura-menu">
                            <ul class="nav sub-menu">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('captura_resultados')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.captura.captura')); ?>" class="nav-link <?php echo e(active_class(['stevlab.captura.captura'])); ?>">
                                            Captura general
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('captura_bloques')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.captura.captura-block')); ?>" class="nav-link <?php echo e(active_class(['stevlab.captura.captura-block'])); ?>">Captura por bloques</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('lista_trabajo')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.captura.listas')); ?>" class="nav-link <?php echo e(active_class(['stevlab.captura.listas'])); ?>">Lista de trabajo</a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('importacion')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.captura.importacion')); ?>" class="nav-link <?php echo e(active_class(['stevlab.captura.importacion'])); ?>">Importación de resultados</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>          
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('caja')): ?>
                    <li class="nav-item <?php echo e(active_class('stevlab.caja.index')); ?>">
                        <a href="<?php echo e(route('stevlab.caja.index')); ?>" class="nav-link ">
                            <i class="link-icon" data-feather="server"></i>
                            <span class="link-title">Caja</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('catalogo')): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#advanced-ui" role="button" aria-expanded="<?php echo e(is_active_route('stevlab.catalogo.*')); ?>" aria-controls="advanced-ui">
                            <i class="link-icon" data-feather="book-open"></i>
                            <span class="link-title">Catálogo</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>        
                        <div class="collapse <?php echo e(show_class('stevlab.catalogo.*')); ?>" id="advanced-ui">
                            <ul class="nav sub-menu">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('estudios')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.catalogo.estudios')); ?>" class="nav-link <?php echo e(active_class('stevlab.catalogo.estudios')); ?>">Estudios</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('areas')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.catalogo.areas')); ?>" class="nav-link  <?php echo e(active_class('stevlab.catalogo.areas')); ?>">Áreas de estudio</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analitos')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.catalogo.analitos')); ?>" disabled class="nav-link  <?php echo e(active_class('stevlab.catalogo.analitos')); ?>">Analitos</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('perfiles')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.catalogo.perfiles')); ?>" disabled class="nav-link <?php echo e(active_class('stevlab.catalogo.perfiles')); ?>">Perfiles</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('pacientes')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.catalogo.pacientes')); ?>" class="nav-link <?php echo e(active_class('stevlab.catalogo.pacientes')); ?>">Pacientes</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('listas')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.catalogo.precios')); ?>" class="nav-link <?php echo e(active_class('stevlab.catalogo.precios')); ?>">Lista de precios</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('empresas')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.catalogo.empresas')); ?>" class="nav-link <?php echo e(active_class('stevlab.catalogo.empresas')); ?>">Empresas</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('doctores')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.catalogo.doctores')); ?>" class="nav-link <?php echo e(active_class('stevlab.catalogo.doctores')); ?>">Doctores</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
                
                <?php if(auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo'): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('imagenologia')): ?>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#imagenologia" role="button" aria-expanded="<?php echo e(is_active_route('stevlab.imagenologia.*')); ?>" aria-controls="advanced-ui">
                                <i class="link-icon" data-feather="image"></i>
                                <span class="link-title">Imagenologia</span>
                                <i class="link-arrow" data-feather="chevron-down"></i>
                            </a>        
                            <div class="collapse <?php echo e(show_class('stevlab.imagenologia.*')); ?>" id="imagenologia">
                                <ul class="nav sub-menu">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('captura_img')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('stevlab.imagenologia.captura')); ?>" class="nav-link <?php echo e(active_class('stevlab.imagenologia.captura')); ?>">Captura</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('catalogo_img')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('stevlab.imagenologia.imagenologia')); ?>" class="nav-link <?php echo e(active_class('stevlab.imagenologia.imagenologia')); ?>">Catalogo</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('areas_img')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('stevlab.imagenologia.areas-imagenologia')); ?>" class="nav-link <?php echo e(active_class('stevlab.imagenologia.areas-imagenologia')); ?>">Areas</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('administracion')): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#administracion-menu" role="button" aria-expanded="<?php echo e(is_active_route('stevlab.administracion.*')); ?>" aria-controls="administracion-menu">
                            <i class="link-icon" data-feather="settings"></i>
                            <span class="link-title">Administración</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse <?php echo e(show_class('stevlab.administracion.*')); ?>" id="administracion-menu">
                            <ul class="nav sub-menu">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sucursales')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.administracion.sucursales')); ?>" class="nav-link <?php echo e(active_class('stevlab.administracion.sucursales')); ?>">Sucursales</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('usuarios')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.administracion.usuarios')); ?>" class="nav-link <?php echo e(active_class('stevlab.administracion.usuarios')); ?>">Lista de usuarios</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reportes')): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#reportes-menu" role="button" aria-expanded="<?php echo e(is_active_route('stevlab.reportes.*')); ?>" aria-controls="reportes-menu">
                            <i class="link-icon" data-feather="activity"></i>
                                <span class="link-title">Reportes</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse <?php echo e(show_class('stevlab.reportes.*')); ?>" id="reportes-menu">
                            <ul class="nav sub-menu">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('arqueos')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.reportes.arqueo')); ?>" class="nav-link <?php echo e(active_class('stevlab.reportes.arqueo')); ?>">Arqueos</a>
                                    </li>
                                <?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ventas')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.reportes.ventas')); ?>" class="nav-link <?php echo e(active_class('stevlab.reportes.ventas')); ?>">Ventas</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                
                
                

                
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('historial')): ?>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#historial-menu" role="button" aria-expanded="<?php echo e(is_active_route('stevlab.historial.*')); ?>" aria-controls="historial-menu">
                            <i class="link-icon" data-feather="user-check"></i>
                                <span class="link-title">Historial</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse <?php echo e(show_class('stevlab.historial.*')); ?>" id="historial-menu">
                            <ul class="nav sub-menu">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ver_historial')): ?>
                                    <li class="nav-item">
                                        <a href="<?php echo e(route('stevlab.historial.pacientes')); ?>" class="nav-link <?php echo e(active_class('stevlab.historial.pacientes')); ?>">Pacientes</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('almacen')): ?>
                    <?php if(auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo'): ?>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#almacen-menu" role="button" aria-expanded="<?php echo e(is_active_route('stevlab.almacen.*')); ?>" aria-controls="historial-menu">
                                <i class="link-icon" data-feather="user-check"></i>
                                    <span class="link-title">Almacen</span>
                                <i class="link-arrow" data-feather="chevron-down"></i>
                            </a>
                            <div class="collapse <?php echo e(show_class('stevlab.almacen.*')); ?>" id="almacen-menu">
                                <ul class="nav sub-menu">
                                    <?php if(auth()->user()->labs()->first()->inventario_inicial == 1): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('inventarios')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('stevlab.almacen.inventario')); ?>" class="nav-link <?php echo e(active_class('stevlab.almacen.inventario')); ?>">Inventario</a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('articulos')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('stevlab.almacen.articulos')); ?>" class="nav-link <?php echo e(active_class('stevlab.almacen.articulos')); ?>">Articulos</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('solicitud_material')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('stevlab.almacen.solicitudes')); ?>" class="nav-link <?php echo e(active_class('stevlab.almacen.solicitudes')); ?>">Solicitud de material</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('movimientos')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('stevlab.almacen.movimientos')); ?>" class="nav-link <?php echo e(active_class('stevlab.almacen.movimientos')); ?>">Movimientos</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('utilerias')): ?>
                    <?php if(auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo'): ?>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#utils-menu" role="button" aria-expanded="<?php echo e(is_active_route('stevlab.utils.*')); ?>" aria-controls="administracion-menu">
                                <i class="link-icon" data-feather="crop"></i>
                                <span class="link-title">Utilerias</span>
                                <i class="link-arrow" data-feather="chevron-down"></i>
                            </a>
                            <div class="collapse <?php echo e(show_class('stevlab.utils.*')); ?>" id="utils-menu">
                                <ul class="nav sub-menu">
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('multimembrete')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('stevlab.utils.papeleria')); ?>" class="nav-link <?php echo e(active_class('stevlab.utils.papeleria')); ?>">Multimembrete</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('papeleria')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('stevlab.utils.trashed')); ?>" class="nav-link <?php echo e(active_class('stevlab.utils.trashed')); ?>">Papeleria de reciclaje</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('trazabilidad')): ?>
                                        <li class="nav-item">
                                            <a href="<?php echo e(route('stevlab.utils.trazabilidad')); ?>" class="nav-link <?php echo e(active_class('stevlab.utils.trazabilidad')); ?>">Trazabilidad</a>
                                        </li>    
                                    <?php endif; ?>
                                    <?php if(auth()->user()->hasRole(['Administrador', 'Contador'])): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('informacion_personal')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('stevlab.utils.user')); ?>" class="nav-link <?php echo e(active_class('stevlab.utils.user')); ?>">Información personal</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('fitosanitario')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('stevlab.utils.fitosanitario')); ?>" class="nav-link <?php echo e(active_class('stevlab.utils.fitosanitario')); ?>">Fitosanitario</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('seguridad')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('stevlab.utils.segurity')); ?>" class="nav-link <?php echo e(active_class('stevlab.utils.segurity')); ?>">Seguridad</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('maquila')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('stevlab.utils.maquila')); ?>" class="nav-link <?php echo e(active_class('stevlab.utils.maquila')); ?>">Maquilar</a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('data')): ?>
                                            <li class="nav-item">
                                                <a href="<?php echo e(route('stevlab.utils.data')); ?>" class="nav-link <?php echo e(active_class('stevlab.utils.data')); ?>" >Data</a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php else: ?>
            <?php endif; ?>

            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'Doctor')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('stevlab.doctor.dashboard')); ?>" class="nav-link <?php echo e(active_class('stevlab.doctor.dashboard')); ?>">
                        <i class="link-icon" data-feather="server"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('stevlab.doctor.prefolio')); ?>" class="nav-link <?php echo e(active_class('stevlab.doctor.prefolio')); ?>">
                        <i class="link-icon" data-feather="server"></i>
                        <span class="link-title">Nuevo</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                        <i class="link-icon" data-feather="log-out"></i>
                        <span class="link-title">Log Out</span>
                    </a>
                    <form method="POST" id="logout-form" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                    </form>
                </li>
            <?php else: ?>
            <?php endif; ?>

            <?php if(\Spatie\Permission\PermissionServiceProvider::bladeMethodWrapper('hasRole', 'Empresa')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('stevlab.empresa.dashboard')); ?>" class="nav-link <?php echo e(active_class('stevlab.empresa.dashboard')); ?>">
                        <i class="link-icon" data-feather="server"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('stevlab.empresa.prefolio')); ?>" class="nav-link <?php echo e(active_class('stevlab.empresa.prefolio')); ?>">
                        <i class="link-icon" data-feather="server"></i>
                        <span class="link-title">Nuevo</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                        <i class="link-icon" data-feather="log-out"></i>
                        <span class="link-title">Log Out</span>
                    </a>
                    <form method="POST" id="logout-form" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                    </form>
                </li>
            <?php else: ?>
            <?php endif; ?>

        </ul>
    </div>
</nav><?php /**PATH C:\laragon\www\laboratorios\resources\views/layout/sidebar.blade.php ENDPATH**/ ?>