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
        $this->call(AllergenSeeder::class);
        $this->call(CategorySeeder::class);
        //$this->call(WeeklyCategorySeeder::class);
        $this->call(UserTypeSeeder::class);
        $this->call(LocationSeeder::class);
        //$this->call(usersSeeder::class);
        
    }
}
