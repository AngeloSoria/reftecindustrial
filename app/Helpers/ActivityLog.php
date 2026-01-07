<?php

use App\Http\Controllers\LogController;

if (!function_exists('actLog')) {
    
    function actLog($action = null, $activity, $details) {
        $logController = new LogController();
        $logController->create($action, $activity, $details);
    }
}
