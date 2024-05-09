@extends('layout.master')
@push('plugin-styles')
<link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />

@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="#">Administración</a></li>
            <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
        </ol>
    </nav>

    {{-- @dd(auth()->user()->getRoleNames()) --}}
    @can('crear_usuarios')
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <!-- Button trigger modal -->
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalUsuario">
                    Añadir usuario
                </button>
            </div>
        </div>
    @endcan
    @can('ver_lista_usuarios')
        <div class="row">     
            <div class="d-md-block col-md-12 col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Plantilla laboral</h4>
                        <div class="table-responsive">
                            <table class="table table-hover display table-bordered " id="tableUsuarios" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Usuario</th>
                                        <th>Sucursales</th>
                                        <th>Rol</th>
                                        {{-- <th>Permisos</th> --}}
                                        <th>
                                            <i class="mdi mdi-wrench"></i>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($usuarios as $usuario)
                                        {{-- @if ($usuario->hasRole(['Doctor','Empresa','Contador','Administrador'])) --}}
                                        {{-- @else --}}
                                            <tr>
                                                <td>{{$usuario->id}}</td>
                                                <td>{{$usuario->name}}</td>
                                                <td style="white-space: normal">
                                                    @foreach ($usuario->sucursal()->get() as $sucursal)
                                                        <span class="badge bg-primary">
                                                            {{$sucursal->sucursal}}                                            
                                                        </span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($roles as $rol)
                                                        @if ($usuario->hasRole($rol))
                                                            <span class='badge bg-primary'>{{$rol->name}}</span>
                                                        @endif
                                                    @endforeach
                                                </td>
                                                
                                                <td > 
                                                    @if ($usuario->hasRole('Doctor') || $usuario->hasRole('Empresa'))
                                                    @else
                                                        @can('editar_usuarios')
                                                            <a  href="{{route('stevlab.administracion.edit-user-subsidiary', $usuario->id)}}" title="Editar sucursales" class="btn btn-primary btn-icon btn-sm"><i class="mdi mdi-hospital-marker"></i></a>
                                                        @endcan
                                                        @can('asignar_permiso') 
                                                            <a  href="{{route('stevlab.administracion.edit-permission', $usuario->id)}}" title="Permisos del usuario" class="btn btn-secondary btn-icon btn-sm"  ><i class="mdi mdi-account-key"></i></a>
                                                        @endcan
                                                    @endif
                                                    @can('asignar_rol')
                                                        <a  href="{{route('stevlab.administracion.edit-user-rol', $usuario->id)}}" title="Editar rol" class="btn btn-info btn-icon  btn-sm" aria-disabled="true"><i class="mdi mdi-account-star"></i></a>
                                                    @endcan
                                                    @can('editar_usuarios')
                                                        <a  href="{{route('stevlab.administracion.edit-user-info', $usuario->id)}}" title="Editar información del usuario" class="btn btn-success btn-icon btn-sm"  ><i class="mdi mdi mdi-account-details"></i></a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        {{-- @endif --}}
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="6">
                                                No data allowed.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <!-- Modal -->
    <div class="modal fade" id="modalUsuario" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalAñadirUsuario" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Añadir usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id='regisUser' class="form-sample" {{--action="{{ route('stevlab.administracion.store-user') }}" method="POST" --}} >
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre completo</label>
                                    <input type="text"  class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nombre completo" value="{{old('name')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo usuario</label>
                                    <input type="email"  class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{old('email')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Usuario</label>
                                    <input type="text"  class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Usuario" value="{{old('username')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="text"  class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Contraseña" value="{{old('password')}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="confirmar_contraseña" class="form-label">Confirmar contraseña</label>
                                    <input type="password"  class="form-control @error('confirmar_contraseña') is-invalid @enderror" id="confirmar_contraseña" name="confirmar_contraseña" placeholder="Confirme contraseña">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="rol" class="form-label">Rol</label>
                                    <select id='rol' name="rol" class="js-example-basic-single form-select" data-width="100%">
                                        <option selected disabled>Seleccione</option>
                                        @foreach ($roles as $rol)
                                            @if ( !auth()->user()->hasRole('Administrador') && ($rol->name === 'Administrador' || $rol->name === 'Contador' || $rol->name === 'Doctor' || $rol->name === 'Empresa') )
                                            @else
                                                <option value="{{$rol->id}}">{{$rol->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary submit">Guardar</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div> 
@endsection
@push('plugin-scripts')
	<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
	<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

@endpush
@push('custom-scripts')
    <script src="{{ asset('public/stevlab/administracion/usuarios/data-table.js') }}"></script>
    <script src="{{ asset('public/stevlab/administracion/usuarios/form-validation.js') }}"></script>

    {{-- <script src="{{ asset('public/stevlab/administracion/usuarios/functions.js') }}"></script> --}}
@endpush