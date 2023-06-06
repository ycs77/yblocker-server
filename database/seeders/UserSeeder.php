<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => '舊電腦',
        ]);
        User::create([
            'name' => 'HP 銀色電腦',
        ]);
    }
}
