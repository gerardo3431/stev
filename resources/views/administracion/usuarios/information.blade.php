@extends('layout.master')

@push('plugin-styles')

@endpush

@section('content')
    <div class="row">
        @if (session('errors'))
            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                <i data-feather="alert-circle"></i>
                <strong>Aviso!</strong> {{ session('errors') }} 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
            </div>
        @endif
        <div class="d-md-block col-sm-12 col-md-6 col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Actualizar información de: {{$usuario->name}}</h4>
                    <form id="usuarioForm" action="{{route('stevlab.administracion.update-user-info')}}"  method="post" >
                        @csrf
                        <input type="hidden"   class="form-control @error('id') is-invalid @enderror" id="id" name="id"  value="{{old('id') ? old('id') : $usuario->id}}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre completo</label>
                                    <input type="text"  class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nombre del usuario" value="{{old('name') ? old('name') : $usuario->name}}">
                                    @error('name')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-8">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo usuario</label>
                                    <input type="email"  class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{old('email') ? old('email') : $usuario->email}}">
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-xl-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Usuario </label>
                                    <input type="text"  class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Nombre del usuario" value="{{old('username') ? old('username') : $usuario->username}}">
                                    @error('username')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-md-12 col-lg-12 col-xl-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Contraseña actual</label>
                                    <input type="password" autocomplete="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Ingrese contraseña actual" value="{{old('password')}}">
                                    @error('password')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="col-md-12 col-lg-12 col-xl-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nueva contraseña</label>
                                    <input type="text" class="form-control @error('new_password_1') is-invalid @enderror" id="new_password_1" name="new_password_1" placeholder="Nueva contraseña" value="{{old('new_password_1')}}">
                                    @error('new_password_1')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12 col-xl-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Repita contraseña</label>
                                    <input type="password" class="form-control @error('new_password_2') is-invalid @enderror" id="new_password_2" name="new_password_2" placeholder="Repita contraseña" value="{{old('new_password_2')}}">
                                    @error('new_password_2')
                                        <span class="invalid-feedback">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush


@push('custom-scripts')
    <script src="{{ asset('public/stevlab/administracion/usuarios/edit/form-validation.js') }}?v=<?php echo rand();?>"></script>
@endpush