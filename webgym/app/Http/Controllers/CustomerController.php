<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    // 1. Lấy danh sách Khách hàng
    public function index()
    {
        $customers = User::where('role', 'member')
                        ->orderBy('id', 'asc')
                        ->paginate(10);

        return view('admin.customers', compact('customers'));
    }

    // 2. THÊM MỚI (AJAX)
    public function store(Request $request)
    {
        $request->validate([
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email|unique:user,email', 
            'password'     => 'required|string|min:6',
            'phone'        => 'nullable|string|max:15',
            'address'      => 'nullable|string',
            'gender'       => 'required|in:Nam,Nữ,Khác',
            'birth_date'   => 'nullable|date',
            'image'        => 'nullable|image|max:2048', 
        ]);

        DB::beginTransaction();

        try {
            $userData = [
                'full_name'  => $request->full_name,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'phone'      => $request->phone,
                'address'    => $request->address,
                'gender'     => $request->gender,
                'birth_date' => $request->birth_date,
                'role'       => 'member',
                'status'     => 'active',
            ];

            // Upload ảnh đại diện
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('users', 'public');
                $userData['image_url'] = '/storage/' . $path;
            } else {
                // Ảnh mặc định nếu không upload
                $userData['image_url'] = 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762341321/ava_ntqezy.jpg';
            }

            $user = User::create($userData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Thêm khách hàng thành công!',
                'data'    => $user
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    // 3. CẬP NHẬT (AJAX)
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->where('role', 'member')->firstOrFail();

        $request->validate([
            'full_name'    => 'required|string|max:255',
            'email'        => ['required', 'email', Rule::unique('user', 'email')->ignore($user->id)],
            'phone'        => 'nullable|string|max:15',
            'address'      => 'nullable|string',
            'gender'       => 'required|in:Nam,Nữ,Khác',
            'birth_date'   => 'nullable|date',
            'status'       => 'required|in:active,inactive',
            'image'        => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $userData = [
                'full_name'  => $request->full_name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'address'    => $request->address,
                'gender'     => $request->gender,
                'birth_date' => $request->birth_date,
                'status'     => $request->status,
            ];

            // Chỉ cập nhật mật khẩu nếu người dùng nhập vào
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            // Xử lý upload ảnh mới
            if ($request->hasFile('image')) {
                // Xóa ảnh cũ nếu không phải ảnh mặc định (tùy chọn)
                // if ($user->image_url && !str_contains($user->image_url, 'cloudinary')) { ... }

                $path = $request->file('image')->store('users', 'public');
                $userData['image_url'] = '/storage/' . $path;
            }

            $user->update($userData);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Cập nhật thành công!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    // 4. XÓA (AJAX)
    public function destroy($id)
    {
        $user = User::where('id', $id)->where('role', 'member')->firstOrFail();

        // Kiểm tra ràng buộc dữ liệu (Ví dụ: Đã mua gói tập, đang có đơn hàng, v.v...)
        // if ($user->orders()->exists() || $user->bookings()->exists()) {
        //      return response()->json(['success' => false, 'message' => 'Không thể xóa! Khách hàng này đang có dữ liệu giao dịch.'], 400);
        // }

        try {
            $user->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Xóa khách hàng thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()], 500);
        }
    }
}