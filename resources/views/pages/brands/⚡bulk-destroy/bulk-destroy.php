<?php

use App\Models\Brand;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    /**
     * The IDs of the records to delete.
     */
    public array $ids = [];

    /**
     * Get the records matching the given IDs, for display.
     */
    #[Computed]
    public function brands(): Collection
    {
        return Brand::query()->whereIn('id', $this->ids)->get(['id', 'name']);
    }

    /**
     * Permanently delete the selected records.
     */
    public function destroy(): void
    {
        Brand::whereIn('id', $this->ids)->delete();

        $this->redirect('/merek', navigate: true);
    }
};
