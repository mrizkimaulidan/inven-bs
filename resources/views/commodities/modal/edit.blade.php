<div class="modal fade" id="commodity_edit_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Ubah Data Barang</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST" id="editForm">
				@csrf
				@method('PUT')

				<div class="modal-body">
					<!-- Info Alert -->
					<div class="alert alert-warning" role="alert">
						<i class="fa-solid fa-circle-info mr-2"></i>
						Kolom yang memiliki tanda merah <span class="font-weight-bold">wajib diisi.</span>
					</div>

					<!-- First Row: Basic Information -->
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="item_code">
									Kode Barang <span class="text-danger">*</span>
								</label>
								<input type="text" class="form-control @error('item_code', 'store') is-invalid @enderror"
									name="item_code" id="item_code" value="{{ old('item_code') }}" placeholder="Masukan kode barang"
									required>
								@error('item_code', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="name">
									Nama Barang <span class="text-danger">*</span>
								</label>
								<input type="text" class="form-control @error('name', 'store') is-invalid @enderror" name="name"
									id="name" value="{{ old('name') }}" placeholder="Masukan nama barang" required>
								@error('name', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="commodity_location_id">
									Lokasi Barang <span class="text-danger">*</span>
								</label>
								<select class="form-control select2 @error('commodity_location_id', 'store') is-invalid @enderror"
									name="commodity_location_id" id="commodity_location_id" required>
									<option value="">Pilih Lokasi Barang</option>
									@foreach ($commodity_locations as $commodity_location)
									<option value="{{ $commodity_location->id }}" {{ old('commodity_location_id')==$commodity_location->id
										? 'selected' : '' }}>
										{{ $commodity_location->name }}
									</option>
									@endforeach
								</select>
								@error('commodity_location_id', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>

					<hr>

					<!-- Second Row: Material and Brand -->
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="material">
									Bahan <span class="text-danger">*</span>
								</label>
								<input type="text" class="form-control @error('material', 'store') is-invalid @enderror" name="material"
									id="material" value="{{ old('material') }}" placeholder="Masukan bahan barang" required>
								@error('material', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="brand">
									Merek <span class="text-danger">*</span>
								</label>
								<input type="text" class="form-control @error('brand', 'store') is-invalid @enderror" name="brand"
									id="brand" value="{{ old('brand') }}" placeholder="Masukan merek barang" required>
								@error('brand', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>

					<!-- Third Row: Purchase Details -->
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="year_of_purchase">
									Tahun Pembelian <span class="text-danger">*</span>
								</label>
								<input type="number" class="form-control @error('year_of_purchase', 'store') is-invalid @enderror"
									name="year_of_purchase" id="year_of_purchase" value="{{ old('year_of_purchase') }}" min="2000"
									max="{{ date('Y') + 1 }}" placeholder="Tahun pembelian" required>
								@error('year_of_purchase', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="commodity_acquisition_id">
									Asal Perolehan <span class="text-danger">*</span>
								</label>
								<select class="form-control select2 @error('commodity_acquisition_id', 'store') is-invalid @enderror"
									name="commodity_acquisition_id" id="commodity_acquisition_id" required>
									<option value="">Pilih Asal Perolehan</option>
									@foreach ($commodity_acquisitions as $commodity_acquisition)
									<option value="{{ $commodity_acquisition->id }}" {{
										old('commodity_acquisition_id')==$commodity_acquisition->id ? 'selected' : '' }}>
										{{ $commodity_acquisition->name }}
									</option>
									@endforeach
								</select>
								@error('commodity_acquisition_id', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="condition">
									Kondisi <span class="text-danger">*</span>
								</label>
								<select class="form-control @error('condition', 'store') is-invalid @enderror" name="condition"
									id="condition" required>
									<option value="">Pilih Kondisi</option>
									<option value="1" {{ old('condition')==1 ? 'selected' : '' }}>Baik</option>
									<option value="2" {{ old('condition')==2 ? 'selected' : '' }}>Kurang Baik</option>
									<option value="3" {{ old('condition')==3 ? 'selected' : '' }}>Rusak Berat</option>
								</select>
								@error('condition', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>

					<hr>

					<!-- Fourth Row: Pricing -->
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="quantity">
									Kuantitas <span class="text-danger">*</span>
								</label>
								<input type="number" class="form-control @error('quantity', 'store') is-invalid @enderror"
									name="quantity" id="quantity" value="{{ old('quantity') }}" min="1" placeholder="Jumlah barang"
									required>
								@error('quantity', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="price">
									Harga Total <span class="text-danger">*</span>
								</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">Rp</span>
									</div>
									<input type="number" class="form-control @error('price', 'store') is-invalid @enderror" name="price"
										id="price" value="{{ old('price') }}" min="0" placeholder="Harga total" required>
								</div>
								@error('price', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label for="price_per_item">
									Harga Satuan <span class="text-danger">*</span>
								</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text">Rp</span>
									</div>
									<input type="number" class="form-control @error('price_per_item', 'store') is-invalid @enderror"
										name="price_per_item" id="price_per_item" value="{{ old('price_per_item') }}" min="0"
										placeholder="Harga per item" required>
								</div>
								@error('price_per_item', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>

					<!-- Notes -->
					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="note">
									Keterangan <small class="text-muted">(opsional)</small>
								</label>
								<textarea class="form-control @error('note', 'store') is-invalid @enderror" name="note" id="note"
									rows="3" placeholder="Masukan keterangan tambahan">{{ old('note') }}</textarea>
								@error('note', 'store')
								<div class="invalid-feedback d-block">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>
				</div>

				<!-- Modal Footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">
						<i class="fas fa-times mr-1"></i> Tutup
					</button>
					<button type="submit" class="btn btn-success">
						<i class="fas fa-floppy-disk mr-1"></i> Simpan Perubahan
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
