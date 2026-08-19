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
            'userid' => 'DEV-0002',
            'fullname' => 'Inactive Developer',
            'username' => 'InacDev',
            'email' => 'inactive@example.com',
            'phone' => '0111111111',
            'password' => 'password',
            'role' => 'Developer',
            'status' => 'Inactive',
        ]);

        User::create([
            'userid' => 'DEV-0003',
            'fullname' => 'Developer3',
            'username' => 'Dev3',
            'email' => 'developer3@example.com',
            'phone' => '0111111111',
            'password' => 'password',
            'role' => 'Developer',
            'status' => 'Active',
        ]);

        User::create([
            'userid' => 'DEV-0004',
            'fullname' => 'Developer4',
            'username' => 'Dev4',
            'email' => 'developer4@example.com',
            'phone' => '0111111111',
            'password' => 'password',
            'role' => 'Developer',
            'status' => 'Inactive',
        ]);

        User::create([
            'userid' => 'ADM-0002',
            'fullname' => 'Admin2',
            'username' => 'Ad2',
            'email' => 'admin2@example.com',
            'phone' => '0000000000',
            'password' => 'password',
            'role' => 'Admin',
            'status' => 'Inactive',
        ]);

        User::create([
            'userid' => 'DEV-0005',
            'fullname' => 'Developer5',
            'username' => 'Dev5',
            'email' => 'developer5@example.com',
            'phone' => '0000000000',
            'password' => 'password',
            'role' => 'Developer',
            'status' => 'Active',
        ]);

        User::create([
            'userid' => 'ADM-0003',
            'fullname' => 'Admin3',
            'username' => 'Ad3',
            'email' => 'admin3@example.com',
            'phone' => '0000000000',
            'password' => 'password',
            'role' => 'Admin',
            'status' => 'Active',
        ]);

        User::create([
            'userid' => 'DEV-0006',
            'fullname' => 'Developer6',
            'username' => 'Dev6',
            'email' => 'developer6@example.com',
            'phone' => '0000000000',
            'password' => 'password',
            'role' => 'Developer',
            'status' => 'Active',
        ]);

        User::create([
            'userid' => 'DEV-0007',
            'fullname' => 'Developer7',
            'username' => 'Dev7',
            'email' => 'developer7@example.com',
            'phone' => '0000000000',
            'password' => 'password',
            'role' => 'Developer',
            'status' => 'Active',
        ]);

        User::create([
            'userid' => 'DEV-008',
            'fullname' => 'Developer8',
            'username' => 'Dev8',
            'email' => 'developer8@example.com',
            'phone' => '0000000000',
            'password' => 'password',
            'role' => 'Developer',
            'status' => 'Active',
        ]);

        
    }
}
