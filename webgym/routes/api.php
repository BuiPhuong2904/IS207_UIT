<?php

use App\Http\Controllers\ImageUploadController;
use Illuminate\Support\Facades\Route;

Route::post('/upload-image', [ImageUploadController::class, 'upload']);

