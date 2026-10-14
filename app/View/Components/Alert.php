<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public array $alertTypes = [
        'success' => ['title' => 'Berhasil!', 'icon' => 'fa-check-circle'],
        'danger' => ['title' => 'Gagal!', 'icon' => 'fa-exclamation-circle'],
        'warning' => ['title' => 'Peringatan!', 'icon' => 'fa-exclamation-triangle'],
        'info' => ['title' => 'Informasi!', 'icon' => 'fa-info-circle'],
    ];

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
