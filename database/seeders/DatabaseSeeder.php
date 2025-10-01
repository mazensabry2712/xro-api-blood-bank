<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create a test user only if not exists to avoid duplicate key on repeated seeds
        $defaultUserPassword = Hash::make(env('SEED_USER_PASSWORD', 'password123'));
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => $defaultUserPassword,
            ]
        );

        $this->call(GovernoratesSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(HospitalSeeder::class);
        $this->call(BloodTypeSeeder::class);
    }
}
