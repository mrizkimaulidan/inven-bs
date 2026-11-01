<?php

use App\Livewire\Forms\StoreCommodityLocationForm;
use Livewire\Component;

/**
 * Validate the form, create a commodity location, and redirect to the listing.
 */
new class extends Component
{
    /**
     * The form instance.
     */
    public StoreCommodityLocationForm $form;

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function save(): void
    {
        $this->form->store();

        $this->redirect('/ruangan', navigate: true);
    }
};
