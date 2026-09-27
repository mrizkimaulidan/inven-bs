<div>
    <x-modal title="Konfirmasi Hapus Data Barang" submit="destroy">
        <x-slot:body>
            <p class="mb-3">
                Anda akan menghapus <strong>{{ count($ids) }}</strong> data barang berikut. Tindakan ini tidak dapat
                dibatalkan.
            </p>

            <div class="d-flex flex-wrap">
                @foreach ($this->commodities as $commodity)
                    <x-badge :label="$commodity->name" icon="fa-box" class="badge-danger mr-1 mb-1" />
                @endforeach
            </div>
        </x-slot:body>

        <x-slot:footer>
            <x-button type="submit" icon="fa-trash-alt" label="Ya, Hapus" class="btn-danger" />
        </x-slot:footer>
    </x-modal>
</div>
