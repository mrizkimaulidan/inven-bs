<?php

use App\Livewire\Forms\StoreBrandForm;
use Livewire\Component;

new class extends Component
{
    /**
     * The form instance.
     */
    public StoreBrandForm $form;

    /**
     * Store a newly created resource in storage.
     */
    public function save(): void
    {
        $this->form->store();

        $this->redirect('/merek', navigate: true);
    }
};
