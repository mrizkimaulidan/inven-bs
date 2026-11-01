<?php

use App\Exports\UsersExport;
use App\Livewire\Forms\ExportForm;
use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Validate the export format and download the user spreadsheet.
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
        return User::count();
    }

    /**
     * Handle the export request.
     *
     * @return BinaryFileResponse
     */
    public function export()
    {
        $this->form->validate();

        return (new UsersExport)
            ->download(
                $this->form->filename('Data Pengguna'),
                $this->form->formatEnum()->writerType()
            );
    }
};
