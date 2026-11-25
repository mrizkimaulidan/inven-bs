@php
    $uploadedSpreadsheet = $importForm->spreadsheetFile ?? null;
    $templateUrl = asset(rawurlencode('Template Data Barang.xlsx'));
@endphp

<div>
    <x-import-modal
        modalTitle="Impor Data Barang"
        :uploadedFile="$uploadedSpreadsheet"
        :templateDownloadUrl="$templateUrl"
    />
</div>
