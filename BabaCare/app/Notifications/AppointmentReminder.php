<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Reminder Janji Temu Anda di BabaCare')
                    ->greeting('Halo ' . $notifiable->name)
                    ->line('Ini adalah pengingat bahwa Anda memiliki janji temu di BabaCare dalam 1 jam.')
                    ->line('Tanggal: ' . $this->appointment->tanggal_pelaksanaan->format('d M Y'))
                    ->line('Waktu: ' . $this->appointment->waktu_pelaksanaan->format('H:i'))
                    ->action('Lihat Detail', url('/user/appointments/' . $this->appointment->id))
                    ->line('Terima kasih telah menggunakan layanan BabaCare!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Reminder Janji Temu',
            'message' => 'Janji temu Anda akan dimulai pada ',
            'time' => $this->appointment->waktu_pelaksanaan->format('H:i'),
            'appointment_id' => $this->appointment->id,
            'url' => route('appointments.show', $this->appointment->id)
        ];
    }
}
