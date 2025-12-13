<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalItem;
use App\Models\Branch;     
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RentalController extends Controller
{
    // 1. Danh sách (View chính)
    public function index()
    {
        // Lấy danh sách đồ thuê, kèm thông tin chi nhánh (eager loading)
        $rentals = RentalItem::with('branch')
            ->orderBy('item_id', 'desc')
            ->paginate(10);

        // Lấy danh sách chi nhánh để hiển thị trong Dropdown
        $branches = Branch::where('is_active', true)->get(); 

        return view('admin.rentals', compact('rentals', 'branches'));
    }

    // 2. Tạo mới (AJAX)
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'item_name'          => 'required|string|max:255',
            'rental_fee'         => 'required|numeric|min:0',
            'quantity_total'     => 'required|integer|min:1',
            'quantity_available' => 'required|integer|min:0|lte:quantity_total',
            'branch_id'          => 'nullable|exists:branch,branch_id',
            'description'        => 'nullable|string',
            'status'             => 'required|in:active,inactive',
            'image_url'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Xử lý upload ảnh
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('rentals', 'public');
            $data['image_url'] = '/storage/' . $path;
        } else {
            // Ảnh mặc định nếu không upload
            $data['image_url'] = 'https://res.cloudinary.com/dna9qbejm/image/upload/v1763142934/item_1_mw0d1r.png';
        }

        // Tạo mới
        $rental = RentalItem::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thêm đồ thuê thành công!',
            'data'    => $rental
        ], 201);
    }

    // 3. Lấy thông tin chi tiết (AJAX)
    public function show($id)
    {
        $rental = RentalItem::findOrFail($id);
        return response()->json([
            'success' => true,
            'data'    => $rental
        ]);
    }

    // 4. Cập nhật (AJAX)
    public function update(Request $request, $id)
    {
        $rental = RentalItem::findOrFail($id);

        $request->validate([
            'item_name'          => 'required|string|max:255',
            'rental_fee'         => 'required|numeric|min:0',
            'quantity_total'     => 'required|integer|min:1',
            'quantity_available' => 'required|integer|min:0|lte:quantity_total',
            'branch_id'          => 'nullable|exists:branch,branch_id',
            'status'             => 'required|in:active,inactive',
            'image_url'          => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Lấy data ngoại trừ ảnh (xử lý riêng)
        $data = $request->except(['image_url']);

        // Xử lý upload ảnh mới
        if ($request->hasFile('image_url')) {
            // Xóa ảnh cũ nếu không phải ảnh mặc định
            // if ($rental->image_url && file_exists(public_path($rental->image_url))) { ... }

            $path = $request->file('image_url')->store('rentals', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $rental->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật đồ thuê thành công!',
            'data'    => $rental
        ]);
    }

    // 5. Xóa (AJAX)
    public function destroy($id)
    {
        $rental = RentalItem::findOrFail($id);

        // Kiểm tra xem món đồ này có đang trong giao dịch thuê chưa trả không?
        if ($rental->transactions()->where('status', 'renting')->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa! Đồ này đang có người thuê.'
            ], 400);
        }

        $rental->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa đồ thuê thành công!'
        ]);
    }
}