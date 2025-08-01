<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = ['IT', 'HR', 'Finance', 'Operations', 'Admin', 'Library'];

        foreach ($departments as $name) {
            DB::table('departments')->updateOrInsert(
                ['name' => $name],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
