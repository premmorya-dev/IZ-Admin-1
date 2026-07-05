<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('en_IN');

        $vendors = [];

        $companies = [
            'Tata Consultancy Services',
            'Infosys Technologies',
            'Wipro Solutions',
            'Tech Mahindra',
            'HCL Technologies',
            'Reliance Industries',
            'Airtel Business',
            'Jio Platforms',
            'Google India',
            'Amazon Seller Services',
            'Microsoft India',
            'Zoho Corporation',
            'Freshworks',
            'Hostinger India',
            'GoDaddy India',
            'DigitalOcean',
            'AWS India',
            'Razorpay',
            'Cashfree Payments',
            'Shiprocket'
        ];

        for ($i = 1; $i <= 10; $i++) {

            $company = $companies[array_rand($companies)];

            $vendors[] = [

                'user_id' => 2,

                'vendor_code' =>
                     str_pad($i, 30, '0', STR_PAD_LEFT),

                'vendor_name' =>
                    $faker->name(),

                'company_name' =>
                    $company,

                'email' =>
                    'vendor'.$i.'@example.com',

                'phone' =>
                    '9'.$faker->numerify('#########'),

                'gst_number' =>
                    strtoupper(
                        sprintf(
                            '%02d%s%04d%s1Z%d',
                            rand(1, 37),
                            strtoupper($faker->lexify('AAAAA')),
                            rand(1000, 9999),
                            strtoupper($faker->lexify('A')),
                            rand(1, 9)
                        )
                    ),

                'address_1' =>
                    $faker->streetAddress(),

                'address_2' =>
                    $faker->streetAddress(),

                'city' =>
                    $faker->city(),

                'state_id' => 542,

                'country_id' => 106,

                'zip' =>
                    $faker->postcode(),

                'notes' =>
                    $faker->sentence(),

                'status' => collect([
                    'active',
                    'active',
                    'active',
                    'deactive'
                ])->random(),

                'currency_code' => 'INR',

                'created_at' => Carbon::now(),

                'updated_at' => Carbon::now(),
            ];
        }

        foreach (array_chunk($vendors, 50) as $chunk) {
            DB::table('vendors')->insert($chunk);
        }

        $this->command->info('10 Vendors Created Successfully.');
    }
}