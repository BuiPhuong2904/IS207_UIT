<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RentalTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa sạch dữ liệu
        DB::table('rental_transaction')->truncate();

        // Đặt ngày 
        $today = Carbon::parse('2025-11-17');

        // Tạo giao dịch
        DB::table('rental_transaction')->insert([
            
            // --- CÁC GIAO DỊCH ĐÃ TRẢ (Status: returned) ---

            // 1. User 27 (HCM) thuê Khăn (item 1) ở CN 1
            [
                'user_id' => 27, // Trần Thị Quỳnh (HCM)
                'item_id' => 1,  // Khăn tắm (Branch 1)
                'quantity' => 1,
                'borrow_date' => $today->copy()->subDays(5),
                'return_date' => $today->copy()->subDays(5),
                'status' => 'returned',
                'note' => 'Khách thuê theo ngày',
            ],
            // 2. User 25 (Hanoi) thuê Tủ đồ (item 8) ở CN 4
            [
                'user_id' => 25, // Vũ Thị Ngọc (Hanoi)
                'item_id' => 8,  // Tủ đồ (Branch 4)
                'quantity' => 1,
                'borrow_date' => $today->copy()->subDays(10), 
                'return_date' => $today->copy()->subDays(2),
                'status' => 'returned',
                'note' => 'Hết hạn thuê 1 tuần',
            ],
            // 3. User 30 (Danang) thuê Găng tay (item 11) ở CN 7
            [
                'user_id' => 30, // Võ Văn Tiến (Danang)
                'item_id' => 11, // Găng 12oz (Branch 7)
                'quantity' => 1,
                'borrow_date' => $today->copy()->subDays(3),
                'return_date' => $today->copy()->subDays(3), 
                'status' => 'returned',
                'note' => null,
            ],
            // 4. User 26 (Hanoi) thuê Con lăn (item 17) ở CN 4
            [
                'user_id' => 26, // Đỗ Văn Phúc (Hanoi)
                'item_id' => 17, // Con lăn (Branch 4)
                'quantity' => 1,
                'borrow_date' => $today->copy()->subDay(),
                'return_date' => $today->copy()->subDay(), 
                'status' => 'returned',
                'note' => null,
            ],
            // 5. User 33 (HCM) thuê Thảm (item 12) ở CN 1
            [
                'user_id' => 33, // Huỳnh Thị Cẩm (HCM)
                'item_id' => 12, // Thảm Yoga (Branch 1)
                'quantity' => 1,
                'borrow_date' => $today->copy()->subDay(),
                'return_date' => $today->copy()->subDay(),
                'status' => 'returned',
                'note' => null,
            ],
            // 6. User 29 (HCM) thuê Đai lưng (item 15) ở CN 2
            [
                'user_id' => 29, // Phan Thị Thảo (HCM)
                'item_id' => 15, // Đai lưng (Branch 2)
                'quantity' => 1,
                'borrow_date' => $today->copy()->subDays(7),
                'return_date' => $today->copy()->subDays(7),
                'status' => 'returned',
                'note' => 'Thuê tập thử',
            ],
            // 7. User 27 (HCM) thuê Khăn (item 1) ở CN 1 (thuê lần 2)
             [
                'user_id' => 27, // Trần Thị Quỳnh (HCM)
                'item_id' => 1,  // Khăn tắm (Branch 1)
                'quantity' => 1,
                'borrow_date' => $today->copy()->subDays(2),
                'return_date' => $today->copy()->subDays(2),
                'status' => 'returned',
                'note' => null,
            ],

            // --- CÁC GIAO DỊCH ĐANG THUÊ (Status: renting) ---

            // 8. User 31 (HCM) thuê Tủ đồ (item 7) ở CN 1
            [
                'user_id' => 31, // Đặng Thị Uyên (HCM)
                'item_id' => 7,  // Tủ đồ (Branch 1)
                'quantity' => 1,
                'borrow_date' => $today->copy()->subDays(2), 
                'return_date' => null,
                'status' => 'renting',
                'note' => 'Thuê 1 tháng',
            ],
            // 9. User 34 (HCM) thuê Tủ đồ (item 7) ở CN 1
            [
                'user_id' => 34, // Nguyễn Văn Hùng (HCM)
                'item_id' => 7,  // Tủ đồ (Branch 1)
                'quantity' => 1,
                'borrow_date' => $today->copy()->subDay(), 
                'return_date' => null, 
                'status' => 'renting',
                'note' => 'Thuê 1 tháng',
            ],
            // 10. User 28 (Danang) thuê Con lăn (item 16) ở CN 7
            [
                'user_id' => 28, // Lý Văn Sang (Danang)
                'item_id' => 16, // Con lăn (Branch 7)
                'quantity' => 1,
                'borrow_date' => $today, 
                'return_date' => null,
                'status' => 'renting',
                'note' => null,
            ],
            // 11. User 30 (Danang) thuê Găng tay (item 11) ở CN 7
            [
                'user_id' => 30, // Võ Văn Tiến (Danang)
                'item_id' => 11, // Găng 12oz (Branch 7)
                'quantity' => 1,
                'borrow_date' => $today, 
                'return_date' => null,
                'status' => 'renting',
                'note' => 'Thuê cho lớp Boxing',
            ],
            // 12. User 25 (Hanoi) thuê Tủ đồ (item 8) ở CN 4
            [
                'user_id' => 25, // Vũ Thị Ngọc (Hanoi)
                'item_id' => 8,  // Tủ đồ (Branch 4)
                'quantity' => 1,
                'borrow_date' => $today->copy()->subDay(),
                'return_date' => null,
                'status' => 'renting',
                'note' => 'Thuê 1 tháng',
            ],
            // 13. User 32 (Hanoi) thuê Tủ đồ (item 9) ở CN 5
            [
                'user_id' => 32, // Trịnh Văn Bình (Hanoi)
                'item_id' => 9,  // Tủ đồ (Branch 5)
                'quantity' => 1,
                'borrow_date' => $today,
                'return_date' => null,
                'status' => 'renting',
                'note' => 'Thuê 1 tháng',
            ],
            // 14. User 27 (HCM) thuê Khăn (item 1) ở CN 1
            [
                'user_id' => 27, // Trần Thị Quỳnh (HCM)
                'item_id' => 1,  // Khăn tắm (Branch 1)
                'quantity' => 1,
                'borrow_date' => $today,
                'return_date' => null,
                'status' => 'renting',
                'note' => null,
            ],
            // 15. User 29 (HCM) thuê Bóng Massage (item 4) ở CN 1
            [
                'user_id' => 29, // Phan Thị Thảo (HCM)
                'item_id' => 4,  // Bóng Massage (Branch 1)
                'quantity' => 1,
                'borrow_date' => $today,
                'return_date' => null,
                'status' => 'renting',
                'note' => 'Thuê dùng tại chỗ',
            ],
        ]);

        // --- CẬP NHẬT LẠI SỐ LƯỢNG KHO (quantity_available) ---
        // Item 1 (CN 1):
        DB::table('rental_item')->where('item_id', 1)->update(['quantity_available' => 49]);
        
        // Item 4 (CN 1): 
        DB::table('rental_item')->where('item_id', 4)->update(['quantity_available' => 39]);
        
        // Item 7 (CN 1): 
        DB::table('rental_item')->where('item_id', 7)->update(['quantity_available' => 48]);
        
        // Item 8 (CN 4):
        DB::table('rental_item')->where('item_id', 8)->update(['quantity_available' => 49]);
        
        // Item 9 (CN 5): 
        DB::table('rental_item')->where('item_id', 9)->update(['quantity_available' => 49]);

        // Item 11 (CN 7): 
        DB::table('rental_item')->where('item_id', 11)->update(['quantity_available' => 39]);
        
        // Item 16 (CN 7):
        DB::table('rental_item')->where('item_id', 16)->update(['quantity_available' => 24]);
    }
}