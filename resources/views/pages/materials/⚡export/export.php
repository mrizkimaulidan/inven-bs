<?php

use App\Exports\MaterialsExport;
use App\Livewire\Forms\ExportForm;
use App\Models\Material;
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
        return Material::count();
    }

    /**
     * Handle the export request.
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
