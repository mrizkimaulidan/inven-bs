<?php

use App\Exports\RolesExport;
use App\Livewire\Forms\ExportForm;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Role;

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
        return Role::count();
    }

    /**
     * Handle the export request.
     */
    public function export()
    {
        $this->form->validate();

        return (new RolesExport)
            ->download(
                $this->form->filename('Data Peran'),
                $this->form->formatEnum()->writerType()
            );
    }
};
