<?php

namespace App;

use Livewire\Attributes\On;

/**
 * Trait for handling modal state management.
 */
trait WithModal
{
    /**
     * The currently active modal identifier.
     */
    public ?string $activeModal = null;

    /**
     * Parameters/data to be passed to the modal.
     */
    public mixed $modalParams = null;

    /**
     * Open a modal with given name and parameters.
     *
     * @param  string  $modalName  The modal identifier
     * @param  array<string, mixed>|null  $params  Data to pass to the modal
     */
    #[On('showModal')]
    public function showModal(string $modalName, mixed $params = null): void
    {
        $this->activeModal = $modalName;
        $this->modalParams = $params;
    }

    /**
     * Close the currently active modal.
     */
    #[On('closeModal')]
    public function closeModal(): void
    {
        $this->activeModal = null;
        $this->modalParams = null;
    }
}
