<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\ApiTestDataSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::create([
            'username' => 'testuser',
            'fullname' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
        
        // Run API test data seeder
        $this->call([
            ApiTestDataSeeder::class,
        ]);
    }
}
