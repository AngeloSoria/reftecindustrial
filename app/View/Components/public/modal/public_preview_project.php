<?php

namespace App\View\Components\public\modal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class public_preview_project extends Component
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
        return view('components.public.modal.public_preview_project');
    }
}
