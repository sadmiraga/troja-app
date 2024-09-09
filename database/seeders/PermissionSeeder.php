<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    $groups = [
        'user',
        'product',
        'mystocktaking',
        'stocktaking',
        'delivery',
        'category',
        'drink',
        'food',
        // Add more group names as needed.
    ];

    foreach ($groups as $group) {
        \DB::table('permissions')->insert([
            'name' => $group,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

}
