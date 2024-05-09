@extends('layout.master')

@push('plugin-styles') 
<link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />

<link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush


@section('content')
  {{-- Inicio breadcrumb caja --}}
  <nav class="page-breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
          <li class="breadcrumb-item"> <a href="{{route('stevlab.recepcion.index')}}">Recepcion</a> </li>
          <li class="breadcrumb-item active" aria-current="page"> <a href="{{route('stevlab.recepcion.editar')}}">Editar solicitud</a> </li>
      </ol>
  </nav>
  {{-- Fin breadcrumb recepcion --}}
  {{-- Inicia panel's detalle --}}
  {{-- @dd(Auth::user()->first()) --}}
<!----------------------------------------------------------------------------------------------------->
@if (session('status') == 'Debes aperturar caja antes de empezar a trabajar.')

<div class="alert alert-secondary alert-dismissible fade show" role="alert">
    <i data-feather="alert-circle"></i>
    <strong>Aviso!</strong> {{ session('status') }} <a href="{{route('stevlab.caja.index')}}" class="alert-link">Click aquí</a>. 
</div>

@elseif(session('status')== 'Caja cerrada automáticamente...')

<div class="alert alert-secondary alert-dismissible fade show" role="alert">
    <i data-feather="alert-circle"></i>
    <strong>Aviso!</strong> {{ session('status') }} <a href="{{route('stevlab.caja.index')}}" class="alert-link">Click aquí</a> 
</div>

@else
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h6 class="card-title">Solicitudes</h6>
          <div class="table-responsive">
            <table id="dataTableExample" class="table table-hover nowrap" style="width:100%">
              <thead>
                <tr>
                  <th>Folio</th>
                  <th>Nombre</th>
                  <th>Fecha nacimiento</th>
                  <th>Empresa</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody id="recepcionsList">
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif

@endsection

@push('plugin-scripts')
<script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('public/stevlab/recepcion/edicion/edit_index/data-table.js') }}?v=<?php echo rand();?>"></script>
@endpush