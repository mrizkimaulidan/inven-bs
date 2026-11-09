<?php

use App\Livewire\Forms\UpdateCommodityLocationForm;
use App\Models\CommodityLocation;
use Livewire\Component;

/**
 * Load the selected location into the form and save its validated changes.
 */
new class extends Component
{
    /**
     * The form instance.
     */
    public UpdateCommodityLocationForm $form;

    /**
     * Load the selected location and populate the edit form.
     *
     * @param  int  $commodityLocationId
     * @return void
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
     *
     * @return void
     */
    public function edit(): void
    {
        $this->form->update();

        session()->flash('success', 'Data ruangan berhasil diperbarui.');

        $this->redirect('/ruangan', navigate: true);
    }
};
