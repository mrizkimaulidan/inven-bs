<div>
    <x-modal title="Tambah Data Ruangan" submit="save">
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
                name="form.description"
                label="Deskripsi Ruangan"
                placeholder="Masukkan deskripsi ruangan (opsional)"
            />
        </x-slot:body>

        <x-slot:footer>
            <x-button
                type="submit"
                icon="fa-plus-circle"
                label="Simpan Data"
                class="btn-primary"
                wire:loading.attr="disabled"
                wire:target="save"
            />
        </x-slot:footer>
    </x-modal>
</div>
