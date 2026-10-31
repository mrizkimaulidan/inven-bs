<?php

use App\Livewire\Forms\StoreMaterialForm;
use Livewire\Component;

new class extends Component
{
    /**
     * The form instance.
     */
    public StoreMaterialForm $form;

    /**
     * Store a newly created resource in storage.
     */
    public function save(): void
    {
        $this->form->store();

        $this->redirect('/bahan', navigate: true);
    }
};
