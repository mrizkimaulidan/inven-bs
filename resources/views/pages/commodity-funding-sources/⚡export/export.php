<?php

use App\Exports\CommodityFundingSourcesExport;
use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Livewire\Forms\ExportForm;
use App\Models\CommodityFundingSource;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Validate the export format and download the funding source spreadsheet.
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
        return CommodityFundingSource::count();
    }

    /**
     * Handle the export request.
     *
     * @return BinaryFileResponse
     */
    public function export()
    {
        $this->authorizeModuleAction('ekspor', 'perolehan');

        $this->form->validate();

        return (new CommodityFundingSourcesExport)
            ->download(
                $this->form->filename('Data Perolehan'),
                $this->form->formatEnum()->writerType()
            );
    }
};
