<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    protected $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at'
    ];
    public $incrementing = false;
    protected $keyType = 'string';
    public function getTitleAttribute()
    {
        return $this->data['title'] ?? '-';
    }

    public function getMessageAttribute()
    {
        return $this->data['message'] ?? '-';
    }
}