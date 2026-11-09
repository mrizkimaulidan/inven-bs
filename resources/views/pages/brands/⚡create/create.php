<?php

use App\Livewire\Forms\StoreBrandForm;
use Livewire\Component;

/**
 * Validate the form, create a brand, and redirect to the listing.
 */
new class extends Component
{
    /**
     * The form instance.
     */
    public StoreBrandForm $form;

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function save(): void
    {
        $this->form->store();

        session()->flash('success', 'Data merek berhasil ditambahkan.');

        $this->redirect('/merek', navigate: true);
    }
};
