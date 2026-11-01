<?php

use App\Livewire\Forms\UpdateCommodityFundingSourceForm;
use App\Models\CommodityFundingSource;
use Livewire\Component;

/**
 * Load the selected funding source and save its validated changes.
 */
new class extends Component
{
    /**
     * The form instance.
     */
    public UpdateCommodityFundingSourceForm $form;

    /**
     * Load the selected funding source and populate the edit form.
     *
     * @param  int  $commodityFundingSourceId
     * @return void
     */
    public function mount(int $commodityFundingSourceId): void
    {
        $commodityFundingSource = CommodityFundingSource::findOrFail($commodityFundingSourceId);

        $this->form->fill([
            'commodityFundingSource' => $commodityFundingSource,
            'name' => $commodityFundingSource->name,
            'description' => $commodityFundingSource->description,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return void
     */
    public function edit(): void
    {
        $this->form->update();

        $this->redirect('/perolehan', navigate: true);
    }
};
