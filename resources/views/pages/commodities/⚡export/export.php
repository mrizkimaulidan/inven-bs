<?php

use App\Exports\CommoditiesExport;
use App\Livewire\Forms\ExportForm;
use App\Models\Commodity;
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
        return Commodity::count();
    }

    /**
     * Handle the export request.
     */
    public function export()
    {
        $this->form->validate();

        return (new CommoditiesExport)
            ->download(
                $this->form->filename('Data Barang'),
                $this->form->formatEnum()->writerType()
            );
    }
};
