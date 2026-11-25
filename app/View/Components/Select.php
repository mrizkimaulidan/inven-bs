<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Render a validated select control with optional label and help text.
 */
class Select extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  string  $name  The select name attribute.
     * @param  string|null  $label  The select label.
     * @param  string|null  $icon  The Font Awesome icon class.
     * @param  bool  $required  Indicates whether the select is required.
     * @param  bool  $disabled  Indicates whether the select is disabled.
     * @param  string|null  $help  The help text.
     */
    public function __construct(
        public string $name,
        public ?string $label = null,
        public ?string $icon = null,
        public bool $required = false,
        public bool $disabled = false,
        public ?string $help = null,
    ) {}

    /**
     * Get the view or contents that represent the component.
     */
    public function render(): View
    {
        return view('components.select');
    }
}
