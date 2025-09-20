<div class="modal fade" id="role_edit_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Ubah Data Peran dan Hak Akses</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST">
				@csrf
				@method('PUT')

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
								<input type="text" class="form-control @error('name', 'update') is-invalid @enderror" name="name"
									id="name" value="{{ old('name') }}" placeholder="Masukan nama peran" required>
								@error('name', 'update')
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
								<select multiple class="tom-select @error('permissions', 'update') is-invalid @enderror"
									name="permissions[]" id="permissions" placeholder="Pilih atau ketik hak akses..">
									@foreach ($permissions as $permission)
									<option value="{{ $permission->id }}">{{ $permission->name }}</option>
									@endforeach
								</select>
								@error('permissions', 'update')
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
						<i class="fas fa-floppy-disk mr-1"></i> Simpan Perubahan
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
