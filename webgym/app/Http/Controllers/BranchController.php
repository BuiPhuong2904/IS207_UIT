<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with('manager')->paginate(10);
        return view('admin.branches', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'manager_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        Branch::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thêm chi nhánh thành công'
        ]);
    }

    public function show(Branch $branch)
    {
        $branch->load('manager');
        return response()->json($branch);
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate([
            'branch_name' => 'required|string|max: 255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'manager_id' => 'nullable|exists:users,id',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $branch->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật chi nhánh thành công'
        ]);
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa chi nhánh thành công'
        ]);
    }
}