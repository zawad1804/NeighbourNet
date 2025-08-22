<?php

namespace Database\Seeders;

use App\Models\HelperAchievement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HelperAchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            [
                'name' => 'First Timer',
                'description' => 'Complete your first help request',
                'icon' => 'fa-award',
                'badge_image' => 'badges/first-timer.png',
                'achievement_type' => 'milestone',
                'threshold' => 1,
                'criteria' => ['completed_helps' => 1],
            ],
            [
                'name' => 'Reliable Helper',
                'description' => 'Complete 10 help requests',
                'icon' => 'fa-star',
                'badge_image' => 'badges/reliable-helper.png',
                'achievement_type' => 'milestone',
                'threshold' => 10,
                'criteria' => ['completed_helps' => 10],
            ],
            [
                'name' => 'Community Champion',
                'description' => 'Complete 50 help requests',
                'icon' => 'fa-trophy',
                'badge_image' => 'badges/community-champion.png',
                'achievement_type' => 'milestone',
                'threshold' => 50,
                'criteria' => ['completed_helps' => 50],
            ],
            [
                'name' => 'Category Expert',
                'description' => 'Complete 20 help requests in one specific category',
                'icon' => 'fa-certificate',
                'badge_image' => 'badges/category-expert.png',
                'achievement_type' => 'category_specialist',
                'threshold' => 20,
                'criteria' => ['category_helps' => 20],
            ],
            [
                'name' => 'Streak Master',
                'description' => 'Help someone 7 days in a row',
                'icon' => 'fa-fire',
                'badge_image' => 'badges/streak-master.png',
                'achievement_type' => 'streak',
                'threshold' => 7,
                'criteria' => ['consecutive_days' => 7],
            ],
            [
                'name' => 'Emergency Hero',
                'description' => 'Respond to 5 urgent requests',
                'icon' => 'fa-bolt',
                'badge_image' => 'badges/emergency-hero.png',
                'achievement_type' => 'emergency_response',
                'threshold' => 5,
                'criteria' => ['emergency_helps' => 5],
            ],
            [
                'name' => 'Five-Star Helper',
                'description' => 'Receive 10 five-star ratings',
                'icon' => 'fa-star',
                'badge_image' => 'badges/five-star-helper.png',
                'achievement_type' => 'rating',
                'threshold' => 10,
                'criteria' => ['five_star_ratings' => 10],
            ],
            [
                'name' => 'Senior Supporter',
                'description' => 'Complete 15 help requests in the Elderly Support category',
                'icon' => 'fa-hand-holding-heart',
                'badge_image' => 'badges/senior-supporter.png',
                'achievement_type' => 'category_specialist',
                'threshold' => 15,
                'criteria' => ['category_id' => 1, 'category_helps' => 15],
            ],
            [
                'name' => 'Pet Pal',
                'description' => 'Complete 15 help requests in the Pet Care category',
                'icon' => 'fa-paw',
                'badge_image' => 'badges/pet-pal.png',
                'achievement_type' => 'category_specialist',
                'threshold' => 15,
                'criteria' => ['category_id' => 2, 'category_helps' => 15],
            ],
            [
                'name' => 'Tech Wizard',
                'description' => 'Complete 15 help requests in the Technology Help category',
                'icon' => 'fa-laptop-code',
                'badge_image' => 'badges/tech-wizard.png',
                'achievement_type' => 'category_specialist',
                'threshold' => 15,
                'criteria' => ['category_id' => 8, 'category_helps' => 15],
            ],
        ];

        foreach ($achievements as $achievementData) {
            $achievementData['slug'] = Str::slug($achievementData['name']);
            HelperAchievement::create($achievementData);
        }
    }
}
