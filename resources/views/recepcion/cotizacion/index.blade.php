@extends('layout.master')

@push('plugin-styles') 
    <link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
@endpush


@section('content')
{{-- Inicio breadcrumb caja --}}
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
        <li class="breadcrumb-item active" aria-current="page"> <a href="{{route('stevlab.recepcion.cotizacion')}}">Cotizacion</a> </li>
    </ol>
</nav>
{{-- Fin breadcrumb recepcion --}}
{{-- Inicia panel's detalle --}}
{{-- @dd(Auth::user()->first()) --}}
<!----------------------------------------------------------------------------------------------------->
<style>
    input, label, button{
        font-size: 13px !important;
    }
</style>
<!----------------------------------------------------------------------------------------------------->
<div class="row">
    <div class="col-sm-12 col-md-10  grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Nombre de solicitante:</label>
                                <input  class="form-control @error('nombre') is-invalid @enderror" placeholder='Nombre del solicitante' id='nombre' name="nombre" type="text" value="">
                            </div>                           
                        </div>
                        <div class="col-md-12">                                   
                            <div class="mb-3">
                                <label class="form-label">Empresa:</label>
                                <select class="js-example-basic-multiple form-control" multiple='multiple' id='id_empresa' name="id_empresa">
                                </select>
                            </div>                      
                        </div>                             
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="defaultconfig-4" class="form-label">Observaciones:</label>
                                <textarea class="form-control" maxlength="500" rows="2" placeholder="Observaciones" id="observaciones" name="observaciones"></textarea>
                            </div>  
                        </div> 
                        <div class="col-md-12">
                            <div class="mb-3">       
                                <label class="form-label">Estudios:</label>
                                <select name="listEstudio" id="listEstudio" multiple='multiple' class="js-example-basic-multiple form-select" data-width="100%">
                                </select>
                            </div>                                
                        </div>
                        <div class="mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive-md">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Clv</th>
                                                        <th>Descrip</th>
                                                        <th>Tip</th>
                                                        <th>Cost</th>
                                                        <th>Conforme</th>
                                                        <th><i class="mdi mdi-wrench"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody id='tablelistEstudios'>
                                                </tbody>
                                                <tbody id="tablelistPerfiles">
                                                </tbody>
                                                <tbody id="tablelistImagenologia">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Total:</label>
                                <input disabled class="form-control fs-1"  name="num_total" type="text" placeholder="$00.00" id="num_total">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mb-3">
                                <label class="form-label">Formato de cotización</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input value="ticket" type="radio" class="form-check-input" name="factura_radio" id="factura1">
                                        <label class="form-check-label" for="factura1">
                                            Ticket
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input value="hoja" checked type="radio" class="form-check-input" name="factura_radio" id="factura2">
                                        <label class="form-check-label" for="factura2">
                                            Hoja
                                        </label>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <div class="mb-3">
                                        <button onclick="cotizarPdf()" type="submit" class="btn btn-primary">Imprimir</button>                                        
                                    </div>
                                </div>
                                @if (auth()->user()->first()->labs()->first()->paquete()->first()->paquete == 'completo')
                                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="input-group mb-3">
                                            <textarea hidden name="whatsapp" id="whatsapp" cols="30" rows="10"></textarea>
                                            <input  class="form-control" placeholder='Numero de telefono' id='telefono' name="telefono" type="number" >
                                            <button onclick="enviarmsj()" type="submit" class="btn btn-success"><i class="mdi mdi-whatsapp "></i> Enviar por whatsapp</button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>  
                    </div>
            </div>
        </div>        
    </div>    
</div>

<!----------------------------------------------------------------------------------------------------->

@endsection

@push('plugin-scripts')
    <script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/select2/select2.min.js') }}"></script>
    
@endpush

@push('custom-scripts')
    <script src="{{ asset('public/stevlab/recepcion/cotizacion/data-table.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/recepcion/cotizacion/select2.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/recepcion/cotizacion/recep-date.js') }}?v=<?php echo rand();?>"></script>
    <script src="{{ asset('public/stevlab/recepcion/cotizacion/functions.js') }}?v=<?php echo rand();?>"></script>
@endpush