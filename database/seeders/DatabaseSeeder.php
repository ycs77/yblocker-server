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
        $user_1 = User::create([
            'name' => '舊電腦',
            'connected' => true,
        ]);
        User::create([
            'name' => 'HP 銀色電腦',
            'connected' => false,
        ]);

        History::create([
            'url' => 'https://laravel.com/',
            'hostname' => 'laravel.com',
            'blocked' => false,
            'user_id' => $user_1->id,
        ]);
        History::create([
            'url' => 'https://www.youtube.com/',
            'hostname' => 'www.youtube.com',
            'blocked' => true,
            'user_id' => $user_1->id,
        ]);
        History::create([
            'url' => 'https://translate.google.com.tw/',
            'hostname' => 'translate.google.com.tw',
            'blocked' => false,
            'user_id' => $user_1->id,
        ]);
    }
}
