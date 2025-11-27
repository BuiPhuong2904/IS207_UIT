<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipPackage;
use App\Models\PackageRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserPackageController extends Controller
{
    /**
     * Hiển thị danh sách các gói đang bán 
     */
    public function index()
    {
        // Lấy tất cả gói đang hoạt động 
        $packages = MembershipPackage::where('status', 'active')->get();

        // Trả về view danh sách sản phẩm 
        return view('user.package', [ 
            'packages' => $packages 
        ]);
    }

    /**
     * Hiển thị các gói user ĐÃ MUA 
     */
    public function myPackages()
    {
        $userId = Auth::id();

        // 1. Lấy dữ liệu từ bảng Đăng ký 
        $registrations = PackageRegistration::where('user_id', $userId)
            ->with('package')
            ->orderBy('end_date', 'desc')
            ->get();

        // 2. Xử lý logic tính toán 
        $myPackages = $registrations->map(function($reg) {
            if (!$reg->package) return null;

            $now = Carbon::now();
            $start = Carbon::parse($reg->start_date);
            $end = Carbon::parse($reg->end_date);

            // Tính toán ngày
            $totalDays = $start->diffInDays($end);
            $daysUsed = $start->diffInDays($now);
            $daysLeft = $now->diffInDays($end, false); 

            // Trạng thái hiển thị
            $status = ($daysLeft < 0) ? 'expired' : 'active';

            // Tính % tiến độ
            $progress = 0;
            if ($daysLeft < 0) {
                $progress = 100;
            } elseif ($totalDays > 0 && $daysUsed > 0) {
                $progress = ($daysUsed / $totalDays) * 100;
            }

            // Tách dòng mô tả thành mảng quyền lợi
            $rawDescription = $reg->package->description ?? '';

            // 1. Tách chuỗi bằng dấu chấm
            $benefits = explode('.', $rawDescription);

            // 2. Xóa khoảng trắng thừa ở đầu/cuối mỗi câu (trim)
            $benefits = array_map('trim', $benefits);

            // 3. Lọc bỏ các phần tử rỗng
            $benefits = array_filter($benefits, fn($value) => !empty($value));

            return [
                'name' => $reg->package->package_name,
                'status' => $status,
                'days_left' => max(0, (int)$daysLeft),
                'expiry_date' => $end->format('d/m/Y'),
                'progress' => round($progress),
                'benefits' => $benefits
            ];
        })->filter();

        // 3. Trả về View 
        return view('user.my_packages', [ 
            'packages' => $myPackages 
        ]);
    }
}