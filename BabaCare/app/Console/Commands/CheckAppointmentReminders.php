<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use App\Notifications\AppointmentReminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Attributes\AsScheduled;

#[AsScheduled(frequency: 'everyMinute', withoutOverlapping: true)]
class CheckAppointmentReminders extends Command
{
    protected $signature = 'check:appointment-reminders';
    protected $description = 'Cek janji temu yang akan berlangsung 1 jam lagi dan kirimkan notifikasi';

    public function handle()
    {
        $now = Carbon::now();
        $targetStart = $now->copy()->addHour()->startOfMinute();
        $targetEnd = $targetStart->copy()->addSeconds(59);

        $appointments = Appointment::whereBetween('waktu_pelaksanaan', [$targetStart, $targetEnd])
            ->where('status', 'pending')
            ->where('reminder_sent', false)
            ->get();

        // Log jumlah janji temu yang ditemukan
        \Log::info("Total appointments found: " . $appointments->count());

        foreach ($appointments as $appointment) {
            // Log detail appointment
            \Log::info("Checking appointment: " . $appointment->id . " for user: " . $appointment->pengguna->name);

            $user = $appointment->pengguna;
            if ($user) {
                \Log::info("Sending reminder to user: " . $user->id);
                $user->notify(new AppointmentReminder($appointment));
                $appointment->reminder_sent = true;
                $appointment->save();
            }
        }

        $this->info("Reminder processed at " . now());
    }
}