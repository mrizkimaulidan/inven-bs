<div class="modal fade" id="commodity_create_modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
	role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalLabel">Tambah Data Barang</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
				<form action="{{ route('barang.store') }}" method="POST">
					@csrf
					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label for="item_code">Kode Barang</label>
								<input type="text" class="form-control @error('item_code', 'store') is-invalid @enderror"
									name="item_code" id="item_code" value="{{ old('item_code') }}" placeholder="Masukan kode barang..">
								@error('item_code', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label for="name">Nama Barang</label>
								<input type="text" class="form-control @error('name', 'store') is-invalid @enderror" name="name"
									id="name" value="{{ old('name') }}" placeholder="Masukan nama barang..">
								@error('name', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col-lg-4">
							<div class="form-group">
								<label for="commodity_location_id">Lokasi Barang</label>
								<select class="form-control @error('commodity_location_id', 'store') is-invalid @enderror"
									name="commodity_location_id" id="commodity_location_id" style="width: 100%;">
									<option value="" selected>Pilih..</option>
									@foreach ($commodity_locations as $commodity_location)
									<option value="{{ $commodity_location->id }}"
										@selected(old('commodity_location_id')==$commodity_location->id)>{{ $commodity_location->name }}
									</option>
									@endforeach
								</select>
								@error('commodity_location_id', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="material">Bahan</label>
								<input type="text" class="form-control @error('material', 'store') is-invalid @enderror" name="material"
									id="material" value="{{ old('material') }}" placeholder="Masukan bahan barang..">
								@error('material', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="brand">Merek</label>
								<input type="text" class="form-control @error('brand', 'store') is-invalid @enderror" name="brand"
									id="brand" value="{{ old('brand') }}" placeholder="Masukan merek barang..">
								@error('brand', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<label for="year_of_purchase">Tahun Pembelian</label>
								<input type="number" class="form-control @error('year_of_purchase', 'store') is-invalid @enderror"
									name="year_of_purchase" id="year_of_purchase" value="{{ old('year_of_purchase') }}"
									placeholder="Masukan tahun pembelian barang..">
								@error('year_of_purchase', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<label for="school_operational_assistance_id">Asal Perolehan</label>
								<select class="form-control @error('school_operational_assistance_id', 'store') is-invalid @enderror"
									name="school_operational_assistance_id" id="school_operational_assistance_id" style="width: 100%;">
									<option value="" selected">Pilih..</option>
									@foreach ($school_operational_assistances as $school_operational_assistance)
									<option value="{{ $school_operational_assistance->id }}"
										@selected(old('school_operational_assistance_id')==$school_operational_assistance->id)>{{
										$school_operational_assistance->name }}
									</option>
									@endforeach
								</select>
								@error('school_operational_assistance_id', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="form-group">
								<label for="condition">Kondisi</label>
								<select class="form-control @error('condition', 'store') is-invalid @enderror" name="condition"
									id="condition" style="width: 100%;">
									<option value="" selected>Pilih..</option>
									<option value="1" @selected(old('condition')==1)>Baik</option>
									<option value="2" @selected(old('condition')==2)>Kurang Baik</option>
									<option value="3" @selected(old('condition')==3)>Rusak Berat</option>
								</select>
								@error('condition', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>

					<hr>

					<div class="row">
						<div class="col-lg-4">
							<div class="form-group">
								<label for="quantity">Kuantitas</label>
								<input type="number" class="form-control @error('quantity', 'store') is-invalid @enderror"
									name="quantity" id="quantity" value="{{ old('quantity') }}" placeholder="Masukan kuantitas barang..">
								@error('quantity', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
						<div class="col-lg-4 col-6">
							<div class="form-group">
								<label for="price">Harga</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1">Rp.</span>
									</div>
									<input type="number" class="form-control @error('price', 'store') is-invalid @enderror" name="price"
										id="price" value="{{ old('price') }}" placeholder="Masukan harga barang..">
									@error('price', 'store')
									<div class="d-block invalid-feedback">
										{{ $message }}
									</div>
									@enderror
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
									<input type="number" class="form-control @error('price_per_item', 'store') is-invalid @enderror"
										name="price_per_item" id="price_per_item" value="{{ old('price_per_item') }}"
										placeholder="Masukan harga satuan barang..">
									@error('price_per_item', 'store')
									<div class="d-block invalid-feedback">
										{{ $message }}
									</div>
									@enderror
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="form-group">
								<label for="note">Keterangan</label>
								<textarea class="form-control @error('note', 'store') is-invalid @enderror" name="note" id="note"
									style="height: 100px;" placeholder="Masukan keterangan (opsional)..">{{ old('note') }}</textarea>
								@error('note', 'store')
								<div class="d-block invalid-feedback">
									{{ $message }}
								</div>
								@enderror
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
						<button type="submit" class="btn btn-success">Tambah</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
