<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat user admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@puskesmas.com',
            'password' => Hash::make('12345'),
            'role' => 'admin',
        ]);

        // // Buat user dokter
        // User::create([
        //     'name' => 'Dr. Santosa',
        //     'email' => 'dokter@puskesmas.com',
        //     'password' => Hash::make('12345'),
        //     'role' => 'dokter',
        // ]);
    }
}
