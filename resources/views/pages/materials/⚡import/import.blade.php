<div>
    {{-- Material import modal --}}
    <x-import-modal
        modalTitle="Impor Data Bahan"
        :uploadedFile="$importForm->spreadsheetFile"
        :templateDownloadUrl="asset('Template Data Bahan.xlsx')"
    />
</div>
