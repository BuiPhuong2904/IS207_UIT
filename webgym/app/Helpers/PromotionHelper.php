<?php
// app/Helpers/PromotionHelper.php

namespace App\Helpers;

use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PromotionHelper
{
    /**
     * Lấy tất cả mã giảm giá đang hoạt động (còn hạn + is_active = 1)
     */
    public static function getActivePromotions(): Collection
    {
        $now = Carbon::now();

        return Promotion::with('targets')
            ->where('is_active', true)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->get()
            ->keyBy('code')
            ->map(fn($p) => [
                'title'            => $p->title,
                'description'      => $p->description,
                'is_percent'       => (bool)$p->is_percent,
                'discount_value'   => (float)$p->discount_value,
                'min_order_amount' => (float)($p->min_order_amount ?? 0),
                'max_discount'     => (float)($p->max_discount ?? PHP_INT_MAX),
                'target_type'      => $p->targets->pluck('target_type')->first(),
                'target_ids'       => $p->targets->pluck('target_id')->toArray(),
            ]);
    }

    /**
     * Kiểm tra xem mã có áp dụng được cho giỏ hàng không
     */
    public static function validateAndApply(string $code, array $cart_items, float $subtotal): array
    {
        $code = strtoupper(trim($code));
        $promotions = self::getActivePromotions();

        if (!$promotions->has($code)) {
            return [
                'success' => false,
                'message' => "Mã \"$code\" không tồn tại hoặc đã hết hạn.",
                'discount' => 0,
            ];
        }

        $promo = $promotions->get($code);

        // Kiểm tra đơn tối thiểu
        if ($subtotal < $promo['min_order_amount']) {
            return [
                'success' => false,
                'message' => "Mã \"$code\" chỉ áp dụng cho đơn từ " . number_format($promo['min_order_amount']) . "đ",
                'discount' => 0,
            ];
        }

        // Kiểm tra target (nếu có)
        if (!empty($promo['target_type']) && !empty($promo['target_ids'])) {
            $matched = false;
            foreach ($cart_items as $item) {
                $itemType = $item['type'] ?? 'product'; // membership / product

                if ($promo['target_type'] === 'category' && !empty($item['category_id']) && in_array($item['category_id'], $promo['target_ids'])) {
                    $matched = true; break;
                }
                if ($promo['target_type'] === 'product' && !empty($item['product_id']) && in_array($item['product_id'], $promo['target_ids'])) {
                    $matched = true; break;
                }
                if ($promo['target_type'] === 'membership' && $itemType === 'membership') {
                    $matched = true; break;
                }
            }

            if (!$matched) {
                return [
                    'success' => false,
                    'message' => "Mã \"$code\" chỉ áp dụng cho một số sản phẩm/danh mục nhất định.",
                    'discount' => 0,
                ];
            }
        }

        // Tính giảm giá
        $discount = $promo['is_percent']
            ? $subtotal * ($promo['discount_value'] / 100)
            : $promo['discount_value'];

        $discount = min($discount, $promo['max_discount']);

        return [
            'success' => true,
            'message' => "Áp dụng thành công mã $code: {$promo['title']}",
            'discount' => $discount,
            'promo'    => $promo,
        ];
    }
}
