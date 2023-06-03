<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Client;
use App\Models\History;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Client::create([
            'id' => 1,
            'title' => '紅色電腦',
            'connected' => true,
        ]);
        Client::create([
            'id' => 2,
            'title' => '藍色電腦',
            'connected' => false,
        ]);

        History::create([
            'id' => 1,
            'url' => 'https://laravel.com/',
            'hostname' => 'laravel.com',
            'blocked' => false,
            'client_id' => 1,
        ]);
        History::create([
            'id' => 2,
            'url' => 'https://www.youtube.com/',
            'hostname' => 'www.youtube.com',
            'blocked' => true,
            'client_id' => 1,
        ]);
        History::create([
            'id' => 3,
            'url' => 'https://translate.google.com.tw/',
            'hostname' => 'translate.google.com.tw',
            'blocked' => false,
            'client_id' => 1,
        ]);
    }
}
