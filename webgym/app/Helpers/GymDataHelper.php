<?php

namespace App\Helpers;

use App\Models\MembershipPackage;
use App\Models\Promotion;
use App\Models\GymClass;
use App\Models\ClassSchedule;
use App\Models\Trainer;
use App\Models\ProductVariant;
use App\Models\Order;

class GymDataHelper
{
    public static function getRelevantData(string $message, ?int $userId = null): string
    {
        $message = strtolower($message);
        $data = [];

        // 1. Gói tập (tìm theo tên, gợi ý rẻ/phù hợp)
        if (str_contains($message, 'gói tập') || str_contains($message, 'membership') || str_contains($message, 'gói')) {
            $packages = MembershipPackage::select('package_name as name', 'price', 'duration_months', 'description')
                ->get();

            $list = [];
            foreach ($packages as $p) {
                $list[] = "- {$p->name}: " . number_format($p->price) . "đ/{$p->duration_months} tháng - {$p->description}";
            }

            $data[] = "Danh sách gói tập:\n" . implode("\n", $list);

            // Gợi ý thêm nếu hỏi "rẻ nhất" hoặc "phù hợp người mới"
            if (str_contains($message, 'rẻ nhất')) {
                $cheapest = MembershipPackage::orderBy('price')->first();
                $data[] = "Gói rẻ nhất: {$cheapest->name} - " . number_format($cheapest->price) . "đ";
            } elseif (str_contains($message, 'phù hợp người mới') || str_contains($message, 'người mới')) {
                $data[] = "Gợi ý cho người mới: Gói cơ bản (giá rẻ, dễ tập)";
            }

            // Tìm theo tên cụ thể
            if (preg_match('/gói (.+?)$/i', $message, $matches)) {
                $name = $matches[3];
                $package = MembershipPackage::where('package_name', 'like', "%{$name}%")->first();
                if ($package) {
                    $data[] = "Gói bạn hỏi: {$package->name} - {$package->description}";
                } else {
                    $data[] = "Không tìm thấy gói với tên '{$name}'";
                }
            }
        }

        // 2. Khuyến mãi (gợi ý hot nhất)
        if (str_contains($message, 'khuyến mãi') || str_contains($message, 'mã giảm') || str_contains($message, 'promotion')) {
            $promos = Promotion::active()->select('code', 'title', 'discount_value', 'is_percent')->get();
            $list = [];
            foreach ($promos as $p) {
                $discount = $p->is_percent ? $p->discount_value . '%' : number_format($p->discount_value) . 'đ';
                $list[] = "- {$p->code}: {$p->title} ({$discount})";
            }
            $data[] = "Khuyến mãi đang chạy:\n" . implode("\n", $list);

            // Gợi ý hot nếu hỏi "hot" hoặc "mạnh nhất"
            if (str_contains($message, 'hot') || str_contains($message, 'mạnh nhất')) {
                $hotPromo = Promotion::active()->orderByDesc('discount_value')->first();
                $data[] = "Khuyến mãi hot nhất: {$hotPromo->title} - Giảm {$hotPromo->discount_value}" . ($hotPromo->is_percent ? '%' : 'đ');
            }
        }

        // 3. Lớp học (tìm theo tên, gợi ý đông)
        if (str_contains($message, 'lớp học') || str_contains($message, 'yoga') || str_contains($message, 'zumba') || str_contains($message, 'crossfit')) {
            $classes = ClassSchedule::with(['gymClass', 'trainer.user'])->get();
            $list = [];
            foreach ($classes as $c) {
                $className = $c->gymClass->class_name ?? 'Lớp không tên';
                $trainerName = $c->trainer->user->full_name ?? 'Chưa chỉ định';
                $list[] = "- {$className}: {$c->day_of_week} lúc {$c->start_time} với HLV {$trainerName}";
            }
            $data[] = "Lịch lớp học:\n" . implode("\n", $list);

            // Tìm theo tên lớp
            if (preg_match('/lớp (.+?)$/i', $message, $matches)) {
                $name = $matches[1];
                $class = GymClass::where('class_name', 'like', "%{$name}%")->first();
                if ($class) {
                    $data[] = "Lớp bạn hỏi: {$class->class_name} - {$class->description}";
                } else {
                    $data[] = "Không tìm thấy lớp với tên '{$name}'";
                }
            }
        }

        // 4. Huấn luyện viên (PT) – nâng cao tìm kiếm theo nhu cầu
        if (str_contains($message, 'pt') || str_contains($message, 'huấn luyện viên') || str_contains($message, 'trainer') || str_contains($message, 'cá nhân') || str_contains($message, '1:1')) {
            $trainers = Trainer::with('user')->get();

            if ($trainers->isEmpty()) {
                $data[] = "Hiện tại chưa có thông tin huấn luyện viên.";
            } else {
                // Danh sách chung nếu hỏi tổng quát
                if (str_contains($message, 'danh sách') || str_contains($message, 'có những ai') || str_contains($message, 'có pt nào')) {
                    $list = [];
                    foreach ($trainers as $t) {
                        $name = $t->user->full_name ?? 'HLV không tên';
                        $list[] = "- {$name}: Chuyên {$t->specialty}, {$t->experience_years} năm kinh nghiệm";
                    }
                    $data[] = "Danh sách huấn luyện viên tại GRYND:\n" . implode("\n", $list);
                }

                // Tìm theo tên cụ thể
                if (preg_match('/(pt|hlv|huấn luyện viên)\s+(.+?)$/i', $message, $matches) ||
                    preg_match('/(.+?)\s+(pt|hlv|huấn luyện viên)/i', $message, $matches)) {
                    $name = $matches[2] ?? $matches[1];
                    $trainer = $trainers->firstWhere(fn($t) => str_contains(strtolower($t->user->full_name ?? ''), strtolower($name)));
                    if ($trainer) {
                        $name = $trainer->user->full_name;
                        $data[] = "Huấn luyện viên bạn hỏi là **{$name}**:\n- Chuyên môn: {$trainer->specialty}\n- Kinh nghiệm: {$trainer->experience_years} năm\n- Lịch làm việc: {$trainer->work_schedule}\nBạn muốn đặt lịch tập 1:1 với HLV này không ạ? 💪";
                    } else {
                        $data[] = "Mình không tìm thấy HLV tên '{$name}'. Bạn thử hỏi tên khác hoặc mô tả nhu cầu tập nhé!";
                    }
                }
                // Gợi ý theo nhu cầu tập (chuyên môn)
                else {
                    $suggestions = [];

                    // Từ khóa nhu cầu → chuyên môn tương ứng
                    $demandMap = [
                        'giảm cân'     => 'giảm cân',
                        'đốt mỡ'        => 'giảm cân',
                        'tăng cơ'       => 'tăng cơ',
                        'thể hình'      => 'thể hình',
                        'yoga'          => 'Yoga',
                        'zumba'         => 'Zumba',
                        'phục hồi'      => 'phục hồi',
                        'sau sinh'      => 'phục hồi',
                        'dinh dưỡng'    => 'dinh dưỡng',
                        'nữ'            => 'nữ', // giả sử có PT nữ
                        'nam'           => 'nam',
                        '1:1'           => 'tập cá nhân',
                        'cá nhân'       => 'tập cá nhân',
                    ];

                    $matchedDemand = null;
                    foreach ($demandMap as $keyword => $specialty) {
                        if (str_contains($message, $keyword)) {
                            $matchedDemand = $specialty;
                            break;
                        }
                    }

                    if ($matchedDemand) {
                        $matchedTrainers = $trainers->filter(fn($t) => str_contains(strtolower($t->specialty), strtolower($matchedDemand)));

                        if ($matchedTrainers->isNotEmpty()) {
                            $list = [];
                            foreach ($matchedTrainers as $t) {
                                $name = $t->user->full_name ?? 'HLV';
                                $list[] = "- {$name} (chuyên {$t->specialty})";
                            }
                            $data[] = "Với nhu cầu **{$matchedDemand}**, mình gợi ý các HLV sau:\n" . implode("\n", $list) . "\nBạn muốn tập thử với ai ạ? 😊";
                        } else {
                            $data[] = "Hiện chưa có HLV chuyên sâu về '{$matchedDemand}'. Bạn có thể hỏi thêm về gói tập tự do hoặc lớp nhóm nhé!";
                        }
                    } else {
                        // Nếu không match nhu cầu cụ thể → gợi ý chung
                        $data[] = "Bạn đang tìm HLV cho mục tiêu gì ạ? (giảm cân, tăng cơ, yoga, tập 1:1...) Mình sẽ gợi ý phù hợp nhất! 💪";
                    }
                }
            }
        }

        // 5. Sản phẩm (tìm theo tên, gợi ý hot/giảm mạnh)
        $keywords = ['whey', 'protein', 'bcaa', 'vitamin', 'pre-workout', 'áo', 'quần', 'tạ', 'dụng cụ'];
        $foundKeyword = false;
        foreach ($keywords as $kw) {
            if (str_contains($message, $kw)) {
                $foundKeyword = true;
                $products = ProductVariant::with('product')
                    ->whereHas('product', fn($q) => $q->where('product_name', 'like', "%{$kw}%"))
                    ->limit(5)
                    ->get();

                if ($products->isNotEmpty()) {
                    $list = [];
                    foreach ($products as $v) {
                        $name = $v->product->product_name ?? 'Sản phẩm không tên';
                        $original = number_format($v->price);
                        $discounted = number_format($v->discount_price ?? $v->price);
                        $list[] = "- {$name} (size {$v->size}): {$original}đ → {$discounted}đ";
                    }
                    $data[] = "Sản phẩm liên quan đến '{$kw}':\n" . implode("\n", $list);
                }
                break;
            }
        }

        // Nếu hỏi "hot" hoặc "giảm mạnh"
        if (str_contains($message, 'hot') || str_contains($message, 'giảm mạnh') && !$foundKeyword) {
            $hotProducts = ProductVariant::where('discount_price', '>', 0)
                ->with('product')
                ->orderByRaw('(price - discount_price) DESC')
                ->limit(5)
                ->get();

            if ($hotProducts->isNotEmpty()) {
                $list = [];
                foreach ($hotProducts as $v) {
                    $name = $v->product->product_name ?? 'Sản phẩm không tên';
                    $original = number_format($v->price);
                    $discounted = number_format($v->discount_price ?? $v->price);
                    $list[] = "- {$name}: {$original}đ → {$discounted}đ";
                }
                $data[] = "Sản phẩm hot / giảm mạnh nhất:\n" . implode("\n", $list);
            }
        }

        // 6. Trạng thái đơn hàng
        if ($userId && (str_contains($message, 'đơn hàng') || str_contains($message, 'order') || str_contains($message, 'mã đơn') || str_contains($message, 'trạng thái'))) {
            $orders = Order::where('user_id', $userId)
                ->orderByDesc('created_at')
                ->limit(5)
                ->get(['order_code', 'status', 'total_amount', 'created_at']);

            if ($orders->isNotEmpty()) {
                $list = [];
                foreach ($orders as $o) {
                    $list[] = "- Mã đơn: {$o->order_code}\n  Trạng thái: {$o->status}\n  Tổng tiền: " . number_format($o->total_amount) . "đ\n  Ngày đặt: " . $o->created_at->format('d/m/Y');
                }
                $data[] = "Các đơn hàng gần nhất của bạn:\n" . implode("\n\n", $list);
            } else {
                $data[] = "Bạn chưa có đơn hàng nào.";
            }
        }

        return $data ? "DỮ LIỆU TỪ HỆ THỐNG GRYND (cập nhật realtime):\n" . implode("\n\n", $data) : '';
    }
}
