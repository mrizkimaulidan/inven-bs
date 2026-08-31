<?php

namespace App;

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
     *
     * @var array<string, mixed>
     */
    public array $modalParams = [];

    /**
     * Open a modal with given name and parameters.
     *
     * @param  string  $modalName  The modal identifier
     * @param  array<string, mixed>  $params  Data to pass to the modal
     */
    public function showModal(string $modalName, array $params = []): void
    {
        $this->activeModal = $modalName;
        $this->modalParams = $params;
    }

    /**
     * Close the currently active modal.
     */
    public function closeModal(): void
    {
        $this->activeModal = null;
        $this->modalParams = [];
    }
}
