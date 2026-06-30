<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [

            ['Electronics', 'CAT001'],
            ['Software', 'CAT002'],
            ['Web Development', 'CAT003'],
            ['Mobile App Development', 'CAT004'],
            ['Digital Marketing', 'CAT005'],
            ['SEO Services', 'CAT006'],
            ['Graphic Design', 'CAT007'],
            ['UI UX Design', 'CAT008'],
            ['Hosting Services', 'CAT009'],
            ['Domain Services', 'CAT010'],

            ['Consulting', 'CAT011'],
            ['Training', 'CAT012'],
            ['Maintenance', 'CAT013'],
            ['Support Services', 'CAT014'],
            ['Cloud Services', 'CAT015'],
            ['Office Supplies', 'CAT016'],
            ['Computer Hardware', 'CAT017'],
            ['Networking', 'CAT018'],
            ['Security Solutions', 'CAT019'],
            ['Accounting Services', 'CAT020'],

            ['Legal Services', 'CAT021'],
            ['Business Registration', 'CAT022'],
            ['GST Services', 'CAT023'],
            ['Printing Services', 'CAT024'],
            ['Advertising', 'CAT025'],
            ['Photography', 'CAT026'],
            ['Video Production', 'CAT027'],
            ['Content Writing', 'CAT028'],
            ['Translation Services', 'CAT029'],
            ['Data Entry', 'CAT030'],

            ['Furniture', 'CAT031'],
            ['Electrical Items', 'CAT032'],
            ['Construction Material', 'CAT033'],
            ['Interior Design', 'CAT034'],
            ['Automobile Services', 'CAT035'],
            ['Travel Services', 'CAT036'],
            ['Courier Services', 'CAT037'],
            ['Packaging', 'CAT038'],
            ['Stationery', 'CAT039'],
            ['Medical Equipment', 'CAT040'],

            ['Education Services', 'CAT041'],
            ['Event Management', 'CAT042'],
            ['Insurance Services', 'CAT043'],
            ['Financial Services', 'CAT044'],
            ['Subscription Services', 'CAT045'],
            ['IT Services', 'CAT046'],
            ['Cloud Hosting', 'CAT047'],
            ['SaaS Products', 'CAT048'],
            ['Freelance Services', 'CAT049'],
            ['Miscellaneous', 'CAT050'],
        ];

        $insertData = [];

        foreach ($categories as $category) {

            $insertData[] = [
                'user_id' => 2,
                'item_category_name' => $category[0],
                'item_category_code' => $category[1],
            ];
        }

        DB::table('item_categories')->insert($insertData);

        $this->command->info('50 Item Categories Created Successfully.');
    }
}