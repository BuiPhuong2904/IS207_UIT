<?php

namespace App\Http\Controllers;

use App\Models\ProductVariant;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

use App\Models\MembershipPackage;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang Thanh toán (Checkout).
     */
public function index(Request $request)
    {
        $userId = Auth::id(); 

        // TRƯỜNG HỢP 1: THANH TOÁN NGAY GÓI TẬP
        if ($request->has('package_id')) {
            $package = MembershipPackage::findOrFail($request->package_id);

            $cart_items = [[
                'variant_id'     => null,
                'package_id'     => $package->package_id,
                'name'           => $package->package_name,
                'type'           => 'membership', // Đánh dấu là gói tập
                'size'           => null,
                'color'          => null,
                'duration'       => $package->duration_months . ' tháng',
                
                'final_price'    => $package->price,
                'unit_price'     => $package->price,
                'discount_value' => 0,

                'quantity'       => 1,
                'image_url'      => $package->image_url ?? asset('images/default_package.jpg'),
            ]];

            // Lấy danh sách khuyến mãi 
            $promotions_data = $this->getPromotionsData();

            // Trả về view 
            return view('user.checkout', compact('cart_items', 'promotions_data'));
        }

        // TRƯỜNG HỢP 2: THANH TOÁN GIỎ HÀNG SẢN PHẨM
        $cart = Cart::with('items.variant.product')
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->firstOrCreate(
                ['user_id' => $userId, 'status' => 'active'],
                ['created_at' => now()]
            );

        // Lấy cart_items và map dữ liệu
        $cart_items = $cart->items->map(function ($cartItem) {
            $variant = $cartItem->variant;

            // Nếu variant bị xóa hoặc không tồn tại, bỏ qua
            if (!$variant) return null;

            $productName = $variant->product->product_name ?? 'Sản phẩm';
            $unitPrice = $cartItem->unit_price;
            
            $finalPrice = $unitPrice;
            $discountAmount = 0; 

            // Logic tính giảm giá
            if ($variant->is_discounted && $variant->discount_price > 0 && $variant->discount_price < $unitPrice) {
                $finalPrice = $variant->discount_price;
                $discountAmount = $unitPrice - $finalPrice;
            }

            return [
                'variant_id'     => $cartItem->variant_id, 
                'package_id'     => null,
                'name'           => $productName . ' - ' . ($variant->color ?? ''),
                'type'           => 'product',
                'size'           => $variant->size ?? 'N/A',
                'color'          => $variant->color ?? 'N/A',
                'duration'       => null,

                'final_price'    => $finalPrice,
                'unit_price'     => $unitPrice,
                'discount_value' => $discountAmount,

                'quantity'       => $cartItem->quantity,
                'image_url'      => $variant->image_url ?? asset('images/default.jpg'),
            ];
        })->filter()->values()->toArray();

        $promotions_data = $this->getPromotionsData();

        return view('user.checkout', compact('cart_items', 'promotions_data'));
    }

    // Helper lấy khuyến mãi 
    private function getPromotionsData() {
        return Promotion::all()->keyBy('code')->map(function ($promo) {
            return [
                'discount_value' => $promo->discount_value,
                'is_percent' => $promo->is_percent,
                'min_order_amount' => $promo->min_order_amount,
                'max_discount' => $promo->max_discount,
                'title' => $promo->title,
                'description' => $promo->description,
            ];
        })->toArray();
    }

    // Hàm lấy cart
    private function getCart($userId)
    {
        if (!$userId) abort(400, 'Thiếu user_id');

        return Cart::firstOrCreate([
            'user_id' => $userId,
            'status'  => 'active'
        ], ['created_at' => now()]);
    }

    // 1. API LẤY GIỎ HÀNG
    public function getCartItems(Request $request)
    {
        $userId = $request->query('user_id') ?? $request->input('user_id');
        $cart = $this->getCart($userId)->load('items.variant.product');

        $items = $cart->items->map(function ($cartItem) {
            $variant = $cartItem->variant;
            if (!$variant) return null;

            return [
                'key'          => $cartItem->cart_id . '-' . $cartItem->variant_id, 
                'item_id'      => $cartItem->variant_id,
                'item_type'    => 'product',
                'name'         => ($variant->product->product_name ?? 'Sản phẩm') . ' - ' . ($variant->color ?? ''),
                'image'        => $variant->image_url ?? asset('images/default.jpg'),
                'price'        => $cartItem->unit_price,
                'quantity'     => $cartItem->quantity,
                'subtotal'     => $cartItem->quantity * $cartItem->unit_price,
                'can_edit_qty' => true,
            ];
        })->filter()->values();

        return response()->json([
            'success' => true,
            'user_id' => $userId,
            'items'   => $items,
            'total'   => $items->sum('subtotal'),
            'count'   => $items->count()
        ]);
    }

    // 2. API THÊM VÀO GIỎ 
    public function addToCart(Request $request)
    {
        $request->validate([
            'user_id'  => 'required|integer',
            'id'       => 'required|integer',
            'quantity' => 'nullable|integer|min:1|max:99',
        ]);

        $cart = $this->getCart($request->user_id);
        
        // Luôn tìm Variant
        $variant = ProductVariant::findOrFail($request->id);
        $quantity = $request->quantity ?? 1;

        // Tìm xem sản phẩm đã có trong giỏ chưa (theo variant_id)
        $cartItem = CartItem::where('cart_id', $cart->cart_id)
            ->where('variant_id', $variant->variant_id)
            ->first();

        if ($cartItem) {
            // Có rồi thì cộng dồn số lượng
            $cartItem->quantity += $quantity;
            $cartItem->unit_price = $variant->price; // Cập nhật giá mới nhất
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id'    => $cart->cart_id,
                'variant_id' => $variant->variant_id,
                'quantity'   => $quantity,
                'unit_price' => $variant->price,
            ]);
        }
        
        // Trả về số lượng item trong giỏ để update header
        $newCount = CartItem::where('cart_id', $cart->cart_id)->count();

        return response()->json([
            'success'    => true, 
            'message'    => 'Đã thêm vào giỏ hàng',
            'cart_count' => $newCount
        ]);
    }

    // 3. API CẬP NHẬT SỐ LƯỢNG
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'user_id'  => 'required|integer',
            'item_id'  => 'required|integer', 
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getCart($request->user_id);

        $cartItem = CartItem::where('cart_id', $cart->cart_id)
            ->where('variant_id', $request->item_id) // Tìm theo variant_id
            ->firstOrFail();

        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
    }

    // 4. API XÓA KHỎI GIỎ
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'item_id' => 'required|integer',
        ]);

        $cart = $this->getCart($request->user_id);

        $deleted = CartItem::where('cart_id', $cart->cart_id)
            ->where('variant_id', $request->item_id) // Tìm theo variant_id
            ->delete();
        
        // Đếm lại số lượng còn lại trong giỏ sau khi xóa
        $newCount = CartItem::where('cart_id', $cart->cart_id)->count();

        return response()->json([
            'success' => $deleted > 0,
            'message' => $deleted ? 'Đã xóa' : 'Không tìm thấy',
            'cart_count' => $newCount // Trả về số này để JS cập nhật Header
        ]);
    }
}