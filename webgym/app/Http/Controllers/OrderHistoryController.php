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
            'all',
            'pending',
            'processing',
            'completed',
            'cancelled'
        ];

        $status = $request->query('status', 'all');

        if (!in_array($status, $validStatuses)) {
            $status = 'all';
        }

        $query = Order::with(['details.product'])
            ->where('user_id', Auth::id());
        
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->latest('order_date')->get();

        $statusLabels = [
            'all' => 'Tất cả',
            'pending' => 'Chờ xác nhận',
            'processing' => 'Đang giao',
            'completed' => 'Đã hoàn thành',
            'cancelled' => 'Đã hủy',
        ];

        return view('user.order_history', compact('orders', 'status', 'statusLabels'));
    }

    public function cancelOrder($id) {
        $order = Order::where('order_id', $id)->where('user_id', Auth::id())->firstOrFail();

        if ($order->status == 'pending') {
            $order->status = 'cancelled';
            $order->save();
            return back()->with('success', 'Đã hủy đơn hàng thành công.');
        }

        return back()->with('error', 'Không thể hủy đơn hàng này.');
    }
}