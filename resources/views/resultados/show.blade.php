@extends('layout.master2')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-10 col-xl-10 mx-auto">
            <div class="card">
                <div class="row">
                    <div class="col-md-2 pe-md-0">
                        <div class="auth-side-wrapper" style="background-image: url({{ asset('public/assets/images/images/login.jpg') }})">

                        </div>
                    </div>
                    <div class="col-md-10 ps-md-0">
                        <div class="auth-form-wrapper px-4 py-5">
                            <a href="#" class="noble-ui-logo d-block mb-2">Stev<span>Lab</span></a>
                            <h5 class="text-muted fw-normal mb-4">Entrega de resultados.</h5>
                            @if (session('message'))
                                <div class="alert alert-danger mb-3 rounded-0" role="alert">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        @if ($resultado->estado == 'no pagado')
                                            <a type="button"  class="btn btn-success disabled" href=""><i class="btn-icon-prepend" data-feather="download"></i> Descargar resultados</a>
                                            
                                        @else
                                            <a type="button" class="btn btn-success" href="{{route( 'resultados.show',  $resultado->id )}}"><i class="btn-icon-prepend" data-feather="download"></i> Descargar resultados</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" >Resultados anteriores</label>
                                        <div class="table-responsive">
                                            <table class="table display nowrap"  style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Folio</th>
                                                        <th>Nombre</th>
                                                        <th>Fecha</th>
                                                        <th>Estado</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @foreach ($otros as $key => $otro)
                                                        <tr>
                                                            <td>{{$otro->folio}}</td>
                                                            <td>{{$otro->paciente()->first()->nombre}}</td>
                                                            <td>{{$otro->created_at}}</td>
                                                            <td>
                                                                {{$otro->estado}}
                                                                {{-- @if ({{($otro->estado == 'no pagado')}})
                                                                    <a href="{{route( 'resultados.show',  $otro->id )}}" disabled type="button" class="btn btn-primary btn-icon">
                                                                        <i data-feather="eye"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{route( 'resultados.show',  $otro->id )}}" type="button" class="btn btn-primary btn-icon">
                                                                        <i data-feather="eye"></i>
                                                                    </a>
                                                                @endif --}}
                                                            </td>
                                                            <td>
                                                                @if ($otro->estado == 'no pagado')
                                                                    <a href="#"  type="button" class="btn btn-primary btn-icon disabled">
                                                                        <i data-feather="eye"></i>
                                                                    </a>
                                                                @else
                                                                    <a href="{{route( 'resultados.show',  $otro->id )}}" type="button" class="btn btn-primary btn-icon">
                                                                        <i data-feather="eye"></i>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
