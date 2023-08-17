<?php

namespace Database\Seeders;

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
        $this->call(BranchSeeder::class);
        $this->call(OrderTypeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(AppNameSeeder::class);
    }
}
