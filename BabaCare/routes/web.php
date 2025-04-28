<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Models\Patient;

// Rute default diarahkan ke halaman login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');

// Rute login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Rute registrasi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Rute landing page untuk petugas
Route::middleware(['auth'])->group(function () {
    Route::get('/petugas', function () {
        return view('landing_page_petugas');
    })->name('petugas.landing');

    Route::get('/admin', function () {
        return view('landing_page_admin');
    })->name('admin.landing');

    Route::get('/user', function () {
        return view('landing_page_user');
    })->name('user.landing');
}); 

// Resource route untuk pasien
Route::resource('patients', PatientController::class);

// Rute laporan
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
