<div>
    <x-modal title="Tambah Data Merek" submit="save">
        <x-slot:body>
            {{-- Form fields --}}
            <x-input
                wire:model="form.name"
                name="form.name"
                label="Nama Merek"
                placeholder="Masukkan nama merek"
                required
            />
        </x-slot:body>

        <x-slot:footer>
            {{-- Form actions --}}
            <x-button type="submit" icon="fa-plus-circle" label="Simpan Data" class="btn-primary" />
        </x-slot:footer>
    </x-modal>
</div>
