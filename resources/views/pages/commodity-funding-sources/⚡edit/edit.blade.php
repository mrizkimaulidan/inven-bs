<x-modal title="Ubah Data Perolehan" submit="edit">
    <x-slot:body>
        <x-input
            wire:model="form.name"
            name="form.name"
            label="Nama Perolehan"
            placeholder="Masukkan nama perolehan"
            required
        />

        <x-textarea
            wire:model="form.description"
            label="Deskripsi Perolehan"
            placeholder="Masukan deskripsi perolehan (opsional)"
            name="form.description"
        />
    </x-slot:body>

    <x-slot:footer>
        <x-button type="submit" icon="fa-plus-circle" label="Simpan Data" class="btn-primary" />
    </x-slot:footer>
</x-modal>
