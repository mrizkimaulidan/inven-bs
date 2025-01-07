<!-- Modal -->
<div class="modal fade" id="role_create_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Tambah Data Peran dan Hak Akses</h5>
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
				<form action="{{ route('peran-dan-hak-akses.store') }}" method="POST">
					@csrf
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="name">Nama Peran<span class="font-weight-bold text-danger">*</span></label>
								<input type="text" name="name" id="name"
									class="form-control @error('name', 'store') is-invalid @enderror" value="{{ old('name') }}"
									placeholder="Masukan nama peran..">
								@error('name', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>

						<div class="col-lg-12">
							<div class="form-group">
								<label for="permissions">Daftar Hak Akses<span class="font-weight-bold text-danger">*</span></label>
								<select multiple class="tom-select @error('permissions', 'store') is-invalid @enderror"
									name="permissions[]" id="permissions" placeholder="Pilih hak akses..">
									@foreach ($permissions as $permission)
									<option value="{{ $permission->id }}">{{ $permission->name }}</option>
									@endforeach
								</select>
								@error('permissions', 'store')
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
