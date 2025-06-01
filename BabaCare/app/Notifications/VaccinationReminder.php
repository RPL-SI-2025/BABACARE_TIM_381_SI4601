<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class VaccinationReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $vaccination;

    public function __construct($vaccination)
    {
        $this->vaccination = $vaccination;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        try {
            Log::info('[VaccinationReminder][toMail] Notifiable', ['notifiable' => $notifiable->toArray()]);
            Log::info('[VaccinationReminder][toMail] Vaccination', ['vaccination' => $this->vaccination->toArray()]);
            $tanggal = Carbon::parse($this->vaccination->vaccination_date)->format('d M Y');
            $waktu = Carbon::parse($this->vaccination->vaccination_time)->format('H:i');
            Log::info('[VaccinationReminder][toMail] Tanggal/Waktu', ['tanggal' => $tanggal, 'waktu' => $waktu]);
            return (new MailMessage)
                        ->subject('Reminder Vaksinasi/Imunisasi Anda di BabaCare')
                        ->greeting('Halo ' . $notifiable->name)
                        ->line('Ini adalah pengingat bahwa Anda memiliki jadwal vaksinasi/imunisasi di BabaCare dalam 1 jam.')
                        ->line('Tanggal: ' . $tanggal)
                        ->line('Waktu: ' . $waktu)
                        ->action('Lihat Detail', url('/user/vaccination/' . $this->vaccination->id))
                        ->line('Terima kasih telah menggunakan layanan BabaCare!');
        } catch (\Throwable $e) {
            Log::error('[VaccinationReminder][toMail] Exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }

    public function toDatabase($notifiable)
    {
        try {
            Log::info('[VaccinationReminder][toDatabase] Notifiable', ['notifiable' => $notifiable->toArray()]);
            Log::info('[VaccinationReminder][toDatabase] Vaccination', ['vaccination' => $this->vaccination->toArray()]);
            $waktu = Carbon::parse($this->vaccination->vaccination_time)->format('H:i');
            Log::info('[VaccinationReminder][toDatabase] Waktu', ['waktu' => $waktu]);
            $url = route('vaccination.show', $this->vaccination->id);
            Log::info('[VaccinationReminder][toDatabase] URL', ['url' => $url]);
            return [
                'title' => 'Reminder Vaksinasi/Imunisasi',
                'message' => 'Jadwal vaksinasi/imunisasi Anda akan dimulai pada ',
                'time' => $waktu,
                'vaccination_id' => $this->vaccination->id,
                'url' => $url
            ];
        } catch (\Throwable $e) {
            Log::error('[VaccinationReminder][toDatabase] Exception', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            throw $e;
        }
    }
}
