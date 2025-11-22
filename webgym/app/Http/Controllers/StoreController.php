<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductVariant;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    // 1. INDEX - Load danh sách sản phẩm cho table (Blade + API)
    public function index(Request $request)
    {
        $query = Product::with(['variants', 'category']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            });
        }


        $products = $query->orderBy('product_id', 'asc')->paginate(20);

        $categories = ProductCategory::pluck('category_name', 'category_id')->toArray();
        $statuses   = ['active' => 'Còn hàng', 'inactive' => 'Hết hàng'];


        // Nếu gọi từ AJAX/JS → trả JSON
        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'products'   => $products,
                'categories' => $categories,
                'statuses'   => $statuses,
            ]);
        }

        // Nếu gọi từ browser → trả view (vẫn hoạt động bình thường)
        return view('admin.store', compact('products', 'categories', 'statuses'));
    }


    // 3. STORE - Thêm sản phẩm mới + variants
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|unique:product,product_name',
            'description'  => 'required|string',
            'category_id'  => 'required|exists:product_category,category_id',
            'brand'        => 'nullable|string|max:100',
            'origin'       => 'nullable|string|max:100',
            'status'       => 'required|in:active,inactive',
        ]);


        $validated['slug']= Str::slug($request->product_name);
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('packages', 'public');
            $validated['image_url'] = '/storage/' . $path;
        } else {
            $validated['image_url'] = 'https://via.placeholder.com/150';
        }
        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thêm sản phẩm thành công!',
            'product' => $product
        ], 201);
    }

    // 5. UPDATE - Cập nhật sản phẩm
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255|unique:product,product_name,'.$product->product_id. ',product_id',
            'description'  => 'required|string',
            'category_id'  => 'required|exists:product_category,category_id',
            'brand'        => 'nullable|string|max:100',
            'origin'       => 'nullable|string|max:100',
            'status'       => 'required|in:active,inactive',
        ]);

        $validated['slug']= Str::slug($request->product_name);
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('packages', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật sản phẩm thành công!',
            'success',
            'product'  => $product->fresh()->load('variants')
        ]);
    }

    // 6. DESTROY - Xóa sản phẩm
    public function destroy(Product $product)
    {
        $product->variants()->delete();
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa sản phẩm thành công!'
        ]);
    }

    // 7. API lấy variants theo product_id
    public function variants(Product $product)
    {
        $variants = $product->variants()
            ->orderBy('color')
            ->orderBy('size')
            ->get();

        return response()->json([
            'success' => true,
            'variants' => $variants
        ]);
    }

    // 8. API thêm variant mới
    public function storeVariant(Request $request, Product $product)
    {
        $validated = $request->validate([
            'color'           => 'required|string|max:50',
            'size'            => 'required|string|max:50',
            'price'           => 'required|numeric|min:0',
            'discount_price'  => 'nullable|numeric|lte:price',
            'is_discounted'   => 'sometimes|boolean',
            'stock'           => 'required|integer|min:0',
            'image_url'       => 'nullable|url',
            'status'          => 'required|in:active,inactive',
            'weight'          => 'nullable|numeric',
            'unit'            => 'nullable|string|max:20',
        ]);
        $data = $validated;
        $data['product_id'] = $product->product_id;

        if (!empty($data['discount_price']) || $data['discount_price'] === '0') {
            $data['is_discounted'] = true;
        } elseif (!isset($data['is_discounted'])) {
            $data['is_discounted'] = false;
        }

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('packages', 'public');
            $data['image_url'] = '/storage/' . $path;
        }
        else {
            $data['image_url'] = 'https://via.placeholder.com/150';
        }

        $variant = ProductVariant::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thêm biến thể thành công',
            'variant' => $variant
        ], 201);
    }


    public function updateVariant(Request $request, Product $product, ProductVariant $variant)
    {
        // Bảo vệ: variant phải thuộc về product này
        if ($variant->product_id !== $product->product_id) {
            return response()->json([
                'success' => false,
                'message' => 'Biến thể không thuộc sản phẩm này!'
            ], 403);
        }

        $validated = $request->validate([
            'color'           => 'required|string|max:50',
            'size'            => 'required|string|max:50',
            'price'           => 'required|numeric|min:0.01',
            'discount_price'  => 'nullable|numeric|min:0|lte:price',
            'stock'           => 'required|integer|min:0',
            'image_url'       => 'nullable|url:http,https|max:500',
            'status'          => 'required|in:active,inactive',
            'weight'          => 'nullable|numeric|min:0',
            'unit'            => 'nullable|string|max:20',
        ]);

        // Tự động bật/tắt is_discounted
        $validated['is_discounted'] = !empty($validated['discount_price']) || $validated['discount_price'] === 0;

        // Nếu xóa link ảnh → để mặc định
        if (empty($validated['image_url'])) {
            $validated['image_url'] = 'https://via.placeholder.com/400x400/cccccc/666666?text=No+Image';
        }

        $variant->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật biến thể thành công!',
            'variant' => $variant->fresh()
        ]);
    }

    // 3. DESTROY VARIANT – SẠCH + AN TOÀN
    public function destroyVariant(Product $product, ProductVariant $variant)
    {
        // Kiểm tra quyền sở hữu
        if ($variant->product_id !== $product->product_id) {
            return response()->json([
                'success' => false,
                'message' => 'Không có quyền xóa biến thể này!'
            ], 403);
        }

        $variant->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa biến thể thành công!'
        ]);
    }
}
