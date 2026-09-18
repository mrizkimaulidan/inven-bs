<?php

use App\Livewire\Forms\StoreCommodityLocationForm;
use Livewire\Component;

new class extends Component
{
    /**
     * The form instance.
     */
    public StoreCommodityLocationForm $form;

    /**
     * Store a newly created resource in storage.
     */
    public function save(): void
    {
        $this->form->store();

        $this->redirect('/lokasi', navigate: true);
    }
};
