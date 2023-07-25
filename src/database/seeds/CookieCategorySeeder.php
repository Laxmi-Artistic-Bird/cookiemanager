<?php

namespace Artisticbird\Cookies\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CookieCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('cookie_categories')->where('title', 'Necessary')->exists()) {
            $this->command->info('Data already exists, skipping seeding.');
            return;
        }

        DB::table('cookie_categories')->insert([
            ['title' => 'Necessary'],
            ['title' => 'Functional'],
            ['title' => 'Analytics'],
            ['title' => 'Performance'],
            ['title' => 'Advertisement']
        ]);
    }
}
