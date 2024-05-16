<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Position::create([
            'name'    => 'shop_one',
        ]);

        \App\Models\Position::create([
            'name'    => 'shop_two',
        ]);

        \App\Models\Position::create([
            'name'    => 'warehouse',
        ]);
    }
}
