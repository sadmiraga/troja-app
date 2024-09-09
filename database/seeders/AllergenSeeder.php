<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllergenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('allergens')->delete();
        
        $allergens = array(
            array('name' => 'žito z glutenom','shortcode'=>'GL'),
            array('name' => 'gorčično seme','shortcode'=>'GO'),
            array('name' => 'raki','shortcode'=>'RA'),
            array('name' => 'sezamovo seme','shortcode'=>'SS'),
            array('name' => 'jajca','shortcode'=>'JA'),
            array('name' => 'ribe','shortcode'=>'RI'),
            array('name' => 'žveplov dioksid','shortcode'=>'ŽD'),
            array('name' => 'soja','shortcode'=>'SO'),
            array('name' => 'arašidi','shortcode'=>'AR'),
            array('name' => 'volčji bob','shortcode'=>'VB'),
            array('name' => 'mleko in mlečni proizvodi z laktozo','shortcode'=>'LA'),
            array('name' => 'mehkužci','shortcode'=>'ME'),
            array('name' => 'oreščki','shortcode'=>'OR'),
            array('name' => 'listna zelene','shortcode'=>'LZ'),
        );
        DB::table('allergens')->insert($allergens);
    }
}
