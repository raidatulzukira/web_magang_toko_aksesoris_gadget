<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun ADMIN
        DB::table('users')->insert([
            'name' => 'Admin Gadget',
            'email' => 'admin@toko.com',
            'password' => Hash::make('password'), // Passwordnya: password
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Akun PEMBELI (Customer)
        DB::table('users')->insert([
            'name' => 'Budi Pembeli',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'), // Passwordnya: password
            'role' => 'customer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
