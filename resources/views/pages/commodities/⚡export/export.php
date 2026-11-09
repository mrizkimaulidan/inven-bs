<?php

use App\Exports\CommoditiesExport;
use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Livewire\Forms\ExportForm;
use App\Models\Commodity;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Validate the export format and download the commodity spreadsheet.
 */
new class extends Component
{
    use AuthorizesModulePermissions;

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
        return Commodity::count();
    }

    /**
     * Handle the export request.
     *
     * @return BinaryFileResponse
     */
    public function export()
    {
        $this->authorizeModuleAction('ekspor', 'barang');

        $this->form->validate();

        return (new CommoditiesExport)
            ->download(
                $this->form->filename('Data Barang'),
                $this->form->formatEnum()->writerType()
            );
    }
};
