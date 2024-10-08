<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->delete();
        $user_types = array(
            array('id' => 1, 'name' => 'admin'),
            array('id' => 2, 'name' => 'emplyee'),
            array('id' => 3, 'name' => 'lead'),
        );
        DB::table('user_types')->insert($user_types);
    }
}
