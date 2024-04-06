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
				<form action="{{ route('peran-dan-hak-akses.store') }}" method="POST">
					@csrf
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="name">Nama Peran</label>
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
								<label for="permissions">Daftar Hak Akses</label>
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
