@php
    $uploadedSpreadsheet = $importForm->spreadsheetFile ?? null;
    $templateUrl = asset(rawurlencode('Template Data Perolehan.xlsx'));
@endphp

<div>
    <x-import-modal
        modalTitle="Impor Perolehan"
        :uploadedFile="$uploadedSpreadsheet"
        :templateDownloadUrl="$templateUrl"
    />
</div>
