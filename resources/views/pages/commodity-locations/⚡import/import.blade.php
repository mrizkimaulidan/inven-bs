<div>
    {{-- Spreadsheet import modal --}}
    <x-import-modal
        modalTitle="Impor Data Ruangan"
        :uploadedFile="$importForm->spreadsheetFile"
        :templateDownloadUrl="asset('Template Data Ruangan.xlsx')"
    />
</div>
