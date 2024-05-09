@extends('layout.master')

@push('plugin-styles')
    <link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('public/assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />

@endpush

@section('content')

<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
        <li class="breadcrumb-item"> <a href="#">Maquila</a></li>
        <li class="breadcrumb-item active" aria-current="page">Maquilar documento</li>
    </ol>
</nav>
@if (session('msj'))

<div class="alert alert-secondary alert-dismissible fade show" role="alert">
    <i data-feather="alert-circle"></i>
    <strong>Aviso!</strong> {{ session('msj') }} 
</div>
@endif
<div class="row">
    <div class="d-md-block col-md-4 col-lg-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Cargar archivo</h6>
                <form action="{{route('stevlab.utils.load-file')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">Cargar archivo</label>
                                <input type="file" class="" data-height="300" id="archivo" name="archivo"/>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cargar imagen</label>
                                <input type="file" class="" data-height="300" id="imagen" name="imagen"/>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Maquilar</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('plugin-scripts')
    <script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('public/assets/plugins/ckeditor5-build-classic/ckeditor.js')}}" ></script>
@endpush

@push('custom-scripts')
    <script src="{{ asset('public/stevlab/utils/maquila/dropify.js')}}?v=<?php echo rand();?>"></script>

@endpush
