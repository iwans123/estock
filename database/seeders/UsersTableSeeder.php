<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin123'
        ]);

        \App\Models\User::create([
            'name' => 'toko1',
            'username' => 'toko1',
            'email' => 'toko1@gmail.com',
            'password' => 'toko1123'
        ]);

        \App\Models\User::create([
            'name' => 'toko2',
            'username' => 'toko2',
            'email' => 'toko2@gmail.com',
            'password' => 'toko2123'
        ]);
    }
}
