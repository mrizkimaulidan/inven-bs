@php
    $uploadedSpreadsheet = $importForm->spreadsheetFile ?? null;
    $templateUrl = asset(rawurlencode('Template Data Bahan.xlsx'));
@endphp

<div>
    <x-import-modal
        modalTitle="Impor Data Bahan"
        :uploadedFile="$uploadedSpreadsheet"
        :templateDownloadUrl="$templateUrl"
    />
</div>
