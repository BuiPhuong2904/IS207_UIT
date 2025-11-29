<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController; 

use App\Http\Controllers\UserPackageController;
use App\Http\Controllers\UserClassController;
use App\Http\Controllers\UserStoreController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\User\ProfileController;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/chatbot/message', [ChatbotController::class, 'chat'])->name('chatbot.message');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Login view route (used by header links)
Route::get('/login', function () { return view('auth.login'); })->name('login');

// Handle login form submit
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// If SocialAuthController exists, keep Google routes (no-op if file absent)
if (class_exists(\App\Http\Controllers\Auth\SocialAuthController::class)) {
	Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
	Route::get('/auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
}

// Blog placeholder routes used by homepage links
Route::view('/blog/1', 'user.blog.blog1')->name('blog1');
Route::view('/blog/2', 'user.blog.blog2')->name('blog2');
Route::view('/blog/3', 'user.blog.blog3')->name('blog3');

// Placeholder routes for header navigation links
Route::view('/about', 'user.pages.about')->name('about');
Route::view('/package', 'user.pages.package')->name('package');
Route::view('/class', 'user.pages.class')->name('class');
Route::view('/product', 'user.pages.product')->name('product');
Route::view('/contact', 'user.pages.contact')->name('contact');

// Forgot Password
Route::get('/forget-password', [ForgotPasswordController::class, 'show'])->name('forget-password');
Route::post('/forget-password', [ForgotPasswordController::class, 'send'])->name('forget-password.send');

// Reset Password
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// User Profile Routes (requires authentication)
Route::middleware('auth')->group(function () {
	Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
	Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
	Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
});

// Admin Customer Management Routes (requires authentication and admin role)
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
	Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class);
});

