<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Mapping of session flash keys to their display configuration.
     *
     * Each entry defines the alert title and Font Awesome icon
     * used when the corresponding session key is present.
     */
    public const ALERT_TYPES = [
        'success' => ['title' => 'Berhasil!',   'icon' => 'fa-check-circle'],
        'danger' => ['title' => 'Gagal!',      'icon' => 'fa-exclamation-circle'],
        'warning' => ['title' => 'Peringatan!', 'icon' => 'fa-exclamation-triangle'],
        'info' => ['title' => 'Informasi!',  'icon' => 'fa-info-circle'],
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
        return view('components.alert', [
            'alertTypes' => self::ALERT_TYPES,
        ]);
    }
}
