<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\BorrowReturnController;
use App\Http\Controllers\UserController;

Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('dashboard');       // user.dashboard
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');                 // user.profile
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::view('/rental-history', 'user.rental-history')->name('rental.history');
});
