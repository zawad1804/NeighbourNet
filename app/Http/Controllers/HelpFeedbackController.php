<?php

namespace App\Http\Controllers;

use App\Models\HelpFeedback;
use App\Models\HelpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpFeedbackController extends Controller
{
    /**
     * Show the form for creating a new feedback.
     */
    public function create(HelpRequest $helpRequest)
    {
        // Check if the user is authorized to leave feedback
        if (Auth::id() !== $helpRequest->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the help request is completed
        if ($helpRequest->status !== 'completed') {
            return redirect()->route('help.show', $helpRequest)
                ->with('error', 'You can only leave feedback for completed help requests.');
        }
        
        // Check if feedback already exists
        $existingFeedback = $helpRequest->feedback()->where('user_id', Auth::id())->first();
        if ($existingFeedback) {
            return redirect()->route('help.show', $helpRequest)
                ->with('error', 'You have already left feedback for this help request.');
        }
        
        // Get the helper
        $helper = $helpRequest->helper();
        if (!$helper) {
            return redirect()->route('help.show', $helpRequest)
                ->with('error', 'No helper was assigned to this request.');
        }
        
        return view('help.feedback.create', compact('helpRequest', 'helper'));
    }
    
    /**
     * Store a newly created feedback in storage.
     */
    public function store(Request $request, HelpRequest $helpRequest)
    {
        // Check if the user is authorized to leave feedback
        if (Auth::id() !== $helpRequest->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the help request is completed
        if ($helpRequest->status !== 'completed') {
            return redirect()->route('help.show', $helpRequest)
                ->with('error', 'You can only leave feedback for completed help requests.');
        }
        
        // Check if feedback already exists
        $existingFeedback = $helpRequest->feedback()->where('user_id', Auth::id())->first();
        if ($existingFeedback) {
            return redirect()->route('help.show', $helpRequest)
                ->with('error', 'You have already left feedback for this help request.');
        }
        
        // Get the helper
        $helper = $helpRequest->helper();
        if (!$helper) {
            return redirect()->route('help.show', $helpRequest)
                ->with('error', 'No helper was assigned to this request.');
        }
        
        // Validate the request
        $validated = $request->validate([
            'punctuality_rating' => 'required|integer|min:1|max:5',
            'communication_rating' => 'required|integer|min:1|max:5',
            'quality_rating' => 'required|integer|min:1|max:5',
            'friendliness_rating' => 'required|integer|min:1|max:5',
            'overall_rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string|max:1000',
            'is_anonymous' => 'boolean',
        ]);
        
        // Create the feedback
        $feedback = new HelpFeedback();
        $feedback->help_request_id = $helpRequest->id;
        $feedback->user_id = Auth::id();
        $feedback->helper_id = $helper->id;
        $feedback->punctuality_rating = $validated['punctuality_rating'];
        $feedback->communication_rating = $validated['communication_rating'];
        $feedback->quality_rating = $validated['quality_rating'];
        $feedback->friendliness_rating = $validated['friendliness_rating'];
        $feedback->overall_rating = $validated['overall_rating'];
        $feedback->comments = $validated['comments'] ?? null;
        $feedback->is_anonymous = $validated['is_anonymous'] ?? false;
        $feedback->save();
        
        // Add a system message
        $helpRequest->messages()->create([
            'user_id' => Auth::id(),
            'message' => 'Feedback has been submitted for this help request.',
            'is_system_message' => true,
        ]);
        
        // Check for achievements that might be unlocked
        // This would be handled by a separate service in a real application
        
        return redirect()->route('help.show', $helpRequest)
            ->with('success', 'Your feedback has been submitted successfully. Thank you!');
    }
    
    /**
     * Show the form for helper to respond to feedback.
     */
    public function respond(HelpFeedback $feedback)
    {
        // Check if the user is the helper who received the feedback
        if (Auth::id() !== $feedback->helper_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the helper has already responded
        if (!empty($feedback->helper_response)) {
            return redirect()->route('help.show', $feedback->helpRequest)
                ->with('error', 'You have already responded to this feedback.');
        }
        
        return view('help.feedback.respond', compact('feedback'));
    }
    
    /**
     * Store the helper's response to feedback.
     */
    public function storeResponse(Request $request, HelpFeedback $feedback)
    {
        // Check if the user is the helper who received the feedback
        if (Auth::id() !== $feedback->helper_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the helper has already responded
        if (!empty($feedback->helper_response)) {
            return redirect()->route('help.show', $feedback->helpRequest)
                ->with('error', 'You have already responded to this feedback.');
        }
        
        // Validate the request
        $validated = $request->validate([
            'response' => 'required|string|max:1000',
        ]);
        
        // Update the feedback
        $feedback->helper_response = $validated['response'];
        $feedback->save();
        
        // Add a system message
        $feedback->helpRequest->messages()->create([
            'user_id' => Auth::id(),
            'message' => 'Helper has responded to the feedback.',
            'is_system_message' => true,
        ]);
        
        return redirect()->route('help.show', $feedback->helpRequest)
            ->with('success', 'Your response to the feedback has been submitted successfully.');
    }
}
