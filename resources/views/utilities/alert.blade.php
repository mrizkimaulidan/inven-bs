@if ($errors->store->any())
@foreach ($errors->store->all() as $message)
<div class="alert alert-warning alert-dismissible fade show" role="alert">
	<strong>
		<i class="fas fa-exclamation"></i>
		Perhatian!
	</strong> {{ $message }}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endforeach
@endif

@if ($errors->update->any())
@foreach ($errors->update->all() as $message)
<div class="alert alert-warning alert-dismissible fade show" role="alert">
	<strong>
		<i class="fas fa-exclamation"></i>
		Perhatian!
	</strong> {{ $message }}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endforeach
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
