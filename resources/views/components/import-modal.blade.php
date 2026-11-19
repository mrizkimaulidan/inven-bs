<div>
    <x-modal :title="$modalTitle" submit="import">
        <x-slot:body>
            {{-- Informasi Template --}}
            <div class="alert alert-info" role="alert">
                <div class="d-flex align-items-start">
                    <i class="fas fa-info-circle mt-1 mr-2" aria-hidden="true"></i>

                    <div>
                        <strong class="d-block mb-1"> Informasi Impor </strong>

                        <p class="mb-2">
                            Gunakan template yang tersedia agar nama dan urutan kolom sesuai dengan format impor.
                        </p>

                        <a href="{{ $templateDownloadUrl }}" download class="alert-link font-weight-bold">
                            <i class="fas fa-download mr-1" aria-hidden="true"></i>
                            Unduh Template Impor
                        </a>
                    </div>
                </div>
            </div>

            {{-- Pemilihan Berkas --}}
            <x-input
                type="file"
                name="importForm.spreadsheetFile"
                label="Berkas Data"
                icon="fa-file-import"
                accept=".xlsx,.xls,.csv"
                wire:model="importForm.spreadsheetFile"
                :selectedFileName="$uploadedFile?->getClientOriginalName()"
            />

            <small class="form-text text-muted">
                <i class="fas fa-file-excel mr-1" aria-hidden="true"></i>
                Format yang didukung: XLSX, XLS, dan CSV.
            </small>
        </x-slot:body>

        <x-slot:footer>
            <x-button type="submit" icon="fa-file-import" label="Impor Data" />
        </x-slot:footer>
    </x-modal>
</div>
