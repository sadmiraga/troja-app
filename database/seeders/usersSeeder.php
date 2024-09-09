<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Seeder;

class usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->delete();
        $users = array(
            array('name' => 'sadmir', 'email' => 'sadmirvela@gmail.com', 'password' => Hash::make('password'), 'user_type_id' => 1),
            array('name' => 'sadmir', 'email' => 'admin@gmail.com', 'password' => Hash::make('password'), 'user_type_id' => 1),
        );
        DB::table('users')->insert($users);
    }
}
