<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
use App\Models\Patient;

Route::get('/', function () {
    $totalPatients = Patient::count();
    $todayPatients = Patient::whereDate('waktu_periksa', today())->count();
    $inCarePatients = Patient::where('jenis_perawatan', 'Rawat Inap')->count();

    return view('landing_page_petugas', compact('totalPatients', 'todayPatients', 'inCarePatients'));
})->name('landing');

Route::resource('patients', PatientController::class);
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
