<div>
    <x-modal :title="$modalTitle" submit="import">
        <x-slot:body>
            {{-- Import guidance and file selection --}}
            <div class="alert alert-info alert-has-icon" role="alert">
                <div class="alert-icon">
                    <i class="fas fa-upload"></i>
                </div>
                <div class="alert-body">
                    <div class="alert-title">Informasi</div>
                    <p class="mb-2">Gunakan template agar nama dan urutan kolom sesuai dengan format impor.</p>
                    <a href="{{ $templateDownloadUrl }}" download class="alert-link">
                        <i class="fas fa-download mr-1" aria-hidden="true"></i> Unduh template impor
                    </a>
                </div>
            </div>

            <x-input
                type="file"
                name="importForm.spreadsheetFile"
                label="File Spreadsheet"
                icon="fa-file-import"
                accept=".xlsx,.xls,.csv"
                wire:model="importForm.spreadsheetFile"
                :selectedFileName="$uploadedFile?->getClientOriginalName()"
            />
        </x-slot:body>

        <x-slot:footer>
            {{-- Import action --}}
            <x-button type="submit" icon="fa-file-import" label="Impor" />
        </x-slot:footer>
    </x-modal>
</div>
