@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    

<div class="row">
    <div class="d-md-block col-sm-12 col-md-12 col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Permisos de: {{$usuario->name}}</h4>
                <p class="text-muted mb-3">Asignar o revocar permisos</p>
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="checkedAll" name="checkedAll" >
                    <label class="form-check-label" for="checkedAll">
                        Seleccionar todos los permisos
                    </label>
                </div>
                <form id="permisosForm" action="{{route('stevlab.administracion.update-permissions')}}" method="post" >
                    <hr>
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="hidden" name="user" value="{{ $usuario->id }}">
                                <div class="mb-4">
                                    @foreach ($permissions->chunk(ceil($permissions->count() / 3))[0] as $key =>  $permiso)
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="permiso{{$permiso->id}}" name="permisos[]" value="{{$permiso->id}}" {{$usuario->hasPermissionTo($permiso->id) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="permiso{{$permiso->id}}">
                                                {{$permiso->description}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="hidden" name="user" value="{{ $usuario->id }}">
                                <div class="mb-4">
                                    @foreach ($permissions->chunk(ceil($permissions->count() / 3))[1] as $key =>  $permiso)
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="permiso{{$permiso->id}}" name="permisos[]" value="{{$permiso->id}}" {{$usuario->hasPermissionTo($permiso->id) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="permiso{{$permiso->id}}">
                                                {{$permiso->description}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <input type="hidden" name="user" value="{{ $usuario->id }}">
                                <div class="mb-4">
                                    @foreach ($permissions->chunk(ceil($permissions->count() / 3))[2] as $key =>  $permiso)
                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input" id="permiso{{$permiso->id}}" name="permisos[]" value="{{$permiso->id}}" {{$usuario->hasPermissionTo($permiso->id) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="permiso{{$permiso->id}}">
                                                {{$permiso->description}}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <button class="btn btn-primary">Actualizar permisos</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
@endpush


@push('custom-scripts')
    <script src="{{ asset('public/stevlab/administracion/usuarios/select2.js') }}"></script>
    <script src="{{ asset('public/stevlab/administracion/usuarios/functions.js') }}"></script>
@endpush