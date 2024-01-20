<div class="modal fade" id="edit_commodity" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Ubah Data Barang</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form method="POST">
					@csrf
					@method('PUT')
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label for="item_code">Kode Barang</label>
								<input type="text" class="form-control" name="item_code" id="item_code"
									placeholder="Masukan kode barang..">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label for="name">Nama Barang</label>
								<input type="text" class="form-control" name="name" id="name" placeholder="Masukan nama barang..">
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label for="commodity_location_id">Lokasi Barang</label>
								<select class="form-control" name="commodity_location_id" id="commodity_location_id"
									style="width: 100%;">
									<option selected>Pilih..</option>
									@foreach ($commodity_locations as $commodity_location)
									<option value="{{ $commodity_location->id }}">{{ $commodity_location->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="material">Bahan</label>
								<input type="text" class="form-control" name="material" id="material"
									placeholder="Masukan bahan barang..">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="brand">Merek</label>
								<input type="text" class="form-control" name="brand" id="brand" placeholder="Masukan merek barang..">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<label for="year_of_purchase">Tahun Pembelian</label>
								<input type="number" class="form-control" name="year_of_purchase" id="year_of_purchase"
									placeholder="Masukan tahun pembelian barang..">
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<label for="school_operational_assistance_id">Asal Perolehan</label>
								<select class="form-control" name="school_operational_assistance_id"
									id="school_operational_assistance_id" style="width: 100%;">
									<option selected>Pilih..</option>
									@foreach ($school_operational_assistances as $school_operational_assistance)
									<option value="{{ $school_operational_assistance->id }}">{{ $school_operational_assistance->name }}
									</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<label for="condition">Kondisi</label>
								<select class="form-control" name="condition" id="condition" style="width: 100%;">
									<option selected>Pilih..</option>
									<option value="1">Baik</option>
									<option value="2">Kurang Baik</option>
									<option value="3">Rusak Berat</option>
								</select>
							</div>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label for="quantity">Kuantitas</label>
								<input type="number" class="form-control" name="quantity" id="quantity"
									placeholder="Masukan kuantitas barang..">
							</div>
						</div>
						<div class="col-lg-4 col-6">
							<div class="form-group">
								<label for="price">Harga</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1">Rp.</span>
									</div>
									<input type="number" class="form-control" name="price" id="price"
										placeholder="Masukan harga barang..">
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
									<input type="number" class="form-control" name="price_per_item" id="price_per_item"
										placeholder="Masukan harga satuan barang..">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="note">Keterangan</label>
								<textarea class="form-control" name="note" id="note" style="height: 100px;"
									placeholder="Masukan keterangan (opsional).."></textarea>
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
