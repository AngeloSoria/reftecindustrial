<?php

namespace App\View\Components\auth\content\general;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class product_lines extends Component
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
        return view('components.auth.content.general.product_lines');
    }
}
