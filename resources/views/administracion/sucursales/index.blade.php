@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item" aria-current="page"><a href="#">Administración</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sucursales</li>
        </ol>
    </nav>
    
    <div class="row">
        @can('crear_sucursal')
            <div class="d-md-block col-md-12 col-lg-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">
                            Añadir sucursal
                        </h4>
                
                        <form action="{{route('stevlab.administracion.store-sucursal')}}" method="post" class="form-sample">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sucursal" class="form-label">Nombre sucursal</label>
                                        <input type="text"  class="form-control @error('sucursal') is-invalid @enderror" id="sucursal" name="sucursal" placeholder="Nombre de la sucursal" value="{{old('sucursal')}}">
                                        @error('sucursal')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">Número de teléfono</label>
                                        <input type="text"  class="form-control @error('telefono') is-invalid @enderror" id="telefono" name="telefono" placeholder="Teléfono de la sucursal" value="{{old('telefono')}}">
                                        @error('telefono')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Dirección sucursal</label>
                                        <input type="text"  class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" placeholder="Dirección de la sucursal" value="{{old('direccion')}}">
                                        @error('direccion')
                                            <span class="invalid-feedback">
                                                <strong>{{$message}}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">Añadir sucursal</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endcan
        <div class="d-md-block col-md-12S col-lg-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h4 class="card-title">Sucursales</h4>
                        <div class="table-responsive">
                            <table id='tableSucursales' class="table" width="100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sucursal</th>
                                        <th><i class="mdi mdi-wrench"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($locales as $local)
                                        <tr>
                                            <td>{{$local->id}}</td>
                                            <td>{{$local->sucursal}}</td>
                                            <td>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('public/stevlab/administracion/sucursales/functions.js') }}?v=<?php echo rand();?>"></script>
    
@endpush