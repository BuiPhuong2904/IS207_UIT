<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

// Models
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use App\Models\MembershipPackage;
use App\Models\Promotion;
use App\Helpers\PromotionHelper; 

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang Thanh toán (Checkout).
     */
    public function index(Request $request)
    {
        $userId = Auth::id(); 
        $cart_items = [];
        $subtotal_amount = 0;

        // --- BƯỚC 1: CHUẨN BỊ CART_ITEMS & SUBTOTAL ---

        // TRƯỜNG HỢP 1: THANH TOÁN NGAY GÓI TẬP (MUA NGAY)
        if ($request->has('package_id')) {
            $package = MembershipPackage::findOrFail($request->package_id);
            $cart_items = [[
                'variant_id'     => null,
                'package_id'     => $package->package_id,
                'name'           => $package->package_name,
                'type'           => 'membership', 
                'size'           => null,
                'color'          => null,
                'duration'       => $package->duration_months . ' tháng',
                
                'final_price'    => $package->price,
                'unit_price'     => $package->price,
                'discount_value' => 0,

                'quantity'       => 1,
                'image_url'      => $package->image_url ?? asset('images/default_package.jpg'),
            ]];
            
            $subtotal_amount = $package->price;
        }
        // TRƯỜNG HỢP 2: THANH TOÁN GIỎ HÀNG SẢN PHẨM
        else {
            $cart = Cart::with('items.variant.product')
                ->where('user_id', $userId)
                ->where('status', 'active')
                ->firstOrCreate(
                    ['user_id' => $userId, 'status' => 'active'],
                    ['created_at' => now()]
                );

            // Map dữ liệu
            $cart_items = $cart->items->map(function ($cartItem) {
                $variant = $cartItem->variant;
                if (!$variant) return null;

                $productName = $variant->product->product_name ?? 'Sản phẩm';
                $unitPrice = $cartItem->unit_price;
                
                $finalPrice = $unitPrice;
                $discountAmount = 0; 

                // Logic tính giảm giá sản phẩm (nếu có)
                if ($variant->is_discounted && $variant->discount_price > 0 && $variant->discount_price < $unitPrice) {
                    $finalPrice = $variant->discount_price;
                    $discountAmount = $unitPrice - $finalPrice;
                }

                return [
                    'variant_id'     => $cartItem->variant_id, 
                    'package_id'     => null,
                    'name'           => $productName, 
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

            // Tính tổng tiền hàng (chưa trừ giảm giá item)
            $subtotal_amount = collect($cart_items)->sum(function ($item) {
                return ($item['unit_price'] ?? 0) * ($item['quantity'] ?? 1);
            });
        }

        // --- BƯỚC 2: XỬ LÝ MÃ GIẢM GIÁ ---
        
        $promotion_code = strtoupper(trim($request->input('promotion_code', '')));
        $promotion_discount = 0;
        $applied_promo = null;
        $promo_message = '';

        if ($promotion_code) {
            if (class_exists('App\Helpers\PromotionHelper')) {
                $result = PromotionHelper::validateAndApply(
                    $promotion_code,
                    $cart_items,
                    $subtotal_amount,
                    $userId
                );

                if ($result['success']) {
                    $applied_promo = $result; // Chứa thông tin mã, số tiền giảm...
                    $promotion_discount = $result['discount'];
                    $promo_message = $result['message'];
                } else {
                    $promo_message = $result['message'];
                }
            }
        }

        // --- BƯỚC 3: TÍNH TOÁN CUỐI CÙNG & TRẢ VỀ VIEW ---

        $promotions_data = $this->getPromotionsData();

        $item_discount_total = collect($cart_items)->sum(function ($item) {
            return ($item['discount_value'] ?? 0) * ($item['quantity'] ?? 1);
        });

        $shipping_fee = 30000;
        $total_amount = $subtotal_amount - $item_discount_total - $promotion_discount + $shipping_fee;

        return view('user.checkout', compact(
            'cart_items', 
            'promotions_data',
            'promotion_code',
            'applied_promo',
            'promotion_discount',
            'promo_message',
            'subtotal_amount',
            'item_discount_total',
            'shipping_fee',
            'total_amount'
        ));
    }

    /**
     * Helper lấy khuyến mãi: Chỉ lấy mã còn hạn và đang bật
     */
    private function getPromotionsData() {
        return Promotion::where('is_active', 1)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get()
            ->keyBy('code')
            ->map(function ($promo) {
                return [
                    'code'             => $promo->code,
                    'discount_value'   => $promo->discount_value,
                    'is_percent'       => $promo->is_percent,
                    'min_order_amount' => $promo->min_order_amount,
                    'max_discount'     => $promo->max_discount,
                    'title'            => $promo->title,
                    'description'      => $promo->description,
                ];
            })->toArray();
    }

    // Hàm lấy cart nội bộ
    private function getCart($userId)
    {
        if (!$userId) abort(400, 'Thiếu user_id');
        return Cart::firstOrCreate([
            'user_id' => $userId,
            'status'  => 'active'
        ], ['created_at' => now()]);
    }

    // ==========================================
    // API METHODS (AJAX) git status
    // ==========================================

    // 1. API LẤY GIỎ HÀNG
    public function getCartItems(Request $request)
    {
        // Chỉ lấy giỏ của người đang đăng nhập
        $userId = Auth::id(); 
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
        try {
            $request->validate([
                'user_id'  => 'required|integer',
                'id'       => 'required|integer', // variant_id
                'quantity' => 'nullable|integer|min:1|max:99',
            ]);

            // [BẢO MẬT] Check ID người dùng
            if ($request->user_id != Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Không có quyền truy cập'], 403);
            }

            $cart = $this->getCart($request->user_id);
            $variant = ProductVariant::findOrFail($request->id);
            $quantity = $request->quantity ?? 1;

            $cartItem = CartItem::where('cart_id', $cart->cart_id)
                ->where('variant_id', $variant->variant_id)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->unit_price = $variant->price; 
                $cartItem->save();
            } else {
                CartItem::create([
                    'cart_id'    => $cart->cart_id,
                    'variant_id' => $variant->variant_id,
                    'quantity'   => $quantity,
                    'unit_price' => $variant->price,
                ]);
            }
            
            $newCount = CartItem::where('cart_id', $cart->cart_id)->count();

            return response()->json([
                'success'    => true, 
                'message'    => 'Đã thêm vào giỏ hàng',
                'cart_count' => $newCount
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi thêm giỏ hàng: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Lỗi server'], 500);
        }
    }

    // 3. API CẬP NHẬT SỐ LƯỢNG
    public function updateQuantity(Request $request)
    {
        try {
            $request->validate([
                'user_id'  => 'required|integer',
                'item_id'  => 'required|integer', 
                'quantity' => 'required|integer|min:1',
            ]);

            // [BẢO MẬT]
            if ($request->user_id != Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $cart = $this->getCart($request->user_id);

            $cartItem = CartItem::where('cart_id', $cart->cart_id)
                ->where('variant_id', $request->item_id)
                ->first();

            if ($cartItem) {
                $cartItem->update(['quantity' => $request->quantity]);
                return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
            }

            return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm'], 404);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi cập nhật'], 500);
        }
    }

    // 4. API XÓA KHỎI GIỎ
    public function removeFromCart(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|integer',
                'item_id' => 'required|integer',
            ]);

            // [BẢO MẬT]
            if ($request->user_id != Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $cart = $this->getCart($request->user_id);

            $deleted = CartItem::where('cart_id', $cart->cart_id)
                ->where('variant_id', $request->item_id)
                ->delete();
            
            $newCount = CartItem::where('cart_id', $cart->cart_id)->count();

            return response()->json([
                'success'    => $deleted > 0,
                'message'    => $deleted ? 'Đã xóa' : 'Không tìm thấy',
                'cart_count' => $newCount
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Lỗi xóa sản phẩm'], 500);
        }
    }
}