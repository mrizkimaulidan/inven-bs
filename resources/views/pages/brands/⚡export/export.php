<?php

use App\Exports\BrandsExport;
use App\Livewire\Concerns\AuthorizesModulePermissions;
use App\Livewire\Forms\ExportForm;
use App\Models\Brand;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Validate the export format and download the brand spreadsheet.
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
        return Brand::count();
    }

    /**
     * Handle the export request.
     *
     * @return BinaryFileResponse
     */
    public function export()
    {
        $this->authorizeModuleAction('ekspor', 'merek');

        $this->form->validate();

        return (new BrandsExport)
            ->download(
                $this->form->filename('Data Merek'),
                $this->form->formatEnum()->writerType()
            );
    }
};
