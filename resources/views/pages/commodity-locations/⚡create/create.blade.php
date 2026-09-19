<div>
    <x-modal title="Tambah Data" submit="save">
        <x-slot:body>
            <x-input
                wire:model="form.name"
                name="form.name"
                label="Nama Ruangan"
                placeholder="Masukkan nama ruangan"
                required
            />

            <x-textarea
                wire:model="form.description"
                label="Deskripsi Ruangan"
                placeholder="Masukan deskripsi ruangan (opsional)"
                name="form.description"
            />
        </x-slot:body>

        <x-slot:footer>
            <x-button type="submit" icon="fa-plus-circle" label="Simpan Data" class="btn-primary" />
        </x-slot:footer>
    </x-modal>
</div>
