<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\VaccinationRegistrationController;
use App\Models\Patient;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PrescriptionController;

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

    // Feedback Dashboard Route
    Route::get('/admin/feedback/dashboard', [FeedbackController::class, 'dashboard'])->name('admin.feedback.dashboard');

    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
}); 

// Resource route untuk pasien
Route::resource('appointments', AppointmentController::class);
Route::resource('vaccination', VaccinationRegistrationController::class);
Route::resource('patients', PatientController::class);

// Rute laporan
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.exportPdf');

Route::resource('obats', ObatController::class);

Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.form');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

Route::middleware('auth')->prefix('notifications')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/{id}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::get('/poll', [NotificationController::class, 'poll'])->name('notifications.poll');
    Route::get('/latest', [NotificationController::class, 'latest'])->name('notifications.latest');
    Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});
Route::get('/dashboarddataobat', [ObatController::class, 'dashboard'])->name('obats.dashboarddataobat');

// Rujukan
Route::prefix('referrals')->name('referrals.')->group(function () {
    Route::get('/', [ReferralController::class, 'index'])->name('index');
    Route::get('/create', [ReferralController::class, 'create'])->name('create');
    Route::post('/', [ReferralController::class, 'store'])->name('store');
    Route::get('/{referral}/edit', [ReferralController::class, 'edit'])->name('edit');
    Route::put('/{referral}', [ReferralController::class, 'update'])->name('update');
    Route::delete('/{referral}', [ReferralController::class, 'destroy'])->name('destroy');
    Route::get('/{referral}/download', [ReferralController::class, 'downloadPDF'])->name('download');
    Route::get('/patient-details', [ReferralController::class, 'getPatientDetails'])->name('patient-details');
});

// Hospital (belum ada page)
Route::prefix('hospitals')->name('hospitals.')->group(function () {
    Route::get('/', [HospitalController::class, 'index'])->name('index');
    Route::get('/create', [HospitalController::class, 'create'])->name('create');
    Route::post('/store', [HospitalController::class, 'store'])->name('store');
    Route::get('/{hospital}/edit', [HospitalController::class, 'edit'])->name('edit');
    Route::put('/{hospital}', [HospitalController::class, 'update'])->name('update');
    Route::delete('/{hospital}', [HospitalController::class, 'destroy'])->name('destroy');
    
    Route::get('/options', [HospitalController::class, 'getOptions'])->name('options');
});

// Prescription Routes
Route::prefix('prescriptions')->name('prescriptions.')->group(function () {
    Route::get('/create', [PrescriptionController::class, 'create'])->name('create');
    Route::post('', [PrescriptionController::class, 'store'])->name('store');
    Route::get('/{prescription}/edit', [PrescriptionController::class, 'edit'])->name('edit');
    Route::put('/{prescription}', [PrescriptionController::class, 'update'])->name('update');
    Route::delete('/{prescription}', [PrescriptionController::class, 'destroy'])->name('destroy');
    Route::get('/{prescription}/download', [PrescriptionController::class, 'downloadPDF'])->name('download');
});