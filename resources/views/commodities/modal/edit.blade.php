<!-- Modal -->
<div class="modal fade" id="edit_commodity" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="commodity_edit">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="item_code_edit">Kode Barang</label>
                                <input type="text" name="item_code_edit" class="form-control" id="item_code_edit">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="acquisition">Asal Perolehan</label>
                                <select class="custom-select" id="school_operational_assistance_id_edit">
                                    <option selected>Pilih</option>
                                    @foreach($school_operational_assistances as $school_operational_assistance)
                                    <option value="{{ $school_operational_assistance->id }}">{{ $school_operational_assistance->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="name_edit">Nama Barang</label>
                                <input type="text" class="form-control" id="name_edit">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="brand_edit">Merek</label>
                                <input type="text" class="form-control" id="brand_edit">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="year_of_purchase_edit">Tahun Pembelian</label>
                                <input type="number" class="form-control" id="year_of_purchase_edit">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-5">
                            <div class="form-group">
                                <label for="material_edit">Bahan</label>
                                <input type="text" class="form-control" id="material_edit">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="commodity_location_id_edit">Lokasi</label>
                                <select class="custom-select" id="commodity_location_id_edit">
                                    <option selected>Pilih</option>
                                    @foreach($commodity_locations as $commodity_location)
                                    <option value="{{ $commodity_location->id }}">{{ $commodity_location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="condition_edit">Kondisi Barang</label>
                                <select class="custom-select" id="condition_edit">
                                    <option selected>Pilih</option>
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
                                <label for="quantity_edit">Kuantitas</label>
                                <input type="number" class="form-control" id="quantity_edit">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="price_edit">Harga</label>
                                <input type="number" class="form-control" id="price_edit">
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="price_per_item_edit">Harga Satuan</label>
                                <input type="number" class="form-control" id="price_per_item_edit">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="note_edit">Keterangan</label>
                                <textarea class="form-control" id="note_edit" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button data-id="" type="submit" class="btn btn-primary" id="swal-update-button">Ubah Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>