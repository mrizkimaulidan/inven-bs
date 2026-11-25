<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

/**
 * Render the import modal and provide its title, template link, and uploaded file.
 */
class ImportModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  string  $modalTitle  The modal dialog heading.
     * @param  string  $templateDownloadUrl  URL to download the import template file.
     * @param  TemporaryUploadedFile|null  $uploadedFile  Currently selected spreadsheet upload.
     */
    public function __construct(
        public string $modalTitle,
        public string $templateDownloadUrl,
        public ?TemporaryUploadedFile $uploadedFile = null,
    ) {}

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.import-modal');
    }
}
