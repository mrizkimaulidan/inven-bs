<x-layout>
	<x-slot name="title">Halaman Pengaturan Profil</x-slot>
	<x-slot name="page_heading">Pengaturan Profil</x-slot>

	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-6">
					@include('utilities.alert')
					<div class="d-flex align-items-center">
						<i class="text-warning fa-solid fa-circle-info mr-2"></i>
						<p class="font-italic mb-0">
							Kolom yang memiliki tanda merah <span class="font-weight-bold">wajib diisi.</span>
						</p>
					</div>
					<hr>
					<form action="{{ route('profile.update') }}" method="POST">
						@csrf
						@method('PUT')
						<div class="form-group">
							<label for="name">Nama Lengkap<span class="font-weight-bold text-danger">*</span></label>
							<input type="text" name="name" class="form-control @error('name', 'update') is-invalid @enderror"
								id="name" value="{{ auth()->user()->name }}" placeholder="Masukan nama lengkap.." autofocus>
							@error('name', 'update')
							<div class="d-block invalid-feedback">
								{{ $message }}
							</div>
							@enderror
						</div>
						<div class="form-group">
							<label for="email">Alamat Email<span class="font-weight-bold text-danger">*</span></label>
							<input type="email" name="email" class="form-control @error('email', 'update') is-invalid @enderror"
								id="email" value="{{ auth()->user()->email }}" placeholder="Masukan alamat email..">
							<small class="text-muted font-weight-bold">Jika alamat email diubah, Anda akan otomatis keluar
								dari
								aplikasi.</small>
							@error('email', 'update')
							<div class="d-block invalid-feedback">
								{{ $message }}
							</div>
							@enderror
						</div>
						<div class="form-group">
							<label for="password">Kata Sandi</label>
							<input type="password" class="form-control @error('password', 'update') is-invalid @enderror"
								name="password" id="password" placeholder="Masukan kata sandi..">
							<small class="text-muted font-weight-bold">Kosongkan kata sandi jika tidak ingin
								diubah.</small></br>
							<small class="text-muted font-weight-bold">Jika kata sandi diubah, Anda akan otomatis keluar
								dari
								aplikasi.</small>
							@error('password', 'update')
							<div class="d-block invalid-feedback">
								{{ $message }}
							</div>
							@enderror
						</div>
						<div class="form-group">
							<label for="password_confirmation">Konfirmasi Kata Sandi</label>
							<input type="password" name="password_confirmation"
								class="form-control @error('password_confirmation', 'update') is-invalid @enderror"
								id="password_confirmation" placeholder="Konfirmasi kata sandi..">
							@error('password_confirmation', 'update')
							<div class="d-block invalid-feedback">
								{{ $message }}
							</div>
							@enderror
						</div>
						<button type="submit" class="btn btn-success">Ubah</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</x-layout>
