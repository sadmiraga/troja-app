<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->delete();
        
        $categories = array(
            array('categoryName' => 'Topli napitki','drink_or_food'=>'drink'),
            array('categoryName' => 'Brezalkoholne pijače','drink_or_food'=>'drink'),
            array('categoryName' => 'Vina','drink_or_food'=>'drink'),
            array('categoryName' => 'Gin','drink_or_food'=>'drink'),
            array('categoryName' => 'Žgane pijače','drink_or_food'=>'drink'),
            array('categoryName' => 'Cocktails','drink_or_food'=>'drink'),
            array('categoryName' => 'Miksi','drink_or_food'=>'drink'),
            array('categoryName' => 'Boat','drink_or_food'=>'drink'),
            array('categoryName' => 'Burgerji','drink_or_food'=>'food'),
            array('categoryName' => 'Solate','drink_or_food'=>'food'),
            array('categoryName' => 'Krožniki','drink_or_food'=>'food'),
            array('categoryName' => 'Priloge','drink_or_food'=>'food'),
        );
        DB::table('categories')->insert($categories);
    }
}
