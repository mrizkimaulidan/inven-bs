<div class="modal fade" id="commodity_location_edit_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Ubah Data Ruangan</h5>
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
									Nama Ruangan <span class="text-danger">*</span>
								</label>
								<input type="text" class="form-control @error('name', 'update') is-invalid @enderror" name="name"
									id="name" value="{{ old('name') }}" placeholder="Masukan nama ruangan" required>
								@error('name', 'update')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>

						<div class="col-md-12">
							<div class="form-group">
								<label for="description">
									Deskripsi Ruangan <small class="text-muted">(opsional)</small>
								</label>
								<textarea class="form-control @error('description', 'update') is-invalid @enderror" name="description"
									id="description" rows="3" placeholder="Masukan deskripsi ruangan">{{ old('description') }}</textarea>
								@error('description', 'update')
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
