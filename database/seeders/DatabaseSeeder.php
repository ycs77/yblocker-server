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
        ]);
        User::create([
            'name' => 'HP 銀色電腦',
        ]);

        History::create([
            'url' => 'https://laravel.com/',
            'hostname' => 'laravel.com',
            'user_id' => $user_1->id,
        ]);
        History::create([
            'url' => 'https://www.youtube.com/',
            'hostname' => 'www.youtube.com',
            'user_id' => $user_1->id,
        ]);
        History::create([
            'url' => 'https://translate.google.com.tw/',
            'hostname' => 'translate.google.com.tw',
            'user_id' => $user_1->id,
        ]);
    }
}
