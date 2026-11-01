<?php

use App\Livewire\Forms\StoreCommodityFundingSourceForm;
use Livewire\Component;

/**
 * Validate the form, create a funding source, and redirect to the listing.
 */
new class extends Component
{
    /**
     * The form instance.
     */
    public StoreCommodityFundingSourceForm $form;

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function save(): void
    {
        $this->form->store();

        session()->flash('success', 'Data perolehan berhasil ditambahkan!');

        $this->redirect('/perolehan', navigate: true);
    }
};
