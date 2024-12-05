<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Test@12345'), // Encrypt the password
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => Hash::make('Test@12345'), // Encrypt the password
            'role' => 'student',
        ]);
        User::create([
            'name' => 'Teacher',
            'email' => 'teacher@gmail.com',
            'password' => Hash::make('Test@12345'), // Encrypt the password
            'role' => 'teacher',
        ]);
    }
}
