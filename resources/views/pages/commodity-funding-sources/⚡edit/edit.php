<?php

use App\Livewire\Forms\UpdateCommodityFundingSourceForm;
use App\Models\CommodityFundingSource;
use Livewire\Component;

new class extends Component
{
    /**
     * The form instance.
     */
    public UpdateCommodityFundingSourceForm $form;

    /**
     * Mount the component.
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
     */
    public function edit(): void
    {
        $this->form->update();

        $this->redirect('/perolehan', navigate: true);
    }
};
