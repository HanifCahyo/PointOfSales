<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true
        ]);

        User::create([
            'name' => 'Kasir User',
            'email' => 'kasir@example.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
            'is_active' => true
        ]);


    }
}
