<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatbotController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/chatbot/message', [ChatbotController::class, 'chat'])->name('chatbot.message');

Route::get('/about', function () {  return view('about');})->name('about');
Route::get('/contact', function () {  return view('contact');})->name('contact');

//blog
Route::get('/blog1', function () { return view('blogs.blog_1'); })->name('blog1');
Route::get('/blog2', function () { return view('blogs.blog_2'); })->name('blog2');
Route::get('/blog3', function () { return view('blogs.blog_3'); })->name('blog3');

//admin
// Dòng 1: Để "gọi" bộ não
use App\Http\Controllers\AdminController; 
// Dòng 2: Để đăng ký địa chỉ
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');


//admin dashboard
use App\Http\Controllers\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//admin packages
use App\Http\Controllers\PackageController;
Route::get('/admin/packages', [PackageController::class, 'index'])->name('admin.packages');

//admin store
use App\Http\Controllers\StoreController;
Route::get('/admin/store', [StoreController::class, 'index'])->name('admin.store');

//admin orders
use App\Http\Controllers\OrderController;
Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders');

//admin promotions
use App\Http\Controllers\PromotionController;
Route::get('/admin/promotions', [PromotionController::class, 'index'])->name('admin.promotions');

//admin rentals
use App\Http\Controllers\RentalController;
Route::get('/admin/rentals', [RentalController::class, 'index'])->name('admin.rentals');

//admin payment
use App\Http\Controllers\PaymentController;
Route::get('/admin/payment', [PaymentController::class, 'index'])->name('admin.payment');

//admin blogs
use App\Http\Controllers\BlogController;
Route::get('/admin/blogs', [BlogController::class, 'index'])->name('admin.blogs');

//admin branches
use App\Http\Controllers\BranchController;
Route::get('/admin/branches', [BranchController::class, 'index'])->name('admin.branches');

//admin class schedule
use App\Http\Controllers\ClassScheduleController;
Route::get('/admin/class-schedule', [ClassScheduleController::class, 'index'])->name('admin.class_schedule');

//admin class list
use App\Http\Controllers\ClassListController;
Route::get('/admin/class-list', [ClassListController::class, 'index'])->name('admin.class_list');

//admin customer
use App\Http\Controllers\CustomerController;
Route::get('/admin/customers', [CustomerController::class, 'index'])->name('admin.customers');

//admin trainers
use App\Http\Controllers\TrainerController;
Route::get('/admin/trainers', [TrainerController::class, 'index'])->name('admin.trainers');

// //admin contact info
// use App\Http\Controllers\ContactInfoController;
// Route::get('/admin/contact-info', [ContactInfoController::class, 'index'])->name('admin.contact_info');

// //admin policies
// use App\Http\Controllers\PolicyController;
// Route::get('/admin/policies', [PolicyController::class, 'index'])->name('admin.policies');

