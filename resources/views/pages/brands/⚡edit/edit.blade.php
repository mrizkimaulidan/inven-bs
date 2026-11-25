<div>
    <x-modal title="Ubah Data Merek" submit="edit">
        <x-slot:body>
            <x-input
                wire:model="form.name"
                name="form.name"
                label="Nama Merek"
                placeholder="Masukkan nama merek"
                required
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
