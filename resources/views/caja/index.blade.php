@extends('layout.master')

@push('plugin-styles')
<link href="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
<link href="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('public/stevlab/css/caja/style.css')}}">
@endpush

@section('content')

	{{-- Inicio breadcrumb caja --}}
	<nav class="page-breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{route('stevlab.dashboard')}}">StevLab</a></li>
			<li class="breadcrumb-item active" aria-current="page">Caja</li>
		</ol>
	</nav>
	{{-- Fin breadcrumb caja --}}
@if (session('caja_estatus'))
	<div class="alert alert-secondary alert-dismissible fade show" role="alert">
		<i data-feather="alert-circle"></i>
		<strong>Aviso!</strong> {{ session('caja_estatus') }} 
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
	</div>
@endif
@if (session('status_caja') == 'Debes aperturar caja antes de empezar a trabajar.' || session('status_caja')== 'Caja cerrada automáticamente...' )

	<div class="alert alert-secondary alert-dismissible fade show" role="alert">
		<i data-feather="alert-circle"></i>
		<strong>Aviso!</strong> {{ session('status_caja') }} 
	</div>

	{{-- Inicia panel's detalle --}}
	<div class="row profile-body">
		<!-- left wrapper start -->
		<div class="d-md-block col-md-4 col-xl-3 mb-4 left-wrapper">
			<div class="card rounded">
				<div class="card-header">
					<div class="ms-2">
						<h6 class="card-title mb-0">Apertura de caja</h6>
					</div>
				</div>
				<div class="card-body">
					
					<form class="forms-sample" action="{{route('stevlab.caja.store')}}" method="POST">
						@csrf
						<div class="mb-3">
							<label for="monto" class="col-form-label">Monto de apertura</label>
							<div class="col-sm-12">
								<input type="number" min='0' class="form-control {{ $errors->has('monto') ? 'is-invalid' : '' }}" name="monto" placeholder="$" value="0">
								<x-jet-input-error for="monto"></x-jet-input-error>
								
							</div>
						</div>
						<button type="submit" class="btn btn-primary me-2">Abrir Caja</button>
					</form>
				</div>
				<div class="card-footer">
					
				</div>
			</div>
		</div>
		<!-- left wrapper end -->
	</div>
	{{-- Fin panel's detalle --}}
@else

	<div class="alert alert-secondary alert-dismissible fade show" role="alert">
		<i data-feather="alert-circle"></i>
		<strong>Aviso!</strong> {{ session('status_caja') }}
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
	</div>
	{{-- Inicia tablas --}}
	<div class="row">
		<div class="col-sm-12 col-md-6 col-lg-6 ">
			<div class="card">
				<div class="card-body">
					<h6 class="card-title">Montos correspondientes al dia: {{date('d-m-Y')}} </h6>
					<div class="row">
						<div class="col-md-4 col-lg-4">
							<div class="mb-3">
								<label class='form-label' for="">Apertura</label>
								<input id="apertura" name="apertura" disabled type="number" class="form-control" value="{{$caja->apertura}}">
							</div>
						</div>
						<div class="col-md-4 col-lg-4">
							<div class="mb-3">
								<label for="" class="form-label">Entradas</label>
								<input id="entrada" name="entrada" disabled type="number" class="form-control" value="{{$caja->entradas}}">
							</div>
						</div>
						<div class="col-md-4 col-lg-4">
							<div class="mb-3">
								<label for="" class="form-label">Salidas</label>
								<input id="salida" name="salida" disabled type="number" class="form-control" value="{{$caja->salidas}}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-lg-4">
							<div class="mb-3">
								<h4 class="card-title">VENTAS</h4>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-lg-4">
							<div class="mb-3">
								<label for="" class="form-label">Efectivo entradas</label>
								<input id="efectivo_entrada" name="efectivo_entrada" disabled type="number" class="form-control" value="{{$caja->ventas_efectivo}}">
							</div>
						</div>
						<div class="col-md-4 col-lg-4">
							<div class="mb-3">
								<label for="" class="form-label">Tarjetas entradas </label>
								<input id="tarjeta_entrada" name="tarjeta_entrada" disabled type="number" class="form-control" value="{{$caja->ventas_tarjeta}}">
							</div>
						</div>
						<div class="col-md-4 col-lg-4">
							<div class="mb-3">
								<label for="" class="form-label">Trf. entradas </label>
								<input id="transfer_entrada" name="transfer_entrada" disabled type="number" class="form-control" value="{{$caja->ventas_transferencia}}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-lg-4">
							<div class="mb-3">
								<label for="" class="form-label">Efectivo salidas</label>
								<input id="efectivo_salida" name="efectivo_salida" disabled type="number" class="form-control" value="{{$caja->salidas_efectivo}}">
							</div>
						</div>
						<div class="col-md-4 col-lg-4">
							<div class="mb-3">
								<label for="" class="form-label">Tarjetas salidas </label>
								<input id="tarjeta_salida" name="tarjeta_salida" disabled type="number" class="form-control" value="{{$caja->salidas_tarjeta}}">
							</div>
						</div>
						<div class="col-md-4 col-lg-4">
							<div class="mb-3">
								<label for="" class="form-label">Trf. salidas </label>
								<input id="transfer_salida" name="transfer_salida" disabled type="number" class="form-control" value="{{$caja->salidas_transferencia}}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-lg-4">
							<div class="mb-3">
								<h4 class="card-title">TOTAL</h4>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-lg-4">
							<div class="mb-3">
								<label for="" class="form-label">Total</label>
								<input id="total" name='total' disabled type="number" class="form-control" value="{{$caja->total}}">
							</div>
						</div>
						<div class="col-md-4 col-lg-4">
							<div class="mb-3">
								<label for="" class="form-label">Total retiros</label>
								<input id="total" name='total' disabled type="number" class="form-control" value="{{$caja->retiros}}">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-12">
							<div class="mb-3">
								<a class="btn btn-sm btn-danger" href="{{route('stevlab.caja.cerrar_caja', $caja->id)}}" role="button"> <i class="mdi mdi-content-save"></i> Cerrar caja</a>
								<a class="btn btn-sm btn-primary" onclick="show_modal_retiro({{$caja->id}}, {{$caja->total}})" role="button"> <i class="mdi mdi-login-variant"></i> Retirar</a>
								<a class="btn btn-sm btn-primary" onclick="genera_reporte({{$caja->id}})" role="button"><i class="mdi mdi-file-chart"></i> Movimientos</a>
								<a class="btn btn-sm btn-primary" onclick="genera_reporte_folios({{$caja->id}})" role="button"><i class="mdi mdi-file-chart"></i> Pacientes</a>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-12">
							<div class="mb-3">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-12 col-md-3 col-lg-3 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<h6 class="card-title">Movimientos</h6>
					<form id='formEgreso' class="forms-sample">
						@csrf
						<div class="mb-3">
							<label for="tipo_movimiento" class="form-label">Tipo de entrada</label>
							<select class="form-select" id="tipo_movimiento" name='tipo_movimiento'>
								<option value='ingreso'>Entrada</option>
								<option value='egreso'>Salida</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="descripcion" class="form-label">Descripción</label>
							<input type="text" class="form-control" id="descripcion" name='descripcion' placeholder="Descripción">
						</div>
						<div class="mb-3">
							<label for="metodo_pago" class="form-label">Método pago</label>
							<select class="form-select" id="metodo_pago" name='metodo_pago'>
								<option value='nothing' selected="" disabled="">Selecciona método</option>
								<option value='efectivo'>Efectivo</option>
								<option value='tarjeta'>Tarjeta</option>
								<option value='transferencia'>Transferencia</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="importe" class="form-label">Importe</label>
							<input type="number" class="form-control" id="importe" name='importe' placeholder="$ Importe">
						</div>
						<div class="mb-3">
							<label for="observaciones" class="form-label">Observaciones</label>
							<textarea class="form-control" id="observaciones" name="observaciones" rows="5"></textarea>
						</div>
						<div class="form-check mb-3">
							<input type="checkbox" class="form-check-input" id="is_factura" name="is_factura">
							<label class="form-check-label text-muted" for="is_factura">
								¿Solicitar factura?
							</label>
							{{-- <p class="text-muted">Factura próximo a implementar</p> --}}
						</div>
						<button id='blockform' type="submit" class="btn btn-sm btn-primary me-2"> <i class="mdi mdi-content-save"></i> Guardar</button>
						<button class="btn btn-sm btn-danger "> <i class="mdi mdi-delete"></i> </button>
					</form>
				</div>
			</div>
		</div>
		@can('reporte_fechas')
			<div class="col-sm-12 col-md-3 col-lg-3">
				<div class="card">
					<div class="card-body">
						<h6 class="card-title">REPORTE ENTRE FECHAS</h6>
						<form id="formReporteRango">
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label for="" class="form-label">Fecha inicial</label>
										<div class="input-group date datepicker" >
											<input type="text" class="form-control" id="fecha_inicial" name="fecha_inicial" data-date-end-date="0d">
											<span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="mb-3">
										<label for="" class="form-label">Fecha final</label>
										<div class="input-group date datepicker" >
											<input type="text" class="form-control" id="fecha_final" name="fecha_final" data-date-end-date="0d">
											<span class="input-group-text input-group-addon"><i data-feather="calendar"></i></span>
										</div>
									</div>
								</div>
							</div>
							<a class="btn btn-sm btn-primary" onclick="genera_reporte_rango()" href="#" role="button"><i class="mdi mdi-file-chart"></i>Genera reporte</a>
						</form>
					</div>
				</div>
			</div>
		@endcan
	</div>

	@can('ver_cajas')
		<div class="row">
			<div class="col-md-12 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h6 class="card-title">Línea de tiempo: usuario</h6>
						{{-- <p class="text-muted mb-3">Read the <a href="https://datatables.net/" target="_blank"> Official DataTables Documentation </a>for a full list of instructions and other options.</p> --}}
						<div class="table-responsive">
							<table id="dataTableCajas" class="table display table-hover nowrap"  style="width:100%">
								<thead>
									<tr>
										<th>#</th>
										<th>Edo.</th>
										<th>Apertura</th>
										<th>Entradas</th>
										<th>Salidas</th>
										<th>Entrda. Efectivo</th>
										<th>Entrda. Tarjeta</th>
										<th>Entrda. Trf.</th>
										<th>Salida Efectivo</th>
										<th>Salida Tarjeta</th>
										<th>Salida Trf.</th>
										<th>Total</th>
										<th>Inicio</th>
										<th>Cierre</th>
										<th>Reportes</th>
									</tr>
								</thead>
								<tbody>
									@forelse ($cajas as $caja)
									{{-- @dd($caja) --}}
									<tr>
										{{-- <td><i class=""></i></td> --}}
										<td>{{$caja->id}}</td>
										<td>{{$caja->estatus}}</td>
										<td>{{$caja->apertura}}</td>
										<td>{{$caja->entradas}}</td>
										<td>{{$caja->salidas}}</td>
										<td>{{$caja->ventas_efectivo}}</td>
										<td>{{$caja->ventas_tarjeta}}</td>
										<td>{{$caja->ventas_transferencia}}</td>
										<td>{{$caja->salidas_efectivo}}</td>
										<td>{{$caja->salidas_tarjeta}}</td>
										<td>{{$caja->salidas_transferencia}}</td>
										<td>{{$caja->total}}</td>
										<td>{{$caja->created_at}}</td>
										<td>{{$caja->updated_at}}</td>
										<td>
											<button type="button" class="btn btn-sm btn-primary btn-icon" onclick="genera_reporte_rapido({{$caja->id}})">
												<i class="mdi mdi-file-document"></i>
											</button>
											<button type="button" class="bt btn-smn btn-danger btn-icon" onclick="genera_reporte({{$caja->id}})">
												<i class="mdi mdi-earth"></i>
											</button>
										</td>
									</tr>
									@empty
									<tr>
										<td>No data allowed</td>
									</tr>
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endcan

	<div class="row">
		<div class="col-md-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<h6 class="card-title">Historial de pagos: usuario - Caja actual.</h6>
					<div class="table-responsive">
						<table id="dataTablePagos" class="table display table-hover nowrap" style="width:100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Descripción</th>
									<th>Observaciones</th>
									<th>Importe</th>
									<th>Tipo</th>
									<th>Metodo</th>
									<th>Factura</th>
									<th>Fecha</th>
								</tr>
							</thead>
							<tbody>
								@forelse ($movimientos as $movimiento)
								<tr>
									<td>{{$movimiento->id}}</td>
									<td>{{$movimiento->descripcion}}</td>
									<td>{{$movimiento->observaciones}}</td>
									<td>{{$movimiento->importe}}</td>
									<td>{{$movimiento->tipo_movimiento}}</td>
									<td>{{$movimiento->metodo_pago}}</td>
									<td>{{$movimiento->is_factura}}</td>
									<td>{{$movimiento->created_at}}</td>
								</tr>
								@empty
								<tr>
									<td>No data allowed</td>
								</tr>
								@endforelse
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	{{-- Fin tabla --}}


@endif

<!-- Modal retiro caja-->
<div class="modal fade" id="modal-retiro-caja" tabindex="-1" aria-labelledby="modal-retiro-cajaLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<label for="caja" class="form-label" id='caja_span'></label>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
			</div>
			<div class="modal-body">
				<div class="mb-3">
				</div>
				<div class="mb-3">
					<label for="total" class="form-label">Total (fondo + ingresos)</label>
					<input type="number" class="form-control" name="total_caja" id="total_caja" disabled>
				</div>
				<form id='formCaja'>
					@csrf
					<div class="mb-3">
						<input type="number" class="form-control" name='caja' id="caja" hidden>
					</div>
					<div class="mb-3">
						<label for="cantidad" class="form-label">Cantidad:</label>
						<input value='0' onkeyup="revisaRetiro()" type="number" class="form-control" name='cantidad' id="cantidad">
					</div>
					<button type="submit" class="btn btn-primary">Retirar</button>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('public/assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('public/assets/plugins/datatables-net-bs5/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('public/assets/js/axios.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('public/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="{{ asset('public/stevlab/caja/data-table.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/caja/caja.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/caja/datepicker.js') }}?v=<?php echo rand();?>"></script>
<script src="{{ asset('public/stevlab/caja/form-validation.js') }}?v=<?php echo rand();?>"></script>

@endpush