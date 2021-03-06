<?php

use App\Imports\AccountMethodImport;
use App\ORM\AccountMethod;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class AccountMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        AccountMethod::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $file_name = 'database/seeds/data/account_method.xlsx';
        Excel::import(new AccountMethodImport(), $file_name);
    }
}
