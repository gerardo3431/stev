
@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />

@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item"><a href="{{route('stevlab.recepcion.index')}}">Recepcion</a></li>
            <li class="breadcrumb-item"><a href="{{route('stevlab.recepcion.importacion')}}">Importación</a></li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="#">Muestreo de datos</a> </li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @foreach ($arreglo as $clave => $padre)
                                <form>
                                    <input type="hidden" id="area" name="area" class="" value="{{$area->id}}">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-3 col-lg-2">
                                                <h6 class="card-title mt-3">{{$padre['folio']}}</h6>
                                            </div>
                                            <div class="col-sm-12 col-md-3 col-lg-2">
                                                <label class='form-label' for="folio">Folio:</label>
                                                <select id="folio" name="folio" class="js-example-basic-multiple form-select selectFolio" multiple='multiple' data-width="100%">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        @foreach ($padre['parametros'] as $key => $parametro)
                                            @foreach ($parametro as $key => $analito)
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-3 col-lg-3">
                                                        <div class="mb-3">
                                                            <label class='form-label' for="clave">Analito:</label>
                                                            
                                                            <select id="analito" name="analito[{{$key}}]" class="js-example-basic-multiple form-select selectAnalito" multiple='multiple' data-width="100%" aria-label="size 2">
                                                                <option value="{{$analito['analito']}}" selected>{{$analito['analito']}}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-2 col-lg-2">
                                                        <div class="mb-3">
                                                            <label class="form-label">Valor de captura:</label>
                                                            <input  class="form-control @error('valor') is-invalid @enderror" id='valor' name="{{ $analito['analito'] }}" type="text" value="{{$analito['valor']}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-2 col-lg-1">
                                                        <a type="button" class="btn btn-danger btn-xs btn-icon mt-4" onclick="deleteThis(this)">
                                                            <i class="mdi mdi-delete-forever "></i>
                                                        </a>
                                                    </div>
                                                    {{-- <div class="col-sm-12 col-md-2 col-lg-3">
                                                        @foreach ($fila as $item)
                                                            <span class="badge bg-light text-dark">{{$item}}</span>
                                                        @endforeach
                                                    </div> --}}
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-success">
                                            <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                                            Guardar
                                        </button>
                                    </div>
                                </form>
                                {{-- <form>
                                    <input type="hidden" id="area" name="area" class="" value="{{$area->id}}">
                                    <div class="mb-3">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-3 col-lg-2">
                                                <h6 class="card-title mt-3">{{$clave}}</h6>
                                            </div>
                                            <div class="col-sm-12 col-md-3 col-lg-2">
                                                <label class='form-label' for="folio">Folio:</label>
                                                <select id="folio" name="folio" class="js-example-basic-multiple form-select selectFolio" multiple='multiple' data-width="100%">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        @foreach ($estudio as $key => $fila )
                                            <div class="row">
                                                
                                                <div class="col-sm-12 col-md-3 col-lg-3">
                                                    <div class="mb-3">
                                                        <label class='form-label' for="clave">Analito:</label>
                                                        @php
                                                            $analito  = $tr->translate($estudio);
                                                        @endphp
                                                        <select id="analito" name="analito[{{$key}}]" class="js-example-basic-multiple form-select selectAnalito" multiple='multiple' data-width="100%" aria-label="size 2">
                                                            <option value="{{$analito}}" selected>{{$analito}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-2 col-lg-2">
                                                    <div class="mb-3">
                                                        <label class="form-label">Valor de captura:</label>
                                                        <input  class="form-control @error('valor') is-invalid @enderror" id='valor' name="valor[{{$key}}]" type="text" value="{{$valorNumerico}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-2 col-lg-1">
                                                    <a type="button" class="btn btn-danger btn-xs btn-icon mt-4" onclick="deleteThis(this)">
                                                        <i class="mdi mdi-delete-forever "></i>
                                                    </a>
                                                </div>
                                                <div class="col-sm-12 col-md-2 col-lg-3">
                                                    @foreach ($fila as $item)
                                                        <span class="badge bg-light text-dark">{{$item}}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-success">
                                            <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                                            Guardar
                                        </button>
                                    </div>
                                </form> --}}
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('public/stevlab/recepcion/importacion/select2.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/recepcion/importacion/functions.js') }}?v=<?php echo rand();?>"></script>


@endpush