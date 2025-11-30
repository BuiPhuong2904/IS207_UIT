<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController
{
    public function index(Request $request)
    {
        $validStatuses = [
            'pending',
            'ready_for_pickup',
            'processing',
            'completed',
            'cancelled'
        ];

        $status = $request->query('status', 'pending');
        if (!in_array($status, $validStatuses)) {
            $status = 'pending';
        }

        $orders = Order::with(['details.product'])
            ->where('user_id', 25)
            ->where('status', $status)
            ->latest('order_date')
            ->get();

        $statusLabels = [
            'pending' => 'Chờ xác nhận',
            'ready_for_pickup'     => 'Chờ lấy hàng',
            'processing'             => 'Đang giao',
            'completed'            => 'Đã giao',
            'cancelled'            => 'Đã hủy',
        ];

        return view('user.order_history', compact('orders', 'status', 'statusLabels'));
    }
}
