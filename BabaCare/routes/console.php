<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Appointment;
use App\Notifications\AppointmentReminder;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $now = Carbon::now();
    $targetStart = $now->copy()->addHour()->startOfMinute();
    $targetEnd = $targetStart->copy()->addSeconds(59);

    $appointments = Appointment::whereBetween('waktu_pelaksanaan', [$targetStart, $targetEnd])
        ->where('status', 'pending')
        ->where('reminder_sent', false)
        ->get();

    foreach ($appointments as $appointment) {
        if ($appointment->pengguna) {
            $appointment->pengguna->notify(new AppointmentReminder($appointment));
        }
    }
})->everyMinute();
