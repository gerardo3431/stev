@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item"><a href="{{route('stevlab.recepcion.index')}}">Recepcion</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="{{route('stevlab.captura.importacion')}}">Importacion</a> </li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-4 grid-margin">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <form action="{{route('stevlab.recepcion.import')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <h6 class="card-title">Procesamiento</h6>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="mb-3">
                                        <label class='form-label' for="clave">Area del documento:</label>
                                        <select id="area" name="area" class="js-example-basic-multiple form-select" data-width="100%" aria-label="size 2">
                                            @foreach ($areas as $key=> $area)
                                                <option value="{{$area->id}}">{{$area->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <div class="mb-3">
                                        <label for="file">Carga de archivos</label>
                                        <p class="text-muted">La aplicación de escritorio genera el archivo en: <br> 
                                            <strong>
                                                C:\Users\~~\Documents\ 
                                            </strong>
                                            <br> Donde <strong>~~</strong> es el usuario de la maquina actual.
                                        </p>
                                        <input type="file" id="file" name="file" class="{{$errors->has('file' ? 'is-invalid' : '')}}" data-allowed-file-extensions="xlsx" data-default-file="#">{{-- Verificar si abre realmente la misma carpeta siempre--}}
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" type="submit">Procesar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>

@endpush

@push('custom-scripts')
    <script src="{{ asset('public/stevlab/recepcion/importacion/importacion.js') }}?v=<?php echo rand();?>"></script>
    {{-- <script src="{{ asset('public/stevlab/recepcion/importacion/select2.js') }}?v=<?php echo rand();?>"></script> --}}

@endpush