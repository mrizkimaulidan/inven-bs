<?php

use App\Livewire\Forms\StoreCommodityLocationForm;
use Livewire\Component;

new class extends Component
{
    public StoreCommodityLocationForm $form;

    /**
     * Store a newly created resource.
     */
    public function save(): void
    {
        $this->form->store();

        $this->redirect('/lokasi', navigate: true);
    }
};
