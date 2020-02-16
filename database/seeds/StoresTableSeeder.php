<?php

use Illuminate\Database\Seeder;
use App\Imports\StoreImport;
use App\ORM\Store;
use Maatwebsite\Excel\Facades\Excel;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Log::info('d');
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \Log::info('d');
        Store::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        \Log::info('d');
        $file_name = "database/seeds/data/store.xlsx";
        Excel::import(new StoreImport, $file_name);
    }
}
