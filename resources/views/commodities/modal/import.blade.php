<!-- Modal -->
<div class="modal fade" id="excel_menu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
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
                        <small>*Asal Perolehan dan Lokasi bersifat Case Sensitive. <br> Pastikan Namanya sesuai dengan Data BOS dan Data Ruangan di Sistem</small>
                        <br>
                        <a href="/import.xlsx" class="btn btn-primary mb-3">Template</a>
                    </div>
                    <div class="col-lg-12">
                        <form action="{{ route('excel.barang.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" id="file" class="form-control">
                            <button class="btn btn-danger mt-3">Import</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>