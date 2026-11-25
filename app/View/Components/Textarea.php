<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render a validated multiline input with optional label and help text.
 */
class Textarea extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  string  $name  The textarea name attribute.
     * @param  string|null  $label  The textarea label.
     * @param  bool  $required  Indicates whether the textarea is required.
     * @param  string|null  $icon  The Font Awesome icon class.
     * @param  string|null  $help  The help text.
     * @param  int  $rows  The number of visible text lines.
     */
    public function __construct(
        public string $name,
        public ?string $label = null,
        public bool $required = false,
        public ?string $icon = null,
        public ?string $help = null,
        public int $rows = 3,
    ) {
        if ($this->rows < 1) {
            $this->rows = 1;
        }
    }

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.textarea');
    }
}
