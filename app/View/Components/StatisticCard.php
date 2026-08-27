<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StatisticCard extends Component
{
    /**
     * Create a new component instance.
     *
     * @param  string  $icon  The Font Awesome icon class (e.g., 'fas fa-box')
     * @param  string  $title  The title/label displayed on the statistic card
     * @param  string  $bgColor  The Bootstrap background color class (e.g., 'primary', 'success')
     * @param  mixed  $value  The numeric or text value to display (can be int, float, or string)
     */
    public function __construct(
        public string $icon,
        public string $title,
        public string $bgColor,
        public mixed $value,
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.statistic-card');
    }
}
