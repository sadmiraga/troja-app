<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('locations')->delete();
        
        $locations = array(
            array('name' => 'KGG - 1','image'=>'food','image_url'=>'https://fnx.si/images/catering1.png'),
            array('name' => 'KGG - 2','image'=>'food','image_url'=>'https://fnx.si/images/drinks2.png'),
            array('name' => 'KGG - 3','image'=>'food','image_url'=>'https://fnx.si/images/drinks3.png'),
            array('name' => 'KGG - 4','image'=>'food','image_url'=>'https://fnx.si/images/drinks4.png'),
            array('name' => 'KGG - 5','image'=>'food','image_url'=>'https://fnx.si/images/drinks1.png')


        );
        DB::table('locations')->insert($locations);
    }
}
