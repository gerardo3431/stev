@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    

<div class="row">
    <div class="d-md-block col-md-6 col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Rol</h4>
                <div class="row">
                    <div class="col-md-12">
                        <label for="" class="form-label">Rol asignado</label>
                        <div class="mb-3">
                            @if ($usuario->roles())
                                <span class="badge bg-light text-dark">{{$usuario->roles()->first() ? $usuario->roles()->first()->name : ''}}</span>
                            @else
                                <span class="badge badge-danger bg-danger">No rol asignado</span>
                            @endif

                            
                        </div>
                    </div>
                </div>
                <form action="{{route('stevlab.administracion.update-user-roles')}}" method="post" >
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Asignar o revocar rol</label>
                                <input type="hidden" name="user" value="{{ $usuario->id }}">
                                {{-- @dd($roles) --}}
                                <select name="permisos" id="permisos" class="form-select js-example-basic-multiple" data-width="100%">
                                    @foreach ($roles as $rol)
                                        @if (auth()->user()->hasRole(['Administrador', 'Contador']))
                                            <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                        @else
                                            @if (!in_array($rol->name, ['Doctor', 'Empresa']))
                                                <option {{ $usuario->hasRole($rol) ? 'selected' : '' }} value="{{ $rol->id }}">
                                                    {{ $rol->name }}
                                                </option>
                                            @endif
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary">Actualizar rol</button>
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