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
    $oneHourLater = $now->copy()->addHour();

    $appointments = Appointment::whereBetween('waktu_pelaksanaan', [
        $oneHourLater->copy()->subMinute(1)->toDateTimeString(), // rentang 1 menit
        $oneHourLater->copy()->addMinute(1)->toDateTimeString()
    ])->get();

    foreach ($appointments as $appointment) {
        if ($appointment->pengguna) {
            $appointment->pengguna->notify(new AppointmentReminder($appointment));
        }
    }
})->everyMinute();
