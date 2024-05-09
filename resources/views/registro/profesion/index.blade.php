@extends('layout.master2')

@section('content')
    <div class="page-content d-flex align-items-center justify-content-center">
        <div class="row w-100 mx-0 auth-page">
            <div class="col-md-8 col-xl-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">
                            Registro personal (Paso 2 de 3)
                        </h6>
                        <p class="text-muted mb-3">Por favor puede avanzar el registro de formulario a continuación.</p>
                        <form action="{{route('registro.regProfesion')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="cedule">Cedula profesional</label>
                                        <input required type="text" id="cedula" name="cedula" class="form-control {{ $errors->has('cedula') ? 'is-invalid' : '' }}" value="{{old('cedula')}}">
                                        <x-jet-input-error for="cedula"></x-jet-input-error>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="mb-3">
                                        <label class="form-label" for="universidad">Institución que otorgo la cédula.</label>
                                        <input required type="text" id="universidad" name="universidad" class="form-control {{ $errors->has('universidad') ? 'is-invalid' : '' }}" value="{{old('universidad')}}">
                                        <x-jet-input-error for="universidad"></x-jet-input-error>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="firma">Firma</label>
                                        <input required type="file" id="firma" name="firma" class="form-control {{ $errors->has('logotipo') ? 'is-invalid' : '' }}">
                                        <x-jet-input-error for="firma"></x-jet-input-error>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary submit" type="submit">Registrar información</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('custom-scripts')
    
@endpush