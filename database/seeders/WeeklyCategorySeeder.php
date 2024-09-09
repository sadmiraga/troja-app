<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class WeeklyCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('weekly_categories')->delete();
        
        $weekly_categories = array(
            array('name' => 'Na žlico'),
            array('name' => 'Malica'),
            array('name' => 'Glavna jed'),
            array('name' => 'Vegi'),
            array('name' => 'Special Burger')
        );
        DB::table('weekly_categories')->insert($weekly_categories);
    }
}
