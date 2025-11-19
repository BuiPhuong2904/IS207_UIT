<?php

namespace App\Http\Controllers;

use App\Models\GymClass;
use Illuminate\Http\Request;


class ClassListController extends Controller
{
    // 1. Chỉ có index trả view
    public function index()
    {
        $classes = GymClass::select(
            'class_id',
            'class_name',
            'type',
            'max_capacity',
            'is_active',
            'image_url',
            'created_at'
        )
            ->latest('class_id')
            ->paginate(15); // hoặc get() nếu muốn load hết

        return view('admin.class_list', compact('classes'));
    }


    // 3. API: Tạo mới lớp
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name'    => 'required|string|max:255|unique:class,class_name',
            'type'          => 'required|string|max:100',
            'max_capacity'  => 'required|integer|min:1|max:100',
            'description'   => 'nullable|string',
            'is_active'     => 'required|boolean',
            'image_url'     => 'nullable|url|max:500',
        ]);

        $gymClass = GymClass::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thêm lớp học thành công!',
            'data'    => $gymClass
        ], 201);
    }

    // 4. API: Lấy chi tiết 1 lớp
    public function show(GymClass $gymClass)
    {

        return response()->json([
            'success' => true,
            'data'    => $gymClass
        ]);
    }

    // 5. API: Cập nhật lớp
    public function update(Request $request, GymClass $gymClass)
    {
        $validated = $request->validate([
            'class_name'    => 'required|string|max:255|unique:class,class_name,' . $gymClass->class_id . ',class_id',
            'type'          => 'required|string|max:100',
            'max_capacity'  => 'required|integer|min:1|max:100',
            'description'   => 'nullable|string',
            'is_active'     => 'required|boolean',
            'image_url'     => 'nullable|url|max:500',
        ]);

        $gymClass->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật lớp học thành công!',
            'data'    => $gymClass->fresh()
        ]);
    }

    // 6. API: Xóa lớp (kiểm tra nếu đang có lịch dạy thì không cho xóa)
    public function destroy(GymClass $gymClass)
    {
        // Kiểm tra nếu lớp này đang có lịch dạy → không cho xóa
        if ($gymClass->schedules()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa! Lớp này đang có lịch dạy.'
            ], 400);
        }

        $gymClass->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa lớp học thành công!'
        ]);
    }
}
