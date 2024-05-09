@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    

<div class="row">
    <div class="d-md-block col-md-6 col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Sucursales</h4>
                <div class="row">
                    <div class="col-md-12">
                        <label for="" class="form-label">Sucursales asignadas:</label>
                        <div class="mb-3">
                            @forelse ($usuario->sucursal()->get() as $sucursal)
                                <span class="badge bg-light text-dark">{{$sucursal->sucursal}}</span>
                            @empty
                                <span class="badge badge-danger bg-danger">No sucursales asignadas</span>
                            @endforelse
                        </div>
                    </div>
                </div>
                <form action="{{route('stevlab.administracion.update-user-subsidiaries')}}" method="post" >
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Asignar o revocar sucursales</label>
                                <input type="hidden" name="user" value="{{ $usuario->id }}">
                                
                                <select multiple='multiple' name="permisos[]" id="permisos" class="form-select js-example-basic-multiple" data-width="100%">
                                    @foreach ($subsidiaries as $sucursal)
                                        @if ($usuario->sucursal()->where('subsidiary_id', $sucursal->id)->first())
                                            <option selected value="{{$sucursal->id}}">{{$sucursal->sucursal}}</option>
                                        @else
                                            <option value="{{$sucursal->id}}">{{$sucursal->sucursal}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary">Actualizar sucursales</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
@endpush


@push('custom-scripts')
    <script src="{{ asset('public/stevlab/administracion/usuarios/select2.js') }}"></script>
@endpush