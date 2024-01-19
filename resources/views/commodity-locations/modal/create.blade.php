<!-- Modal -->
<div class="modal fade" id="commodity_location_create_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">Tambah Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('ruangan.store') }}" method="POST">
					@csrf
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="name">Nama</label>
								<input type="text" name="name" id="name" class="form-control" placeholder="Masukan nama..">
							</div>
						</div>

						<div class="col-lg-12">
							<div class="form-group">
								<label for="description">Deskripsi</label>
								<textarea name="description" class="form-control" id="description"
									placeholder="Masukan deskripsi (opsional).." style="height: 100px;"></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-primary">Tambah Data</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
