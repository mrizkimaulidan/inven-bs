<?php

use App\Livewire\Forms\UpdateMaterialForm;
use App\Models\Material;
use Livewire\Component;

new class extends Component
{
    /**
     * The form instance.
     */
    public UpdateMaterialForm $form;

    /**
     * Mount the component.
     */
    public function mount(int $materialId): void
    {
        $material = Material::findOrFail($materialId);

        $this->form->fill([
            'material' => $material,
            'name' => $material->name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(): void
    {
        $this->form->update();

        $this->redirect('/bahan', navigate: true);
    }
};
