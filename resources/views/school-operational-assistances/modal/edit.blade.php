<!-- Modal -->
<div class="modal fade" id="school_operational_assistance_edit_modal" data-backdrop="static" data-keyboard="false"
	tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Ubah Data BOS</h5>
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
								<label for="name">Nama BOS</label>
								<input type="text" name="name" class="form-control" id="name" placeholder="Masukan nama..">
							</div>
						</div>

						<div class="col-lg-12">
							<div class="form-group">
								<label for="description">Deskripsi BOS</label>
								<textarea name="description" class="form-control" id="description" style="height: 100px;"
									placeholder="Masukan deskripsi (opsional).."></textarea>
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
