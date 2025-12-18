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
use App\Http\Controllers\PaymentAdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ClassScheduleController;
use App\Http\Controllers\ClassListController;

use App\Http\Controllers\CustomerController;

use App\Http\Controllers\TrainerController;
use App\Http\Controllers\BorrowReturnController;
use App\Http\Controllers\PackageRegistrationController;

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    // --- NHÓM 1: CHỨC NĂNG QUẢN LÝ CẤP CAO (Admin & Manager) ---
    Route::middleware(['admin.role:admin,manager'])->group(function () {
        
        // 1. Quản lý Gói tập & Đăng ký
        Route::resource('packages', PackageController::class);
        Route::resource('package_registrations', PackageRegistrationController::class);

        // 2. Quản lý Cửa hàng (Store)
        Route::prefix('store')->name('store.')->group(function () {
            Route::get('/', [StoreController::class, 'index'])->name('index');
            Route::resource('products', StoreController::class)->except(['index', 'show']);
            
            // Variants
            Route::prefix('products/{product}')->name('products.')->group(function () {
                Route::get('variants', [StoreController::class, 'variants'])->name('variants.index');
                Route::post('variants', [StoreController::class, 'storeVariant'])->name('variants.store');
                Route::put('variants/{variant}', [StoreController::class, 'updateVariant'])->name('variants.update');
                Route::delete('variants/{variant}', [StoreController::class, 'destroyVariant'])->name('variants.destroy');
            });
        });

        // 3. Quản lý Huấn luyện viên 
        Route::resource('trainers', TrainerController::class);

        // 4. Quản lý Khách hàng
        Route::resource('customers', CustomerController::class);

        // 5. Quản lý Đơn hàng & Thanh toán
        Route::resource('orders', OrderController::class);
        Route::resource('payments', PaymentAdminController::class);
        Route::resource('promotions', PromotionController::class);

        // 6. Quản lý Hệ thống & Tài sản
        Route::resource('branches', BranchController::class);
        Route::resource('rentals', RentalController::class);
        Route::resource('borrow_return', BorrowReturnController::class);
    });

    // --- NHÓM 2: CHỨC NĂNG TÁC NGHIỆP (Admin, Manager & Trainer) ---
    Route::middleware(['admin.role:admin,manager,trainer'])->group(function () {
        
        // 1. Dashboard 
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // 2. Lịch & Lớp học
        Route::resource('class_schedule', ClassScheduleController::class);
        Route::post('class_schedule/check-in', [ClassScheduleController::class, 'toggleCheckIn'])->name('class.checkin');
        Route::resource('class_list', ClassListController::class);

        // 3. Blogs 
        Route::resource('blogs', BlogController::class);

        // Test CSRF
        Route::get('/csrf-token', function () {
            return response()->json([
                'csrf_token' => csrf_token(),
                'session_id' => session()->getId()
            ]);
        })->name('csrf.token');
    });

});