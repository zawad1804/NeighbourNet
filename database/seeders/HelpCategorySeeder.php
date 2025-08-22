<?php

namespace Database\Seeders;

use App\Models\HelpCategory;
use App\Models\HelpSkill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class HelpCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elderly Support',
                'icon' => 'fa-hands-helping',
                'description' => 'Assistance for elderly neighbors including companionship, medication reminders, and technology help.',
                'requires_verification' => true,
                'allows_emergency_requests' => true,
                'display_order' => 1,
                'skills' => [
                    'Companionship',
                    'Medication Management',
                    'Technology Assistance',
                    'Mobility Support',
                    'Meal Preparation',
                    'Healthcare Appointment Companion',
                ],
            ],
            [
                'name' => 'Pet Care',
                'icon' => 'fa-paw',
                'description' => 'Help with pets including walking, sitting, vet trips, and emergency care.',
                'requires_verification' => false,
                'allows_emergency_requests' => true,
                'display_order' => 2,
                'skills' => [
                    'Dog Walking',
                    'Pet Sitting',
                    'Vet Transportation',
                    'Emergency Pet Care',
                    'Pet Grooming',
                    'Pet Medication Administration',
                ],
            ],
            [
                'name' => 'Groceries & Errands',
                'icon' => 'fa-shopping-basket',
                'description' => 'Assistance with shopping, pharmacy runs, bill payments, and other errands.',
                'requires_verification' => false,
                'allows_emergency_requests' => true,
                'display_order' => 3,
                'skills' => [
                    'Grocery Shopping',
                    'Pharmacy Pickup',
                    'Bill Payment',
                    'Post Office Runs',
                    'Delivery Assistance',
                ],
            ],
            [
                'name' => 'Home Maintenance',
                'icon' => 'fa-tools',
                'description' => 'Help with home repairs, gardening, cleaning, and seasonal tasks.',
                'requires_verification' => false,
                'allows_emergency_requests' => true,
                'display_order' => 4,
                'skills' => [
                    'Basic Repairs',
                    'Gardening',
                    'Lawn Mowing',
                    'Snow Removal',
                    'Cleaning',
                    'Painting',
                    'Furniture Assembly',
                ],
            ],
            [
                'name' => 'Transportation',
                'icon' => 'fa-car',
                'description' => 'Rides to appointments, airport pickup, moving assistance, and other transportation needs.',
                'requires_verification' => true,
                'allows_emergency_requests' => true,
                'display_order' => 5,
                'skills' => [
                    'Medical Appointment Transportation',
                    'Airport Pickup/Dropoff',
                    'Moving Assistance',
                    'Grocery Transportation',
                    'School Pickup/Dropoff',
                ],
            ],
            [
                'name' => 'Childcare Support',
                'icon' => 'fa-child',
                'description' => 'Help with babysitting, school pickup, tutoring, and other childcare needs.',
                'requires_verification' => true,
                'allows_emergency_requests' => true,
                'display_order' => 6,
                'skills' => [
                    'Babysitting',
                    'School Pickup/Dropoff',
                    'Tutoring',
                    'Homework Help',
                    'Playground Supervision',
                    'After-school Activities',
                ],
            ],
            [
                'name' => 'Emergency Assistance',
                'icon' => 'fa-exclamation-triangle',
                'description' => 'Urgent help with power outages, medical emergencies, weather-related issues, and other emergencies.',
                'requires_verification' => true,
                'allows_emergency_requests' => true,
                'display_order' => 7,
                'skills' => [
                    'First Aid',
                    'CPR',
                    'Power Outage Support',
                    'Weather Emergency Assistance',
                    'Emergency Shelter',
                    'Crisis Response',
                ],
            ],
            [
                'name' => 'Technology Help',
                'icon' => 'fa-laptop',
                'description' => 'Assistance with device setup, online services, digital literacy, and other technology needs.',
                'requires_verification' => false,
                'allows_emergency_requests' => false,
                'display_order' => 8,
                'skills' => [
                    'Computer Setup',
                    'Smartphone/Tablet Help',
                    'Internet Setup',
                    'Software Installation',
                    'Digital Literacy Training',
                    'Smart Home Setup',
                    'Online Account Management',
                ],
            ],
            [
                'name' => 'Community Events',
                'icon' => 'fa-users',
                'description' => 'Help with event setup, volunteer coordination, neighborhood cleanups, and other community activities.',
                'requires_verification' => false,
                'allows_emergency_requests' => false,
                'display_order' => 9,
                'skills' => [
                    'Event Planning',
                    'Volunteer Coordination',
                    'Setup/Cleanup',
                    'Equipment Management',
                    'Photography',
                    'Public Speaking',
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $skills = $categoryData['skills'];
            unset($categoryData['skills']);
            
            $categoryData['slug'] = Str::slug($categoryData['name']);
            $categoryData['is_active'] = true;
            
            $category = HelpCategory::create($categoryData);
            
            foreach ($skills as $skillName) {
                HelpSkill::create([
                    'name' => $skillName,
                    'slug' => Str::slug($skillName),
                    'description' => "Skill for {$skillName} within the {$category->name} category.",
                    'requires_verification' => $category->requires_verification,
                    'help_category_id' => $category->id,
                ]);
            }
        }
    }
}
