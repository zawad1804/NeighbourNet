<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->info('No users found. Please run UserSeeder first.');
            return;
        }
        
        // Sample post content
        $posts = [
            [
                'content' => 'Our annual block party is coming up next Saturday! Please RSVP so we can plan accordingly. There will be food, games, and music for all ages.',
                'category' => 'Announcement',
                'likes_count' => 12,
                'comments_count' => 5,
            ],
            [
                'content' => 'Does anyone have a ladder I could borrow for a day? Need to clean my gutters. Will return it the same day!',
                'category' => 'Help Request',
                'likes_count' => 8,
                'comments_count' => 3,
            ],
            [
                'content' => 'Just wanted to recommend the new bakery on Elm Street - their sourdough bread is amazing! They also give 10% discount if you mention you\'re from the neighborhood.',
                'category' => 'Recommendation',
                'likes_count' => 15,
                'comments_count' => 7,
            ],
            [
                'content' => 'Heads up neighbors - there was a break-in attempt on Maple Street last night around 2am. The police were called and the suspect fled. Please be vigilant and report any suspicious activity.',
                'category' => 'Safety Alert',
                'likes_count' => 24,
                'comments_count' => 12,
            ],
        ];
        
        foreach ($posts as $postData) {
            // Randomly assign a user
            $user = $users->random();
            
            $post = new Post();
            $post->user_id = $user->id;
            $post->content = $postData['content'];
            $post->category = $postData['category'];
            $post->likes_count = $postData['likes_count'];
            $post->comments_count = $postData['comments_count'];
            $post->created_at = now()->subHours(rand(1, 72)); // Random time in the past 3 days
            $post->save();
        }
    }
}
