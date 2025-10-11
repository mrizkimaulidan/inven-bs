<!-- Modal -->
<div class="modal fade" id="user_create_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Tambah Data Pengguna</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="d-flex align-items-center">
					<i class="text-warning fa-solid fa-circle-info mr-2"></i>
					<p class="font-italic mb-0">
						Kolom yang memiliki tanda merah <span class="font-weight-bold">wajib diisi.</span>
					</p>
				</div>
				<hr>
				<form action="{{ route('pengguna.store') }}" method="POST">
					@csrf
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="name">Nama Lengkap<span class="font-weight-bold text-danger">*</span></label>
								<input type="text" name="name" class="form-control @error('name', 'store') is-invalid @enderror"
									id="name" value="{{ old('name') }}" placeholder="Masukan nama lengkap..">
								@error('name', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="email">Alamat Email<span class="font-weight-bold text-danger">*</span></label>
								<input type="email" name="email" class="form-control @error('email', 'store') is-invalid @enderror"
									id="email" value="{{ old('email') }}" placeholder="Masukan alamat email..">
								@error('email', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="role_id">Pilih Peran<span class="font-weight-bold text-danger">*</span></label>
								<select class="tom-select @error('role_id', 'store') is-invalid @enderror" name="role_id" id="role_id"
									placeholder="Pilih peran..">
									@foreach ($roles as $role)
									<option value="{{ $role->id }}">{{ $role->name }}</option>
									@endforeach
								</select>
								@error('role_id', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="role_id">Pilih Prodi<span class="font-weight-bold text-danger">*</span></label>
								<select class="form-control @error('department_id', 'store') is-invalid @enderror" name="department_id" id="department_id"
									placeholder="Pilih peran..">
									@foreach ($departments as $department)
									<option value="{{ $department->id }}">{{ $department->name }}</option>
									@endforeach
								</select>
								@error('role_id', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="password">Kata Sandi<span class="font-weight-bold text-danger">*</span></label>
								<input type="password" name="password"
									class="form-control @error('password', 'store') is-invalid @enderror" id="password"
									value="{{ old('password') }}" placeholder="Masukan kata sandi..">
								@error('password', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="password_confirmation">Konfirmasi Kata Sandi<span
										class="font-weight-bold text-danger">*</span></label>
								<input type="password" name="password_confirmation"
									class="form-control @error('password_confirmation', 'store') is-invalid @enderror"
									id="password_confirmation" value="{{ old('password_confirmation') }}"
									placeholder="Konfirmasi kata sandi..">
								@error('password_confirmation', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-success">Tambah</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
