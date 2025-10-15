<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code' => 'WELCOME10',
                'name' => 'Chào mừng khách hàng mới',
                'description' => 'Giảm 10% cho đơn hàng đầu tiên',
                'type' => 'percentage',
                'value' => 10.00,
                'minimum_amount' => 100.00,
                'usage_limit' => 100,
                'used_count' => 0,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'is_active' => true
            ],
            [
                'code' => 'PIZZA50K',
                'name' => 'Giảm 50k',
                'description' => 'Giảm 50k cho đơn hàng từ 200k',
                'type' => 'fixed',
                'value' => 50.00,
                'minimum_amount' => 200.00,
                'usage_limit' => 50,
                'used_count' => 0,
                'start_date' => now(),
                'end_date' => now()->addMonth(),
                'is_active' => true
            ]
        ];

        foreach ($coupons as $coupon) {
            Coupon::create($coupon);
        }
    }
}
