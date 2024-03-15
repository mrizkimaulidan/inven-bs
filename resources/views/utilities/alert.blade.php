@if ($errors->store->any())
<div class="alert alert-light alert-dismissible fade show border border-danger" role="alert">
	<strong>
		<i class="fas fa-exclamation"></i>
		Data gagal ditambahkan!
	</strong>

	<ul>
		@foreach ($errors->store->all() as $message)
		<li>{{ $message }}</li>
		@endforeach
	</ul>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

@if ($errors->update->any())
<div class="alert alert-light alert-dismissible fade show border border-danger" role="alert">
	<strong>
		<i class="fas fa-exclamation"></i>
		Data gagal diubah!
	</strong>

	<ul>
		@foreach ($errors->update->all() as $message)
		<li>{{ $message }}</li>
		@endforeach
	</ul>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

@session('success')
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>
		<i class="fas fa-thumbs-up"></i>
		Berhasil!
	</strong> {{ session('success') }}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endsession

@session('error')
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>
		<i class="fas fa-thumbs-down"></i>
		Gagal!
	</strong> {{ session('error') }}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endsession
