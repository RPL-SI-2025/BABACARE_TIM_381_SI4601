<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\Appointment;
use App\Notifications\AppointmentReminder;
use App\Models\VaccinationRegistration;
use App\Notifications\VaccinationReminder;
use Carbon\Carbon;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $now = Carbon::now();
    $targetStart = $now->copy()->addHour()->startOfMinute();
    $targetEnd = $targetStart->copy()->addSeconds(59);

    // Appointment reminders
    $appointments = Appointment::whereBetween('waktu_pelaksanaan', [$targetStart, $targetEnd])
        ->where('status', 'pending')
        ->where('reminder_sent', false)
        ->get();

    foreach ($appointments as $appointment) {
        if ($appointment->pengguna) {
            $appointment->pengguna->notify(new AppointmentReminder($appointment));
            $appointment->reminder_sent = true;
            $appointment->save();
        }
    }

    // Vaccination reminders
    $vaccinations = VaccinationRegistration::whereDate('vaccination_date', $targetStart->toDateString())
        ->whereTime('vaccination_time', '>=', $targetStart->toTimeString())
        ->whereTime('vaccination_time', '<=', $targetEnd->toTimeString())
        ->where('reminder_sent', false)
        ->get();

    foreach ($vaccinations as $vaccination) {
        if ($vaccination->pengguna) {
            $vaccination->pengguna->notify(new VaccinationReminder($vaccination));
            $vaccination->reminder_sent = true;
            $vaccination->save();
        }
    }
})->everyMinute();
