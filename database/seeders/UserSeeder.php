<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Rizky Kusuma Nugraha',
                'email' => 'rizky@example.com',
                'nik' => '3201010101010001',
                'tanggal_lahir' => '2003-05-14',
                'gender' => 'L',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Rahmawati',
                'email' => 'siti@example.com',
                'nik' => '3201010101010002',
                'tanggal_lahir' => '2001-11-22',
                'gender' => 'P',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@example.com',
                'nik' => '3201010101010003',
                'tanggal_lahir' => '2002-07-10',
                'gender' => 'L',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
