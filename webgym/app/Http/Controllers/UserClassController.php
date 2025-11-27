<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\GymClass;
use App\Models\ClassRegistration;
use App\Models\ClassSchedule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserClassController extends Controller
{
    public function index()
    {
        $classes = GymClass::where('is_active', true)->get();

        return view('user.class', [
            'classes' => $classes
        ]);
    }

    /**
     * Hiển thị danh sách các lớp học user ĐÃ ĐĂNG KÝ
     */
    public function myClasses()
    {
        $userId = Auth::id();

        // 1. Lấy danh sách đăng ký của user
        $registrations = ClassRegistration::where('user_id', $userId)
            ->with(['schedule.gymClass', 'schedule.branch']) 
            ->orderBy('created_at', 'desc')
            ->get();

        // 2. Map dữ liệu để khớp với giao diện Frontend
        $classes = $registrations->map(function($reg) {
            $schedule = $reg->schedule;
            
            // Nếu lịch bị xóa, bỏ qua 
            if (!$schedule) return null;

            $statusLabel = '';
            switch ($reg->status) {
                case 'registered': $statusLabel = 'Đã đăng ký'; break;
                case 'attended':   $statusLabel = 'Hoàn thành'; break;
                case 'cancelled':  $statusLabel = 'Đã hủy'; break;
                default: $statusLabel = 'Không xác định';
            }
            
            $statusCode = ($reg->status === 'attended') ? 'completed' : $reg->status;

            return [
                'name'   => $schedule->gymClass->class_name ?? 'Lớp học',
                'time'   => Carbon::parse($schedule->start_time)->format('H:i') . ' - ' . Carbon::parse($schedule->end_time)->format('H:i'),
                'date'   => Carbon::parse($schedule->study_date)->format('d/m/Y'), 
                'room'   => $schedule->room,
                'branch' => $schedule->branch->branch_name ?? 'N/A',
                'status' => $statusCode, 
                'status_label' => $statusLabel
            ];
        })->filter(); // Loại bỏ null

        // 3. Tính toán số lượng cho biến $counts 
        $counts = [
            'registered' => $classes->where('status', 'registered')->count(),
            'completed'  => $classes->where('status', 'completed')->count(),
            'cancelled'  => $classes->where('status', 'cancelled')->count(),
        ];

        // 4. Trả về View
        return view('user.my_classes', [
            'classes' => $classes,
            'counts' => $counts
        ]);
    }

    public function booking(Request $request, $id)
    {
        // 1. Lấy thông tin lớp học đang chọn
        $gymClass = GymClass::findOrFail($id);

        // 2. Lấy chi nhánh đang chọn từ URL (nếu có)
        $selectedBranch = $request->input('branch');

        // Xác định tuần hiện tại 
        $startOfWeek = Carbon::now()->startOfWeek(); 
        $endOfWeek = $startOfWeek->copy()->endOfWeek();

        // 3. Query lịch học của lớp này
        $schedulesQuery = ClassSchedule::where('class_id', $id)
            ->whereIn('status', ['scheduled', 'completed'])
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->with(['branch', 'trainer.user']); // Eager load để tránh N+1 query

        $allSchedules = $schedulesQuery->orderBy('date')->orderBy('start_time')->get();

        // 4. Lấy danh sách các chi nhánh có lịch của lớp này (để tạo Dropdown)
        $allBranches = $allSchedules->pluck('branch.branch_name')->unique()->values();

        // 5. Nếu chưa chọn chi nhánh, mặc định lấy chi nhánh đầu tiên trong danh sách
        if (!$selectedBranch && $allBranches->isNotEmpty()) {
            $selectedBranch = $allBranches->first();
        }

        // 6. Lọc lịch học theo chi nhánh đã chọn
        $filteredSchedules = $allSchedules->filter(function ($item) use ($selectedBranch) {
            return $item->branch->branch_name === $selectedBranch;
        });

        // 7. Format dữ liệu để nhóm theo Ngày (Thứ 2, Thứ 3...)
        $formattedData = $filteredSchedules->map(function ($schedule) {
            $date = Carbon::parse($schedule->date);
            // Tạo nhãn ngày: "Thứ 2 (20/11)"
            $dayMap = ['Chủ Nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];
            $dayLabel = $dayMap[$date->dayOfWeek] . ' (' . $date->format('d/m') . ')';

            return (object)[
                'id' => $schedule->schedule_id,
                'day_label' => $dayLabel,
                'start_time' => Carbon::parse($schedule->start_time)->format('H:i'),
                'end_time' => Carbon::parse($schedule->end_time)->format('H:i'),
                'trainer_name' => $schedule->trainer->user->full_name ?? 'Đang cập nhật',
                'branch' => $schedule->branch->branch_name ?? 'N/A',
                'room' => $schedule->room
            ];
        });

        // Nhóm lại theo nhãn ngày
        $groupedSchedules = $formattedData->groupBy('day_label');
        
        $weekDays = collect();
        $loopDate = $startOfWeek->copy(); 

        $dayMap = ['Chủ Nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];

        for ($i = 0; $i < 7; $i++) {
            // Tính ngày: Bắt đầu từ Thứ 2 + i ngày
            $date = $loopDate->copy()->addDays($i);
            
            // Format nhãn: Thứ X (dd/mm)
            $label = $dayMap[$date->dayOfWeek] . ' (' . $date->format('d/m') . ')';
            
            $weekDays->push($label);
        }

        return view('user.class_booking', compact(
            'gymClass', 
            'allBranches', 
            'selectedBranch', 
            'groupedSchedules', 
            'weekDays'
        ));
    }
    
    // Hàm xử lý lưu đăng ký (AJAX)
    public function storeBooking(Request $request) {
        $userId = Auth::id();
        $scheduleIds = $request->schedule_ids; // Mảng ID lịch tập gửi từ JS

        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
        }

        foreach($scheduleIds as $id) {
            // Kiểm tra xem đã đăng ký chưa để tránh trùng
            $exists = ClassRegistration::where('user_id', $userId)
                        ->where('schedule_id', $id)
                        ->exists();
            
            if (!$exists) {
                ClassRegistration::create([
                    'user_id' => $userId,
                    'schedule_id' => $id,
                    'status' => 'registered'
                ]);
            }
        }

        return response()->json(['success' => true, 'message' => 'Đăng ký thành công!']);
    }
}