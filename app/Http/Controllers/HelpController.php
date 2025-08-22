<?php

namespace App\Http\Controllers;

use App\Models\HelpCategory;
use App\Models\HelpRequest;
use App\Models\HelpSkill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpController extends Controller
{
    /**
     * Display the help module dashboard.
     */
    public function index()
    {
        // Get active categories
        $categories = HelpCategory::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        
        // Get open help requests
        $openRequests = HelpRequest::where('status', 'open')
            ->with(['category', 'user'])
            ->latest()
            ->take(5)
            ->get();
        
        // Get current user's help requests
        $userRequests = null;
        if (Auth::check()) {
            $userRequests = Auth::user()->helpRequests()
                ->with(['category'])
                ->latest()
                ->take(5)
                ->get();
        }
        
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
            ->having('completed_helps', '>', 0)
            ->orderByDesc('completed_helps')
            ->take(5)
            ->get();
        
        return view('help.index', compact('categories', 'openRequests', 'userRequests', 'topHelpers'));
    }
    
    /**
     * Show the form for creating a new help request.
     */
    public function create(Request $request)
    {
        $categories = HelpCategory::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        
        // Pre-select category if provided in query
        $selectedCategory = null;
        if ($request->has('category')) {
            $selectedCategory = HelpCategory::where('slug', $request->category)->first();
        }
        
        return view('help.create', compact('categories', 'selectedCategory'));
    }
    
    /**
     * Store a newly created help request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:help_categories,id',
            'location' => 'nullable|string|max:255',
            'is_remote' => 'boolean',
            'scheduled_at' => 'nullable|date|after_or_equal:today',
            'ends_at' => 'nullable|date|after:scheduled_at',
            'is_recurring' => 'boolean',
            'recurrence_pattern' => 'nullable|string|required_if:is_recurring,true',
            'is_emergency' => 'boolean',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:help_skills,id',
        ]);
        
        // Check if emergency requests are allowed for this category
        $category = HelpCategory::findOrFail($validated['category_id']);
        if ($validated['is_emergency'] && !$category->allows_emergency_requests) {
            return back()->withInput()->withErrors([
                'is_emergency' => 'Emergency requests are not allowed for this category.'
            ]);
        }
        
        $helpRequest = new HelpRequest();
        $helpRequest->user_id = Auth::id();
        $helpRequest->help_category_id = $validated['category_id'];
        $helpRequest->title = $validated['title'];
        $helpRequest->description = $validated['description'];
        $helpRequest->location = $validated['location'] ?? null;
        $helpRequest->is_remote = $validated['is_remote'] ?? false;
        $helpRequest->scheduled_at = $validated['scheduled_at'] ?? null;
        $helpRequest->ends_at = $validated['ends_at'] ?? null;
        $helpRequest->is_recurring = $validated['is_recurring'] ?? false;
        $helpRequest->recurrence_pattern = $validated['recurrence_pattern'] ?? null;
        $helpRequest->is_emergency = $validated['is_emergency'] ?? false;
        $helpRequest->status = 'open';
        
        $helpRequest->save();
        
        // Attach skills if provided
        if (!empty($validated['skills'])) {
            $helpRequest->skills()->attach($validated['skills']);
        }
        
        // Add a system message about the request creation
        $helpRequest->messages()->create([
            'user_id' => Auth::id(),
            'message' => 'Help request created.',
            'is_system_message' => true,
        ]);
        
        return redirect()->route('help.show', $helpRequest)
            ->with('success', 'Your help request has been created successfully.');
    }
    
    /**
     * Display the specified help request.
     */
    public function show(HelpRequest $helpRequest)
    {
        // Load relationships
        $helpRequest->load(['user', 'category', 'skills', 'offers.user', 'messages.user']);
        
        // Check if the current user has already made an offer
        $userOffer = null;
        if (Auth::check()) {
            $userOffer = $helpRequest->offers()->where('user_id', Auth::id())->first();
        }
        
        // Get related requests in the same category
        $relatedRequests = HelpRequest::where('help_category_id', $helpRequest->help_category_id)
            ->where('id', '!=', $helpRequest->id)
            ->where('status', 'open')
            ->take(3)
            ->get();
        
        return view('help.show', compact('helpRequest', 'userOffer', 'relatedRequests'));
    }
    
    /**
     * Show the form for editing the specified help request.
     */
    public function edit(HelpRequest $helpRequest)
    {
        // Check if the user is authorized to edit
        if (Auth::id() !== $helpRequest->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Can only edit if the request is still open
        if ($helpRequest->status !== 'open') {
            return redirect()->route('help.show', $helpRequest)
                ->with('error', 'This help request cannot be edited anymore as it is already ' . $helpRequest->status . '.');
        }
        
        $categories = HelpCategory::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        
        $selectedSkills = $helpRequest->skills()->pluck('help_skills.id')->toArray();
        
        return view('help.edit', compact('helpRequest', 'categories', 'selectedSkills'));
    }
    
    /**
     * Update the specified help request.
     */
    public function update(Request $request, HelpRequest $helpRequest)
    {
        // Check if the user is authorized to edit
        if (Auth::id() !== $helpRequest->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Can only edit if the request is still open
        if ($helpRequest->status !== 'open') {
            return redirect()->route('help.show', $helpRequest)
                ->with('error', 'This help request cannot be edited anymore as it is already ' . $helpRequest->status . '.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:help_categories,id',
            'location' => 'nullable|string|max:255',
            'is_remote' => 'boolean',
            'scheduled_at' => 'nullable|date|after_or_equal:today',
            'ends_at' => 'nullable|date|after:scheduled_at',
            'is_recurring' => 'boolean',
            'recurrence_pattern' => 'nullable|string|required_if:is_recurring,true',
            'is_emergency' => 'boolean',
            'skills' => 'nullable|array',
            'skills.*' => 'exists:help_skills,id',
        ]);
        
        // Check if emergency requests are allowed for this category
        $category = HelpCategory::findOrFail($validated['category_id']);
        if ($validated['is_emergency'] && !$category->allows_emergency_requests) {
            return back()->withInput()->withErrors([
                'is_emergency' => 'Emergency requests are not allowed for this category.'
            ]);
        }
        
        $helpRequest->help_category_id = $validated['category_id'];
        $helpRequest->title = $validated['title'];
        $helpRequest->description = $validated['description'];
        $helpRequest->location = $validated['location'] ?? null;
        $helpRequest->is_remote = $validated['is_remote'] ?? false;
        $helpRequest->scheduled_at = $validated['scheduled_at'] ?? null;
        $helpRequest->ends_at = $validated['ends_at'] ?? null;
        $helpRequest->is_recurring = $validated['is_recurring'] ?? false;
        $helpRequest->recurrence_pattern = $validated['recurrence_pattern'] ?? null;
        $helpRequest->is_emergency = $validated['is_emergency'] ?? false;
        
        $helpRequest->save();
        
        // Sync skills
        if (isset($validated['skills'])) {
            $helpRequest->skills()->sync($validated['skills']);
        } else {
            $helpRequest->skills()->detach();
        }
        
        // Add a system message about the update
        $helpRequest->messages()->create([
            'user_id' => Auth::id(),
            'message' => 'Help request updated.',
            'is_system_message' => true,
        ]);
        
        return redirect()->route('help.show', $helpRequest)
            ->with('success', 'Your help request has been updated successfully.');
    }
    
    /**
     * Cancel the specified help request.
     */
    public function cancel(HelpRequest $helpRequest)
    {
        // Check if the user is authorized to cancel
        if (Auth::id() !== $helpRequest->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Can only cancel if the request is still open or assigned
        if (!in_array($helpRequest->status, ['open', 'assigned'])) {
            return redirect()->route('help.show', $helpRequest)
                ->with('error', 'This help request cannot be cancelled as it is already ' . $helpRequest->status . '.');
        }
        
        $helpRequest->status = 'cancelled';
        $helpRequest->save();
        
        // Add a system message about the cancellation
        $helpRequest->messages()->create([
            'user_id' => Auth::id(),
            'message' => 'Help request cancelled by the requester.',
            'is_system_message' => true,
        ]);
        
        return redirect()->route('help.index')
            ->with('success', 'Your help request has been cancelled successfully.');
    }
    
    /**
     * Complete the specified help request.
     */
    public function complete(HelpRequest $helpRequest)
    {
        // Check if the user is authorized to mark as complete
        if (Auth::id() !== $helpRequest->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Can only complete if the request is in progress
        if ($helpRequest->status !== 'in_progress') {
            return redirect()->route('help.show', $helpRequest)
                ->with('error', 'This help request cannot be marked as complete as it is not in progress.');
        }
        
        $helpRequest->status = 'completed';
        $helpRequest->save();
        
        // Add a system message about the completion
        $helpRequest->messages()->create([
            'user_id' => Auth::id(),
            'message' => 'Help request marked as completed by the requester.',
            'is_system_message' => true,
        ]);
        
        // Redirect to the feedback form
        return redirect()->route('help.feedback.create', $helpRequest)
            ->with('success', 'Your help request has been marked as completed. Please provide feedback about your helper.');
    }
    
    /**
     * Display a listing of help requests by category.
     */
    public function category(HelpCategory $category)
    {
        $helpRequests = HelpRequest::where('help_category_id', $category->id)
            ->where('status', 'open')
            ->with(['user', 'skills'])
            ->latest()
            ->paginate(10);
        
        return view('help.category', compact('category', 'helpRequests'));
    }
    
    /**
     * Display a listing of the current user's help requests.
     */
    public function myRequests()
    {
        $helpRequests = Auth::user()->helpRequests()
            ->with(['category', 'offers'])
            ->latest()
            ->paginate(10);
        
        return view('help.my-requests', compact('helpRequests'));
    }
    
    /**
     * Search for help requests.
     */
    public function search(Request $request)
    {
        $query = HelpRequest::query();
        
        // Filter by keyword
        if ($request->has('keyword') && !empty($request->keyword)) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                  ->orWhere('description', 'like', '%' . $request->keyword . '%');
            });
        }
        
        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->where('help_category_id', $request->category);
        }
        
        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        } else {
            // Default to showing open requests only
            $query->where('status', 'open');
        }
        
        // Filter by emergency
        if ($request->has('emergency') && $request->emergency == 1) {
            $query->where('is_emergency', true);
        }
        
        // Filter by date range
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->where('scheduled_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->where('scheduled_at', '<=', $request->date_to);
        }
        
        // Get all active categories for the filter
        $categories = HelpCategory::where('is_active', true)
            ->orderBy('display_order')
            ->get();
        
        $helpRequests = $query->with(['category', 'user', 'skills'])
            ->latest()
            ->paginate(10)
            ->withQueryString();
        
        return view('help.search', compact('helpRequests', 'categories'));
    }
    
    /**
     * Get skills for a specific category (AJAX).
     */
    public function getCategorySkills(HelpCategory $category)
    {
        $skills = $category->skills()->get();
        return response()->json($skills);
    }
}
