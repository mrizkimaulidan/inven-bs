<div class="modal fade" id="user_create_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Tambah Data Pengguna</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('pengguna.store') }}" method="POST">
				@csrf

				<div class="modal-body">
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
								<input type="text" class="form-control @error('name', 'store') is-invalid @enderror" name="name"
									id="name" value="{{ old('name') }}" placeholder="Masukan nama lengkap" required>
								@error('name', 'store')
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
								<input type="text" class="form-control @error('email', 'store') is-invalid @enderror" name="email"
									id="email" value="{{ old('email') }}" placeholder="Masukan alamat email" required>
								<small class="text-muted ">Alamat email digunakan untuk login ke dalam aplikasi.</small>
								@error('email', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="role_id">
									Pilih Peran <span class="text-danger">*</span>
								</label>
								<select name="role_id" placeholder="Pilih atau ketik peran.." id="role_id" @class([ 'form-control'
									, 'is-valid'=>
									request()->filled('role_id')
									])
									>
									<option value="">Pilih peran..</option>
									@foreach ($roles as $role)
									<option value="{{ $role->id }}" @selected(request('role_id')==$role->id)>{{ $role->name }}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="password">
									Kata Sandi <span class="text-danger">*</span>
								</label>
								<input type="password" class="form-control @error('password', 'store') is-invalid @enderror"
									name="password" id="password" value="{{ old('password') }}" placeholder="Masukan kata sandi" required>
								@error('password', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="email">
									Konfirmasi Kata Sandi <span class="text-danger">*</span>
								</label>
								<input type="password"
									class="form-control @error('password_confirmation', 'store') is-invalid @enderror"
									name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}"
									placeholder="Ulangi kata sandi" required>
								@error('password_confirmation', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>
				</div>

				<!-- Modal Footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						<i class="fas fa-times mr-1"></i> Tutup
					</button>
					<button type="submit" class="btn btn-success">
						<i class="fas fa-plus mr-1"></i> Tambah
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
