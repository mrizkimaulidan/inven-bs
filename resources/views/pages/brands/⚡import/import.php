<?php

use App\Imports\BrandsImport;
use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Livewire\Forms\ImportForm;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Validate the uploaded spreadsheet, import brand rows, and redirect after success.
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
        $this->authorizeModuleAction('impor', 'merek');

        $this->importForm->validate();

        Excel::import(new BrandsImport, $this->importForm->spreadsheetFile);

        session()->flash('success', 'Data merek berhasil diimpor!');

        $this->redirect(route('merek.index'), navigate: true);
    }
};
