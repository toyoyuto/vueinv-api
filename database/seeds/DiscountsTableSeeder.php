<?php

use App\Imports\DiscountImport;
use App\ORM\Discount;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Discount::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $file_name = 'database/seeds/data/discount.xlsx';
        Excel::import(new DiscountImport(), $file_name);
    }
}
