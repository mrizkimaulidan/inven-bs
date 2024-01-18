<div class="modal fade" id="excel_menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Import Data</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<p>
							*Asal Perolehan dan Lokasi bersifat Case Sensitive.
							<br> Pastikan Namanya sesuai dengan Data BOS dan Data Ruangan di Sistem
						</p>
						<a href="/import.xlsx" class="btn btn-primary mb-3">Download Template</a>
					</div>
					<div class="col-lg-12">
						<form action="{{ route('barang.import') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label for="file" class="sr-only">Choose file</label>
								<input type="file" name="file" id="file" class="form-control-file">
							</div>
							<button type="submit" class="btn btn-danger">Import</button>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
