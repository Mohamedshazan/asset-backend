<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Call department seeder first to ensure department IDs exist
        $this->call([
            DepartmentSeeder::class,
            UserSeeder::class,
            AssetSeeder::class,
        ]);
    }
}
