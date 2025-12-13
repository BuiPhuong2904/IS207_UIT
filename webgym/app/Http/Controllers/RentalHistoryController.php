<?php

namespace App\Http\Controllers;

use App\Models\RentalTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalHistoryController extends Controller
{
    public function index(Request $request)
    {
        // 1. Xác định trạng thái từ URL (all, renting, returned)
        $status = $request->query('status', 'all');
        
        $validStatuses = ['all', 'renting', 'returned'];
        if (!in_array($status, $validStatuses)) {
            $status = 'all';
        }

        // 2. Query dữ liệu
        $query = RentalTransaction::with(['item.branch']) // Eager load Item và Branch
            ->where('user_id', Auth::id());

        // 3. Áp dụng bộ lọc
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // 4. Lấy dữ liệu mới nhất
        $transactions = $query->orderBy('borrow_date', 'desc')->get();

        // 5. Định nghĩa Tab hiển thị
        $tabs = [
            'all'      => 'Tất cả',
            'renting'  => 'Đang mượn',
            'returned' => 'Đã trả',
        ];

        return view('user.rental_history', compact('transactions', 'status', 'tabs'));
    }
}