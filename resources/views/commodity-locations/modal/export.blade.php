<div class="modal fade" id="export_menu" tabindex="-1" aria-labelledby="export_menu_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="export_menu_label">Export Ruangan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="{{ route('ruangan.export') }}" method="POST">
					@csrf
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<label>Pilih ekstensi yang diinginkan<span class="font-weight-bold text-danger">*</span></label>
								<select class="form-control" name="extension">
									<option value="">Pilih ekstensi..</option>
									<option value="xlsx">XLSX (.xlsx)</option>
									<option value="xls">XLS (.xls)</option>
									<option value="csv">CSV (.csv)</option>
									<option value="html">HTML (.html)</option>
								</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-success">Export</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
