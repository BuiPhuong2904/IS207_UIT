<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TrainerController extends Controller
{
    public function index()
    {
        $trainers = Trainer::with(['user', 'branch'])->latest()->paginate(20);
        $branches = Branch::all(['branch_id', 'branch_name']); // Lấy tất cả chi nhánh
        return view('admin.trainers', compact('trainers', 'branches'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'          => 'required|exists:user,id|unique:trainer,user_id',
            'specialty'        => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'salary'           => 'required|numeric|min:0',
            'work_schedule'    => 'nullable|string',
            'branch_id'        => 'required|exists:branch,branch_id',
            'status'           => 'required|in:active,inactive',
        ]);

        $trainer = Trainer::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Thêm huấn luyện viên thành công!',
            'data'    => $trainer
        ], 201);
    }

    public function show(Trainer $trainer)
    {
        $trainer->load(['user:id,full_name,email,phone,address,image_url', 'branch:branch_id,branch_name']);
        return response()->json([
            'success' => true,
            'data'    => $trainer
        ]);
    }

    public function update(Request $request, Trainer $trainer)
    {
        $validated = $request->validate([
            'specialty'        => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0|max:50',
            'salary'           => 'required|numeric|min:0',
            'work_schedule'    => 'nullable|string',
            'branch_id'        => 'required|exists:branch,branch_id',
            'status'           => 'required|in:active,inactive',
        ]);

        $trainer->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thành công!',
            'data'    => $trainer
        ]);
    }

    public function destroy(Trainer $trainer)
    {
        if ($trainer->classSchedule()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa! HLV này đang dạy lớp học.'
            ], 400);
        }

        $trainer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa huấn luyện viên thành công!'
        ]);
    }
}
