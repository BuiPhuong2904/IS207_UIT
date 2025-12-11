<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PromotionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Chỉ admin đăng nhập mới vào
    }

    // Trang danh sách khuyến mãi
    public function index()
    {
        $promotions = Promotion::orderByDesc('promotion_id')->paginate(15);
        return view('admin.promotions', compact('promotions'));
    }

    // API: Lấy 1 khuyến mãi để edit
    public function show($id)
    {
        $promotion = Promotion::findOrFail($id);
        return response()->json([
            'promotion_id' => $promotion->promotion_id,
            'code' => $promotion->code,
            'title' => $promotion->title,
            'description' => $promotion->description,
            'discount_value' => $promotion->discount_value,
            'is_percent' => $promotion->is_percent,
            'start_date' => $promotion->start_date?->format('Y-m-d'),
            'end_date' => $promotion->end_date?->format('Y-m-d'),
            'min_order_amount' => $promotion->min_order_amount,
            'max_discount' => $promotion->max_discount,
            'usage_limit' => $promotion->usage_limit,
            'per_user_limit' => $promotion->per_user_limit,
            'is_active' => $promotion->is_active,
        ]);
    }

    // Thêm mới
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:promotion,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_value' => 'required|numeric|min:0',
            'is_percent' => 'required|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'per_user_limit' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['code'] = strtoupper($data['code']); // Chuẩn hóa code

        $promotion = Promotion::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thêm khuyến mãi thành công!',
            'promotion' => $promotion
        ]);
    }

    // Cập nhật
    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:promotion,code,' . $id . ',promotion_id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_value' => 'required|numeric|min:0',
            'is_percent' => 'required|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:0',
            'per_user_limit' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();
        $data['code'] = strtoupper($data['code']);

        $promotion->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thành công!'
        ]);
    }

    // Xóa
    public function destroy($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->targets()->delete(); // Xóa targets liên quan
        $promotion->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa khuyến mãi thành công!'
        ]);
    }
}
