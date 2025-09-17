<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class navbar_public extends Component
{
    /**
     * Create a new component instance.
     */
    public string $currentRouteName;
    public function __construct($currentRouteName)
    {
        $this->currentRouteName = $currentRouteName;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar_public');
    }
}
