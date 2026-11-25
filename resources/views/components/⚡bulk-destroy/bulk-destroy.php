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
    public string $resourceLabel = '';

    /**
     * Selected record labels to display for confirmation.
     *
     * @var array<int, string>
     */
    #[Locked]
    public array $records = [];

    /**
     * Initialize the confirmation modal.
     *
     * @param  array<int, mixed>  $records
     */
    public function mount(string $resourceLabel, array $records): void
    {
        $this->resourceLabel = trim($resourceLabel);
        $this->records = array_values(array_map(
            static fn (mixed $record): string => (string) $record,
            $records,
        ));
    }
};
