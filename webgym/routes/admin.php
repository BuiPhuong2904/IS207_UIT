<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ClassScheduleController;
use App\Http\Controllers\ClassListController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\BorrowReturnController;

Route::middleware(['auth', 'admin.role'])
->prefix('admin')
->name('admin.')
->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('packages', PackageController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('rentals', RentalController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('class_schedule', ClassScheduleController::class);
    Route::resource('class_list', ClassListController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('trainers', TrainerController::class);
    Route::resource('borrow_return', BorrowReturnController::class)
        ->only(['index', 'store', 'show', 'update']);

    Route::get('/csrf-token', function () {
        return response()->json([
            'csrf_token' => csrf_token(),
            'session_id' => session()->getId()
        ]);
    })->name('csrf.token');
    Route::get('store', [StoreController::class, 'index'])
        ->name('store.index');
});
