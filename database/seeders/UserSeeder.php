<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan user dengan role Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',  // Ganti dengan email yang sesuai
            'password' => Hash::make('password123'), // Ganti dengan password yang sesuai
            'role' => 'Admin',  // Menetapkan role sebagai Admin
        ]);
    }
}
