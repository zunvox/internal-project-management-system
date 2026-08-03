<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'phone' => '0123456789',
            'password' => 'password',
            'role' => 'Admin',
            'status' => 'Active',
        ]);

        User::create([
            'name' => 'Test Developer',
            'email' => 'developer@example.com',
            'phone' => '0123456788',
            'password' => 'password',
            'role' => 'Developer',
            'status' => 'Active',
        ]);

        User::create([
            'name' => 'Inactive Developer',
            'email' => 'inactive@example.com',
            'phone' => '0111111111',
            'password' => 'password',
            'role' => 'Developer',
            'status' => 'Inactive',
        ]);
    }
}
