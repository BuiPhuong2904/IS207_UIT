<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductVariant;

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

    // 2. CREATE - Trả form data rỗng cho modal thêm
    public function create(Request $request)
    {
        $categories = ProductCategory::pluck('category_name', 'category_id')->toArray();

        return response()->json([
            'success' => true,
            'form_data' => [
                'product_name'  => '',
                'description'   => '',
                'image_url'     => '',
                'slug'          => '',
                'category_id'   => '',
                'brand'         => '',
                'origin'        => '',
                'status'        => 'active',
                'variants'      => []
            ],
            'categories' => $categories
        ]);
    }

    // 3. STORE - Thêm sản phẩm mới + variants
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'description'  => 'required|string',
            'image_url'    => 'nullable|url',
            'slug'         => 'required|string|unique:product,slug|max:255',
            'category_id'  => 'required|exists:product_category,category_id',
            'brand'        => 'nullable|string|max:100',
            'origin'       => 'nullable|string|max:100',
            'status'       => 'required|in:active,inactive',
            'variants'     => 'array',
            'variants.*.color'  => 'required|string|max:50',
            'variants.*.size'   => 'required|string|max:50',
            'variants.*.price'  => 'required|numeric|min:0',
            'variants.*.discount_price' => 'nullable|numeric|lte:variants.*.price',
            'variants.*.is_discounted'  => 'sometimes|boolean',
            'variants.*.stock'  => 'required|integer|min:0',
            'variants.*.image_url' => 'nullable|url',
            'variants.*.status' => 'required|in:active,inactive',
            'variants.*.weight' => 'nullable|numeric',
            'variants.*.unit'   => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::create($request->only([
            'product_name', 'description', 'image_url', 'slug',
            'category_id', 'brand', 'origin', 'status'
        ]));

        if ($request->has('variants') && count($request->variants) > 0) {
            foreach ($request->variants as $variant) {
                $product->variants()->create($variant);
            }
        }

        $product->load(['category', 'variants']);

        return response()->json([
            'success' => true,
            'message' => 'Thêm sản phẩm thành công!',
            'product' => $product
        ], 201);
    }

    // 4. EDIT - Lấy dữ liệu sản phẩm để sửa
    public function edit(Product $product)
    {
        $product->load('variants');
        $categories = ProductCategory::pluck('category_name', 'category_id')->toArray();

        return response()->json([
            'success' => true,
            'form_data' => $product,
            'categories' => $categories,
            'variants' => $product->variants
        ]);
    }

    // 5. UPDATE - Cập nhật sản phẩm + sync variants
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'description'  => 'required|string',
            'image_url'    => 'nullable|url',
            'slug'         => ['required', 'string', 'max:255', Rule::unique('product')->ignore($product->product_id, 'product_id')],
            'category_id'  => 'required|exists:product_category,category_id',
            'brand'        => 'nullable|string|max:100',
            'origin'       => 'nullable|string|max:100',
            'status'       => 'required|in:active,inactive',
            'variants'     => 'array',
            'variants.*.color'  => 'required|string|max:50',
            'variants.*.size'   => 'required|string|max:50',
            'variants.*.price'  => 'required|numeric|min:0',
            'variants.*.discount_price' => 'nullable|numeric|lte:variants.*.price',
            'variants.*.is_discounted'  => 'sometimes|boolean',
            'variants.*.stock'  => 'required|integer|min:0',
            'variants.*.image_url' => 'nullable|url',
            'variants.*.status' => 'required|in:active,inactive',
            'variants.*.weight' => 'nullable|numeric',
            'variants.*.unit'   => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product->update($request->only([
            'product_name', 'description', 'image_url', 'slug',
            'category_id', 'brand', 'origin', 'status'
        ]));

        // Sync variants: xóa cũ, tạo mới
        $product->variants()->delete();
        if ($request->has('variants') && count($request->variants) > 0) {
            foreach ($request->variants as $variant) {
                $product->variants()->create($variant);
            }
        }

        $product->load(['category', 'variants']);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật sản phẩm thành công!',
            'product' => $product
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
        $request->validate([
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

        $variant = $product->variants()->create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Thêm biến thể thành công',
            'variant' => $variant
        ], 201);
    }

    // 9. API sửa variant
    public function updateVariant(Request $request, Product $product, ProductVariant $variant)
    {
        if ($variant->product_id !== $product->product_id) {
            return response()->json(['success' => false, 'message' => 'Không hợp lệ'], 403);
        }

        $request->validate([
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

        $variant->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật biến thể thành công',
            'variant' => $variant->fresh()
        ]);
    }

    // 10. API xóa variant
    public function destroyVariant(Product $product, ProductVariant $variant)
    {
        if ($variant->product_id !== $product->product_id) {
            return response()->json(['success' => false, 'message' => 'Không hợp lệ'], 403);
        }

        $variant->delete();

        return response()->json(['success' => true, 'message' => 'Xóa biến thể thành công']);
    }
}
