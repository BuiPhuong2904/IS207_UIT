<?php

namespace App\Http\Controllers;

use App\Models\GymClass;
use Illuminate\Http\Request;


class ClassListController extends Controller
{
    // Trả về View danh sách
    public function index()
    {
        // Lấy danh sách lớp
        $classes = GymClass::select(
            'class_id',
            'class_name',
            'type',
            'max_capacity',
            'description',
            'is_active',
            'image_url',
            'created_at'
        )
        ->orderBy('class_id', 'asc')
        ->paginate(10);

        // Lấy danh sách TYPES từ Model để truyền sang View cho Dropdown
        $types = GymClass::TYPES; 

        // Truyền cả $classes và $types sang View
        return view('admin.class_list', compact('classes', 'types'));
    }

    // API: Tạo mới lớp
    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_name'    => 'required|string|max:255|unique:class,class_name',
            'type'          => 'required|string|max:100',
            'max_capacity'  => 'required|integer|min:1|max:100',
            'description'   => 'nullable|string',
            'is_active'     => 'required|boolean',

        ]);

        $data = $request->all();

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('packages', 'public');
            $data['image_url'] = '/storage/' . $path;
        } else {
            $data['image_url'] = 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762341321/ava_ntqezy.jpg';
        }

        $class_list = GymClass::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thêm lớp học thành công!',
            'data'    => $class_list
        ], 201);
    }

    // API: Lấy chi tiết 1 lớp
    public function show(GymClass $class_list)
    {
        return response()->json([
            'success' => true,
            'data'    => $class_list
        ]);
    }

    // API: Cập nhật lớp
    public function update(Request $request, GymClass $class_list)
    {
        $validated = $request->validate([
            'class_name'    => 'required|string|max:255|unique:class,class_name,' . $class_list->class_id . ',class_id',
            'type'          => 'required|string|max:100',
            'max_capacity'  => 'required|integer|min:1|max:100',
            'description'   => 'nullable|string',
            'is_active'     => 'required|boolean',
            'image_url'     => 'nullable',
        ]);

        // Xử lý logic Upload ảnh mới 
        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('packages', 'public');
            $validated['image_url'] = '/storage/' . $path; 
        } else {
            unset($validated['image_url']); 
        }

        $class_list->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật lớp học thành công!',
            'data'    => $class_list->fresh()
        ]);
    }

    // API: Xóa lớp (kiểm tra nếu đang có lịch dạy thì không cho xóa)
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
