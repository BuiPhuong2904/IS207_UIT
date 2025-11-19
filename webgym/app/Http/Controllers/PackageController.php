<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipPackage;

class PackageController extends Controller
{
    public function index()
    {
        $packages = MembershipPackage::select(
            'package_id',
            'package_name',
            'description',
            'duration_months',
            'price',
            'slug',
            'image_url',
            'status',
            'is_featured',
            'created_at',
        )
        ->latest('package_id')
        ->paginate(15);
        return view('admin.packages', compact('packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_name' => 'required|string|max:255|unique:membership_package,package_name',
            'description'   => 'required|string|max:255',
            'duration_months'      => 'required|integer|min:1|max:100',
            'price' => 'required|numeric|min:0',
            'slug' => 'required|string|max:255|unique:membership_package,slug',
            'image_url' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'required|in:1,0',
        ]);

        $package = MembershipPackage::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thêm gói tâp thành công!',
            'data'    => $package
        ], 201);
    }


    public function show(MembershipPackage $package)
    {

        return response()->json([
            'success' => true,
            'data'    => $package
        ]);
    }

    public function update(Request $request, MembershipPackage $package)
    {
        $validated = $request->validate([
            'package_name' => 'required|string|max:255|unique:membership_package,package_name',
            'description'   => 'required|string|max:255',
            'duration_months'      => 'required|integer|min:1|max:100',
            'price' => 'required|numeric|min:0',
            'slug' => 'required|string|max:255|unique:membership_package,slug,'.$package->package_id.',package_id',
            'image_url' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'required|in:1,0',
        ]);

        $package->update($validated);

        return response()->json([
            'success' => true,
            'message' => ' Sửa gói tập thành công!',
            'data'    => $package
        ], 201);
    }

    public function destroy(MembershipPackage $package)
    {
        // Kiểm tra nếu lớp này đang có lịch dạy → không cho xóa
        if ($package->registrations()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa! Gói này đang có hội viên đăng ký.'
            ], 400);
        }

        $package->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa lớp học thành công!'
        ]);
    }
}
