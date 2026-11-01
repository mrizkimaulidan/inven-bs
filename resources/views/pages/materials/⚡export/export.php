<?php

use App\Exports\MaterialsExport;
use App\Livewire\Forms\ExportForm;
use App\Models\Material;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Validate the export format and download the material spreadsheet.
 */
new class extends Component
{
    /**
     * The export form state.
     */
    public ExportForm $form;

    /**
     * Get the total number of rows that will be exported.
     *
     * @return int
     */
    #[Computed]
    public function totalRows(): int
    {
        return Material::count();
    }

    /**
     * Handle the export request.
     *
     * @return BinaryFileResponse
     */
    public function export()
    {
        $this->form->validate();

        return (new MaterialsExport)
            ->download(
                $this->form->filename('Data Bahan'),
                $this->form->formatEnum()->writerType()
            );
    }
};
