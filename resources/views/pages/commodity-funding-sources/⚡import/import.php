<?php

use App\Imports\CommodityFundingSourcesImport;
use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Livewire\Forms\ImportForm;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Validate the uploaded spreadsheet, import funding source rows, and redirect after success.
 */
new class extends Component
{
    use AuthorizesModulePermissions;
    use WithFileUploads;

    /**
     * The import form state.
     *
     * @var ImportForm
     */
    public ImportForm $importForm;

    /**
     * Import the uploaded spreadsheet.
     *
     * @return void
     */
    public function import(): void
    {
        $this->authorizeModuleAction('impor', 'perolehan');

        $this->importForm->validate();

        Excel::import(new CommodityFundingSourcesImport, $this->importForm->spreadsheetFile);

        session()->flash('success', 'Data sumber perolehan berhasil diimpor!');

        $this->redirect('/perolehan', navigate: true);
    }
};
