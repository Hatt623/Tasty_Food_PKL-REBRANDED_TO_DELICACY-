<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Import
use DB;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();

        User::create ([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('rahasiaadmin'),
            'phone' => '081234567890',
            'role' => 'admin',
        ]);

        User::create ([
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('rahasiastaff'),
            'phone' => '081234567891',
            'role' => 'staff',
        ]);

        User::create ([
            'name' => 'Member',
            'email' => 'member@gmail.com',
            'password' => bcrypt('rahasiamember'),
            'phone' => '081234567892',
            'role' => 'customer',
        ]);

    }
}
