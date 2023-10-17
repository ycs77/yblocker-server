<?php

namespace Database\Seeders;

use App\Models\Admin;
use Error;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSyncFromEnv extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $username = env('ADMIN_USERNAME');
        $password = env('ADMIN_PASSWORD');

        if (! $username) {
            throw new Error('Missing ADMIN_USERNAME from .env file');
        }

        if (! $password) {
            throw new Error('Missing ADMIN_PASSWORD from .env file');
        }

        Admin::updateOrCreate(
            ['username' => $username],
            ['password' => Hash::make($password)]
        );
    }
}
