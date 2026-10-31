<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

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
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.textarea');
    }
}
