<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  string  $name  The name attribute for the select element, also used as ID
     * @param  string|null  $label  The label text displayed above the select (optional)
     * @param  string|null  $icon  The Font Awesome icon class (e.g., 'fa-tags') displayed next to the label (optional)
     * @param  bool  $required  Whether the select field is required (adds 'required' attribute and asterisk)
     * @param  bool  $disabled  Whether the select field is disabled (adds 'disabled' attribute)
     * @param  string|null  $help  Help text displayed below the select for additional guidance (optional)
     */
    public function __construct(
        public string $name,
        public ?string $label = null,
        public ?string $icon = null,
        public bool $required = false,
        public bool $disabled = false,
        public ?string $help = null,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}
