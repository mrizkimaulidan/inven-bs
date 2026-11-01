<?php

use App\Exports\CommodityLocationsExport;
use App\Livewire\Forms\ExportForm;
use App\Models\CommodityLocation;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Validate the export format and download the commodity location spreadsheet.
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
        return CommodityLocation::count();
    }

    /**
     * Handle the export request.
     *
     * @return BinaryFileResponse
     */
    public function export()
    {
        $this->form->validate();

        return (new CommodityLocationsExport)
            ->download(
                $this->form->filename('Data Ruangan'),
                $this->form->formatEnum()->writerType()
            );
    }
};
