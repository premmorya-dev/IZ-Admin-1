<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('en_IN');

        $categoryIds = DB::table('item_categories')
            ->where('user_id', 2)
            ->pluck('item_category_id')
            ->toArray();

        $taxIds = DB::table('taxes')
            ->where('user_id', 2)
            ->pluck('tax_id')
            ->toArray();

        $discountIds = DB::table('discounts')
            ->where('user_id', 2)
            ->pluck('discount_id')
            ->toArray();

        if (
            empty($categoryIds) ||
            empty($taxIds) ||
            empty($discountIds)
        ) {
            $this->command->error(
                'Please seed Categories, Taxes and Discounts first.'
            );

            return;
        }

        $items = [];

        $productNames = [
            'Website Development',
            'Mobile App Development',
            'SEO Package',
            'Digital Marketing',
            'Cloud Hosting',
            'Domain Registration',
            'Business Consulting',
            'GST Filing Service',
            'Graphic Design',
            'Logo Design',
            'Social Media Management',
            'Software License',
            'Laptop',
            'Desktop Computer',
            'Printer',
            'Router',
            'Network Switch',
            'Security Camera',
            'Annual Maintenance',
            'Technical Support'
        ];

        for ($i = 1; $i <= 10; $i++) {

            $basePrice = rand(500, 50000);

            $items[] = [

                'user_id' => 2,

                'item_category_id' =>
                    $categoryIds[array_rand($categoryIds)],

                'item_name' =>
                    $productNames[array_rand($productNames)]
                  ,

                'description' =>
                    $faker->paragraph(),

                'item_code' =>
                    'ITEM' . str_pad($i, 30, '0', STR_PAD_LEFT),

                'sku' =>
                    'SKU' . strtoupper(
                        $faker->bothify('###??')
                    ),

                'hsn_sac' =>
                    rand(1000, 999999),

                'item_type' =>
                    rand(0, 1)
                        ? 'product'
                        : 'service',

                'unit_price' =>
                    $basePrice,

                'cost_price' =>
                    round($basePrice * 0.70, 2),

                'selling_price' =>
                    $basePrice,

                'stock' =>
                    rand(100, 500),

                'status' =>
                    'Y',

                'tax_id' =>
                    $taxIds[array_rand($taxIds)],

                'discount_id' =>
                    $discountIds[array_rand($discountIds)],

                'created_at' =>
                    Carbon::now(),

                'updated_at' =>
                    Carbon::now(),
            ];
        }

        foreach (array_chunk($items, 100) as $chunk) {
            DB::table('items')
                ->insert($chunk);
        }

        $this->command->info(
            '10 Items Created Successfully.'
        );
    }
}