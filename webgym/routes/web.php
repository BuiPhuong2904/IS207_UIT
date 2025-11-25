<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatbotController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController; 
use App\Http\Controllers\CheckoutDetailController; 

use App\Http\Controllers\UserPackageController;
use App\Http\Controllers\UserClassController;
use App\Http\Controllers\UserStoreController;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Web Routes

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/chatbot/message', [ChatbotController::class, 'chat'])->name('chatbot.message');

// Giới thiệu & Liên hệ
Route::view('/about', 'user.about')->name('about');
Route::view('/contact', 'user.contact')->name('contact');

// Blog (tĩnh view)
Route::get('/blog1', function () { return view('blogs.blog_1'); })->name('blog1');
Route::get('/blog2', function () { return view('blogs.blog_2'); })->name('blog2');
Route::get('/blog3', function () { return view('blogs.blog_3'); })->name('blog3');

// Package
Route::get('/package', [UserPackageController::class, 'index'])->name('package'); 

// Class 
Route::get('/class', [UserClassController::class, 'index'])->name('class'); 

// Product
Route::view('/product', 'user.product')->name('product');

// Product Details
Route::get('/san-pham/{slug}', [UserStoreController::class, 'detail'])->name('product.detail');
Route::get('/api/related-products', [UserStoreController::class, 'loadMoreRelated'])->name('api.related_products');

// Authentication Routes
// Route Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

//
// Route CheckoutDetail
Route::get('/checkout-detail', [CheckoutDetailController::class, 'index'])->name('checkout-detail');

// Route thử đăng nhập user với ID = 1 (chỉ dùng trong giai đoạn chưa có form đăng nhập)
Route::get('/test-login', function () {
    $user = User::find(1); 
    if ($user) {
        Auth::login($user);
        return redirect('/');
    }
    // Báo lỗi nếu không tìm thấy user
    return 'Không tìm thấy user với ID này. Bạn đã tạo user trong database chưa?';
});

// User Profile Routes
Route::view('/ho-so', 'user.profile')->name('profile');
Route::view('/goi-tap-da-mua', 'user.my_packages')->name('my_packages');
Route::view('/lop-hoc-da-dang-ky', 'user.my_classes')->name('my_classes');
Route::view('/lich-su-don-hang', 'user.order_history')->name('order_history');
Route::view('/lich-su-muon-tra', 'user.rental_history')->name('rental_history');
