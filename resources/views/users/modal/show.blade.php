<div class="modal fade" id="show_user" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Detail Data Pengguna</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!-- First Row: Basic Information -->
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="name">
								Nama Lengkap
							</label>
							<input type="text" class="form-control" id="name" disabled>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="email">
								Alamat Email
							</label>
							<input type="text" class="form-control" id="email" disabled>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label for="role_id">
								Peran
							</label>
							<input type="text" class="form-control" id="role_id" disabled>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal Footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">
					<i class="fas fa-times mr-1"></i> Tutup
				</button>
			</div>
		</div>
	</div>
</div>
