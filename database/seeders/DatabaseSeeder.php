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

        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'phone' => '123-456-7890',
            'city' => 'Test City',
            'address' => '123 Test St',
            'post_code' => '12345',
            'password' => bcrypt('password'),
        ]);
        
        // Run the post seeder
        $this->call(PostSeeder::class);
        
        // Run the help category seeder
        $this->call(HelpCategorySeeder::class);
        
        // Run the Help Module seeders
        $this->call([
            HelpCategorySeeder::class,
            HelperAchievementSeeder::class,
        ]);
    }
}
