@if ($errors->any())
<div class="alert alert-danger alert-dismissible show fade">
	<div class="alert-body">
		<button class="close" data-dismiss="alert">
			<span>×</span>
		</button>
		{{ $errors->first() }}
	</div>
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
