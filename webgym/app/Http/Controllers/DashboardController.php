<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Order;
use App\Models\User;
use App\Models\Payment;
use App\Models\GymClass;
use App\Models\PackageRegistration;
use App\Models\MembershipPackage;

class DashboardController extends Controller
{
    public function index()
    {
        // Lấy năm hiện tại
        $currentYear = Carbon::now()->year;
        
        // --- 1. CÁC THẺ THỐNG KÊ (CARDS) ---

        // Tổng doanh thu: Dựa trên bảng Payment (cột amount)
        $totalRevenue = Payment::whereYear('payment_date', $currentYear)
            ->where('status', 'completed')
            ->sum('amount');

        // Số lớp học đang mở (active)
        // Bảng: class, Cột: is_active
        $totalClasses = GymClass::where('is_active', 1)->count();

        // Khách hàng mới trong năm nay
        // Bảng: user, Cột: created_at. 
        $totalNewMembers = User::whereYear('created_at', $currentYear)
            ->whereNotIn('role', ['admin', 'trainer'])
            ->count();

        // Tổng đơn hàng (Bán lẻ)
        $totalOrders = Order::count();


        // --- 2. BIỂU ĐỒ DOANH THU 12 THÁNG (LINE CHART) ---
        // Logic: Group by tháng dựa trên payment_date trong bảng payment
        $revenuePerMonth = Payment::select(
                DB::raw('SUM(amount) as total'),
                DB::raw('MONTH(payment_date) as month')
            )
            ->whereYear('payment_date', $currentYear)
            ->where('status', 'completed')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Chuẩn hóa dữ liệu cho đủ 12 tháng (Tháng nào không có doanh thu thì = 0)
        $monthsLabels = [];
        $revenueChartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthsLabels[] = "Tháng $i";
            $revenueChartData[] = $revenuePerMonth[$i] ?? 0;
        }

        $revenueData = [
            'labels' => $monthsLabels,
            'data'   => $revenueChartData
        ];


        // --- 3. CƠ CẤU DOANH THU (PIE CHART 1) ---
        // Logic: 
        // - Doanh thu Gói tập = Payment có package_registration_id khác null
        // - Doanh thu Bán hàng = Payment có order_id khác null
        
        $revenueFromPackages = Payment::whereYear('payment_date', $currentYear)
            ->whereNotNull('package_registration_id')
            ->where('status', 'completed')
            ->sum('amount');

        $revenueFromProducts = Payment::whereYear('payment_date', $currentYear)
            ->whereNotNull('order_id')
            ->where('status', 'completed')
            ->sum('amount');

        // Có thể có nguồn thu khác (ví dụ thuê đồ - rental_transaction) nếu bảng payment chưa link tới rental
        // Tạm thời tính 2 nguồn chính:
        $structureData = [
            'labels' => ['Gói tập (Membership)', 'Bán lẻ sản phẩm'],
            'data'   => [$revenueFromPackages, $revenueFromProducts]
        ];


        // --- 4. TỶ LỆ GÓI TẬP ĐƯỢC ĐĂNG KÝ (PIE CHART 2) ---
        // Logic: Join bảng package_registration với membership_package để lấy tên gói
        $packageStats = DB::table('package_registration')
            ->join('membership_package', 'package_registration.package_id', '=', 'membership_package.package_id')
            ->select('membership_package.package_name', DB::raw('count(*) as total'))
            ->groupBy('membership_package.package_name')
            ->get();

        // Tính toán phần trăm
        $totalSubs = $packageStats->sum('total');
        $pkgLabels = [];
        $pkgData   = [];

        foreach ($packageStats as $stat) {
            $pkgLabels[] = $stat->package_name;
            // Tính % làm tròn 1 chữ số thập phân
            $pkgData[]   = $totalSubs > 0 ? round(($stat->total / $totalSubs) * 100, 1) : 0;
        }

        $packageData = [
            'labels' => $pkgLabels,
            'data'   => $pkgData
        ];


        // --- 5. TĂNG TRƯỞNG KHÁCH HÀNG MỚI (BAR CHART) ---
        // Logic: Group user theo tháng tạo
        $usersPerMonth = User::select(
                DB::raw('COUNT(*) as count'),
                DB::raw('MONTH(created_at) as month')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $newMemberChartData = [];
        $shortMonthLabels = [];
        for ($i = 1; $i <= 12; $i++) {
            $shortMonthLabels[] = "T$i";
            $newMemberChartData[] = $usersPerMonth[$i] ?? 0;
        }

        $newMemberData = [
            'labels' => $shortMonthLabels,
            'data'   => $newMemberChartData
        ];

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalClasses',
            'totalNewMembers',
            'totalOrders',
            'revenueData',
            'structureData',
            'packageData',
            'newMemberData'
        ));
    }
}