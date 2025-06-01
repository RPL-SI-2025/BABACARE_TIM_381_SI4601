<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ReferralReady extends Notification implements ShouldQueue
{
    use Queueable;

    protected $referral;

    public function __construct($referral)
    {
        $this->referral = $referral;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Surat Rujukan Siap Diambil',
            'message' => 'Surat rujukan Anda sudah siap diambil di konter administrasi. Silakan menuju ke konter untuk mengambil surat rujukan Anda.',
            'referral_id' => $this->referral->id,
            'url' => route('referrals.index')
        ];
    }
}
