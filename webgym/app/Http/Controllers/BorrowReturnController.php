<?php

namespace App\Http\Controllers;

use App\Models\RentalTransaction;
use App\Models\RentalItem;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BorrowReturnController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $query = RentalTransaction::with([
            'user:id,full_name',
            'item:item_id,item_name'
        ]);

        if ($filter === 'today') {
            $query->whereDate('borrow_date', today());
        }

        if ($filter === '7days') {
            $query->whereDate('borrow_date', '>=', now()->subDays(7));
        }

        if ($filter === 'unreturned') {
            $query->where('status', 'borrowed');
        }

        $transactions = $query
            ->orderByDesc('borrow_date')
            ->get();

        // ✅ Sửa role từ 'user' → 'member'
        $customers = User::where('role', 'member')
            ->where('status', 'active') // ✅ Thêm filter active
            ->select('id', 'full_name')
            ->orderBy('full_name')
            ->get();

        // ✅ Sửa status từ 'available' → 'active'
        $items = RentalItem:: where('status', 'active')
            ->select('item_id', 'item_name', 'quantity_available')
            ->orderBy('item_name')
            ->get();

        return view('admin.borrow_return', compact(
            'transactions',
            'customers',
            'items',
            'filter'
        ));
    }

    public function store(Request $request)
    {
        // ✅ Sửa validation:  users → user
        $data = $request->validate([
            'user_id'     => 'required|exists:user,id',
            'item_id'     => 'required|exists:rental_item,item_id',
            'quantity'    => 'required|integer|min:1',
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
            'status'      => 'required|in: borrowed,returned',
            'note'        => 'nullable|string',
        ]);

        // ✅ Kiểm tra số lượng khả dụng
        $item = RentalItem::findOrFail($data['item_id']);
        
        if ($item->quantity_available < $data['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng vượt quá khả dụng!  Chỉ còn ' . $item->quantity_available . ' ' . $item->item_name
            ], 400);
        }

        // ✅ Tạo transaction
        $transaction = RentalTransaction::create($data);

        // ✅ Trừ số lượng (chỉ khi status = borrowed)
        if ($data['status'] === 'borrowed') {
            $item->decrement('quantity_available', $data['quantity']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Thêm giao dịch thành công!',
            'data' => $transaction
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $transaction = RentalTransaction::findOrFail($id);
        $oldQty = $transaction->quantity;
        $oldStatus = $transaction->status;
        $oldItemId = $transaction->item_id;

        // ✅ Sửa validation
        $data = $request->validate([
            'user_id'     => 'required|exists:user,id',
            'item_id'     => 'required|exists:rental_item,item_id',
            'quantity'    => 'required|integer|min:1',
            'borrow_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:borrow_date',
            'status'      => 'required|in: borrowed,returned',
            'note'        => 'nullable|string',
        ]);

        $item = RentalItem::findOrFail($data['item_id']);

        // ✅ Xử lý thay đổi trạng thái:  borrowed → returned
        if ($oldStatus === 'borrowed' && $data['status'] === 'returned') {
            // Hoàn trả số lượng
            $oldItem = RentalItem::find($oldItemId);
            if ($oldItem) {
                $oldItem->increment('quantity_available', $oldQty);
            }
            
            // Set ngày trả
            if (! $data['return_date']) {
                $data['return_date'] = Carbon::now()->format('Y-m-d');
            }
        }

        // ✅ Xử lý thay đổi số lượng (nếu vẫn borrowed)
        if ($oldStatus === 'borrowed' && $data['status'] === 'borrowed') {
            if ($data['quantity'] != $oldQty) {
                $diff = $data['quantity'] - $oldQty;
                
                if ($diff > 0) {
                    // Mượn thêm
                    if ($item->quantity_available < $diff) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Số lượng không đủ!'
                        ], 400);
                    }
                    $item->decrement('quantity_available', $diff);
                } else {
                    // Giảm số lượng mượn
                    $item->increment('quantity_available', abs($diff));
                }
            }
        }

        // ✅ Xử lý thay đổi trạng thái:  returned → borrowed
        if ($oldStatus === 'returned' && $data['status'] === 'borrowed') {
            if ($item->quantity_available < $data['quantity']) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng không đủ!'
                ], 400);
            }
            $item->decrement('quantity_available', $data['quantity']);
        }

        $transaction->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật giao dịch thành công! ',
            'data' => $transaction
        ], 200);
    }

    public function show($id)
    {
        $transaction = RentalTransaction:: with(['user', 'item'])->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'data' => $transaction
        ]);
    }
}