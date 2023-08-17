<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_names')->insert([
          ['name' => 'طلبات'],
          ['name' => 'توترز'],
          ['name' => 'بلي'],
          ['name' => 'ع السريع'],
          ['name' => 'طلباتي'],
        ]);
    }
}
