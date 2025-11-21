<?php

if (!function_exists('toast')) {

    function toast($message, $type = 'info', $duration = 3)
    {
        // Get existing toasts (if any)
        $toasts = session('toasts', []);

        // Append new one
        $toasts[] = compact('message', 'type', 'duration');

        // Flash back into session
        session()->flash('toasts', $toasts);
    }

}
