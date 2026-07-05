<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Address;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([          
            DiscountSeeder::class,
            TaxSeeder::class,  
            ClientSeeder::class,
            ExpenseCategorySeeder::class,
            ExpenseItemSeeder::class,
            ItemCategorySeeder::class,
            ItemSeeder::class,
            VendorSeeder::class,
        ]);

     
    }
}
