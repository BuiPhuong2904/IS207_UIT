<?php

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\ClassRegistration; 
use App\Models\GymClass;
use App\Models\Branch;
use App\Models\Trainer; 
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClassScheduleController extends Controller
{
    public function index()
    {
        // 1. LOGIC TỰ ĐỘNG CẬP NHẬT TRẠNG THÁI
        
        $now = Carbon::now();
        $currentDate = $now->toDateString();
        $currentTime = $now->toTimeString();

        // Tìm các ID của lịch học
        // 1. Đang ở trạng thái 'scheduled' (Đã lên lịch)
        // 2. Đã quá hạn
        $expiredScheduleIds = ClassSchedule::where('status', 'scheduled')
            ->where(function ($query) use ($currentDate, $currentTime) {
                $query->where('date', '<', $currentDate)
                      ->orWhere(function ($q) use ($currentDate, $currentTime) {
                          // Hoặc là hôm nay nhưng đã hết giờ
                          $q->where('date', '=', $currentDate)
                            ->where('end_time', '<', $currentTime);
                      });
            })
            ->pluck('schedule_id');

        // Nếu có lớp nào hết hạn thì thực hiện update
        if ($expiredScheduleIds->isNotEmpty()) {
            
            // A. Cập nhật trạng thái LỊCH LỚP: scheduled -> completed
            ClassSchedule::whereIn('schedule_id', $expiredScheduleIds)
                ->update(['status' => 'completed']);

            // B. Cập nhật trạng thái HỌC VIÊN: registered -> attended
            ClassRegistration::whereIn('schedule_id', $expiredScheduleIds)
                ->where('status', 'registered')
                ->update(['status' => 'attended']);
        }
        
        // Lấy danh sách lịch lớp
        $schedules = ClassSchedule::with(['gymClass', 'branch', 'trainer.user'])
            ->orderBy('date', 'desc') 
            ->paginate(10);

        // Lấy dữ liệu cho Dropdown
        $classes_list = GymClass::select('class_id as id', 'class_name as name')->get();
        $branches_list = Branch::select('branch_id as id', 'branch_name as name')->get();
        
        // Lấy danh sách HLV
        $trainers_list = Trainer::with('user')->get()->map(function($t) {
            return [
                'id' => $t->user_id,
                'name' => $t->user->full_name ?? 'Unknown', 
                'formatted_id' => 'KH' . str_pad($t->user_id, 4, '0', STR_PAD_LEFT)
            ];
        });

        // Xử lý JSON danh sách học viên
        $allSchedules = ClassSchedule::with(['registrations.user'])->get();
        $student_lists = [];

        foreach ($allSchedules as $sch) {
            $formattedScheduleId = 'LL' . str_pad($sch->schedule_id, 4, '0', STR_PAD_LEFT);
            
            $student_lists[$formattedScheduleId] = $sch->registrations->map(function($reg) {
                return [
                    'id' => $reg->class_reg_id,
                    'name' => $reg->user->full_name ?? 'N/A',
                    'date' => $reg->created_at->format('d/m/Y'),
                    'status' => $reg->status 
                ];
            });
        }

        return view('admin.class_schedule', compact(
            'schedules', 
            'classes_list', 
            'branches_list', 
            'trainers_list', 
            'student_lists'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'branch_id' => 'required',
            'study_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $data = $request->all();
        $data['date'] = $request->study_date;
        $data['status'] = 'scheduled';

        ClassSchedule::create($data);

        return redirect()->back()->with('success', 'Thêm lịch thành công');
    }

    public function update(Request $request, $id)
    {
        $schedule = ClassSchedule::findOrFail($id);
        $data = $request->all();

        // 1. Xử lý ngày tháng 
        if($request->has('study_date')) {
             $data['date'] = $request->study_date;
        }

        // 2. LOGIC ĐỒNG BỘ TRẠNG THÁI HỌC VIÊN
        // Kiểm tra: Nếu có thay đổi status
        if ($request->has('status') && $request->status !== $schedule->status) {
            
            $newStatus = $request->status;
            $studentStatus = null;

            // Map trạng thái từ Lịch sang Học viên
            switch ($newStatus) {
                case 'scheduled':
                    $studentStatus = 'registered';
                    break;
                case 'completed':
                    $studentStatus = 'attended';
                    break;
                case 'cancelled':
                    $studentStatus = 'cancelled';
                    break;
            }

            // Thực hiện update hàng loạt cho tất cả học viên trong lớp này
            if ($studentStatus) {
                $schedule->registrations()->update(['status' => $studentStatus]);
            }
        }

        // 3. Cập nhật thông tin lịch
        $schedule->update($data);

        return redirect()->back()->with('success', 'Cập nhật thành công');
    }
    
    public function destroy($id)
    {
        $schedule = ClassSchedule::findOrFail($id);

        // Kiểm tra nếu lịch đã có người đăng ký
        if ($schedule->registrations()->exists()) {
            $schedule->update(['status' => 'cancelled']);
            $schedule->registrations()->update(['status' => 'cancelled']);
            
            // Trả về thông báo rằng lịch đã được hủy thay vì xóa 
            return response()->json([
                'success' => true,
                'message' => 'Lớp học đã có người đăng ký. Hệ thống đã chuyển trạng thái sang "Đã hủy".'
            ]);
        }

        // Nếu không có người đăng ký, tiến hành xóa lịch
        $schedule->delete();
        return response()->json([
            'success' => true,
            'message' => 'Đã xóa lịch lớp thành công.'
        ]);
    }

    public function toggleCheckIn(Request $request)
    {
        $registration = ClassRegistration::find($request->registration_id);

        if (!$registration) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy học viên!']);
        }

        // Nếu đang là 'attended' thì bỏ check về 'registered', ngược lại thì thành 'attended'
        if ($registration->status == 'cancelled') {
            return response()->json(['success' => false, 'message' => 'Học viên này đã hủy, không thể điểm danh!']);
        }

        $newStatus = ($registration->status == 'attended') ? 'registered' : 'attended';
        
        $registration->update(['status' => $newStatus]);

        return response()->json([
            'success' => true, 
            'new_status' => $newStatus,
            'message' => $newStatus == 'attended' ? 'Đã điểm danh!' : 'Đã hủy điểm danh!'
        ]);
    }
}