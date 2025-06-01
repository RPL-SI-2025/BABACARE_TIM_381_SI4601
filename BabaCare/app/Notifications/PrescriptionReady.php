<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PrescriptionReady extends Notification implements ShouldQueue
{
    use Queueable;

    protected $prescription;

    public function __construct($prescription)
    {
        $this->prescription = $prescription;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Resep Obat Siap Diambil',
            'message' => 'Resep obat Anda sudah siap diambil di apotek. Silakan menuju ke apotek untuk mengambil resep Anda.',
            'prescription_id' => $this->prescription->id,
            'url' => route('referrals.index', ['category' => 'resep'])
        ];
    }
}
