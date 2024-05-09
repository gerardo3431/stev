@push('plugin-styles')
    <link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
@endpush

<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{route('stevlab.dashboard')}}" class="sidebar-brand">
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
            
            @hasanyrole('Administrador|Contador|Quimico principal|Quimico sucursal|Quimico|Recepcion')
                @can('dashboard')
                    <li class="nav-item {{ active_class('stevlab.dashboard') }}">
                        <a href="{{ route('stevlab.dashboard') }}" class="nav-link">
                            <i class="link-icon" data-feather="activity"></i>
                            <span class="link-title">Dashboard</span>
                        </a>
                    </li>
                @endcan
                
                @can('recepcion')
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#recepcion-menu" role="button" aria-expanded="{{is_active_route('stevlab.recepcion.*')}}" aria-controls="advanced-ui">
                            <i class="link-icon" data-feather="clipboard"></i>
                                <span class="link-title">Recepcion</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{ show_class('stevlab.recepcion.*')}}" id="recepcion-menu">
                            <ul class="nav sub-menu">
                                @can('recepcion_nuevo')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.recepcion.index')}}" class="nav-link {{ active_class('stevlab.recepcion.index')}}">Nuevo</a>
                                    </li>
                                @endcan
                                @can('recepcion_editar')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.recepcion.editar')}}" class="nav-link {{ active_class('stevlab.recepcion.editar')}}">Editar solicitud</a>
                                    </li>
                                @endcan
                                @can('recepcion_pendiente')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.recepcion.pendientes')}}" class="nav-link {{active_class('stevlab.recepcion.pendientes')}}">Pendientes de pago</a>
                                    </li>
                                @endcan
                                @can('cotizacion')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.recepcion.cotizacion')}}" class="nav-link {{active_class('stevlab.recepcion.cotizacion')}}">Cotizacion</a>
                                    </li>
                                @endcan
                                @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
                                    @can('prefolio')
                                        <li class="nav-item">
                                            <a href="{{route('stevlab.recepcion.prefolio')}}" class="nav-link {{active_class('stevlab.recepcion.prefolio')}}">Prefolio</a>
                                        </li>
                                    @endcan
                                @endif
                            </ul>
                        </div>
                    </li>
                @endcan  

                @can('captura')
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#captura-menu" role="button" aria-expanded="{{is_active_route('stevlab.captura.*')}}" aria-controls="advanced-ui">
                            <i class="link-icon" data-feather="save"></i>
                            <span class="link-title">Captura</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{ show_class('stevlab.captura.*')}}" id="captura-menu">
                            <ul class="nav sub-menu">
                                @can('captura_resultados')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.captura.captura')}}" class="nav-link {{ active_class(['stevlab.captura.captura']) }}">
                                            Captura general
                                        </a>
                                    </li>
                                @endcan
                                @can('captura_bloques')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.captura.captura-block')}}" class="nav-link {{ active_class(['stevlab.captura.captura-block']) }}">Captura por bloques</a>
                                    </li>
                                @endcan
                                @can('lista_trabajo')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.captura.listas')}}" class="nav-link {{ active_class(['stevlab.captura.listas']) }}">Lista de trabajo</a>
                                    </li>
                                @endcan
                                {{-- <li class="nav-item">
                                    <a href="{{route('stevlab.recepcion.delivery')}}" class="nav-link">Entrega de resultados</a>
                                </li> --}}
                                @can('importacion')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.captura.importacion')}}" class="nav-link {{ active_class(['stevlab.captura.importacion']) }}">Importación de resultados</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>          
                @endcan
                
                @can('caja')
                    <li class="nav-item {{ active_class('stevlab.caja.index') }}">
                        <a href="{{route('stevlab.caja.index')}}" class="nav-link ">
                            <i class="link-icon" data-feather="server"></i>
                            <span class="link-title">Caja</span>
                        </a>
                    </li>
                @endcan

                @can('catalogo')
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#advanced-ui" role="button" aria-expanded="{{ is_active_route('stevlab.catalogo.*') }}" aria-controls="advanced-ui">
                            <i class="link-icon" data-feather="book-open"></i>
                            <span class="link-title">Catálogo</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>        
                        <div class="collapse {{ show_class('stevlab.catalogo.*') }}" id="advanced-ui">
                            <ul class="nav sub-menu">
                                @can('estudios')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.catalogo.estudios')}}" class="nav-link {{active_class('stevlab.catalogo.estudios')}}">Estudios</a>
                                    </li>
                                @endcan
                                @can('areas')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.catalogo.areas')}}" class="nav-link  {{active_class('stevlab.catalogo.areas')}}">Áreas de estudio</a>
                                    </li>
                                @endcan
                                @can('analitos')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.catalogo.analitos')}}" disabled class="nav-link  {{active_class('stevlab.catalogo.analitos')}}">Analitos</a>
                                    </li>
                                @endcan
                                @can('perfiles')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.catalogo.perfiles')}}" disabled class="nav-link {{active_class('stevlab.catalogo.perfiles')}}">Perfiles</a>
                                    </li>
                                @endcan
                                @can('pacientes')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.catalogo.pacientes')}}" class="nav-link {{active_class('stevlab.catalogo.pacientes')}}">Pacientes</a>
                                    </li>
                                @endcan
                                @can('listas')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.catalogo.precios')}}" class="nav-link {{active_class('stevlab.catalogo.precios')}}">Lista de precios</a>
                                    </li>
                                @endcan
                                @can('empresas')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.catalogo.empresas')}}" class="nav-link {{active_class('stevlab.catalogo.empresas')}}">Empresas</a>
                                    </li>
                                @endcan
                                @can('doctores')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.catalogo.doctores')}}" class="nav-link {{active_class('stevlab.catalogo.doctores')}}">Doctores</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
                
                @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
                    @can('imagenologia')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#imagenologia" role="button" aria-expanded="{{is_active_route('stevlab.imagenologia.*')}}" aria-controls="advanced-ui">
                                <i class="link-icon" data-feather="image"></i>
                                <span class="link-title">Imagenologia</span>
                                <i class="link-arrow" data-feather="chevron-down"></i>
                            </a>        
                            <div class="collapse {{show_class('stevlab.imagenologia.*')}}" id="imagenologia">
                                <ul class="nav sub-menu">
                                    @can('captura_img')
                                        <li class="nav-item">
                                            <a href="{{route('stevlab.imagenologia.captura')}}" class="nav-link {{active_class('stevlab.imagenologia.captura')}}">Captura</a>
                                        </li>
                                    @endcan
                                    @can('catalogo_img')
                                        <li class="nav-item">
                                            <a href="{{route('stevlab.imagenologia.imagenologia')}}" class="nav-link {{active_class('stevlab.imagenologia.imagenologia')}}">Catalogo</a>
                                        </li>
                                    @endcan
                                    @can('areas_img')
                                        <li class="nav-item">
                                            <a href="{{route('stevlab.imagenologia.areas-imagenologia')}}" class="nav-link {{active_class('stevlab.imagenologia.areas-imagenologia')}}">Areas</a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endcan
                @endif
                
                @can('administracion')
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#administracion-menu" role="button" aria-expanded="{{is_active_route('stevlab.administracion.*')}}" aria-controls="administracion-menu">
                            <i class="link-icon" data-feather="settings"></i>
                            <span class="link-title">Administración</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{show_class('stevlab.administracion.*')}}" id="administracion-menu">
                            <ul class="nav sub-menu">
                                @can('sucursales')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.administracion.sucursales')}}" class="nav-link {{active_class('stevlab.administracion.sucursales')}}">Sucursales</a>
                                    </li>
                                @endcan
                                @can('usuarios')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.administracion.usuarios')}}" class="nav-link {{active_class('stevlab.administracion.usuarios')}}">Lista de usuarios</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('reportes')
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#reportes-menu" role="button" aria-expanded="{{is_active_route('stevlab.reportes.*')}}" aria-controls="reportes-menu">
                            <i class="link-icon" data-feather="activity"></i>
                                <span class="link-title">Reportes</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{show_class('stevlab.reportes.*')}}" id="reportes-menu">
                            <ul class="nav sub-menu">
                                @can('arqueos')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.reportes.arqueo')}}" class="nav-link {{active_class('stevlab.reportes.arqueo')}}">Arqueos</a>
                                    </li>
                                @endcan
                                @can('ventas')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.reportes.ventas')}}" class="nav-link {{active_class('stevlab.reportes.ventas')}}">Ventas</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                
                {{-- @dd(auth()->user()->labs()->first()) --}}
                

                
                @endcan

                @can('historial')
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#historial-menu" role="button" aria-expanded="{{is_active_route('stevlab.historial.*')}}" aria-controls="historial-menu">
                            <i class="link-icon" data-feather="user-check"></i>
                                <span class="link-title">Historial</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{show_class('stevlab.historial.*')}}" id="historial-menu">
                            <ul class="nav sub-menu">
                                @can('ver_historial')
                                    <li class="nav-item">
                                        <a href="{{route('stevlab.historial.pacientes')}}" class="nav-link {{active_class('stevlab.historial.pacientes')}}">Pacientes</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan

                @can('almacen')
                    @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#almacen-menu" role="button" aria-expanded="{{is_active_route('stevlab.almacen.*')}}" aria-controls="historial-menu">
                                <i class="link-icon" data-feather="user-check"></i>
                                    <span class="link-title">Almacen</span>
                                <i class="link-arrow" data-feather="chevron-down"></i>
                            </a>
                            <div class="collapse {{show_class('stevlab.almacen.*')}}" id="almacen-menu">
                                <ul class="nav sub-menu">
                                    @if (auth()->user()->labs()->first()->inventario_inicial == 1)
                                        @can('inventarios')
                                            <li class="nav-item">
                                                <a href="{{route('stevlab.almacen.inventario')}}" class="nav-link {{active_class('stevlab.almacen.inventario')}}">Inventario</a>
                                            </li>
                                        @endcan
                                    @endif
                                    @can('articulos')
                                        <li class="nav-item">
                                            <a href="{{route('stevlab.almacen.articulos')}}" class="nav-link {{active_class('stevlab.almacen.articulos')}}">Articulos</a>
                                        </li>
                                    @endcan
                                    @can('solicitud_material')
                                        <li class="nav-item">
                                            <a href="{{route('stevlab.almacen.solicitudes')}}" class="nav-link {{active_class('stevlab.almacen.solicitudes')}}">Solicitud de material</a>
                                        </li>
                                    @endcan
                                    @can('movimientos')
                                        <li class="nav-item">
                                            <a href="{{route('stevlab.almacen.movimientos')}}" class="nav-link {{active_class('stevlab.almacen.movimientos')}}">Movimientos</a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>
                    @endif
                @endcan

                @can('utilerias')
                    @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="collapse" href="#utils-menu" role="button" aria-expanded="{{is_active_route('stevlab.utils.*')}}" aria-controls="administracion-menu">
                                <i class="link-icon" data-feather="crop"></i>
                                <span class="link-title">Utilerias</span>
                                <i class="link-arrow" data-feather="chevron-down"></i>
                            </a>
                            <div class="collapse {{show_class('stevlab.utils.*')}}" id="utils-menu">
                                <ul class="nav sub-menu">
                                    @can('multimembrete')
                                        <li class="nav-item">
                                            <a href="{{route('stevlab.utils.papeleria')}}" class="nav-link {{active_class('stevlab.utils.papeleria')}}">Multimembrete</a>
                                        </li>
                                    @endcan
                                    @can('papeleria')
                                        <li class="nav-item">
                                            <a href="{{route('stevlab.utils.trashed')}}" class="nav-link {{active_class('stevlab.utils.trashed')}}">Papeleria de reciclaje</a>
                                        </li>
                                    @endcan
                                    @can('trazabilidad')
                                        <li class="nav-item">
                                            <a href="{{route('stevlab.utils.trazabilidad')}}" class="nav-link {{active_class('stevlab.utils.trazabilidad')}}">Trazabilidad</a>
                                        </li>    
                                    @endcan
                                    @if (auth()->user()->hasRole(['Administrador', 'Contador']))
                                        @can('informacion_personal')
                                            <li class="nav-item">
                                                <a href="{{route('stevlab.utils.user')}}" class="nav-link {{active_class('stevlab.utils.user')}}">Información personal</a>
                                            </li>
                                        @endcan
                                        @can('fitosanitario')
                                            <li class="nav-item">
                                                <a href="{{route('stevlab.utils.fitosanitario')}}" class="nav-link {{active_class('stevlab.utils.fitosanitario')}}">Fitosanitario</a>
                                            </li>
                                        @endcan
                                        @can('seguridad')
                                            <li class="nav-item">
                                                <a href="{{route('stevlab.utils.segurity')}}" class="nav-link {{active_class('stevlab.utils.segurity')}}">Seguridad</a>
                                            </li>
                                        @endcan
                                        @can('maquila')
                                            <li class="nav-item">
                                                <a href="{{route('stevlab.utils.maquila')}}" class="nav-link {{active_class('stevlab.utils.maquila')}}">Maquilar</a>
                                            </li>
                                        @endcan
                                        @can('data')
                                            <li class="nav-item">
                                                <a href="{{route('stevlab.utils.data')}}" class="nav-link {{active_class('stevlab.utils.data')}}" >Data</a>
                                            </li>
                                        @endcan
                                    @endif
                                </ul>
                            </div>
                        </li>
                    @endif
                @endcan
            @else
            @endhasanyrole

            @role('Doctor')
                <li class="nav-item">
                    <a href="{{route('stevlab.doctor.dashboard')}}" class="nav-link {{ active_class('stevlab.doctor.dashboard') }}">
                        <i class="link-icon" data-feather="server"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('stevlab.doctor.prefolio')}}" class="nav-link {{active_class('stevlab.doctor.prefolio')}}">
                        <i class="link-icon" data-feather="server"></i>
                        <span class="link-title">Nuevo</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                        <i class="link-icon" data-feather="log-out"></i>
                        <span class="link-title">Log Out</span>
                    </a>
                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                        @csrf
                    </form>
                </li>
            @else
            @endrole

            @role('Empresa')
                <li class="nav-item">
                    <a href="{{route('stevlab.empresa.dashboard')}}" class="nav-link {{active_class('stevlab.empresa.dashboard')}}">
                        <i class="link-icon" data-feather="server"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('stevlab.empresa.prefolio')}}" class="nav-link {{active_class('stevlab.empresa.prefolio')}}">
                        <i class="link-icon" data-feather="server"></i>
                        <span class="link-title">Nuevo</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                        <i class="link-icon" data-feather="log-out"></i>
                        <span class="link-title">Log Out</span>
                    </a>
                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                        @csrf
                    </form>
                </li>
            @else
            @endrole

        </ul>
    </div>
</nav>