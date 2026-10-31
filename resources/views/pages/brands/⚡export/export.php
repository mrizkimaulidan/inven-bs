<?php

use App\Exports\BrandsExport;
use App\Livewire\Forms\ExportForm;
use App\Models\Brand;
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
        return Brand::count();
    }

    /**
     * Handle the export request.
     */
    public function export()
    {
        $this->form->validate();

        return (new BrandsExport)
            ->download(
                $this->form->filename('Data Merek'),
                $this->form->formatEnum()->writerType()
            );
    }
};
