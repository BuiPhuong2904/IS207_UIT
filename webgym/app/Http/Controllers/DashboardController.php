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
        $currentYear = Carbon::now()->year;
        
        // Doanh thu từ Payment (Gói tập + Bán hàng)
        $revenueFromPaymentTable = Payment::whereYear('payment_date', $currentYear)
            ->where('status', 'completed')
            ->sum('amount');

        // Doanh thu từ Thuê đồ 
        $revenueFromRentals = DB::table('rental_transaction')
            ->join('rental_item', 'rental_transaction.item_id', '=', 'rental_item.item_id')
            ->whereYear('rental_transaction.borrow_date', $currentYear)
            ->where('rental_transaction.status', 'returned') 
            ->sum(DB::raw('rental_transaction.quantity * rental_item.rental_fee'));
            
        // --- 1. CÁC THẺ THỐNG KÊ (CARDS) ---
        // Tổng doanh thu: Dựa trên bảng Payment (cột amount)
        $totalRevenue = $revenueFromPaymentTable + $revenueFromRentals;

        // Số lớp học đang mở (active)
        $totalClasses = GymClass::where('is_active', 1)->count();

        // Khách hàng mới trong năm nay
        $totalNewMembers = User::whereYear('created_at', $currentYear)
            ->whereNotIn('role', ['admin', 'trainer'])
            ->count();

        // Tổng đơn hàng (Bán lẻ)
        $totalOrders = Order::count();

        // --- 2. BIỂU ĐỒ DOANH THU 12 THÁNG (LINE CHART) ---
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
        // Doanh thu Gói tập = Payment có package_registration_id khác null
        // Doanh thu Bán hàng = Payment có order_id khác null
        // Doanh thu Thuê đồ = Từ bảng rental_transaction
        
        $revenueFromPackages = Payment::whereYear('payment_date', $currentYear)
            ->whereNotNull('package_registration_id')
            ->where('status', 'completed')
            ->sum('amount');

        $revenueFromProducts = Payment::whereYear('payment_date', $currentYear)
            ->whereNotNull('order_id')
            ->where('status', 'completed')
            ->sum('amount');

        $structureData = [
            'labels' => ['Gói tập', 'Bán lẻ sản phẩm', 'Thuê dụng cụ'],
            'data'   => [$revenueFromPackages, $revenueFromProducts, $revenueFromRentals]
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

        // --- 6. THỐNG KÊ SẢN PHẨM BÁN CHẠY THEO DANH MỤC ---
        
        // Logic: order_detail -> product_variant -> product -> product_category
        $rawProducts = DB::table('order_detail') 
            ->join('order', 'order_detail.order_id', '=', 'order.order_id')
            ->join('product_variant', 'order_detail.variant_id', '=', 'product_variant.variant_id')
            ->join('product', 'product_variant.product_id', '=', 'product.product_id')
            ->join('product_category', 'product.category_id', '=', 'product_category.category_id') 
            ->select(
                'product_category.category_id',
                'product_category.category_name',
                'product.product_name',
                DB::raw('SUM(order_detail.quantity) as total_qty'),
                // Tính doanh thu: quantity * unit_price
                DB::raw('SUM(order_detail.quantity * order_detail.unit_price) as total_revenue') 
            )
            ->groupBy('product_category.category_id', 'product_category.category_name', 'product.product_name')
            ->orderBy('total_qty', 'desc')
            ->get();

        // Format dữ liệu
        $productStats = [];

        foreach ($rawProducts as $item) {
            $catId = $item->category_id;

            if (!isset($productStats[$catId])) {
                $productStats[$catId] = [
                    'name' => $item->category_name,
                    'products' => [],
                    'data' => [], 
                    'quantities' => [] 
                ];
            }

            $productStats[$catId]['products'][] = $item->product_name;
            $productStats[$catId]['data'][] = (int)$item->total_revenue;
            $productStats[$catId]['quantities'][] = (int)$item->total_qty;
        }

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalClasses',
            'totalNewMembers',
            'totalOrders',
            'revenueData',
            'structureData',
            'packageData',
            'newMemberData',
            'productStats'
        ));
    }

    public function filterTopProducts(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        if (!$startDate || !$endDate) {
            $endDate = Carbon::now()->format('Y-m-d');
            $startDate = Carbon::now()->subDays(30)->format('Y-m-d');
        }

        $rawProducts = DB::table('order_detail')
            ->join('order', 'order_detail.order_id', '=', 'order.order_id')
            ->join('product_variant', 'order_detail.variant_id', '=', 'product_variant.variant_id')
            ->join('product', 'product_variant.product_id', '=', 'product.product_id')
            ->join('product_category', 'product.category_id', '=', 'product_category.category_id') 
            ->select(
                'product_category.category_id',
                'product_category.category_name',
                'product.product_name',
                DB::raw('SUM(order_detail.quantity) as total_qty'),
                DB::raw('SUM(order_detail.quantity * order_detail.unit_price) as total_revenue') 
            )
            // Lọc theo ngày đặt hàng
            ->whereBetween('order.order_date', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->groupBy('product_category.category_id', 'product_category.category_name', 'product.product_name')
            ->orderBy('total_qty', 'desc')
            ->get();

        $productStats = [];
        foreach ($rawProducts as $item) {
            $catId = $item->category_id;
            if (!isset($productStats[$catId])) {
                $productStats[$catId] = [
                    'name' => $item->category_name,
                    'products' => [],
                    'data' => [],
                    'quantities' => []
                ];
            }
            $productStats[$catId]['products'][] = $item->product_name;
            $productStats[$catId]['data'][] = (int)$item->total_revenue;
            $productStats[$catId]['quantities'][] = (int)$item->total_qty;
        }

        return response()->json($productStats);
    }
}