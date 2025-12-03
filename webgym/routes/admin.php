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
// Middleware 
Route::middleware(['auth', 'admin.role'])->prefix('admin')->name('admin.')->group(function () {

    // 1. Dashboard
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Packages (Gói tập)
    Route::resource('packages', PackageController::class);
    Route::resource('package_registrations', PackageRegistrationController::class);

    // 3. Store (Cửa hàng)
    Route::prefix('store')->name('store.')->group(function () {
        // Trang danh sách sản phẩm (Giao diện chính)
        Route::get('/', [StoreController::class, 'index'])->name('index');

        // CRUD Product (API cho việc thêm/sửa/xóa sản phẩm trong modal)
        Route::resource('products', StoreController::class)->except(['index', 'show']);

        // Variants (Biến thể) nested trong Product
        Route::prefix('products/{product}')->name('products.')->group(function () {
            Route::get('variants', [StoreController::class, 'variants'])->name('variants.index');
            Route::post('variants', [StoreController::class, 'storeVariant'])->name('variants.store');
            Route::put('variants/{variant}', [StoreController::class, 'updateVariant'])->name('variants.update');
            Route::delete('variants/{variant}', [StoreController::class, 'destroyVariant'])->name('variants.destroy');
        });
    });

    // 4. Class Schedule (Lịch lớp tập)
    Route::resource('class_schedule', ClassScheduleController::class); 

    // 5. Class List (Danh sách lớp tập)
    Route::resource('class_list', ClassListController::class);

    // 6. Trainer (Quản lý huấn luyện viên)
    Route::resource('trainers', TrainerController::class);

    // 7. Customer 
    Route::resource('customers', CustomerController::class);


    Route::resource('orders', OrderController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('rentals', RentalController::class);
    Route::resource('payments', PaymentAdminController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('branches', BranchController::class);
    
    Route::get('borrow_return', [BorrowReturnController::class, 'index'])->name('borrow_return.index');

    // Route test CSRF (xóa khi production)
    Route::get('/csrf-token', function () {
        return response()->json([
            'csrf_token' => csrf_token(),
            'session_id' => session()->getId()
        ]);
    })->name('csrf.token');
});