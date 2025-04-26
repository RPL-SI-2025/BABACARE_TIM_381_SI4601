<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
use App\Models\Patient;
use App\Http\Controllers\ObatController;

Route::get('/', function () {
    $totalPatients = Patient::count();
    $todayPatients = Patient::whereDate('waktu_periksa', today())->count();
    $inCarePatients = Patient::where('jenis_perawatan', 'Rawat Inap')->count();

    return view('landing_page_petugas', compact('totalPatients', 'todayPatients', 'inCarePatients'));
})->name('landing');

Route::resource('patients', PatientController::class);
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::resource('obats', ObatController::class);

Route::get('/user', function () {
    return view('layouts/landing_page_user');
});

Route::get('/admin', function () {
    return view('layouts/landing_page_admin');
});

Route::get('/petugas', function () {
    return view('layouts/landing_page_petugas');
});