@php
    $uploadedSpreadsheet = $importForm->spreadsheetFile ?? null;
    $templateUrl = asset(rawurlencode('Template Data Merek.xlsx'));
@endphp

<div>
    <x-import-modal
        modalTitle="Impor Data Merek"
        :uploadedFile="$uploadedSpreadsheet"
        :templateDownloadUrl="$templateUrl"
    />
</div>
