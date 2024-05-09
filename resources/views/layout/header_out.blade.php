<nav class="navbar">
	<a href="#" class="sidebar-toggler">
		<i data-feather="menu"></i>
	</a>
	<div class="navbar-content">
		<form class="search-form">
			<div class="input-group">
				<div class="input-group-text">
					{{-- <i data-feather="search"></i> --}}
				</div>
				{{-- <input type="text" class="form-control" id="navbarForm" placeholder=""> --}}
			</div>
		</form>
		<ul class="navbar-nav">
			
		</ul>
	</div>
</nav>

@push('custom-scripts')
	<script src="{{ asset('public/stevlab/administracion/change-sucursal.js') }}"></script>
@endpush