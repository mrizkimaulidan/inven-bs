<?php

use App\Imports\MaterialsImport;
use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Livewire\Forms\ImportForm;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Validate the uploaded spreadsheet, import material rows, and redirect after success.
 */
new class extends Component
{
    use AuthorizesModulePermissions;
    use WithFileUploads;

    /**
     * The import form state.
     */
    public ImportForm $importForm;

    /**
     * Import the uploaded spreadsheet and redirect to the listing.
     */
    public function import(): void
    {
        $this->authorizeModuleAction('impor', 'bahan');

        $this->importForm->validate();

        Excel::import(new MaterialsImport, $this->importForm->spreadsheetFile);

        session()->flash('success', 'Data bahan berhasil diimpor!');

        $this->redirect(route('bahan.index'), navigate: true);
    }
};
