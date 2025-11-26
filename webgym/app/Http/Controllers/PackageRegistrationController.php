<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PackageRegistration;
use App\Models\User;
use App\Models\MembershipPackage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PackageRegistrationController extends Controller
{
    public function index()
    {
        $today = Carbon::now();

        // --- LOGIC TỰ ĐỘNG CẬP NHẬT TRẠNG THÁI ---
        // Chỉ quét những gói đang 'active' mà đã quá hạn ngày
        PackageRegistration::where('status', 'active')
            ->whereDate('end_date', '<', $today)
            ->update(['status' => 'expired']);
        
        // --- LẤY DỮ LIỆU ---
        $registrations = PackageRegistration::with(['user', 'package'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $users = User::where('role', 'member')->select('id', 'full_name')->get();

        $packages = MembershipPackage::select('package_id', 'package_name', 'price', 'duration_months')
            ->where('status', 'active')
            ->get();

        return view('admin.package_registration', compact('registrations', 'users', 'packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'package_id' => 'required|exists:membership_package,package_id',
            'start_date' => 'required|date',
        ]);

        $package = MembershipPackage::findOrFail($request->package_id);
        
        $startDate = Carbon::parse($request->start_date);
        $duration = $package->duration_months; 

        // --- XỬ LÝ LOGIC NGÀY/THÁNG ---
        
        if ($duration == 0) {
            // TRƯỜNG HỢP: Gói Tập Lẻ 
            // $endDate = $startDate->copy()->addDay(1);
            $endDate = $startDate->copy()->endOfDay();
        } else {
            // TRƯỜNG HỢP: Gói Tháng/Quý/Năm 
            $endDate = $startDate->copy()->addMonths($duration);
        }

        PackageRegistration::create([
            'user_id' => $request->user_id,
            'package_id' => $request->package_id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active'
        ]);

        return redirect()->back()->with('success', 'Đăng ký gói tập thành công');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,expired,completed,cancelled'
        ]);

        $registration = PackageRegistration::findOrFail($id);
        
        $registration->update([
            'status' => $request->status
        ]);

        $msg = 'Cập nhật trạng thái thành công';
        if ($request->status == 'completed') {
            $msg = 'Đã xác nhận khách hàng hoàn thành lộ trình tập!';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function destroy($id)
    {
        $registration = PackageRegistration::findOrFail($id);
        $registration->delete();

        return response()->json(['success' => true, 'message' => 'Xóa đăng ký thành công']);
    }
}