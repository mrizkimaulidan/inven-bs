<div class="modal fade" id="show_commodity" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Detail Data Barang</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-lg-4">
						<div class="form-group">
							<label for="item_code">Kode Barang</label>
							<input type="text" class="form-control" id="item_code" disabled>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="name">Nama Barang</label>
							<input type="text" class="form-control" id="name" disabled>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label for="commodity_location_id">Lokasi Barang</label>
							<input type="text" class="form-control" id="commodity_location_id" disabled>
						</div>
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="material">Bahan</label>
							<input type="text" class="form-control" id="material" disabled>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="brand">Merk</label>
							<input type="text" class="form-control" id="brand" disabled>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-4 col-6">
						<div class="form-group">
							<label for="year_of_purchase">Tahun Pembelian</label>
							<input type="text" class="form-control" id="year_of_purchase" disabled>
						</div>
					</div>
					<div class="col-lg-4 col-6">
						<div class="form-group">
							<label for="school_operational_assistance_id">Asal Perolehan</label>
							<input type="text" class="form-control" id="school_operational_assistance_id" disabled>
						</div>
					</div>
					<div class="col-lg-4 col-6">
						<div class="form-group">
							<label for="condition">Kondisi</label>
							<input type="text" class="form-control" id="condition" disabled>
						</div>
					</div>
				</div>

				<hr>

				<div class="row">
					<div class="col-lg-4">
						<div class="form-group">
							<label for="quantity">Kuantitas</label>
							<input type="text" class="form-control" id="quantity" disabled>
						</div>
					</div>
					<div class="col-lg-4 col-6">
						<div class="form-group">
							<label for="price">Harga</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1">Rp.</span>
								</div>
								<input type="text" class="form-control" id="price" disabled>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-6">
						<div class="form-group">
							<label for="price_per_item">Harga Satuan</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text" id="basic-addon1">Rp.</span>
								</div>
								<input type="text" class="form-control" id="price_per_item" disabled>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label for="note">Keterangan</label>
							<textarea class="form-control" id="note" style="height: 100px;" disabled></textarea>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
