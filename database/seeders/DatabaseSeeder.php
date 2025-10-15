<?php

namespace Database\Seeders;

use App\Models\User;
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
        $this->call([
            UserSeeder::class,
            \Database\Seeders\CategorySeeder::class,
            \Database\Seeders\CouponSeeder::class,
            \Database\Seeders\PizzaSeeder::class,
            \Database\Seeders\AdminUserSeeder::class,
            \Database\Seeders\OrderSeeder::class,
        ]);

        // keep a known test user
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
