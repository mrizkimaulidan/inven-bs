<!-- Modal -->
<div class="modal fade" id="user_edit_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Ubah Data Pengguna</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST">
					@csrf
					@method('PUT')
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="name">Nama Lengkap</label>
								<input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}"
									placeholder="Masukan nama lengkap..">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="email">Alamat Email</label>
								<input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}"
									placeholder="Masukan alamat email..">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="role_id">Pilih Peran</label>
								<select class="tom-select" name="role_id" id="role_id" placeholder="Pilih peran..">
									@foreach ($roles as $role)
									<option value="{{ $role->id }}">{{ $role->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="password">Kata Sandi</label>
								<input type="password" name="password"
									class="form-control @error('password', 'store') is-invalid @enderror" id="password"
									value="{{ old('password') }}" placeholder="Masukan kata sandi..">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="password_confirmation">Konfirmasi Kata Sandi</label>
								<input type="password" name="password_confirmation"
									class="form-control @error('password_confirmation', 'store') is-invalid @enderror"
									id="password_confirmation" value="{{ old('password_confirmation') }}"
									placeholder="Konfirmasi kata sandi..">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-success">Ubah</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
