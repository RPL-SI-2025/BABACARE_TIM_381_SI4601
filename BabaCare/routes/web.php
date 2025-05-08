<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Models\Patient;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\FeedbackController;

// Rute default diarahkan ke halaman login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');

Route::get('/report', function () {
    $totalPatients = Patient::count();
    $todayPatients = Patient::whereDate('waktu_periksa', today())->count();
    $inCarePatients = Patient::where('jenis_perawatan', 'Rawat Inap')->count();

    return view('landing_page_petugas', compact('totalPatients', 'todayPatients', 'inCarePatients'));
})->name('landing');

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

    // User Profile Routes
    Route::get('/user/profile/edit', [UserProfileController::class, 'edit'])->name('user.profile.edit');
    Route::put('/user/profile/update', [UserProfileController::class, 'update'])->name('user.profile.update');

    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
}); 

// Resource route untuk pasien
Route::resource('appointments', AppointmentController::class);
Route::resource('patients', PatientController::class);

// Rute laporan
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::resource('obats', ObatController::class);

Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.form');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');


