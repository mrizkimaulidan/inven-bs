<?php

use App\Livewire\Forms\UpdateBrandForm;
use App\Models\Brand;
use Livewire\Component;

new class extends Component
{
    /**
     * The form instance.
     */
    public UpdateBrandForm $form;

    /**
     * Mount the component.
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
     */
    public function edit(): void
    {
        $this->form->update();

        $this->redirect('/merek', navigate: true);
    }
};
