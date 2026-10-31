<?php

use Livewire\Attributes\Locked;
use Livewire\Component;

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
     * @param  array<int, string>  $records
     */
    public function mount(string $resourceLabel, array $records): void
    {
        $this->resourceLabel = $resourceLabel;
        $this->records = $records;
    }
};
