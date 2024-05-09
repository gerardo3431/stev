@extends('layout.master')
@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Utilerias </li>
            <li class="breadcrumb-item active" aria-current="page"> Información personal </li>
        </ol>
    </nav>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
    @endif

    @if(session('msj'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('msj') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Usuario</h4>
                    <form enctype="multipart/form-data" id="registro_estudios" action="{{route('stevlab.utils.user-update')}}" method="POST">
                        @csrf
                        <input type='hidden' class="form-control {{ $errors->has('id') ? 'is-invalid' : '' }}" name="id"  placeholder="Identificador" value='{{old('id', $usuario->id)}}'>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type='text' class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name"  placeholder="Nombre" value='{{old('name', $usuario->name)}}'>
                                    <x-jet-input-error for="name"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="cedula" class="form-label">Cedula</label>
                                    <input type='number' class="form-control {{ $errors->has('cedula') ? 'is-invalid' : '' }}" name="cedula"  placeholder="Cedula" value='{{old('cedula', $usuario->cedula)}}'>
                                    <x-jet-input-error for="cedula"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="firma" class="form-label">Firma</label>
                                    {{-- data-height="300" --}}
                                    <input type="file" class="" id="firma" name="firma"  data-default-file="{{ asset('public/storage/' . $usuario->firma) }}" {{--data-allowed-formats=""--}} data-allowed-file-extensions="png"/>
                                    <x-jet-input-error for="firma"></x-jet-input-error>
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush
@push('custom-scripts')
    <script src="{{ asset('public/stevlab/utils/informacion/dropify.js')}}?v=<?php echo rand();?>"></script>
@endpush
