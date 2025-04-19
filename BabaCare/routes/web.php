<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AppointmentController;
use App\Models\Patient;

Route::get('/', function () {
    // if (auth()->user() && auth()->user()->role === 'pasien') {
    //     return redirect()->route('appointments.create');
    // }
    $totalPatients = Patient::count();
    $todayPatients = Patient::whereDate('waktu_periksa', today())->count();
    $inCarePatients = Patient::where('jenis_perawatan', 'Rawat Inap')->count();

    return view('landing_page_user', compact('totalPatients', 'todayPatients', 'inCarePatients'));
})->name('landing');

Route::resource('appointments', AppointmentController::class);
Route::resource('patients', PatientController::class);
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
