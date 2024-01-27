<div class="modal fade" id="excel_menu" tabindex="-1" aria-labelledby="excel_menu_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="excel_menu_label">Import Excel Ruangan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('ruangan.import') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="row">
						<div class="col-lg-12">
							<div class="alert alert-info" role="alert">
								Untuk melakukan impor excel ruangan. Anda harus unduh template excel dengan klik <a
									href="{{ asset('import-ruangan-template.xlsx') }}" class="alert-link"><i class="fas fa-download"></i>
									di
									sini</a>
							</div>

							<div class="custom-file">
								<label for="file">Pilih berkas</label>
								<input type="file" class="form-control" name="file" id="file">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-success">Import</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
