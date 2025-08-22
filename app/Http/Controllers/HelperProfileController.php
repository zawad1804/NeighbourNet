<?php

namespace App\Http\Controllers;

use App\Models\HelpCategory;
use App\Models\HelpRequest;
use App\Models\HelpSkill;
use App\Models\HelperAvailability;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelperProfileController extends Controller
{
    /**
     * Display the current user's helper profile.
     */
    public function show()
    {
        $user = Auth::user();
        
        // Load relationships
        $user->load(['helpCategories', 'helpSkills', 'receivedFeedback']);
        
        // Get availability
        $availability = $user->availability;
        
        // Get completed help requests
        $completedHelps = HelpRequest::whereHas('offers', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('status', 'accepted');
        })
        ->where('status', 'completed')
        ->with('category')
        ->latest()
        ->get();
        
        // Get achievements
        $achievements = $user->achievements;
        
        // Calculate statistics
        $stats = [
            'total_helps' => $completedHelps->count(),
            'average_rating' => $user->getAverageRating(),
            'categories_helped' => $completedHelps->pluck('category.name')->unique()->count(),
        ];
        
        return view('help.profile.show', compact('user', 'availability', 'completedHelps', 'achievements', 'stats'));
    }
    
    /**
     * Show the form for editing the helper profile.
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Get all categories and skills
        $categories = HelpCategory::where('is_active', true)
            ->with('skills')
            ->orderBy('display_order')
            ->get();
        
        // Get user's selected categories and skills
        $selectedCategories = $user->helpCategories()->pluck('help_categories.id')->toArray();
        $selectedSkills = $user->helpSkills()->pluck('help_skills.id')->toArray();
        
        // Get user's availability
        $availability = $user->availability;
        
        return view('help.profile.edit', compact('user', 'categories', 'selectedCategories', 'selectedSkills', 'availability'));
    }
    
    /**
     * Update the helper profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:help_categories,id',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:help_skills,id',
            'primary_category' => 'required|exists:help_categories,id',
            'availability_status' => 'required|in:available_now,available_today,available_this_week,busy',
            'available_from' => 'nullable|date|required_if:availability_status,busy',
            'available_until' => 'nullable|date|after:available_from|required_if:availability_status,busy',
            'available_for_emergency' => 'boolean',
            'recurring_schedule' => 'nullable|array',
            'recurring_schedule.*' => 'array',
            'recurring_schedule.*.*' => 'string',
        ]);
        
        // Check if primary category is in selected categories
        if (!in_array($validated['primary_category'], $validated['categories'])) {
            return back()->withInput()->withErrors([
                'primary_category' => 'The primary category must be one of the selected categories.',
            ]);
        }
        
        // Sync categories
        $categorySync = [];
        foreach ($validated['categories'] as $categoryId) {
            $categorySync[$categoryId] = [
                'is_primary' => ($categoryId == $validated['primary_category']),
            ];
        }
        $user->helpCategories()->sync($categorySync);
        
        // Sync skills
        if (isset($validated['skills'])) {
            $user->helpSkills()->sync($validated['skills']);
        } else {
            $user->helpSkills()->detach();
        }
        
        // Update availability
        $availability = $user->availability ?? new HelperAvailability();
        $availability->user_id = $user->id;
        $availability->status = $validated['availability_status'];
        
        if ($validated['availability_status'] === 'busy' && isset($validated['available_from']) && isset($validated['available_until'])) {
            $availability->available_from = $validated['available_from'];
            $availability->available_until = $validated['available_until'];
        } else {
            $availability->available_from = null;
            $availability->available_until = null;
        }
        
        $availability->available_for_emergency = $validated['available_for_emergency'] ?? false;
        
        if (isset($validated['recurring_schedule'])) {
            $availability->recurring_schedule = $validated['recurring_schedule'];
        }
        
        $availability->save();
        
        return redirect()->route('help.profile.show')
            ->with('success', 'Your helper profile has been updated successfully.');
    }
    
    /**
     * Display the public helper profile.
     */
    public function publicProfile(User $user)
    {
        // Load relationships
        $user->load(['helpCategories', 'helpSkills']);
        
        // Get completed help requests
        $completedHelps = HelpRequest::whereHas('offers', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('status', 'accepted');
        })
        ->where('status', 'completed')
        ->with('category')
        ->count();
        
        // Get public feedback (non-anonymous)
        $feedback = $user->receivedFeedback()
            ->where('is_anonymous', false)
            ->with(['user', 'helpRequest.category'])
            ->latest()
            ->paginate(5);
        
        // Calculate statistics
        $stats = [
            'total_helps' => $completedHelps,
            'average_rating' => $user->getAverageRating(),
            'feedback_count' => $user->receivedFeedback()->count(),
        ];
        
        return view('help.profile.public', compact('user', 'feedback', 'stats'));
    }
    
    /**
     * Display a listing of top helpers.
     */
    public function topHelpers()
    {
        // Get top helpers for the leaderboard
        $topHelpers = User::whereHas('helpOffers', function ($query) {
                $query->where('status', 'accepted');
            })
            ->withCount(['helpOffers as completed_helps' => function ($query) {
                $query->where('status', 'accepted')
                    ->whereHas('helpRequest', function ($q) {
                        $q->where('status', 'completed');
                    });
            }])
            ->with(['achievements', 'receivedFeedback'])
            ->having('completed_helps', '>', 0)
            ->orderByDesc('completed_helps')
            ->paginate(20);
        
        return view('help.leaderboard', compact('topHelpers'));
    }
    
    /**
     * Update the availability status quickly.
     */
    public function updateAvailability(Request $request)
    {
        $user = Auth::user();
        
        // Validate the request
        $validated = $request->validate([
            'status' => 'required|in:available_now,available_today,available_this_week,busy',
            'available_for_emergency' => 'boolean',
        ]);
        
        // Update availability
        $availability = $user->availability ?? new HelperAvailability();
        $availability->user_id = $user->id;
        $availability->status = $validated['status'];
        
        if ($validated['status'] === 'busy') {
            // Default to busy for 24 hours if no dates are provided
            $availability->available_from = now();
            $availability->available_until = now()->addDay();
        } else {
            $availability->available_from = null;
            $availability->available_until = null;
        }
        
        $availability->available_for_emergency = $validated['available_for_emergency'] ?? false;
        $availability->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Your availability has been updated successfully.',
            'status' => $validated['status'],
        ]);
    }
}
