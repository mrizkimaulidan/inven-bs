<?php

use App\Livewire\Forms\UpdateBrandForm;
use App\Models\Brand;
use Livewire\Component;

/**
 * Load the selected brand into the form and save its validated changes.
 */
new class extends Component
{
    /**
     * The form instance.
     */
    public UpdateBrandForm $form;

    /**
     * Load the selected brand and populate the edit form.
     *
     * @param  int  $brandId
     * @return void
     */
    public function mount(int $brandId): void
    {
        $brand = Brand::findOrFail($brandId);

        $this->form->fill([
            'brand' => $brand,
            'name' => $brand->name,
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

        session()->flash('success', 'Data merek berhasil diperbarui.');

        $this->redirect('/merek', navigate: true);
    }
};
