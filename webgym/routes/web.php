<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatbotController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/chatbot/message', [ChatbotController::class, 'chat'])->name('chatbot.message');


