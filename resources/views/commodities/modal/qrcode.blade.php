<div class="modal fade" id="qr_code_modal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qrCodeModalLabel">QR Code untuk Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
				<img id="qr_code_image" src="" alt="QR Code" class="d-none">
        <div id="qr_code_container" class="p-2 border d-inline-block">
            <span class="text-muted">Memuat QR Code...</span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <a href="#" id="download_qr_link" class="btn btn-primary" download>Download</a>
      </div>
    </div>
  </div>
</div>