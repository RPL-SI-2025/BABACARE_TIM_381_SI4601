<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserActivityLogged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user, $title, $message;

    public function __construct(pengguna $user, $title, $message)
    {
        $this->user = $user;
        $this->title = $title;
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('notifications.' . $this->user->id);
    }
}
