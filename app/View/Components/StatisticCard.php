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
     * @param  string  $icon  The Font Awesome icon class
     * @param  string  $title  The statistic card title
     * @param  string  $bgColor  The Bootstrap background color class
     * @param  mixed  $value  The statistic value
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
