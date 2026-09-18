<?php

use App\Livewire\Forms\UpdateCommodityLocationForm;
use App\Models\CommodityLocation;
use Livewire\Component;

new class extends Component
{
    /**
     * The form instance.
     */
    public UpdateCommodityLocationForm $form;

    /**
     * Mount the component.
     */
    public function mount(int $commodityLocationId): void
    {
        $commodityLocation = CommodityLocation::findOrFail($commodityLocationId);

        $this->form->fill([
            'commodityLocation' => $commodityLocation,
            'name' => $commodityLocation->name,
            'description' => $commodityLocation->description,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(): void
    {
        $this->form->update();

        $this->redirect('/lokasi', navigate: true);
    }
};
