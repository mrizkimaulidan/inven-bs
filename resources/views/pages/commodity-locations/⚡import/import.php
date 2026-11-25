<?php

use App\Imports\CommodityLocationsImport;
use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Livewire\Forms\ImportForm;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Validate the uploaded spreadsheet, import its rows, and redirect after success.
 */
new class extends Component
{
    use AuthorizesModulePermissions, WithFileUploads;

    /**
     * The import form state.
     */
    public ImportForm $importForm;

    /**
     * Import the uploaded spreadsheet and redirect to the listing.
     */
    public function import(): void
    {
        $this->authorizeModuleAction('impor', 'ruangan');

        $this->importForm->validate();

        Excel::import(new CommodityLocationsImport, $this->importForm->spreadsheetFile);

        session()->flash('success', 'Data ruangan berhasil diimpor!');

        $this->redirect(route('ruangan.index'), navigate: true);
    }
};
