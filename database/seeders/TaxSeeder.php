<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
      public function run(): void
    {
        $now = Carbon::now();

        $taxes = [
            [
                'user_id'     => 2,
                'name'        => 'GST 0%',
                'percent'     => 0.00,
                'status'      => 'Y',
                'is_default'  => 0,
                'tax_code'    => 'TAX000',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'user_id'     => 2,
                'name'        => 'GST 5%',
                'percent'     => 5.00,
                'status'      => 'Y',
                'is_default'  => 0,
                'tax_code'    => 'TAX005',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'user_id'     => 2,
                'name'        => 'GST 12%',
                'percent'     => 12.00,
                'status'      => 'Y',
                'is_default'  => 0,
                'tax_code'    => 'TAX012',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'user_id'     => 2,
                'name'        => 'GST 18%',
                'percent'     => 18.00,
                'status'      => 'Y',
                'is_default'  => 1,
                'tax_code'    => 'TAX018',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'user_id'     => 2,
                'name'        => 'GST 28%',
                'percent'     => 28.00,
                'status'      => 'Y',
                'is_default'  => 0,
                'tax_code'    => 'TAX028',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        DB::table('taxes')->insert($taxes);
    }
}




