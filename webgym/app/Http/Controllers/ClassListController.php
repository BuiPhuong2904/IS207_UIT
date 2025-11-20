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

        $class_list = GymClass::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thêm lớp học thành công!',
            'data'    => $class_list
        ], 201);
    }

    // 4. API: Lấy chi tiết 1 lớp
    public function show(GymClass $class_list)
    {

        return response()->json([
            'success' => true,
            'data'    => $class_list
        ]);
    }

    // 5. API: Cập nhật lớp
    public function update(Request $request, GymClass $class_list)
    {
        $validated = $request->validate([
            'class_name'    => 'required|string|max:255|unique:class,class_name,' . $class_list->class_id . ',class_id',
            'type'          => 'required|string|max:100',
            'max_capacity'  => 'required|integer|min:1|max:100',
            'description'   => 'nullable|string',
            'is_active'     => 'required|boolean',
            'image_url'     => 'nullable|url|max:500',
        ]);

        $class_list->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật lớp học thành công!',
            'data'    => $class_list->fresh()
        ]);
    }

    // 6. API: Xóa lớp (kiểm tra nếu đang có lịch dạy thì không cho xóa)
    public function destroy(GymClass $class_list)
    {
        // Kiểm tra nếu lớp này đang có lịch dạy → không cho xóa
        if ($class_list->schedules()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa! Lớp này đang có lịch dạy.'
            ], 400);
        }

        $class_list->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa lớp học thành công!'
        ]);
    }
}
