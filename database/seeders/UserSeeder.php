<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        user::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin1234#'),
                'role' => 'admin',
            ]
        );

        user::updateOrCreate(
            ['email' => 'petugas@example.com'],
            [
                'name' => 'Petugas',
                'password' => Hash::make('petugas1234#'),
                'role' => 'petugas',
            ]
        );
    }
}
