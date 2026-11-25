@php
    $uploadedSpreadsheet = $importForm->spreadsheetFile ?? null;
    $templateUrl = asset(rawurlencode('Template Data Ruangan.xlsx'));
@endphp

<div>
    <x-import-modal
        modalTitle="Impor Data Ruangan"
        :uploadedFile="$uploadedSpreadsheet"
        :templateDownloadUrl="$templateUrl"
    />
</div>
