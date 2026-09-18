<?php

namespace App;

use Livewire\Attributes\On;

/**
 * Handle modal state management.
 */
trait WithModal
{
    /**
     * The currently active modal identifier.
     */
    public ?string $activeModal = null;

    /**
     * The parameters to pass to the modal.
     */
    public mixed $modalParams = null;

    /**
     * Open the modal with the given name and parameters.
     *
     * @param  array<string, mixed>|null  $params
     */
    #[On('showModal')]
    public function showModal(string $modalName, mixed $params = null): void
    {
        $this->activeModal = $modalName;
        $this->modalParams = $params;
    }

    /**
     * Close the active modal.
     */
    #[On('closeModal')]
    public function closeModal(): void
    {
        $this->activeModal = null;
        $this->modalParams = null;
    }
}
