<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalTransaction;
use App\Models\RentalItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BorrowReturnController extends Controller
{
    // 1. Danh sách
    public function index()
    {
        $transactions = RentalTransaction::with(['user', 'item'])
            ->orderBy('transaction_id', 'desc')
            ->paginate(10);

        $users = User::select('id', 'full_name', 'phone')->get();
        
        // Lấy danh sách Chi nhánh hoạt động
        $branches = \App\Models\Branch::where('is_active', true)->get();

        // Lấy vật phẩm active 
        $items = RentalItem::where('status', 'active')
            ->where('quantity_available', '>', 0)
            ->get();

        return view('admin.borrow_return', compact('transactions', 'users', 'items', 'branches'));
    }

    // 2. Tạo mới (Mượn đồ)
    public function store(Request $request)
    {
        $request->validate([
            'user_id'     => 'required|exists:user,id',
            'item_id'     => 'required|exists:rental_item,item_id',
            'quantity'    => 'required|integer|min:1',
            'borrow_date' => 'required|date',
            'note'        => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $item = RentalItem::find($request->item_id);

            // Kiểm tra tồn kho
            if ($item->quantity_available < $request->quantity) {
                return response()->json(['success' => false, 'message' => 'Số lượng trong kho không đủ!'], 400);
            }

            // Tạo giao dịch
            $transaction = RentalTransaction::create([
                'user_id'     => $request->user_id,
                'item_id'     => $request->item_id,
                'quantity'    => $request->quantity,
                'borrow_date' => $request->borrow_date,
                'status'      => 'renting', 
                'note'        => $request->note,
            ]);

            // Trừ kho
            $item->decrement('quantity_available', $request->quantity);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Tạo phiếu mượn thành công!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    // 3. Cập nhật (Sửa / Trả đồ)
    public function update(Request $request, $id)
    {
        $transaction = RentalTransaction::findOrFail($id);

        $request->validate([
            'status' => 'required|in:renting,returned',
            'note'   => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Logic Trả đồ: Nếu chuyển từ 'renting' sang 'returned'
            if ($transaction->status == 'renting' && $request->status == 'returned') {
                $transaction->return_date = Carbon::now(); 
                
                // Cộng lại kho
                $item = RentalItem::find($transaction->item_id);
                if($item) {
                    $item->increment('quantity_available', $transaction->quantity);
                }
            }
            
            // Logic Hoàn tác (nếu lỡ bấm trả nhầm): Từ 'returned' sang 'renting'
            if ($transaction->status == 'returned' && $request->status == 'renting') {
                $transaction->return_date = null;
                $item = RentalItem::find($transaction->item_id);
                if($item) {
                    // Kiểm tra xem có đủ hàng để trừ lại không 
                    if ($item->quantity_available >= $transaction->quantity) {
                        $item->decrement('quantity_available', $transaction->quantity);
                    } else {
                        return response()->json(['success' => false, 'message' => 'Kho không đủ để hoàn tác trạng thái!'], 400);
                    }
                }
            }

            $transaction->status = $request->status;
            $transaction->note = $request->note;
            $transaction->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Cập nhật thành công!']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()], 500);
        }
    }

    // 4. Xóa
    public function destroy($id)
    {
        $transaction = RentalTransaction::findOrFail($id);

        // Nếu xóa đơn đang thuê, phải trả lại kho
        if ($transaction->status == 'renting') {
            $item = RentalItem::find($transaction->item_id);
            if($item) {
                $item->increment('quantity_available', $transaction->quantity);
            }
        }

        $transaction->delete();
        return response()->json(['success' => true, 'message' => 'Đã xóa giao dịch!']);
    }
}