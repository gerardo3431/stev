@extends('layout.master')
@push('plugin-styles')
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
                                    Transferencia de areas
                                </h3>
                                <p class="mt-1 text-muted">
                                    <span class="small">
                                        Esta opción (para sistemas anteriores a la versión 2) envia las areas de los registros individuales a una nueva tabla que fusiona todos los datos pertinentes que asocien una relación con los folios creados y registrados. <br>
                                        Lamentable el estado del area no se transfiere, (las funcionalidades no se alteran, solo se añade el area para poder facilitar generar el reporte pdf y fusionar mas facilmente con maquila, de haber algpun archivo). <br>
                                        Solo se debe revisar que no se escape algun dato sin asignar (por alguna razón, cerca del 1% de datos no se le asigna area en esta acción, posiblemente a que las areas no existen).
                                    </span>
                                </p>
                                <button id='transfer' class="btn btn-primary" type="submit">
                                    <span id='search' class="spinner-border spinner-border-sm search" role="status" aria-hidden="true" style="display:none;"></span>
                                        Transferir areas
                                </button>
                            </div>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-3">
        <hr>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
@endpush
@push('custom-scripts')
    <script src="{{ asset('public/stevlab/utils/data/functions.js') }}?v=<?php echo rand();?>"></script>
@endpush