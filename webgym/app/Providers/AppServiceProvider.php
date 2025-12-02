<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Models\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Logic giỏ hàng 
        View::composer('*', function ($view) { 
            $count = 0;
            
            // Chỉ đếm khi user đã đăng nhập
            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::id())
                            ->where('status', 'active')
                            ->first();
                
                if ($cart) {
                    // Đếm số dòng trong bảng cart_items (số loại sản phẩm)
                    $count = $cart->items()->count(); 
                    
                    // Nếu muốn đếm tổng số lượng (vd: mua 2 cái áo tính là 2)
                    // $count = $cart->items()->sum('quantity');
                }
            }
            
            // Chia sẻ biến $cartCount sang tất cả các file blade
            $view->with('cartCount', $count);
        });

        // Ép load CLOUDINARY_URL nếu có
        if ($url = env('CLOUDINARY_URL')) {
            config(['cloudinary.cloud_url' => $url]);
        }

        // Hoặc ép từ 3 biến
        if (env('CLOUDINARY_KEY') && env('CLOUDINARY_SECRET') && env('CLOUDINARY_CLOUD_NAME')) {
            $url = 'cloudinary://' . env('CLOUDINARY_KEY') . ':' . env('CLOUDINARY_SECRET') . '@' . env('CLOUDINARY_CLOUD_NAME');
            config(['cloudinary.cloud_url' => $url]);
        }

        if ($preset = env('CLOUDINARY_UPLOAD_PRESET')) {
            config(['cloudinary.upload_preset' => $preset]);
        }
    }
}