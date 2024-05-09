@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-10 col-xl-10 mx-auto">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center mb-3 mt-4">{{$recepcion->paciente()->first()->nombre}}</h3>
                            <p class="text-muted text-center mb-4 pb-2">{{$estudio->clave}}</p>
                            <div class="container">  
                                <div class="row">
                                    <div class="col-md-12 stretch-card grid-margin grid-margin-md-0">
                                        <div class="card">
                                            <div class="card-body">
                                                <h4 class="text-center mt-3 mb-4"></h4>
                                                <img class="img-fluid rounded mx-auto d-block" src="{{URL::to('/') . '/public/storage/logos_laboratorios/labs.png'}}" height="30%" width="30%" alt="Laboratorio">
                                                {{-- <i data-feather="gift" class="text-success icon-xxl d-block mx-auto my-3"></i> --}}
                                                <p class="text-muted text-center mb-4 fw-light">Fecha de informe</p>
                                                <h2 class="text-center">
                                                    {{$valida}}
                                                </h2>
                                                <p class="text-muted text-center mb-4 fw-light">Resultado</p>
                                                <h5 class="text-secondary text-center mb-4">
                                                    {{$analito->valor}}
                                                </h5>
                                                <table class="mx-auto">
                                                    <tr>
                                                        <td>
                                                            <p class="text-black text-center mb-4 fw-light">
                                                                {{$analito->descripcion}}
                                                            </p> 
                                                        </td>
                                                        <td>
                                                            <p class="text-danger text-center mb-4 fw-light">
                                                                {{$analito->valor}}
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td>
                                                            <p class="text-black text-center mb-4 fw-light">
                                                                {{$recepcion->estudios()->where('clave', $estudio->clave)->first()->historial()->get()[1]->descripcion}}
                                                            </p> 
                                                        </td>
                                                        <td>
                                                            <p class="text-danger text-center mb-4 fw-light">
                                                                {{$recepcion->estudios()->where('clave', $estudio->clave)->first()->historial()->get()[1]->valor}}
                                                            </p>
                                                        </td>
                                                    </tr> --}}
                                                </table>
                                                <div class="d-grid">
                                                    <a class="btn btn-success mt-4" href="{{route('resultados.index')}}">Entendido!</a>
                                                    {{-- <button >Entendido!</button> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
