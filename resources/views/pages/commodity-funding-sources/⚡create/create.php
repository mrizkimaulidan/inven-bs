<?php

use App\Livewire\Forms\StoreCommodityFundingSourceForm;
use Livewire\Component;

new class extends Component
{
    /**
     * The form instance.
     */
    public StoreCommodityFundingSourceForm $form;

    /**
     * Store a newly created resource in storage.
     */
    public function save(): void
    {
        $this->form->store();

        $this->redirect('/perolehan', navigate: true);
    }
};
