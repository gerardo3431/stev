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
                            <h5 class="text-muted fw-normal mb-4">Entrega de resultados. Por favor ingrese los datos correspondiente.</h5>
                            @if (session('status'))
                                <div class="alert alert-success mb-3 rounded-0" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if (session('message'))
                                <div class="alert alert-danger mb-3 rounded-0" role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <form class="forms-sample" action="{{ route('resultados.search') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="username" class="form-label">Folio</label>
                                    <input value="{{old('folio')}}" type="text" class="form-control {{ $errors->has('folio') ? 'is-invalid' : '' }}" name='folio' placeholder="Folio">
                                    <x-jet-input-error for="folio"></x-jet-input-error>
                                </div>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Token</label>
                                    <input value="{{old('token')}}" type="nombre" class="form-control {{ $errors->has('token') ? 'is-invalid' : '' }}" name='token' placeholder="Token">
                                    <x-jet-input-error for="token"></x-jet-input-error>
                                </div>
                                <div>
                                    <button class="btn btn-primary me-2 mb-2 mb-md-0" type="submit">Buscar resultados</button>
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
