<?php

use Livewire\Attributes\Locked;
use Livewire\Component;

/**
 * Initialize the selected records for the bulk-delete confirmation modal.
 */
new class extends Component
{
    /**
     * The label shown for the selected resource.
     */
    #[Locked]
    public string $resourceLabel;

    /**
     * @var array<int, string>
     */
    #[Locked]
    public array $records = [];

    /**
     * Initialize the confirmation modal.
     *
     * @param  string  $resourceLabel
     * @param  array<int, string>  $records
     * @return void
     */
    public function mount(string $resourceLabel, array $records): void
    {
        $this->resourceLabel = $resourceLabel;
        $this->records = $records;
    }
};
