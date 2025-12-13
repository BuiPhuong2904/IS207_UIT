<?php
// app/Helpers/PromotionHelper.php

namespace App\Helpers;

use App\Models\Promotion;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromotionHelper
{
    public static function validateAndApply(string $code, array $cart_items, float $subtotal, ?int $userId = null): array
    {
        $code = strtoupper(trim($code));

        // Bắt buộc dùng transaction + lock để chống race condition
        return DB::transaction(function () use ($code, $cart_items, $subtotal, $userId) {
            $now = Carbon::now();

            // Lấy promotion và lock row này đến khi transaction kết thúc
            $promo = Promotion::whereRaw('UPPER(code) = ?', [$code])
                ->active()
                ->with('targets')
                ->lockForUpdate()    // ← Chỗ này quan trọng nhất
                ->first();

            // Không tìm thấy hoặc không active
            if (!$promo) {
                return [
                    'success' => false,
                    'message' => "Mã \"$code\" không tồn tại, đã hết hạn hoặc hết lượt sử dụng.",
                    'discount' => 0,
                ];
            }

            // Kiểm tra giới hạn lượt dùng toàn cục (dùng accessor realtime)
            if ($promo->usage_limit !== null && $promo->used_count >= $promo->usage_limit) {
                return [
                    'success' => false,
                    'message' => "Mã \"$code\" đã hết lượt sử dụng.",
                    'discount' => 0,
                ];
            }

            // Kiểm tra đơn hàng tối thiểu
            if (($promo->min_order_amount ?? 0) > $subtotal) {
                return [
                    'success' => false,
                    'message' => "Đơn hàng phải từ " . number_format($promo->min_order_amount ?? 0) . "đ để dùng mã này.",
                    'discount' => 0,
                ];
            }

            // Kiểm tra giới hạn mỗi người dùng
            if ($userId && $promo->per_user_limit !== null) {
                $usedByUser = DB::table('order')
                    ->where('promotion_code', $promo->code)
                    ->where('user_id', $userId)
                    ->whereIn('status', ['processing', 'completed', 'shipped', 'done'])
                    ->count();

                if ($usedByUser >= $promo->per_user_limit) {
                    return [
                        'success' => false,
                        'message' => "Bạn đã dùng hết lượt của mã \"$code\".",
                        'discount' => 0,
                    ];
                }
            }

            // Kiểm tra target (sản phẩm, gói, danh mục)
            if ($promo->targets->isNotEmpty()) {
                $matched = false;
                foreach ($cart_items as $item) {
                    foreach ($promo->targets as $target) {
                        $type = $item['type'] ?? '';

                        if ($target->target_type === 'membership_package' && $type === 'membership' && $item['package_id'] == $target->target_id) {
                            $matched = true;
                            break 2;
                        }
                        if ($target->target_type === 'product_category' && ($item['category_id'] ?? null) == $target->target_id) {
                            $matched = true;
                            break 2;
                        }
                        if ($target->target_type === 'product' && ($item['variant_id'] ?? null) == $target->target_id) {
                            $matched = true;
                            break 2;
                        }
                    }
                }

                if (!$matched) {
                    return [
                        'success' => false,
                        'message' => "Mã \"$code\" chỉ áp dụng cho một số sản phẩm/gói nhất định.",
                        'discount' => 0,
                    ];
                }
            }

            // Tính tiền giảm
            $discount = $promo->is_percent
                ? $subtotal * ($promo->discount_value / 100)
                : $promo->discount_value;

            if ($promo->max_discount !== null) {
                $discount = min($discount, $promo->max_discount);
            }

            return [
                'success'        => true,
                'message'        => "Áp dụng thành công mã $code: {$promo->title}",
                'discount'       => round($discount),
                'promotion_code' => $promo->code,
            ];
        });
    }

    // Hàm lấy danh sách mã active (giữ nguyên như cũ)
    public static function getActivePromotions(): \Illuminate\Support\Collection
    {
        return Promotion::active()
            ->with('targets')
            ->get()
            ->filter(function ($promo) {
                if ($promo->usage_limit !== null && $promo->used_count >= $promo->usage_limit) {
                    return false;
                }
                return true;
            })
            ->keyBy(fn($p) => strtoupper($p->code));
    }
}
