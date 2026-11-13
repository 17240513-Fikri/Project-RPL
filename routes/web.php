<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashTransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\LetterRequestController;
use App\Http\Controllers\ResidentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/profil-warga', [ResidentController::class, 'profile'])->name('residents.profile');

    Route::resource('residents', ResidentController::class)
        ->middleware('role:admin');

    Route::resource('households', HouseholdController::class)
        ->middleware('role:admin');

    Route::resource('letters', LetterRequestController::class)
        ->only(['index', 'create', 'store', 'show']);
    Route::patch('/letters/{letter}/status', [LetterRequestController::class, 'updateStatus'])
        ->middleware('role:admin')
        ->name('letters.status');

    Route::resource('cash', CashTransactionController::class)
        ->parameters(['cash' => 'cashTransaction'])
        ->middleware('role:admin');

    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->middleware('role:admin')->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->middleware('role:admin')->name('announcements.store');
    Route::get('/announcements/{announcement}', [AnnouncementController::class, 'show'])->name('announcements.show');
    Route::get('/announcements/{announcement}/edit', [AnnouncementController::class, 'edit'])->middleware('role:admin')->name('announcements.edit');
    Route::put('/announcements/{announcement}', [AnnouncementController::class, 'update'])->middleware('role:admin')->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])->middleware('role:admin')->name('announcements.destroy');
});
