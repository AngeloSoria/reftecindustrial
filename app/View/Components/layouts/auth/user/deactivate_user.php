<?php

namespace App\View\Components\layouts\auth\user;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class deactivate_user extends Component
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
        return view('components.layouts.auth.user.deactivate_user');
    }
}
