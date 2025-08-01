<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Azeem Khan',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role' => 'Admin',
            ],
            [
                'name' => 'Sara Malik',
                'email' => 'it@example.com',
                'password' => bcrypt('password'),
                'role' => 'IT',
            ],
            [
                'name' => 'Rohan Mehta',
                'email' => 'head@example.com',
                'password' => bcrypt('password'),
                'role' => 'Head',
            ],
            [
                'name' => 'Neha Verma',
                'email' => 'employee@example.com',
                'password' => bcrypt('password'),
                'role' => 'Employee',
            ],
            [
                'name' => 'Fatima Ahmed',
                'email' => 'library@example.com',
                'password' => bcrypt('password'),
                'role' => 'Employee',
            ],
            [
                'name' => 'Imran Sheikh',
                'email' => 'finance@example.com',
                'password' => bcrypt('password'),
                'role' => 'Head',
            ],
            [
                'name' => 'Priya Iyer',
                'email' => 'hr@example.com',
                'password' => bcrypt('password'),
                'role' => 'Employee',
            ],
            [
                'name' => 'Zain Qureshi',
                'email' => 'tech@example.com',
                'password' => bcrypt('password'),
                'role' => 'IT',
            ],
            [
                'name' => 'Anjali Desai',
                'email' => 'ops@example.com',
                'password' => bcrypt('password'),
                'role' => 'Head',
            ],
            [
                'name' => 'Ravi Patel',
                'email' => 'guest@example.com',
                'password' => bcrypt('password'),
                'role' => 'Employee',
            ],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}
