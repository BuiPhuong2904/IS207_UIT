<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipPackage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
        ->orderBy('package_id', 'asc') // Sắp xếp tăng dần (1 -> 10)
        ->paginate(15);
                
        return view('admin.packages', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string|max:255|unique:membership_package,package_name',
            'description'   => 'required|string|max:255',
            'duration_months' => 'nullable|integer|min:1|max:100',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
            'is_featured' => 'required', 
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->package_name);
        $data['is_featured'] = filter_var($request->is_featured, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('packages', 'public');
            $data['image_url'] = '/storage/' . $path;
        } else {
            $data['image_url'] = 'https://via.placeholder.com/150';
        }

        $package = MembershipPackage::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Thêm gói tập thành công!',
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
        $request->validate([
            'package_name' => 'required|string|max:255|unique:membership_package,package_name,'.$package->package_id.',package_id',
            'description'   => 'required|string|max:255',
            
            'duration_months' => 'nullable|integer|min:1|max:100', 
            
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->except(['image_url']);
        $data['slug'] = Str::slug($request->package_name);
        $data['is_featured'] = filter_var($request->is_featured, FILTER_VALIDATE_BOOLEAN) ? 1 : 0;

        if ($request->hasFile('image_url')) {
            $path = $request->file('image_url')->store('packages', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $package->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Sửa gói tập thành công!',
            'data'    => $package
        ], 201);
    }

    public function destroy(MembershipPackage $package)
    {
        if ($package->registrations()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa! Gói này đang có hội viên đăng ký.'
            ], 400);
        }
        $package->delete();
        return response()->json(['success' => true, 'message' => 'Xóa thành công!']);
    }
}