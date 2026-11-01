<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

/**
 * Render the import modal and provide its title and selected file.
 */
class ImportModal extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  string  $modalTitle
     * @param  string  $templateDownloadUrl
     * @param  TemporaryUploadedFile|null  $uploadedFile
     * @return void
     */
    public function __construct(
        public string $modalTitle,
        public string $templateDownloadUrl,
        public ?TemporaryUploadedFile $uploadedFile = null,
    ) {}

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.import-modal');
    }
}
