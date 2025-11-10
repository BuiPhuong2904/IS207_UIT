<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatbotController;

use App\Http\Controllers\AuthController;

// Web Routes

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/chatbot/message', [ChatbotController::class, 'chat'])->name('chatbot.message');

// Giới thiệu & Liên hệ
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

// Blog (tĩnh view)
Route::get('/blog1', function () { return view('blogs.blog_1'); })->name('blog1');
Route::get('/blog2', function () { return view('blogs.blog_2'); })->name('blog2');
Route::get('/blog3', function () { return view('blogs.blog_3'); })->name('blog3');

// Authentication Routes