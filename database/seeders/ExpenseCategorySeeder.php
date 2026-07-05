<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [

            [
                'expense_category_name' => 'Office Expenses',
                'expense_category_code' => 'OFFICE'
            ],

            [
                'expense_category_name' => 'Utilities',
                'expense_category_code' => 'UTILITY'
            ],

            [
                'expense_category_name' => 'Marketing & Advertising',
                'expense_category_code' => 'MARKETING'
            ],

            [
                'expense_category_name' => 'Travel & Transportation',
                'expense_category_code' => 'TRAVEL'
            ],

            [
                'expense_category_name' => 'Software & Subscriptions',
                'expense_category_code' => 'SOFTWARE'
            ],

            [
                'expense_category_name' => 'Hosting & Domains',
                'expense_category_code' => 'HOSTING'
            ],

            [
                'expense_category_name' => 'Professional Services',
                'expense_category_code' => 'PROFESSIONAL'
            ],

            [
                'expense_category_name' => 'Legal & Compliance',
                'expense_category_code' => 'LEGAL'
            ],

            [
                'expense_category_name' => 'Accounting & Tax',
                'expense_category_code' => 'ACCOUNTING'
            ],

            [
                'expense_category_name' => 'Bank Charges',
                'expense_category_code' => 'BANK'
            ],

            [
                'expense_category_name' => 'Employee Expenses',
                'expense_category_code' => 'EMPLOYEE'
            ],

            [
                'expense_category_name' => 'Training & Education',
                'expense_category_code' => 'TRAINING'
            ],

            [
                'expense_category_name' => 'Repairs & Maintenance',
                'expense_category_code' => 'MAINTENANCE'
            ],

            [
                'expense_category_name' => 'Equipment & Hardware',
                'expense_category_code' => 'EQUIPMENT'
            ],

            [
                'expense_category_name' => 'Internet & Communication',
                'expense_category_code' => 'COMMUNICATION'
            ],

            [
                'expense_category_name' => 'Furniture & Fixtures',
                'expense_category_code' => 'FURNITURE'
            ],

            [
                'expense_category_name' => 'Rent',
                'expense_category_code' => 'RENT'
            ],

            [
                'expense_category_name' => 'Insurance',
                'expense_category_code' => 'INSURANCE'
            ],

            [
                'expense_category_name' => 'Licenses & Permits',
                'expense_category_code' => 'LICENSE'
            ],

            [
                'expense_category_name' => 'Miscellaneous',
                'expense_category_code' => 'MISC'
            ],
        ];

        $data = [];

        foreach ($categories as $category) {

            $data[] = [
                'expense_category_name' => $category['expense_category_name'],
                'expense_category_code' => $category['expense_category_code'],
                'user_id' => 2,
            ];
        }

        DB::table('expense_categories')->insert($data);

        $this->command->info(
            count($data) . ' Expense Categories Created Successfully.'
        );
    }
}