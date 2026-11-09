<?php

use App\Livewire\Forms\UpdateMaterialForm;
use App\Models\Material;
use Livewire\Component;

/**
 * Load the selected material into the form and save its validated changes.
 */
new class extends Component
{
    /**
     * The form instance.
     */
    public UpdateMaterialForm $form;

    /**
     * Load the selected material and populate the edit form.
     *
     * @param  int  $materialId
     * @return void
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
     *
     * @return void
     */
    public function edit(): void
    {
        $this->form->update();

        session()->flash('success', 'Data bahan berhasil diperbarui.');

        $this->redirect('/bahan', navigate: true);
    }
};
