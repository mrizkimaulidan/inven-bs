<div>
    <x-modal :title="$title" submit="export">
        <x-slot:body>
            {{-- Informasi Ekspor --}}
            <div class="alert alert-info" role="alert">
                <div class="d-flex align-items-start">
                    <i class="fas fa-info-circle mt-1 mr-2" aria-hidden="true"></i>

                    <div>
                        <strong class="d-block mb-1"> Informasi Ekspor </strong>

                        <p class="mb-0">
                            Terdapat
                            <strong> {{ number_format($totalRows, 0, ',', '.') }} baris data </strong>
                            yang akan diekspor ke dalam file spreadsheet.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Pemilihan Format --}}
            <x-select
                name="form.format"
                label="Format File Ekspor"
                icon="fa-file-export"
                wire:model="form.format"
                required
            >
                <option value="">Pilih format file</option>

                @foreach ($options as $option)
                    <option value="{{ $option->value }}">{{ $option->label() }}</option>
                @endforeach
            </x-select>

            <small class="form-text text-muted">
                <i class="fas fa-info-circle mr-1" aria-hidden="true"></i>
                Pilih format file sesuai kebutuhan Anda.
            </small>
        </x-slot:body>

        <x-slot:footer>
            <x-button
                type="submit"
                icon="fa-download"
                label="Ekspor Data"
                wire:loading.attr="disabled"
                wire:target="export"
            />
        </x-slot:footer>
    </x-modal>
</div>
