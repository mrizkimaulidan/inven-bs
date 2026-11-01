<?php

use App\Imports\CommodityLocationsImport;
use App\Livewire\Forms\ImportForm;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Validate the uploaded spreadsheet, import its rows, and redirect after success.
 */
new class extends Component
{
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
        $this->importForm->validate();

        Excel::import(new CommodityLocationsImport, $this->importForm->spreadsheetFile);

        session()->flash('success', 'Data ruangan berhasil diimpor!');

        $this->redirect('/ruangan', navigate: true);
    }
};
