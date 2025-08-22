<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get recent posts from the database
        $recentPosts = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();
            
        // Example data for the dashboard
        $data = [
            'user' => $user,
            'recentPosts' => $recentPosts,
            'upcomingEvents' => [
                [
                    'title' => 'Block Party 2025',
                    'day' => '15',
                    'month' => 'Aug',
                    'time' => 'Saturday, 3:00 PM - 8:00 PM',
                    'location' => 'Maple Street Park',
                    'attending' => 12
                ],
                [
                    'title' => 'Yard Sale',
                    'day' => '22',
                    'month' => 'Aug',
                    'time' => 'Saturday, 8:00 AM - 2:00 PM',
                    'location' => '123 Maple Street',
                    'attending' => 5
                ]
            ],
            'topHelpers' => [
                ['name' => 'Maria Garcia', 'helps' => 25, 'rating' => 4.9],
                ['name' => 'David Kim', 'helps' => 18, 'rating' => 4.8],
                ['name' => 'Sarah Johnson', 'helps' => 15, 'rating' => 4.7],
                ['name' => 'James Wilson', 'helps' => 12, 'rating' => 4.6],
                ['name' => 'Priya Patel', 'helps' => 10, 'rating' => 4.5]
            ],
            'newNeighbors' => [
                ['name' => 'Alex Turner', 'time' => 'Moved in 2 days ago'],
                ['name' => 'Emma Roberts', 'time' => 'Moved in 1 week ago']
            ]
        ];
        
        return view('dashboard', $data);
    }
}
