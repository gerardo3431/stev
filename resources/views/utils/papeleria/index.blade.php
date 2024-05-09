@extends('layout.master')
@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="row">
                <div class="col-md-12">
                    <div class="px-4 px-sm-0">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="h5">
                                    Membretes
                                </h3>
                    
                                <p class="mt-1 text-muted">
                                    <span class="small">
                                        Actualiza el membrete utilizado por los reportes de resultados
                                    </span>
                                </p>
                            </div>
                    
                            <div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8  grid-margin">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <form action="{{route('stevlab.utils.update-membrete')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <h6 class="card-title"></h6>
                                <label for="membrete">Membrete principal.</label>
                                <input type="file" id='membrete' name="membrete" class="{{ $errors->has('membrete') ? 'is-invalid' : '' }}" data-allowed-file-extensions="png" data-default-file="{{asset('/public/storage/' . $laboratorio->membrete)}}"/>
                                <x-jet-input-error for="membrete" />
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <form action="{{route('stevlab.utils.update-membrete-secondary')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <h6 class="card-title"></h6>
                                    <label for="membrete_secundario">Membrete secundario.</label>
                                    <input type="file" id='membrete_secundario' name="membrete_secundario" class="{{ $errors->has('membrete_secundario') ? 'is-invalid' : '' }}" data-allowed-file-extensions="png" data-default-file="{{asset('/public/storage/' .$laboratorio->membrete_secundario)}}"/>
                                    <x-jet-input-error for="membrete_secundario" />
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary" type="submit">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <form action="{{route('stevlab.utils.update-membrete-terciary')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <h6 class="card-title"></h6>
                                    <label for="membrete_terciario">Membrete terciario.</label>
                                    <input type="file" id='membrete_terciario' name="membrete_terciario" class="{{ $errors->has('membrete_terciario') ? 'is-invalid' : '' }}" data-allowed-file-extensions="png" data-default-file="{{asset('/public/storage/' .$laboratorio->membrete_terciario)}}"/>
                                    <x-jet-input-error for="membrete_terciario" />
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary" type="submit">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>
    <div class="py-3">
        <hr>
    </div>
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="row">
                <div class="col-md-12">
                    <div class="px-4 px-sm-0">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="h5">
                                    Membretes imagenologia y recibo de pago
                                </h3>
                    
                                <p class="mt-1 text-muted">
                                    <span class="small">
                                        Actualiza el membrete de imagenologia y recibo de pago
                                    </span>
                                </p>
                            </div>
                    
                            <div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8  grid-margin">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <form action="{{route('stevlab.utils.update-membrete-img')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <h6 class="card-title"></h6>
                                <label for="membrete">Membrete imagenologia.</label>
                                <input type="file" id='membrete_img' name="membrete_img" class="{{ $errors->has('membrete_img') ? 'is-invalid' : '' }}" data-allowed-file-extensions="png" data-default-file="{{asset('/public/storage/' . $laboratorio->membrete_img)}}"/>
                                <x-jet-input-error for="membrete" />
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <form action="{{route('stevlab.utils.update-recibo-pago')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <h6 class="card-title"></h6>
                                <label for="membrete">Membrete recibo de pago.</label>
                                <input type="file" id='recibo_pago' name="recibo_pago" class="{{ $errors->has('recibo_pago') ? 'is-invalid' : '' }}" data-allowed-file-extensions="png" data-default-file="{{asset('/public/storage/membrete_laboratorios/RECIBO-DE-PAGO.png' )}}"/>
                                <x-jet-input-error for="membrete" />
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-3">
        <hr>
    </div>
    <div class="row">
        <div class="col-md-4 grid-margin stretch-card">
            <div class="row">
                <div class="col-md-12">
                    <div class="px-4 px-sm-0">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="h5">Logotipo</h3>
                                <p class="mt-1 text-muted">
                                    <span class="small">
                                        Reemplaze el logotipo mostrado en tickets
                                    </span>
                                </p>

                            </div>
                            <div></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-md-8 grid-margin">
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card">
                        <form action="{{route('stevlab.utils.update-logotipo')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <h6 class="card-title">Logotipo</h6>
                                <label for="Logotipo">Logotipo</label>
                                <input type="file" id="logotipo" name="logotipo" class="{{$errors->has('membrete' ? 'is-invalid' : '')}}" data-allowed-file-extensions="png" data-default-file="{{asset('public/storage/' . $laboratorio->logotipo)}}">
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary" type="submit">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-3">
        <hr>
    </div>
    @can('Administrador')
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="row">
                    <div class="col-md-12">
                        <div class="px-4 px-sm-0">
                            <div class="d-flex justify-content-between">
                                
                                <div>
                                    <h3 class="h5">Limpieza</h3>
                                    <p class="mt-1 text-muted">
                                        <span class="small">
                                            Limpie la caché de la aplicación, configuración, vistas, rutas, cola de trabajo.
                                        </span>
                                    </p>
                                    <p class="mt-1">
                                    </p>

                                </div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-8 grid-margin">
                <div class="row mb-3">
                    <div class="col-md-12">
                        {{-- <div class="card"> --}}
                            <form action="{{route('stevlab.utils.update-cache')}}" method="post">
                                @csrf
                                <div class="card-footer">
                                    <button class="btn btn-primary" type="submit">Limpiar</button>
                                </div>
                            </form>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="py-3">
            <hr>
        </div>
        <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
                <div class="row">
                    <div class="col-md-12">
                        <div class="px-4 px-sm-0">
                            <div class="d-flex justify-content-between">
                                
                                <div>
                                    <h3 class="h5">Storage</h3>
                                    <p class="mt-1 text-muted">
                                        <span class="small">
                                            Enlace la carpeta del almacenamiento predeterminado con la carpeta pública.
                                        </span>
                                    </p>
                                    <p class="mt-1">
                                    </p>

                                </div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-8 grid-margin">
                <div class="row mb-3">
                    <div class="col-md-12">
                        {{-- <div class="card"> --}}
                            <form action="{{route('stevlab.utils.zelda-stg')}}" method="post">
                                @csrf
                                <div class="card-footer">
                                    <button class="btn btn-primary" type="submit">Enlazar</button>
                                </div>
                            </form>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('plugin-scripts')
    <script src="{{ asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
@endpush
@push('custom-scripts')
    <script src="{{ asset('public/stevlab/perfil/dropify.js') }}?v=<?php echo rand();?>"></script>
@endpush