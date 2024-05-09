@extends('layout.master')
@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Utilerias </li>
            <li class="breadcrumb-item active" aria-current="page"> Fitosanitario </li>
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
                    <h4 class="card-title">Responsable sanitario</h4>
                    <form enctype="multipart/form-data" id="registro_estudios" action="{{route('stevlab.utils.fitosanitario-update')}}" method="POST">
                        @csrf
                        <input type='hidden' class="form-control {{ $errors->has('id') ? 'is-invalid' : '' }}" name="id"  placeholder="Identificador" value='{{old('id', $laboratorio->id)}}'>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="responsable_sanitario" class="form-label">Responsable sanitario</label>
                                    <input type='text' class="form-control {{ $errors->has('responsable_sanitario') ? 'is-invalid' : '' }}" name="responsable_sanitario"  placeholder="Nombre" value='{{old('responsable_sanitario', $laboratorio->responsable_sanitario)}}'>
                                    <x-jet-input-error for="responsable_sanitario"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="cedula_sanitario" class="form-label">Cedula</label>
                                    <input type='number' class="form-control {{ $errors->has('cedula_sanitario') ? 'is-invalid' : '' }}" name="cedula_sanitario"  placeholder="Cedula" value='{{old('cedula_sanitario', $laboratorio->cedula_sanitario)}}'>
                                    <x-jet-input-error for="cedula_sanitario"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="firma_sanitario" class="form-label">Firma</label>
                                    {{-- data-height="300" --}}
                                    <input type="file" class="" id="firma_sanitario" name="firma_sanitario"  data-default-file="{{ asset('public/storage/' . $laboratorio->firma_sanitario) }}" {{--data-allowed-formats=""--}} data-allowed-file-extensions="png"/>
                                    <x-jet-input-error for="firma_sanitario"></x-jet-input-error>
                                </div>
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Responsable imagenologia</h4>
                    <form enctype="multipart/form-data" id="registro_estudios" action="{{route('stevlab.utils.fitosanitario-img-update')}}" method="POST">
                        @csrf
                        <input type='hidden' class="form-control {{ $errors->has('id') ? 'is-invalid' : '' }}" name="id"  placeholder="Identificador" value='{{old('id', $laboratorio->id)}}'>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="responsable_img" class="form-label">Responsable sanitario</label>
                                    <input type='text' class="form-control {{ $errors->has('responsable_sanitario') ? 'is-invalid' : '' }}" name="responsable_img"  placeholder="Nombre" value='{{old('responsable_img', $laboratorio->responsable_img)}}'>
                                    <x-jet-input-error for="responsable_img"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="cedula_img" class="form-label">Cedula</label>
                                    <input type='number' class="form-control {{ $errors->has('cedula_img') ? 'is-invalid' : '' }}" name="cedula_img"  placeholder="Cedula" value='{{old('cedula_sanitario', $laboratorio->cedula_img)}}'>
                                    <x-jet-input-error for="cedula_img"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-12 col-lg-12 col-xl-12 ">
                                    <label for="firma_img" class="form-label">Firma</label>
                                    {{-- data-height="300" --}}
                                    <input type="file" class="" id="firma_img" name="firma_img"  data-default-file="{{ asset('public/storage/' . $laboratorio->firma_img) }}" {{--data-allowed-formats=""--}} data-allowed-file-extensions="png"/>
                                    <x-jet-input-error for="firma_img"></x-jet-input-error>
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
    <script src="{{ asset('public/stevlab/utils/fitosanitario/dropify.js')}}?v=<?php echo rand();?>"></script>
@endpush
