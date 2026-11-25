@php
    $rowCount = (int) ($this->totalRows ?? 0);
@endphp

<div>
    <x-export-modal title="Ekspor Data Merek" :total-rows="$rowCount" />
</div>
