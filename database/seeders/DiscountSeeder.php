<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        $now = Carbon::now();

        $discounts = [
            [
                'user_id'      => 2,
                'name'         => 'No Discount',
                'percent'      => 0.00,
                'is_default'   => 1,
                'status'       => 'Y',
                'discount_code'=> 'DISC000',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'user_id'      => 2,
                'name'         => 'Festival Offer 5%',
                'percent'      => 5.00,
                'is_default'   => 0,
                'status'       => 'Y',
                'discount_code'=> 'DISC005',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'user_id'      => 2,
                'name'         => 'Special Offer 10%',
                'percent'      => 10.00,
                'is_default'   => 0,
                'status'       => 'Y',
                'discount_code'=> 'DISC010',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'user_id'      => 2,
                'name'         => 'Premium Customer 15%',
                'percent'      => 15.00,
                'is_default'   => 0,
                'status'       => 'Y',
                'discount_code'=> 'DISC015',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'user_id'      => 2,
                'name'         => 'Bulk Order 20%',
                'percent'      => 20.00,
                'is_default'   => 0,
                'status'       => 'Y',
                'discount_code'=> 'DISC020',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'user_id'      => 2,
                'name'         => 'VIP Customer 25%',
                'percent'      => 25.00,
                'is_default'   => 0,
                'status'       => 'Y',
                'discount_code'=> 'DISC025',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ];

        DB::table('discounts')->insert($discounts);
    }
}
