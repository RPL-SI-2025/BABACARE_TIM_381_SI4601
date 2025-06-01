<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogNotification
{
    public function handle(UserActivityLogged $event)
    {
        Notification::create([
            'id' => $event->user->id,
            'title' => $event->title,
            'message' => $event->message,
        ]);
    }
}