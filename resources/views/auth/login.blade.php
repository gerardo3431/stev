@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
                <div class="row">
                    <div class="col-md-4 pe-md-0">
                        <div class="auth-side-wrapper" style="background-image: url({{ asset('public/assets/images/images/login.jpg') }})">

                        </div>
                    </div>
                    <div class="col-md-8 ps-md-0">
                        <div class="auth-form-wrapper px-4 py-5">
                            <a href="#" class="noble-ui-logo d-block mb-2">Stev<span>Lab</span></a>
                            <h5 class="text-muted fw-normal mb-4">Bienvenido. Inicie sesión en su cuenta.</h5>
                            @if (session('status'))
                                <div class="alert alert-success mb-3 rounded-0" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <form class="forms-sample" action="{{ route('login') }}" method="POST">
                                @csrf
                                {{-- Correo --}}
                                {{-- <div class="mb-3">
                                    <label for="userEmail" class="form-label">Correo</label>
                                    <input value="{{old('email')}}" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name='email' placeholder="Correo Electrónico">
                                    <x-jet-input-error for="email"></x-jet-input-error>
                                </div> --}}
                                {{-- Username --}}
                                <div class="mb-3">
                                    <label for="username" class="form-label">Usuario</label>
                                    <input value="{{old('username')}}" type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" name='username' placeholder="Usuario">
                                    <x-jet-input-error for="username"></x-jet-input-error>
                                </div>
                                <div class="mb-3">
                                    <label for="userPassword" class="form-label">Contraseña</label>
                                    <input value="{{old('password')}}" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"  name='password' autocomplete="current-password" placeholder="Contraseña">
                                    <x-jet-input-error for="password"></x-jet-input-error>
                                </div>
                                <div class="form-check mb-3">
                                    <input type="checkbox" class="form-check-input" id="authCheck">
                                    <label class="form-check-label" for="authCheck">
                                        Recuerdame
                                    </label>
                                </div>
                                <div>
                                    <button class="btn btn-primary me-2 mb-2 mb-md-0" type="submit">Iniciar sesión</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection