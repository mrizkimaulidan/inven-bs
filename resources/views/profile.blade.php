<x-layout>
	<x-slot name="title">Halaman Pengaturan Profil</x-slot>
	<x-slot name="page_heading">Pengaturan Profil</x-slot>

	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-6">
					@include('utilities.alert')
					<form action="{{ route('profile.update') }}" method="POST">
						@csrf
						@method('PUT')

						<!-- Info Alert -->
						<div class="alert alert-warning" role="alert">
							<i class="fa-solid fa-circle-info mr-2"></i>
							Kolom yang memiliki tanda merah <span class="font-weight-bold">wajib diisi.</span>
						</div>

						<!-- First Row: Basic Information -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="name">
										Nama Lengkap <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control @error('name', 'update') is-invalid @enderror" name="name"
										id="name" value="{{ $user->name }}" placeholder="Masukan nama lengkap" required>
									@error('name', 'update')
									<div class="invalid-feedback d-block">
										{{ $message }}
									</div>
									@enderror
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="email">
										Alamat Email <span class="text-danger">*</span>
									</label>
									<input type="text" class="form-control @error('email', 'update') is-invalid @enderror" name="email"
										id="email" value="{{ $user->email }}" placeholder="Masukan alamat email" required>
									<small class="text-muted">Jika alamat email diubah maka akan otomatis keluar dari aplikasi.</small>
									@error('email', 'update')
									<div class="invalid-feedback d-block">
										{{ $message }}
									</div>
									@enderror
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="password">
										Kata Sandi
									</label>
									<input type="password" class="form-control @error('password', 'update') is-invalid @enderror"
										name="password" id="password" placeholder="Masukan kata sandi">
									<small class="text-muted">Jika kata sandi diubah maka akan otomatis keluar dari aplikasi.</small>
									@error('password', 'update')
									<div class="invalid-feedback d-block">
										{{ $message }}
									</div>
									@enderror
								</div>
							</div>

							<div class="col-md-12">
								<div class="form-group">
									<label for="password_confirmation">
										Konfirmasi Kata Sandi
									</label>
									<input type="password"
										class="form-control @error('password_confirmation', 'update') is-invalid @enderror"
										name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi">
									@error('password_confirmation', 'update')
									<div class="invalid-feedback d-block">
										{{ $message }}
									</div>
									@enderror
								</div>
							</div>
						</div>

						<!-- Modal Footer -->
						<button type="submit" class="btn btn-success">
							<i class="fas fa-floppy-disk mr-1"></i> Simpan Perubahan
						</button>
					</form>
				</div>
			</div>
		</div>
</x-layout>
