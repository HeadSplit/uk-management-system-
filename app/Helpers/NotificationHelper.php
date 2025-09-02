<?php

namespace App\Helpers;

class NotificationHelper
{
    public static function flash($message, $type = 'success'): void
    {
        session()->flash('flash_message', $message);
        session()->flash('flash_type', $type);
    }
}
