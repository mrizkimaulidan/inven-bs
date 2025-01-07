<!-- Modal -->
<div class="modal fade" id="commodity_acquisition_create_modal" data-backdrop="static" data-keyboard="false"
	tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Tambah Data Perolehan</h5>
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
				<form action="{{ route('perolehan.store') }}" method="POST">
					@csrf
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="name">Nama Perolehan<span class="font-weight-bold text-danger">*</span></label>
								<input type="text" name="name" class="form-control @error('name', 'store') is-invalid @enderror"
									id="name" value="{{ old('name') }}" placeholder="Masukan nama..">
								@error('name', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>

						<div class="col-lg-12">
							<div class="form-group">
								<label for="description">Deskripsi Perolehan <span class="font-italic">(opsional)</span></label>
								<textarea name="description" class="form-control @error('description', 'store') is-invalid @enderror"
									name="description" id="description" style="height: 100px;"
									placeholder="Masukan deskripsi (opsional)..">{{ old('description') }}</textarea>
								@error('description', 'store')
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
