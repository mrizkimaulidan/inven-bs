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

			<div class="modal-body">
				<form method="POST">
					@csrf
					@method('PUT')
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="name">Nama Ruangan</label>
								<input type="text" class="form-control" name="name" id="name">
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="description">Deskripsi Ruangan</label>
								<textarea class="form-control" name="description" id="description" style="height: 100px"></textarea>
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
