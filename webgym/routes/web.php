<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\RentalHistoryController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PromotionController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CheckoutDetailController;

use App\Http\Controllers\UserPackageController;
use App\Http\Controllers\UserClassController;
use App\Http\Controllers\UserStoreController;
use App\Http\Controllers\UserBlogController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\User\ProfileController;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Chatbot
Route::post('/chatbot/message', [ChatbotController::class, 'chat'])->name('chatbot.message');

// Authentication
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset
Route::get('/forget-password', [ForgotPasswordController::class, 'show'])->name('forget-password');
Route::post('/forget-password', [ForgotPasswordController::class, 'send'])->name('forget-password.send');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Social Auth (Google) - Kiểm tra file tồn tại để tránh lỗi
if (class_exists(\App\Http\Controllers\Auth\SocialAuthController::class)) {
	Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
	Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
}

// Pages (Static & Dynamic)
Route::view('/about', 'user.about')->name('about');
Route::view('/product', 'user.product')->name('product');
Route::view('/contact', 'user.contact')->name('contact');

// Class
Route::get('/class', [UserClassController::class, 'index'])->name('class');
Route::get('/class-booking/{id}', [UserClassController::class, 'booking'])->name('user.class.booking');

// Store
Route::get('/san-pham/{slug}', [UserStoreController::class, 'detail'])->name('product.detail');
Route::get('/api/related-products', [UserStoreController::class, 'loadMoreRelated'])->name('api.related_products');

// Membership Pakage
Route::get('/package', [UserPackageController::class, 'index'])->name('package');

// Blog
Route::view('/blog/1', 'blogs.blog_1')->name('blog1');
Route::view('/blog/2', 'blogs.blog_2')->name('blog2');
Route::view('/blog/3', 'blogs.blog_3')->name('blog3');

Route::get('/blog', [UserBlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [UserBlogController::class, 'show'])->name('blog.show');

// User Profile Routes (requires authentication)
Route::middleware('auth')->group(function () {
    // Route để xử lý hành động lưu đăng ký
    Route::post('/class-booking/store', [UserClassController::class, 'storeBooking'])->name('user.class.booking.store');

    // Profile
	Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
	Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
	Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

    // User Personal
    Route::view('/ho-so', 'user.profile')->name('profile');
    Route::get('/goi-tap-da-mua', [UserPackageController::class, 'myPackages'])->name('my_packages');
    Route::get('/lop-hoc-da-dang-ky', [UserClassController::class, 'myClasses'])->name('my_classes');

    Route::get('/lich-su-don-hang',[OrderHistoryController::class,'index'])->name('order_history');
    Route::get('/lich-su-muon-tra', [RentalHistoryController::class, 'index'])->name('rental_history');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

    Route::post('/api/checkout/add', [CheckoutController::class, 'addToCart'])->name('api.checkout.add');
    Route::post('/api/checkout/update', [CheckoutController::class, 'updateQuantity'])->name('api.checkout.update');
    Route::post('/api/checkout/remove', [CheckoutController::class, 'removeFromCart'])->name('api.checkout.remove');

    Route::post('/checkout-detail', [CheckoutDetailController::class, 'index'])
        ->name('checkout-detail');

    Route::get('/checkout-detail', [CheckoutDetailController::class, 'index'])
        ->name('checkout-detail');

    Route::post('/order', [OrderController::class, 'store'])
        ->name('order.store');

    Route::get('/order/success/{order_code}', [OrderController::class, 'thankYou'])
        ->name('order.thankyou');

    Route::post('/api/apply-promotion', [PromotionController::class, 'apply'])
        ->name('api.apply-promotion');

    Route::get('/payment/vnpay/return', [PaymentController::class, 'vnpayReturn'])
        ->name('payment.vnpay.return');

});
Route::post('/chat/reset', function (Request $request) {
    $request->session()->forget('chat_history');
    return response()->json(['status' => 'reset']);
});
Route::view('/invoice', 'user.invoice')->name('invoice');
