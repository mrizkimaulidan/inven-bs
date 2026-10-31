<?php

use App\Exports\UsersExport;
use App\Livewire\Forms\ExportForm;
use App\Models\User;
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
        return User::count();
    }

    /**
     * Handle the export request.
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
