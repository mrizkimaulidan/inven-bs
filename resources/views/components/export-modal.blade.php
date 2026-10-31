<div>
    <x-modal :title="$title" submit="export">
        <x-slot:body>
            <div class="alert alert-info alert-has-icon" role="alert">
                <div class="alert-icon">
                    <i class="fas fa-download"></i>
                </div>
                <div class="alert-body">
                    <div class="alert-title">Informasi</div>

                    Akan mengekspor <strong>{{ $totalRows }} baris data</strong> ke dalam file spreadsheet.
                </div>
            </div>

            <x-select icon="fa-file-export" name="form.format" label="Format File" wire:model="form.format" required>
                <option value="">Pilih format file</option>
                @foreach ($options as $option)
                    <option value="{{ $option->value }}">{{ $option->label() }}</option>
                @endforeach
            </x-select>
        </x-slot:body>

        <x-slot:footer>
            <x-button type="submit" icon="fa-download" label="Ekspor" />
        </x-slot:footer>
    </x-modal>
</div>
