<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatbotController;

use App\Http\Controllers\AuthController;

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

// Authentication Routes


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