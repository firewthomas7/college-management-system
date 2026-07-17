<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class StatCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $label,
        public string $value,
        public string $icon = 'bi-bar-chart-fill',
        public string $color = 'primary',
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.stat-card');
    }
}
