<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\History;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => '舊電腦',
            'connected' => true,
        ]);
        User::create([
            'id' => 2,
            'name' => 'HP 銀色電腦',
            'connected' => false,
        ]);

        History::create([
            'id' => 1,
            'url' => 'https://laravel.com/',
            'hostname' => 'laravel.com',
            'blocked' => false,
            'user_id' => 1,
        ]);
        History::create([
            'id' => 2,
            'url' => 'https://www.youtube.com/',
            'hostname' => 'www.youtube.com',
            'blocked' => true,
            'user_id' => 1,
        ]);
        History::create([
            'id' => 3,
            'url' => 'https://translate.google.com.tw/',
            'hostname' => 'translate.google.com.tw',
            'blocked' => false,
            'user_id' => 1,
        ]);
    }
}
