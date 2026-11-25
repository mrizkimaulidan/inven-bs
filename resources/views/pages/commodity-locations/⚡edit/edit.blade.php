<div>
    <x-modal title="Ubah Data Ruangan" submit="edit">
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
                icon="fa-save"
                label="Simpan Perubahan"
                class="btn-primary"
                wire:loading.attr="disabled"
                wire:target="edit"
            />
        </x-slot:footer>
    </x-modal>
</div>
