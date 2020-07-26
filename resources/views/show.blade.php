<!-- Modal -->
<div class="modal fade" id="show_commodity" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <label for="item_code"><b>Kode Barang</b></label>
            <input type="text" name="" class="form-control" id="item_code" placeholder="" disabled>
          </div>
        </div>
        <hr>
        <div class="row">
          <table class="table">
            <tr>
              <td style="width: 145px;">
                <b>Nama Barang</b>
              </td>
              <td style="width: 20px;">:</td>
              <td id="name"></td>
            </tr>
            <tr>
              <td>
                <b>Lokasi</b>
              </td>
              <td>:</td>
              <td id="commodity_location_id"></td>
            </tr>
          </table>
        </div>
        <hr>
        <div class="row">
          <div class="col-lg-4">
            <label for="material"><b>Bahan</b></label>
            <input type="text" name="" class="form-control" id="material" placeholder="" disabled>
          </div>
          <div class="col-lg-4">
            <label for="brand"><b>Merk</b></label>
            <input type="text" name="" class="form-control" id="brand" placeholder="" disabled>
          </div>
          <div class="col-lg-4">
            <label for="year_of_purchase"><b>Tahun Pembelian</b></label>
            <input type="text" name="" class="form-control" id="year_of_purchase" placeholder="" disabled>
          </div>
        </div>
        <hr>
        <div class="row">
          <table class="table">
            <tr>
              <td style="width: 145px;">
                <b>Asal</b>
              </td>
              <td style="width: 20px;">:</td>
              <td id="school_operational_assistance_id"></td>
            </tr>
            <tr>
              <td>
                <b>Keterangan</b>
              </td>
              <td>:</td>
              <td id="note"></td>
            </tr>
          </table>
        </div>
        <hr>
        <div class="row">
          <div class="col-lg-4">
            <label for="quantity"><b>Banyaknya</b></label>
            <input type="text" name="" class="form-control" id="quantity" placeholder="" disabled>
          </div>
          <div class="col-lg-4">
            <label for="price"><b>Harga</b></label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Rp.</span>
              </div>
              <input type="text" id="price" class="form-control" placeholder="" disabled>
            </div>
          </div>
          <div class="col-lg-4">
            <label for="price_per_item"><b>Harga Satuan</b></label>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Rp.</span>
              </div>
              <input type="text" id="price_per_item" class="form-control" placeholder="" disabled>
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