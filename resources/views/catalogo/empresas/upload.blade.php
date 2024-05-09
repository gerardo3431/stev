@extends('layout.master')

@push('plugin-styles') 
<link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush


@section('content')
  {{-- Inicio breadcrumb caja --}}
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item" aria-current="page"> <a href="">Catalogo</a> </li>
            <li class="breadcrumb-item" aria-current="page"> <a href="">Empresas</a> </li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="">Crear usuario empresa</a> </li>
        </ol>
    </nav>

  {{-- Fin breadcrumb recepcion --}}
  {{-- Inicia panel's detalle --}}
  {{-- @dd(Auth::user()->first()) --}}

<!------------------------------------------------------------------------------------------------>

<div class="row">
    <div class="col-sm-8  stretch-card">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{route('stevlab.catalogo.empresa-upload-user')}}">
                @csrf  
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <input hidden class="form-control @error('id') is-invalid @enderror" name="id" value="{{$empresa->id}}"type="text">
                            @error('id')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{$empresa->contacto}}"type="text">
                            @error('name')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">Correo</label>
                            <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" type="text">
                            @error('email')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">Usuario</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{old('username')}}">
                            @error('username')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{old('password')}}">
                            @error('password')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="mb-3">
                            <label class="form-label">Cedula</label>
                            <input type="text" class="form-control @error('cedula') is-invalid @enderror" name="cedula" value="{{old('cedula')}}">
                            @error('cedula')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="mb-3">
                            <label class="form-label">Universidad</label>
                            <input type="text" class="form-control @error('universidad') is-invalid @enderror" name="universidad" value="{{old('universidad')}}">
                            @error('universidad')
                            <span class="invalid-feedback">
                                <strong>{{$message}}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3">
                        <p class="text-muted">La configuración del rol se asigna en automático. </p>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Crear usuario</button>
                </form>
            </div>
        </div> 
    </div>
</div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
@endpush





