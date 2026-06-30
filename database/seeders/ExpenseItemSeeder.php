<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxIds = DB::table('taxes')
            ->where('user_id', 2)
            ->pluck('tax_id')
            ->toArray();

        $discountIds = DB::table('discounts')
            ->where('user_id', 2)
            ->pluck('discount_id')
            ->toArray();

        $expenseCategories = DB::table('expense_categories')
            ->where('user_id', 2)
            ->pluck('expense_category_id')
            ->toArray();

        $expenseItems = [

            'Office Rent',
            'Electricity Bill',
            'Internet Bill',
            'Mobile Recharge',
            'Office Supplies',
            'Printer Ink',
            'Printer Maintenance',
            'Laptop Repair',
            'Computer Accessories',
            'Software Subscription',
            'Cloud Hosting',
            'Domain Renewal',
            'SSL Certificate',
            'Facebook Ads',
            'Google Ads',
            'Instagram Ads',
            'Marketing Expense',
            'Travel Expense',
            'Fuel Expense',
            'Courier Charges',
            'Consultant Fees',
            'Legal Fees',
            'Accounting Fees',
            'Bank Charges',
            'Office Cleaning',
            'Security Service',
            'Employee Refreshments',
            'Training Expense',
            'Business License Fee',
            'CRM Subscription',
            'Email Service',
            'Project Management Tool',
            'Meeting Expense',
            'Transportation Expense',
            'Repair & Maintenance',
            'Equipment Purchase',
            'Office Furniture',
            'Internet Marketing',
            'Miscellaneous Expense',
            'Website Maintenance',
        ];

        $data = [];

        foreach ($expenseItems as $index => $item) {

            $data[] = [

                'user_id' => 2,

                'expense_item_name' => $item,

                'expense_item_code' => 'EXP' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),

                'hsn_sac' => rand(100000, 999999),

                'expense_item_type' => collect([
                    'product',
                    'service'
                ])->random(),

                'unit_price' => rand(500, 25000),

                'status' => 'Y',

                'tax_id' => !empty($taxIds)
                    ? $taxIds[array_rand($taxIds)]
                    : null,

                'discount_id' => !empty($discountIds)
                    ? $discountIds[array_rand($discountIds)]
                    : null,

                'expense_category_id' => !empty($expenseCategories)
                    ? $expenseCategories[array_rand($expenseCategories)]
                    : null,
            ];
        }

        DB::table('expense_items')->insert($data);

        $this->command->info(
            count($data) . ' Expense Items Created Successfully.'
        );
    }
}