
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
            <li class="breadcrumb-item active" aria-current="page"> <a href="">Catalogo</a> </li>
            <li class="breadcrumb-item active" aria-current="page"> <a href="">Areas de imagenología</a> </li>
        </ol>
    </nav>

    
    <div class="row" id="areas">
        {{-- d-none d-md-block col-md-4 col-xl-3 left-wrapper --}}
        <div class="d-md-block col-md-12 col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    
                    <h6 class="card-title">Áreas</h6>
                    
                    <form class="forms-sample" action="{{route('stevlab.catalogo.store-area-img')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" name='descripcion' class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" autocomplete="off" placeholder="Descripción">
                            <x-jet-input-error for="descripcion"></x-jet-input-error>
                        </div>
                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea name="observaciones" rows="3" class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" placeholder="Observaciones"></textarea>
                            <x-jet-input-error for="observaciones"></x-jet-input-error>
                        </div>
                        <button type="submit" class="btn btn-primary me-2">Guardar</button>
                        {{-- <button class="btn btn-secondary">Cancel</button> --}}
                    </form>
                    
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tabla de áreas</h4>
                    <div class="table-responsive">
                        <table id="dataTableAreas" class="table">
                            <thead>
                                <tr>
                                    <th>Descripcion</th>
                                    <th>Observaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deparments as $deparment)
                                    <tr>
                                        <td>{{$deparment->descripcion}}</td>
                                        <td>{{$deparment->observaciones}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!------------------------------------------------------------------------------------------------>

    <div class="row">
    @if (session('msg'))
        <div class="alert alert-warning">
            {{ session('msg') }}
        </div>
    @endif
    </div>

<!------------------------------------------------------------------------------------------------>
@endsection

@push('plugin-scripts')
<script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('public/assets/js/data-table.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/catalogo/doctores/functions.js') }}?v=<?php echo rand();?>"></script>
@endpush





