<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TrainerController extends Controller
{
    // 1. Lấy danh sách HLV
    public function index()
    {
        $trainers = Trainer::with(['user', 'branch'])->orderBy('user_id', 'asc')->paginate(10);
        $branches = Branch::all(['branch_id', 'branch_name']); 
        return view('admin.trainers', compact('trainers', 'branches'));
    }

    // 2. THÊM: Tạo User -> Tạo Trainer
    public function store(Request $request)
    {
        $request->validate([
            // User
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email|unique:user,email', 
            'password'     => 'required|string|min:6',
            'phone'        => 'nullable|string|max:15',
            'address'      => 'nullable|string',
            'gender'       => 'required|in:Nam,Nữ',
            
            'dob'          => 'nullable|date', 
            
            'image_file'   => 'nullable|image|max:2048',

            // Trainer
            'specialty'        => 'required|string|max:255',
            'experience_years' => 'required|integer|min:0',
            'salary'           => 'required|numeric|min:0',
            'work_schedule'    => 'nullable|string',
            'branch_id'        => 'required|exists:branch,branch_id',
        ]);

        DB::beginTransaction();

        try {            
            // Tạo User
            $userData = [
                'full_name' => $request->full_name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'phone'     => $request->phone,
                'address'   => $request->address,
                'gender'    => $request->gender,
                'birth_date'=> $request->dob, 
                'role'      => 'trainer',
                'status'    => 'active', 
            ];

            // Upload ảnh đại diện
            if ($request->hasFile('image_file')) {
                $path = $request->file('image_file')->store('avatars', 'public');
                $userData['image_url'] = '/storage/' . $path;
            } else {
                $userData['image_url'] = 'https://res.cloudinary.com/dna9qbejm/image/upload/v1762341321/ava_ntqezy.jpg';
            }

            $user = User::create($userData);

            // Tạo Trainer (Dùng ID của user vừa tạo)
            $trainer = Trainer::create([
                'user_id'          => $user->id, 
                'specialty'        => $request->specialty,
                'experience_years' => $request->experience_years,
                'salary'           => $request->salary,
                'work_schedule'    => $request->work_schedule,
                'branch_id'        => $request->branch_id,
                'status'           => 'active',
            ]);

            DB::commit(); // Lưu vào DB

            return response()->json([
                'success' => true,
                'message' => 'Thêm huấn luyện viên thành công!',
                'data'    => $trainer
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack(); 
            return response()->json([
                'success' => false, 
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 500);
        }
    }

    // 3. CẬP NHẬT (Cập nhật cả User và Trainer)
    public function update(Request $request, $id) 
    {
        // Tìm Trainer theo ID (ở đây $id là user_id)
        $trainer = Trainer::where('user_id', $id)->firstOrFail();
        $user = $trainer->user;

        $request->validate([
            // User
            'full_name'    => 'required|string|max:255',
            'email'        => ['required', 'email', Rule::unique('user', 'email')->ignore($user->id)],
            'gender'       => 'required|in:Nam,Nữ',
            
            'dob'          => 'nullable|date', 
            
            'image_file'   => 'nullable|image|max:2048',
            
            // Trainer
            'specialty'        => 'required|string',
            'experience_years' => 'required|integer',
            'salary'           => 'required|numeric',
            'branch_id'        => 'required|exists:branch,branch_id',
            'status'           => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {
            
            $userData = [
                'full_name' => $request->full_name,
                'email'     => $request->email,
                'phone'     => $request->phone,
                'address'   => $request->address,
                'gender'    => $request->gender,
                'birth_date'=> $request->dob,
            ];

            // Chỉ đổi pass nếu người dùng nhập vào
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            if ($request->hasFile('image_file')) {
                $path = $request->file('image_file')->store('avatars', 'public');
                $userData['image_url'] = '/storage/' . $path;
            }

            $user->update($userData);

            // Update Trainer
            $trainer->update([
                'specialty'        => $request->specialty,
                'experience_years' => $request->experience_years,
                'salary'           => $request->salary,
                'work_schedule'    => $request->work_schedule,
                'branch_id'        => $request->branch_id,
                'status'           => $request->status,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Cập nhật thành công!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    // 4. XÓA 
    public function destroy($id)
    {
        $trainer = Trainer::where('user_id', $id)->firstOrFail();
        $user = $trainer->user;

        // Kiểm tra ràng buộc: Nếu HLV đang có lớp dạy thì không cho xóa
        if ($trainer->classSchedule()->exists()) {
             return response()->json(['success' => false, 'message' => 'Không thể xóa! HLV này đang có lịch dạy.'], 400);
        }

        DB::transaction(function () use ($trainer, $user) {
            $trainer->delete();
            $user->delete();
        });

        return response()->json([
            'success' => true, 
            'message' => 'Xóa huấn luyện viên thành công!'
        ]);
    }
}