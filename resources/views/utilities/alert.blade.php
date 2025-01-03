@if ($errors->store->any())
<div class="alert alert-danger alert-has-icon alert-dismissible fade show" role="alert">
	<div class="d-flex align-items-start">
		<i class="fas fa-exclamation-circle alert-icon mr-3" style="font-size: 1.5rem;"></i>
		<div>
			<div class="alert-title font-weight-bold">Gagal</div>
			@foreach ($errors->store->all() as $message)
			<p><i class="fas fa-arrow-right mr-2"></i>{{ $message }}</p>
			@endforeach
		</div>
	</div>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

@if ($errors->update->any())
<div class="alert alert-danger alert-has-icon alert-dismissible fade show" role="alert">
	<div class="d-flex align-items-start">
		<i class="fas fa-exclamation-circle alert-icon mr-3" style="font-size: 1.5rem;"></i>
		<div>
			<div class="alert-title font-weight-bold">Gagal</div>
			@foreach ($errors->update->all() as $message)
			<p><i class="fas fa-arrow-right mr-2"></i>{{ $message }}</p>
			@endforeach
		</div>
	</div>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

@session('success')
<div class="alert alert-success alert-has-icon alert-dismissible fade show" role="alert">
	<div class="d-flex align-items-start">
		<i class="fas fa-check-circle alert-icon mr-3" style="font-size: 1.5rem;"></i>
		<div>
			<div class="alert-title font-weight-bold">Berhasil</div>
			{{ session('success') }}
		</div>
	</div>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endsession

@session('error')
<div class="alert alert-danger alert-has-icon alert-dismissible fade show" role="alert">
	<div class="d-flex align-items-start">
		<i class="fas fa-exclamation-circle alert-icon mr-3" style="font-size: 1.5rem;"></i>
		<div>
			<div class="alert-title font-weight-bold">Gagal</div>
			{{ session('error') }}
		</div>
	</div>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endsession