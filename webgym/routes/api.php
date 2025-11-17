<?php

use App\Http\Controllers\ImageUploadController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserStoreController;

// Route cho upload ảnh (dùng trong admin)
Route::post('/upload-image', [ImageUploadController::class, 'upload']);

// Route cho cửa hàng
// API lấy danh sách sản phẩm (có lọc)
Route::get('/products', [UserStoreController::class, 'index']);

// API lấy danh sách danh mục (cho sidebar)
Route::get('/categories', [UserStoreController::class, 'getCategories']);