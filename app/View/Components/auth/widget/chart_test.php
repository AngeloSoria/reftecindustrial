<?php

namespace App\View\Components\auth\widget;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class chart_test extends Component
{
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
        return view('components.auth.widget.chart_test');
    }
}
