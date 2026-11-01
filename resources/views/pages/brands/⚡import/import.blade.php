<div>
    {{-- Brand import modal --}}
    <x-import-modal
        modalTitle="Impor Data Merek"
        :uploadedFile="$importForm->spreadsheetFile"
        :templateDownloadUrl="asset('Template Data Merek.xlsx')"
    />
</div>
