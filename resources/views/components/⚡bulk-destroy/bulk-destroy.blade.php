<div>
    <x-modal title="Konfirmasi Hapus Data {{ ucfirst($resourceLabel) }}" submit="$dispatch('confirmBulkDelete')">
        <x-slot:body>
            <p class="mb-3">
                Anda akan menghapus <strong>{{ count($records) }}</strong> data {{ $resourceLabel }} berikut. Tindakan
                ini tidak dapat dibatalkan.
            </p>

            <div class="d-flex flex-wrap rounded border p-2" style="max-height: 220px; overflow-y: auto">
                @foreach ($records as $record)
                    <x-badge :label="$record" icon="fa-box" variant="danger" class="mr-1 mb-1" />
                @endforeach
            </div>
        </x-slot:body>

        <x-slot:footer>
            <x-button type="submit" icon="fa-trash-alt" label="Ya, Hapus" class="btn-danger" />
        </x-slot:footer>
    </x-modal>
</div>
