<div class="modal fade" id="excel_menu" tabindex="-1" aria-labelledby="excel_menu_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="excel_menu_label">Import Excel Barang</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="{{ route('barang.import') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="modal-body">
					<div class="alert alert-info" role="alert">
						<i class="fas fa-info-circle mr-1"></i>
						Untuk melakukan impor excel barang. Anda harus unduh template excel dengan klik
						<a href="{{ asset('import-barang-template.xlsx') }}" class="alert-link font-weight-bold">
							<i class="fas fa-download"></i> di sini
						</a>
					</div>

					<div class="alert alert-warning" role="alert">
						<i class="fas fa-exclamation-triangle mr-1"></i>
						<span class="font-weight-bold">Perhatian:</span> Jika ada data yang memiliki kode barang yang sama pada
						database,
						maka data tersebut tidak akan diimpor.
					</div>

					<div class="form-group">
						<div class="custom-file">
							<input type="file" name="file" class="custom-file-input" id="file">
							<label class="custom-file-label" for="file">Pilih berkas</label>
						</div>
						<small class="form-text text-muted">Format file yang didukung: .xlsx, .xls</small>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						<i class="fas fa-times mr-1"></i> Tutup
					</button>
					<button type="submit" class="btn btn-primary">
						<i class="fas fa-file-import mr-1"></i> Import
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
