<?php

use App\Imports\CommoditiesImport;
use App\Livewire\Forms\ImportForm;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Validate the uploaded spreadsheet, import commodity rows, and redirect after success.
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

        Excel::import(new CommoditiesImport, $this->importForm->spreadsheetFile);

        session()->flash('success', 'Data barang berhasil diimpor!');

        $this->redirect('/barang', navigate: true);
    }
};
