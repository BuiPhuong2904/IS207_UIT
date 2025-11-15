<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // TẮT KIỂM TRA KHÓA NGOẠI
        Schema::disableForeignKeyConstraints();

        // GỌI TẤT CẢ SEEDER
        $this->call([
            UserSeeder::class,
            BranchSeeder::class,
            ProductCategorySeeder::class,
            MembershipPackageSeeder::class,
            PromotionSeeder::class,
            TrainerSeeder::class,
            
            // -- BlogPostSeeder::class,
            RentalItemSeeder::class,
            ProductSeeder::class,
            ProductVariantSeeder::class,
            ClassSeeder::class,
            PromotionTargetSeeder::class,

            ClassScheduleSeeder::class,
            PackageRegistrationSeeder::class,
            RentalTransactionSeeder::class,
            OrderSeeder::class,
            ClassRegistrationSeeder::class,
            // -- OrderDetailSeeder::class,
            PaymentSeeder::class,
        ]);

        // BẬT LẠI KIỂM TRA KHÓA NGOẠI
        Schema::enableForeignKeyConstraints();
    }
}