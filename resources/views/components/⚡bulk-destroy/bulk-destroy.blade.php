@php
    $normalizedLabel = filled($resourceLabel ?? null) ? trim((string) $resourceLabel) : 'data';
    $capitalizedLabel = ucfirst($normalizedLabel);
    $recordList = is_array($records ?? null) ? $records : [];
    $recordCount = count($recordList);
@endphp

<div>
    <x-modal title="Konfirmasi Hapus Data {{ $capitalizedLabel }}" submit="$dispatch('confirmBulkDelete')">
        <x-slot:body>
            <p class="mb-3">
                Anda akan menghapus <strong>{{ $recordCount }}</strong> data {{ $normalizedLabel }} berikut. Tindakan
                ini tidak dapat dibatalkan.
            </p>

            <div class="d-flex flex-wrap rounded border p-2" style="max-height: 220px; overflow-y: auto">
                @foreach ($recordList as $record)
                    <x-badge
                        :label="(string) $record"
                        icon="fa-box"
                        variant="danger"
                        class="mr-1 mb-1"
                        wire:key="bulk-record-{{ $loop->index }}"
                    />
                @endforeach
            </div>
        </x-slot:body>

        <x-slot:footer>
            <x-button type="submit" icon="fa-trash-alt" label="Ya, Hapus" class="btn-danger" />
        </x-slot:footer>
    </x-modal>
</div>
