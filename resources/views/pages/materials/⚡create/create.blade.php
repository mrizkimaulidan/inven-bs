<div>
    <x-modal title="Tambah Data Bahan" submit="save">
        <x-slot:body>
            <x-input
                wire:model="form.name"
                name="form.name"
                label="Nama Bahan"
                placeholder="Masukkan nama bahan"
                required
            />
        </x-slot:body>

        <x-slot:footer>
            <x-button type="submit" icon="fa-plus-circle" label="Simpan Data" class="btn-primary" />
        </x-slot:footer>
    </x-modal>
</div>
