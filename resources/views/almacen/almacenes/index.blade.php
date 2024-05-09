@extends('layout.master')

@push('plugin-styles')
@endpush
@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Almacen </li>
            <li class="breadcrumb-item active" aria-current="page"> Almacenes </li>
        </ol>
    </nav>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('msj'))
        <div class="alert alert-success">
            {{ session('msj') }}
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Almacen</h4>
                    <form id="registro_estudios" action="{{route('stevlab.almacen.store-almacen')}}" method="POST">
                        @csrf
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="mb-3 col-sm-4">
                                    <label for="clave" class="form-label">Clave</label>
                                    <input type='text' class="form-control {{ $errors->has('clave') ? 'is-invalid' : '' }}" name="clave"  placeholder="Clave" value='{{old('clave')}}'>
                                    <x-jet-input-error for="clave"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-4">
                                    <label for="clave" class="form-label">Estado</label>
                                    <select class="form-select {{ $errors->has('estatus') ? 'is-invalid' : '' }}" name="estatus" value='{{old('estatus')}}'>
                                        <option value="activo">Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                    </select>
                                    <x-jet-input-error for="descripcion"></x-jet-input-error>
                                </div>
                                <div class="mb-3 col-sm-12">
                                    <label for="clave" class="form-label">Descripcion</label>
                                    <input type='text' class="form-control {{ $errors->has('descripcion') ? 'is-invalid' : '' }}" name="descripcion"  placeholder="Descripcion" value='{{old('descripcion')}}'>
                                    <x-jet-input-error for="descripcion"></x-jet-input-error>
                                </div>
                                
                            </div>
                        </div>
                        <input class="btn btn-primary" type="submit" value="Guardar">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-8 col-lg-8 col-xl-8 d-md-block grid-margin stretch-card">
            
        </div>
    </div>
@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')

@endpush