<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductCategory;

class UserStoreController extends Controller
{
    /**
     * API Endpoint
     * Trả về JSON cho JavaScript của trang Cửa hàng.
     */
    public function index(Request $request)
    {
        // Khởi tạo Query
        $query = Product::with(['category', 'variants']) // Eager load
                        ->where('status', 'active');

        // Lọc theo Danh mục
        if ($request->filled('category') && $request->category != 'all') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Lọc theo Giá
        if ($request->has('min_price') || $request->has('max_price')) {
            $min = $request->min_price ?? 0;
            $max = $request->max_price ?? 999999999;
            
            $query->whereHas('variants', function($q) use ($min, $max) {
                $q->whereBetween('price', [$min, $max]);
            });
        }

        // Lọc theo Khuyến mãi
        if ($request->filled('sale') && $request->sale == 'on_sale') {
            $query->whereHas('variants', function($q) {
                $q->where('is_discounted', true);
            });
        }

        // Phân trang
        $products = $query->paginate(9);

        // Transform 
        $data = $products->getCollection()->map(function($product) {
            
            // Lấy biến thể đầu tiên
            $firstVariant = $product->variants->first();
            if (!$firstVariant) {
                return null;
            }

            // Tính toán giá
            $price = $firstVariant->price;
            $originalPrice = null;
            $discountPercent = 0;

            if ($firstVariant->is_discounted && $firstVariant->discount_price > 0) {
                $price = $firstVariant->discount_price;
                $originalPrice = $firstVariant->price;
                if ($originalPrice > 0) {
                    $discountPercent = round((($originalPrice - $price) / $originalPrice) * 100);
                }
            }

            return [
                'id' => $product->product_id,
                'slug' => $product->slug,
                'name' => $product->product_name,
                'category' => $product->category->slug ?? 'other',
                'image' => $product->image_url,
                'price' => number_format($price, 0, ',', '.') . ' VNĐ',
                'originalPrice' => $originalPrice ? number_format($originalPrice, 0, ',', '.') . ' VNĐ' : null,
                'discount' => $discountPercent,
            ];
        })->filter(); // Loại bỏ các sản phẩm 'null'

        // Trả về JSON
        return response()->json([
            'products' => $data,
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ]
        ]);
    }

    /**
     * API lấy Categories để hiển thị động lên Sidebar
     */
    public function getCategories()
    {
        $categories = ProductCategory::orderBy('category_name', 'asc')->get();
        return response()->json(['categories' => $categories]);
    }
}