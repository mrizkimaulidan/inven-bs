<?php

use App\Exports\CommodityFundingSourcesExport;
use App\Livewire\Forms\ExportForm;
use App\Models\CommodityFundingSource;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    /**
     * The export form state.
     */
    public ExportForm $form;

    /**
     * Get the total number of rows that will be exported.
     */
    #[Computed]
    public function totalRows(): int
    {
        return CommodityFundingSource::count();
    }

    /**
     * Handle the export request.
     */
    public function export()
    {
        $this->form->validate();

        return (new CommodityFundingSourcesExport)
            ->download(
                $this->form->filename('Data Perolehan'),
                $this->form->formatEnum()->writerType()
            );
    }
};
