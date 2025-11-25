<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GymClass;

use App\Models\ClassRegistration;
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
}