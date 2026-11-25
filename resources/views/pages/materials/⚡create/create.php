<?php

use App\Livewire\Forms\StoreMaterialForm;
use Livewire\Component;

/**
 * Validate the form, create a material, and redirect to the listing.
 */
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

        session()->flash('success', 'Data bahan berhasil ditambahkan.');

        $this->redirect(route('bahan.index'), navigate: true);
    }
};
