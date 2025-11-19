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

// Admin Routes
// Các route dành cho quản trị viên, bảo vệ bằng middleware 'auth' và 'admin.role'

Route::middleware([/*'auth', 'admin.role'*/])->prefix('admin')->name('admin.')->group(function () {

    // Trang dashboard
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Sử dụng resource cho các module CRUD
    Route::resource('packages', PackageController::class);

    Route::resource('store', StoreController::class);
    // Cập nhật: Resource cho Store - Tập trung vào Products (CRUD chính)
    Route::prefix('store')->name('store.')->group(function () {
        // Danh sách tổng quan store (nếu cần, ví dụ index chung)
        Route::get('/', [StoreController::class, 'index'])->name('index'); // Hoặc redirect đến products

        // CRUD cho Products
        Route::resource('products', StoreController::class)->except(['index']); // Index dùng chung, tránh conflict
        // Hoặc nếu muốn resource đầy đủ: Route::resource('products', StoreController::class);


        // Nested routes cho Variants (CRUD con của Product)
        Route::prefix('products/{product}')->name('products.')->group(function () {
            Route::resource('variants', StoreController::class)->only(['store', 'update', 'destroy']);
            Route::delete('variants/{variant}', [StoreController::class, 'destroyVariant']);
            Route::get('variants', [StoreController::class, 'variants'])
                ->name('variants.index');
        });
    });

    Route::resource('orders', OrderController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('rentals', RentalController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('class_schedule', ClassScheduleController::class);


    // Chỉnh class_list do không lấy id được
    Route::prefix('class_list')->name('class_list.')->group(function () {
        Route::get('/', [ClassListController::class, 'index'])->name('index'); // trang view
        Route::get('/data', [ClassListController::class, 'list'])->name('data');
        Route::post('/', [ClassListController::class, 'store'])->name('store');

        // Các route dùng class_id làm key
        Route::get('/{gymClass:class_id}', [ClassListController::class, 'show'])->name('show');
        Route::put('/{gymClass:class_id}', [ClassListController::class, 'update'])->name('update');
        Route::delete('/{gymClass:class_id}', [ClassListController::class, 'destroy'])->name('destroy');
    });


    Route::resource('customers', CustomerController::class);
    Route::resource('trainers', TrainerController::class);
    Route::get('borrow_return', [BorrowReturnController::class, 'index'])->name('borrow_return.index');



    // Route tạm lấy CSRF token plain cho test (xóa sau)
    Route::get('/csrf-token', function () {
        return response()->json([
            'csrf_token' => csrf_token(),  // Token plain text
            'session_id' => session()->getId()  // Để verify session
        ]);
    })->name('admin.csrf.token');
});
