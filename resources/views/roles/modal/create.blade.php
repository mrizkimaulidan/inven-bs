<div class="modal fade" id="role_create_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Tambah Data Peran dan Hak Akses</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('peran-dan-hak-akses.store') }}" method="POST">
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
									Nama Peran <span class="text-danger">*</span>
								</label>
								<input type="text" class="form-control @error('name', 'store') is-invalid @enderror" name="name"
									id="name" value="{{ old('name') }}" placeholder="Masukan nama peran" required>
								@error('name', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="permissions">
									Daftar Hak Akses <span class="text-danger">*</span>
								</label>
								<select multiple class="tom-select @error('permissions', 'store') is-invalid @enderror"
									name="permissions[]" id="permissions" placeholder="Pilih atau ketik hak akses..">
									@foreach ($permissions as $permission)
									<option value="{{ $permission->id }}">{{ $permission->name }}</option>
									@endforeach
								</select>
								@error('permissions', 'store')
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
