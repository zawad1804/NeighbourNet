<?php

namespace App\Http\Controllers;

use App\Models\HelpOffer;
use App\Models\HelpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpOfferController extends Controller
{
    /**
     * Store a newly created help offer in storage.
     */
    public function store(Request $request, HelpRequest $helpRequest)
    {
        // Check if the request is still open
        if ($helpRequest->status !== 'open') {
            return back()->with('error', 'This help request is no longer accepting offers.');
        }
        
        // Check if user already made an offer
        $existingOffer = $helpRequest->offers()->where('user_id', Auth::id())->first();
        if ($existingOffer) {
            return back()->with('error', 'You have already made an offer for this help request.');
        }
        
        // Validate the request
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);
        
        // Create the offer
        $offer = new HelpOffer();
        $offer->help_request_id = $helpRequest->id;
        $offer->user_id = Auth::id();
        $offer->message = $validated['message'];
        $offer->status = 'pending';
        $offer->save();
        
        // Add a message to the help request
        $helpRequest->messages()->create([
            'user_id' => Auth::id(),
            'message' => 'Offered to help: ' . $validated['message'],
            'is_system_message' => false,
        ]);
        
        return redirect()->route('help.show', $helpRequest)
            ->with('success', 'Your offer to help has been submitted successfully.');
    }
    
    /**
     * Update the specified help offer.
     */
    public function update(Request $request, HelpOffer $offer)
    {
        // Check if the user is authorized to update this offer
        if (Auth::id() !== $offer->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the offer can still be updated
        if ($offer->status !== 'pending') {
            return back()->with('error', 'This offer can no longer be updated.');
        }
        
        // Validate the request
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);
        
        // Update the offer
        $offer->message = $validated['message'];
        $offer->save();
        
        // Add a message to the help request
        $offer->helpRequest->messages()->create([
            'user_id' => Auth::id(),
            'message' => 'Updated offer: ' . $validated['message'],
            'is_system_message' => false,
        ]);
        
        return redirect()->route('help.show', $offer->helpRequest)
            ->with('success', 'Your offer has been updated successfully.');
    }
    
    /**
     * Withdraw the specified help offer.
     */
    public function withdraw(HelpOffer $offer)
    {
        // Check if the user is authorized to withdraw this offer
        if (Auth::id() !== $offer->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the offer can still be withdrawn
        if (!in_array($offer->status, ['pending', 'accepted'])) {
            return back()->with('error', 'This offer can no longer be withdrawn.');
        }
        
        // Update the offer status
        $offer->status = 'withdrawn';
        $offer->save();
        
        // If this was the accepted offer, update the help request status
        $helpRequest = $offer->helpRequest;
        if ($helpRequest->status === 'assigned' || $helpRequest->status === 'in_progress') {
            $helpRequest->status = 'open';
            $helpRequest->save();
            
            // Add a system message
            $helpRequest->messages()->create([
                'user_id' => Auth::id(),
                'message' => 'Helper has withdrawn from this request. The request is now open again.',
                'is_system_message' => true,
            ]);
        } else {
            // Add a system message
            $helpRequest->messages()->create([
                'user_id' => Auth::id(),
                'message' => 'Helper has withdrawn their offer to help.',
                'is_system_message' => true,
            ]);
        }
        
        return redirect()->route('help.show', $helpRequest)
            ->with('success', 'Your offer has been withdrawn successfully.');
    }
    
    /**
     * Accept the specified help offer.
     */
    public function accept(HelpOffer $offer)
    {
        $helpRequest = $offer->helpRequest;
        
        // Check if the user is authorized to accept this offer
        if (Auth::id() !== $helpRequest->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the help request is still open
        if ($helpRequest->status !== 'open') {
            return back()->with('error', 'This help request already has an accepted offer or is no longer open.');
        }
        
        // Check if the offer is still pending
        if ($offer->status !== 'pending') {
            return back()->with('error', 'This offer is no longer available to accept.');
        }
        
        // Update the offer status
        $offer->status = 'accepted';
        $offer->save();
        
        // Update the help request status
        $helpRequest->status = 'assigned';
        $helpRequest->save();
        
        // Reject all other pending offers
        $helpRequest->offers()
            ->where('id', '!=', $offer->id)
            ->where('status', 'pending')
            ->update(['status' => 'rejected']);
        
        // Add a system message
        $helpRequest->messages()->create([
            'user_id' => Auth::id(),
            'message' => 'Offer from ' . $offer->user->name . ' has been accepted.',
            'is_system_message' => true,
        ]);
        
        return redirect()->route('help.show', $helpRequest)
            ->with('success', 'You have accepted this offer to help.');
    }
    
    /**
     * Reject the specified help offer.
     */
    public function reject(HelpOffer $offer)
    {
        $helpRequest = $offer->helpRequest;
        
        // Check if the user is authorized to reject this offer
        if (Auth::id() !== $helpRequest->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the offer is still pending
        if ($offer->status !== 'pending') {
            return back()->with('error', 'This offer is no longer available to reject.');
        }
        
        // Update the offer status
        $offer->status = 'rejected';
        $offer->save();
        
        // Add a system message
        $helpRequest->messages()->create([
            'user_id' => Auth::id(),
            'message' => 'Offer from ' . $offer->user->name . ' has been rejected.',
            'is_system_message' => true,
        ]);
        
        return redirect()->route('help.show', $helpRequest)
            ->with('success', 'You have rejected this offer to help.');
    }
    
    /**
     * Mark a help request as in progress.
     */
    public function startHelp(HelpRequest $helpRequest)
    {
        // Get the accepted offer
        $offer = $helpRequest->offers()->where('status', 'accepted')->first();
        
        // Check if the user is the accepted helper
        if (!$offer || Auth::id() !== $offer->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the help request is assigned
        if ($helpRequest->status !== 'assigned') {
            return back()->with('error', 'This help request is not assigned to you or is already in progress.');
        }
        
        // Update the help request status
        $helpRequest->status = 'in_progress';
        $helpRequest->save();
        
        // Add a system message
        $helpRequest->messages()->create([
            'user_id' => Auth::id(),
            'message' => 'Helper has started working on this request.',
            'is_system_message' => true,
        ]);
        
        return redirect()->route('help.show', $helpRequest)
            ->with('success', 'You have marked this help request as in progress.');
    }
    
    /**
     * Display a listing of help offers made by the current user.
     */
    public function myOffers()
    {
        $offers = Auth::user()->helpOffers()
            ->with(['helpRequest.category', 'helpRequest.user'])
            ->latest()
            ->paginate(10);
        
        return view('help.my-offers', compact('offers'));
    }
}
