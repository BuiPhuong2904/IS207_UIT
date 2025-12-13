<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User; // Import Model User
use Illuminate\Http\Request;

class BranchController extends Controller
{
    // List Branches
    public function index()
    {
        // 1. Lấy danh sách chi nhánh, eager load 'manager' để hiển thị tên quản lý
        $branches = Branch::with('manager')
                          ->orderBy('branch_id', 'desc')
                          ->paginate(10);

        // 2. Lấy danh sách User để hiển thị trong Dropdown "Chọn quản lý"
        $managers = User::select('id', 'full_name')->where('role', 'admin')->get(); 

        return view('admin.branches', compact('branches', 'managers'));
    }

    // Create Branch
    public function store(Request $request)
    {
        // Validate dữ liệu từ AJAX gửi lên
        $request->validate([
            'branch_name' => 'required|string|max:255',
            'address'     => 'required|string',
            'phone'       => 'nullable|string|max:20',
            'manager_id'  => 'nullable|exists:user,id', 
            'is_active'   => 'boolean'
        ]);

        // Tạo mới
        Branch::create([
            'branch_name' => $request->branch_name,
            'address'     => $request->address,
            'phone'       => $request->phone,
            'manager_id'  => $request->manager_id,
            'is_active'   => $request->input('is_active', true),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thêm chi nhánh thành công!'
        ]);
    }

    // Update Branch
    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);

        $request->validate([
            'branch_name' => 'required|string|max:255',
            'address'     => 'required|string',
            'phone'       => 'nullable|string|max:20',
            'manager_id'  => 'nullable|exists:user,id',
            'is_active'   => 'required'
        ]);

        $branch->update([
            'branch_name' => $request->branch_name,
            'address'     => $request->address,
            'phone'       => $request->phone,
            'manager_id'  => $request->manager_id,
            'is_active'   => (bool)$request->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thành công!'
        ]);
    }

    // Delete Branch
    public function destroy($id)
    {
        $branch = Branch::findOrFail($id);
        
        // Kiểm tra xem chi nhánh có HLV không trước khi xóa
        if($branch->trainers()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Không thể xóa chi nhánh đang có HLV!'], 400);
        }

        $branch->delete();

        return response()->json([
            'success' => true, 
            'message' => 'Đã xóa chi nhánh!'
        ]);
    }
}