@php
    $rowCount = (int) ($this->totalRows ?? 0);
@endphp

<div>
    <x-export-modal title="Ekspor Data Peran dan Hak Akses" :total-rows="$rowCount" />
</div>
