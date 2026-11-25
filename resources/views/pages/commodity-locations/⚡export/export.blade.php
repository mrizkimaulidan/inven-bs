@php
    $rowCount = (int) ($this->totalRows ?? 0);
@endphp

<div>
    <x-export-modal title="Ekspor Data Ruangan" :total-rows="$rowCount" />
</div>
