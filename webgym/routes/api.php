<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\PromotionController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserStoreController;

// Route cho upload ảnh (dùng trong admin)
Route::post('/upload-image', [ImageUploadController::class, 'upload']);

// Route cho cửa hàng
// API lấy danh sách sản phẩm (có lọc)
Route::get('/products', [UserStoreController::class, 'index']);

// API lấy danh sách danh mục (cho sidebar)
Route::get('/categories', [UserStoreController::class, 'getCategories']);

;

//API lấy thông tin giỏ hàng


Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'getCartItems']);           // ?user_id=1
    Route::post('/add', [CheckoutController::class, 'addToCart']);         // body + user_id
    Route::post('/update', [CheckoutController::class, 'updateQuantity']);
    Route::delete('/remove', [CheckoutController::class, 'removeFromCart']);
    Route::delete('/clear', [CheckoutController::class, 'clearCart']);
});

