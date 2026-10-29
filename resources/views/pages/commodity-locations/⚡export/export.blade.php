<div>
    <x-modal title="Ekspor Data Ruangan" submit="export">
        <x-slot:body>
            <div class="alert alert-info alert-has-icon" role="alert">
                <div class="alert-icon">
                    <i class="fas fa-download"></i>
                </div>
                <div class="alert-body">
                    <div class="alert-title">Informasi</div>

                    Akan mengekspor <strong>{{ $this->totalRows }} ruangan</strong> ke dalam file spreadsheet.
                </div>
            </div>

            <x-select icon="fa-file-export" name="form.format" label="Format File" wire:model="form.format" required>
                <option value="">Pilih format file</option>
                @foreach (\App\Enums\ExportFormat::options() as $format)
                    <option value="{{ $format->value }}">{{ $format->label() }}</option>
                @endforeach
            </x-select>
        </x-slot:body>

        <x-slot:footer>
            <x-button type="submit" icon="fa-download" label="Ekspor" />
        </x-slot:footer>
    </x-modal>
</div>
