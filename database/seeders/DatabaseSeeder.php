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
            'userid' => 'ADM-0001',
            'fullname' => 'System Admin',
            'username' => 'SysAdmin',
            'email' => 'admin@example.com',
            'phone' => '0123456789',
            'password' => 'password',
            'role' => 'Admin',
            'status' => 'Active',
        ]);

        User::create([
            'userid' => 'DEV-0001',
            'fullname' => 'Test Developer',
            'username' => 'TesDev',
            'email' => 'developer@example.com',
            'phone' => '0123456788',
            'password' => 'password',
            'role' => 'Developer',
            'status' => 'Active',
        ]);

        User::create([
            'userid' => 'Dev-0002',
            'fullname' => 'Inactive Developer',
            'username' => 'InacDev',
            'email' => 'inactive@example.com',
            'phone' => '0111111111',
            'password' => 'password',
            'role' => 'Developer',
            'status' => 'Inactive',
        ]);
    }
}
