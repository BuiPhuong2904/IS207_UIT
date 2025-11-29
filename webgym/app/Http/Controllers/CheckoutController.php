<?php

namespace App\Http\Controllers;

use App\Models\MembershipPackage;
use App\Models\ProductVariant;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang Thanh toán (Checkout).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userId = 1; // Nếu chưa auth, dùng test user_id=1

        $cart = Cart::with('items.item')
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->firstOrCreate(
                ['user_id' => $userId, 'status' => 'active'],  // ← Chỉ tìm theo 2 cột này
                ['created_at' => now()]                        // ← Chỉ dùng khi tạo mới
            );

        // Lấy cart_items từ DB (chuyển sang mảng giống mock)
        $cart_items = $cart->items->map(function ($cartItem) {
            $item = $cartItem->item;
            $isPackage = $cartItem->item_type === MembershipPackage::class;

            // Giả sử item có discount_value (thêm vào model nếu cần)
            $discount_value = $item->discount_value ?? 0; // Hoặc lấy từ promotion riêng cho item
            $final_price = $cartItem->unit_price - $discount_value;

            return [
                'variant_id' => $isPackage ? null : $cartItem->item_id,
                'package_id' => $isPackage ? $cartItem->item_id : null,
                'name' => $isPackage ? $item->package_name : ($item->product->product_name ?? 'Sản phẩm') . ' - ' . ($item->color ?? ''),
                'type' => $isPackage ? 'membership' : 'product',
                'size' => $isPackage ? null : ($item->size ?? 'N/A'),
                'color' => $isPackage ? null : ($item->color ?? 'N/A'),
                'duration' => $isPackage ? ($item->duration_months ?? 0) . ' tháng' : null,
                'final_price' => $final_price,
                'unit_price' => $cartItem->unit_price,
                'discount_value' => $discount_value,
                'quantity' => $cartItem->quantity,
                'image_url' => $item->image_url ?? asset('images/default.jpg'),
            ];
        })->toArray();

        // Lấy promotions_data từ DB (keyBy code, giống mock)
        $promotions_data = Promotion::all()->keyBy('code')->map(function ($promo) {
            return [
                'discount_value' => $promo->discount_value,
                'is_percent' => $promo->is_percent,
                'min_order_amount' => $promo->min_order_amount,
                'max_discount' => $promo->max_discount,
                'title' => $promo->title,
                'description' => $promo->description,
            ];
        })->toArray();

        // Truyền vào view (giữ nguyên không truyền data khác để tránh thay đổi giao diện)
        return view('user.checkout', compact('cart_items', 'promotions_data'));
    }

    // Hàm lấy cart theo user_id truyền vào (từ query hoặc body)
    private function getCart($userId)
    {
        if (!$userId) {
            abort(400, 'Thiếu user_id');
        }

        return Cart::firstOrCreate([
            'user_id' => $userId,
            'status'  => 'active'
        ], ['created_at' => now()]);
    }

    // 1. LẤY GIỎ HÀNG
    public function getCartItems(Request $request)
    {
        $userId = $request->query('user_id') ?? $request->input('user_id');
        $cart = $this->getCart($userId)->load('items.item');

        $items = $cart->items->map(function ($cartItem) {
            $item = $cartItem->item;
            $isPackage = $cartItem->item_type === MembershipPackage::class;

            return [
                'key'         => $cartItem->cart_id . '-' . $cartItem->item_id . '-' . $cartItem->item_type,
                'item_id'     => $cartItem->item_id,
                'item_type'   => class_basename($cartItem->item_type),
                'name'        => $isPackage ? ($item->package_name ?? 'Gói tập') : ($item?->product?->name ?? 'Sản phẩm'),
                'image'       => $item->image_url ?? asset('images/default.jpg'),
                'price'       => $cartItem->unit_price,
                'quantity'    => $cartItem->quantity,
                'subtotal'    => $cartItem->subtotal ?? ($cartItem->quantity * $cartItem->unit_price),
                'can_edit_qty'=> ! $isPackage,
            ];
        });

        return response()->json([
            'success' => true,
            'user_id' => $userId,
            'items'   => $items,
            'total'   => $items->sum('subtotal'),
            'count'   => $items->count()
        ]);
    }

    // 2. THÊM VÀO GIỎ
    public function addToCart(Request $request)
    {
        $request->validate([
            'user_id'  => 'required|integer',
            'type'     => 'required|in:product,package',
            'id'       => 'required|integer',
            'quantity' => 'nullable|integer|min:1|max:99',
        ]);

        $cart = $this->getCart($request->user_id);

        $model = $request->type === 'product'
            ? ProductVariant::findOrFail($request->id)
            : MembershipPackage::findOrFail($request->id);

        $quantity = $request->type === 'package' ? 1 : ($request->quantity ?? 1);

        CartItem::updateOrCreate(
            [
                'cart_id'   => $cart->cart_id,
                'item_id'   => $model->getKey(),
                'item_type' => $request->type === 'product' ? ProductVariant::class : MembershipPackage::class,
            ],
            [
                'quantity'   => $quantity,
                'unit_price' => $model->price,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Đã thêm vào giỏ hàng']);
    }

    // 3. CẬP NHẬT SỐ LƯỢNG
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|integer',
            'item_id'    => 'required|integer',
            'item_type'  => 'required|string',
            'quantity'   => 'required|integer|min:1',
        ]);

        $cart = $this->getCart($request->user_id);

        $cartItem = CartItem::where('cart_id', $cart->cart_id)
            ->where('item_id', $request->item_id)
            ->where('item_type', $request->item_type)
            ->firstOrFail();

        if ($cartItem->item_type === MembershipPackage::class) {
            return response()->json(['success' => false, 'message' => 'Không thể sửa số lượng gói tập'], 400);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
    }

    // 4. XÓA KHỎI GIỎ
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|integer',
            'item_id'   => 'required|integer',
            'item_type' => 'required|string',
        ]);

        $cart = $this->getCart($request->user_id);

        $deleted = CartItem::where('cart_id', $cart->cart_id)
            ->where('item_id', $request->item_id)
            ->where('item_type', $request->item_type)
            ->delete();

        return response()->json([
            'success' => $deleted > 0,
            'message' => $deleted ? 'Đã xóa' : 'Không tìm thấy'
        ]);
    }

}
