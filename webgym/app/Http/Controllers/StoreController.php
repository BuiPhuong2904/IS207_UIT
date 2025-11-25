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
    // 1. INDEX - Load danh sách sản phẩm
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

        $products = $query->orderBy('product_id', 'asc')->paginate(10);

        $categories = ProductCategory::pluck('category_name', 'category_id')->toArray();
        $statuses   = ['active' => 'Còn hàng', 'inactive' => 'Hết hàng'];
        $variant_promos = ['Có', 'Không'];

        // Nếu gọi từ AJAX/JS → trả JSON
        if ($request->ajax() || $request->expectsJson()) {
            return view('admin.partials.product_table', compact('products', 'categories', 'statuses'))->render();
        }

        return view('admin.store', compact('products', 'categories', 'statuses', 'variant_promos'));
    }

    // 2. STORE - Thêm sản phẩm mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|unique:product,product_name',
            'description'  => 'required|string',
            'category_id'  => 'required|exists:product_category,category_id',
            'brand'        => 'nullable|string|max:100',
            'origin'       => 'nullable|string|max:100',
            'status'       => 'required|in:active,inactive',
            
            'image_url'    => 'nullable|image|max:5120', 
        ]);

        $validated['slug'] = Str::slug($request->product_name);

        // Xử lý ảnh sản phẩm chính
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('products', 'public');
            $validated['image_url'] = '/storage/' . $path;
        } else {
            
            $validated['image_url'] = $request->input('default_image_url', 'https://via.placeholder.com/150');
        }
        
        unset($validated['default_image_url']);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thêm sản phẩm thành công!',
            'product' => $product
        ], 201);
    }

    // 3. UPDATE - Cập nhật sản phẩm
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255|unique:product,product_name,' . $product->product_id . ',product_id',
            'description'  => 'required|string',
            'category_id'  => 'required|exists:product_category,category_id',
            'brand'        => 'nullable|string|max:100',
            'origin'       => 'nullable|string|max:100',
            'status'       => 'required|in:active,inactive',
            'image_url'    => 'nullable', 
        ]);

        $validated['slug'] = Str::slug($request->product_name);

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('products', 'public');
            $validated['image_url'] = '/storage/' . $path;
        } else {
            
            unset($validated['image_url']);
        }

        $product->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật sản phẩm thành công!',
            'product' => $product->fresh()->load('variants')
        ]);
    }

    // 4. DESTROY - Xóa sản phẩm
    public function destroy(Product $product)
    {
        $product->variants()->delete();
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa sản phẩm thành công!'
        ]);
    }

    // 5. API lấy variants
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

    // 6. STORE VARIANT - Thêm biến thể mới 
    public function storeVariant(Request $request, Product $product)
    {
        $validated = $request->validate([
            'color'          => 'required|string|max:50',
            'size'           => 'required|string|max:50',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|lte:price',
            'stock'          => 'required|integer|min:0',
            'status'         => 'required|in:active,inactive',
            'weight'         => 'nullable|numeric',
            'unit'           => 'nullable|string|max:20',
            // Chấp nhận cả file ảnh (image_file) và link ảnh (image_url)
            'image_file'     => 'nullable|image|max:5120', 
            'image_url'      => 'nullable|string',
        ]);

        $data = $validated;
        $data['product_id'] = $product->product_id;

        // Xử lý logic giảm giá
        $data['is_discounted'] = (!empty($data['discount_price']) && $data['discount_price'] > 0);

        // Nếu có file upload (image_file)
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('variants', 'public');
            $data['image_url'] = '/storage/' . $path;
        } 
        // Nếu không có file, dùng link ảnh gửi kèm (image_url) nếu có
        elseif (empty($data['image_url'])) {
            // Fallback: Nếu cả 2 đều không có -> dùng ảnh placeholder
            $data['image_url'] = 'https://via.placeholder.com/150';
        }

        // Loại bỏ trường 'image_file' vì trong DB không có 
        unset($data['image_file']);

        $variant = ProductVariant::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thêm biến thể thành công',
            'variant' => $variant
        ], 201);
    }

    // 7. UPDATE VARIANT - Cập nhật biến thể 
    public function updateVariant(Request $request, Product $product, ProductVariant $variant)
    {
        if ($variant->product_id !== $product->product_id) {
            return response()->json(['success' => false, 'message' => 'Sai thông tin sản phẩm!'], 403);
        }

        $validated = $request->validate([
            'color'          => 'required|string|max:50',
            'size'           => 'required|string|max:50',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lte:price',
            'stock'          => 'required|integer|min:0',
            'status'         => 'required|in:active,inactive',
            'weight'         => 'nullable|numeric|min:0',
            'unit'           => 'nullable|string|max:20',
            // Chấp nhận cả file ảnh (image_file) và link ảnh (image_url)
            'image_file'     => 'nullable|image|max:5120', 
            'image_url'      => 'nullable|string',
        ]);

        // Tự động bật/tắt is_discounted
        $validated['is_discounted'] = (!empty($validated['discount_price']) && $validated['discount_price'] > 0);

        // Nếu có file mới được upload
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('variants', 'public');
            $validated['image_url'] = '/storage/' . $path;
        } 
        elseif (empty($validated['image_url'])) {
            unset($validated['image_url']);
        }

        // Loại bỏ trường thừa trước khi update
        unset($validated['image_file']);

        $variant->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật biến thể thành công!',
            'variant' => $variant->fresh()
        ]);
    }

    // 8. DESTROY VARIANT
    public function destroyVariant(Product $product, ProductVariant $variant)
    {
        if ($variant->product_id !== $product->product_id) {
            return response()->json(['success' => false, 'message' => 'Không có quyền xóa!'], 403);
        }

        $variant->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa biến thể thành công!'
        ]);
    }
}