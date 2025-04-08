<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Patient;



Route::get('/', function () {
    $totalPatients = Patient::count();
    $todayPatients = Patient::whereDate('waktu_periksa', today())->count();
    $inCarePatients = Patient::where('jenis_perawatan', 'Rawat Inap')->count();

    return view('login_page', compact('totalPatients', 'todayPatients', 'inCarePatients'));
})->name('login');

Route::resource('patients', PatientController::class);
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'submit'])->name('register.submit');