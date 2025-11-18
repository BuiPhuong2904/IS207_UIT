<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductVariant;
use App\Http\Requests\ProductStoreRequest; // Nếu dùng FormRequest, thay bằng $request->validated()
use Illuminate\Validation\Rule;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.store');
    }

    // Create: Trả về form data rỗng cho modal (JSON)
    public function create(Request $request)
    {
        $categories = ProductCategory::pluck('category_name', 'category_id')->toArray();

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'form_data' => [
                    'product_name' => '',
                    'description' => '',
                    'image_url' => '',
                    'slug' => '',
                    'category_id' => '',
                    'brand' => '',
                    'origin' => '',
                    'status' => 'active',
                    'variants' => []  // Mảng rỗng để JS thêm
                ],
                'categories' => $categories
            ], 200);
        }
    }

    // Store: Tạo sản phẩm + variants (JSON luôn), cái này dùng để tạo product nè
    public function store(Request $request)
    {
        // Validation (nếu không dùng FormRequest, dùng Validator)
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|url',
            'slug' => 'required|string|unique:product,slug|max:255',
            'category_id' => 'required|exists:product_category,category_id',
            'brand' => 'nullable|string|max:100',
            'origin' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'variants' => 'array',
            'variants.*.color' => 'required|string',
            'variants.*.size' => 'required|string',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            // ... thêm rules cho variants khác nếu cần
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::create($request->only([
            'product_name', 'description', 'image_url', 'slug', 'category_id', 'brand', 'origin', 'status'
        ]));

        // Tạo variants nếu có
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                $product->variants()->create($variantData);
            }
        }

        // Load relations để return full data
        $product->load(['category', 'variants']);

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được tạo!',
            'product' => $product
        ], 201);
    }

    // Show: Chi tiết (JSON như trước), hiển thị product theo id
    public function show(Request $request, $id)
    {
        $product = Product::with(['category', 'variants'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'product' => $product
        ], 200);
    }

    // Edit: Trả về data hiện tại cho modal edit (JSON)
    public function edit(Request $request, $id)
    {
        $product = Product::with('variants')->findOrFail($id);
        $categories = ProductCategory::pluck('category_name', 'category_id')->toArray();

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'success' => true,
                'form_data' => $product->toArray(),  // Full data để populate form
                'categories' => $categories,
                'variants' => $product->variants->toArray()  // Mảng variants để edit
            ], 200);
        }

    }

    // Update: Cập nhật + sync variants (JSON luôn)
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validation với Rule::unique để specify primary key 'product_id'
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|url',
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('product')->ignore($id, 'product_id')  // Fix: Ignore bằng product_id
            ],
            'category_id' => 'required|exists:product_category,category_id',
            'brand' => 'nullable|string|max:100',
            'origin' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
            'variants' => 'array',
            'variants.*.color' => 'required|string',
            'variants.*.size' => 'required|string',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            // ... rules variants khác
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Phần còn lại giữ nguyên (update product, sync variants, return JSON)
        $product->update($request->only([
            'product_name', 'description', 'image_url', 'slug', 'category_id', 'brand', 'origin', 'status'
        ]));

        $product->variants()->delete();
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                $product->variants()->create($variantData);
            }
        }

        $product->fresh()->load(['category', 'variants']);

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được cập nhật!',
            'product' => $product
        ], 200);
    }

    // Destroy: Xóa (JSON luôn)
    public function destroy(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->variants()->delete();
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được xóa!'
        ], 200);
    }

    // Variant: Store variant cho product
    public function storeVariant(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'color' => 'required|string',
            'size' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|lt:price',
            'is_discounted' => 'boolean',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
            'status' => 'in:active,inactive',
            'weight' => 'nullable|numeric',
            'unit' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::findOrFail($productId);
        $variant = $product->variants()->create($request->only([
            'color', 'size', 'price', 'discount_price', 'is_discounted', 'stock',
            'image_url', 'status', 'weight', 'unit'
        ]));

        return response()->json(['success' => true, 'variant' => $variant]);
    }

    // Variant: Update
    public function updateVariant(Request $request, $productId, $variantId)
    {
        // Validation giống storeVariant
        $validator = Validator::make($request->all(), [
            'color' => 'required|string',
            'size' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|lt:price',
            'is_discounted' => 'boolean',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url',
            'status' => 'in:active,inactive',
            'weight' => 'nullable|numeric',
            'unit' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::findOrFail($productId);
        $variant = $product->variants()->findOrFail($variantId);
        $variant->update($request->only([
            'color', 'size', 'price', 'discount_price', 'is_discounted', 'stock',
            'image_url', 'status', 'weight', 'unit'
        ]));

        return response()->json(['success' => true, 'variant' => $variant]);
    }

    // Variant: Destroy
    public function destroyVariant($productId, $variantId)
    {
        $product = Product::findOrFail($productId);
        $product->variants()->findOrFail($variantId)->delete();
        return response()->json(['success' => true]);
    }
}
