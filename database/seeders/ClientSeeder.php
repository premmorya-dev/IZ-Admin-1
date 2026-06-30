<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $faker = Faker::create('en_IN');

        $clients = [];

        for ($i = 1; $i <= 10; $i++) {

            $clients[] = [

                'user_id'                => 2,

                'client_code'            => str_pad($i, 30, '0', STR_PAD_LEFT),

                'client_name'            => $faker->name(),

                'shipping_client_name'   => $faker->name(),

                'company_name'           => $faker->company(),

                'email'                  => $faker->unique()->safeEmail(),

                'phone'                  => '9' . $faker->numerify('#########'),

                'shipping_phone'         => '8' . $faker->numerify('#########'),

                'gst_number'             => strtoupper(
                    sprintf(
                        '%02d%s%04d%s1Z%d',
                        rand(1, 37),
                        strtoupper($faker->lexify('AAAAA')),
                        rand(1000, 9999),
                        strtoupper($faker->lexify('A')),
                        rand(1, 9)
                    )
                ),

                'address_1'              => $faker->streetAddress(),

                'shipping_address_1'     => $faker->streetAddress(),

                'address_2'              => $faker->streetAddress(),

                'shipping_address_2'     => $faker->streetAddress(),

                'city'                   => $faker->city(),

                'shipping_city'          => $faker->city(),

                'state_id'               => 542,

                'shipping_state_id'      => 542,

                'country_id'             => 106,

                'shipping_country_id'    => 106,

                'zip'                    => $faker->postcode(),

                'shipping_zip'           => $faker->postcode(),

                'notes'                  => $faker->sentence(),

                'terms'                  => 'Payment due within 15 days.',

                'status'                 => 'active',

                'currency_code'          => 'INR',

                'created_at'             => Carbon::now(),

                'updated_at'             => Carbon::now(),
            ];
        }

        foreach (array_chunk($clients, 100) as $chunk) {
            DB::table('clients')->insert($chunk);
        }
    }
}
