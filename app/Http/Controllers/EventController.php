<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display a listing of events.
     */
    public function index()
    {
        $events = Event::with('user')
            ->orderBy('start_date', 'asc')
            ->where('start_date', '>=', now()->format('Y-m-d'))
            ->paginate(10);
            
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate form data
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|string|max:50',
                'start_date' => 'required|date',
                'start_time' => 'required',
                'end_date' => 'nullable|date',
                'end_time' => 'nullable',
                'location' => 'required|string|max:255',
                'location_details' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB limit
                'max_attendees' => 'nullable|integer|min:1',
                'is_public' => 'boolean',
                'rsvp_enabled' => 'boolean',
            ], [
                'image.max' => 'The image must be less than 2MB in size.',
                'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
                'image.image' => 'The file must be an image.',
            ]);
            
            $eventData = $validated;
            $eventData['user_id'] = Auth::id();
            
            // Set boolean fields (ensure defaults if checkboxes aren't checked)
            $eventData['is_public'] = $request->has('is_public') ? true : false;
            $eventData['rsvp_enabled'] = $request->has('rsvp_enabled') ? true : false;
            
            // Handle image upload with specific JPG fix
            if ($request->hasFile('image')) {
                try {
                    $image = $request->file('image');
                    
                    // Extra file size check
                    $maxSize = 2 * 1024 * 1024; // 2MB
                    if ($image->getSize() > $maxSize) {
                        $fileSizeMB = round($image->getSize() / 1024 / 1024, 2);
                        throw new \Exception("Image size ({$fileSizeMB}MB) exceeds the maximum allowed size of 2MB");
                    }
                    
                    // Debug info for upload
                    \Log::info('Image upload info', [
                        'originalName' => $image->getClientOriginalName(),
                        'originalExtension' => $image->getClientOriginalExtension(),
                        'mimeType' => $image->getMimeType(),
                        'size' => $image->getSize(),
                        'sizeFormatted' => round($image->getSize() / 1024 / 1024, 2) . 'MB',
                    ]);
                    
                    // Get file extension
                    $extension = strtolower($image->getClientOriginalExtension());
                    
                    // For JPG files, ensure consistent extension
                    if ($extension === 'jpg' || $extension === 'jpeg' || $image->getMimeType() === 'image/jpeg') {
                        $extension = 'jpg';
                    }
                    
                    // Create a safe filename
                    $filename = time() . '_' . uniqid() . '.' . $extension;
                    
                    // Store the file manually to ensure proper handling of all image types
                    $path = $image->storeAs('events', $filename, 'public');
                    
                    if ($path) {
                        $eventData['image'] = $path;
                        \Log::info('Image stored successfully', ['path' => $path]);
                    } else {
                        // Log error if storage fails
                        \Log::error('Failed to store image file: ' . $image->getClientOriginalName());
                        throw new \Exception("Failed to store the image file. Please try again.");
                    }
                } catch (\Exception $e) {
                    // Log any errors during image processing
                    \Log::error('Image upload error: ' . $e->getMessage());
                    \Log::error($e->getTraceAsString());
                    
                    // Return with a specific error message for the user
                    return redirect()->back()
                        ->withInput()
                        ->withErrors(['image' => $e->getMessage()]);
                }
            }
            
            // Create the event
            $event = Event::create($eventData);
            
            // Add the creator as an attendee
            $event->attendees()->attach(Auth::id());
            
            return redirect()->route('events.show', $event)
                            ->with('success', 'Event created successfully!');
                            
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Event creation error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Error creating event: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        $event->load(['user', 'attendees']);
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        // Check if the current user is the event creator
        if ($event->user_id !== Auth::id()) {
            return redirect()->route('events.show', $event)
                             ->with('error', 'You are not authorized to edit this event.');
        }
        
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        // Check if the current user is the event creator
        if ($event->user_id !== Auth::id()) {
            return redirect()->route('events.show', $event)
                             ->with('error', 'You are not authorized to edit this event.');
        }
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:50',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'nullable|date',
            'end_time' => 'nullable',
            'location' => 'required|string|max:255',
            'location_details' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'max_attendees' => 'nullable|integer|min:1',
            'is_public' => 'boolean',
            'rsvp_enabled' => 'boolean',
        ]);
        
        $eventData = $validated;
        
        // Set boolean fields
        $eventData['is_public'] = $request->has('is_public');
        $eventData['rsvp_enabled'] = $request->has('rsvp_enabled');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            try {
                // Delete old image if exists
                if ($event->image) {
                    Storage::disk('public')->delete($event->image);
                }
                
                $image = $request->file('image');
                
                // Debug info for upload
                \Log::info('Image update info', [
                    'originalName' => $image->getClientOriginalName(),
                    'originalExtension' => $image->getClientOriginalExtension(),
                    'mimeType' => $image->getMimeType(),
                    'size' => $image->getSize(),
                ]);
                
                // Get file extension
                $extension = strtolower($image->getClientOriginalExtension());
                
                // For JPG files, ensure consistent extension
                if ($extension === 'jpg' || $extension === 'jpeg' || $image->getMimeType() === 'image/jpeg') {
                    $extension = 'jpg';
                }
                
                // Create a safe filename
                $filename = time() . '_' . uniqid() . '.' . $extension;
                
                // Store the file manually to ensure proper handling of all image types
                $path = $image->storeAs('events', $filename, 'public');
                
                if ($path) {
                    $eventData['image'] = $path;
                    \Log::info('Image updated successfully', ['path' => $path]);
                } else {
                    // Log error if storage fails
                    \Log::error('Failed to store updated image file: ' . $image->getClientOriginalName());
                }
            } catch (\Exception $e) {
                // Log any errors during image processing
                \Log::error('Image update error: ' . $e->getMessage());
                \Log::error($e->getTraceAsString());
            }
        }
        
        // Handle image removal
        if ($request->has('remove_image') && $event->image) {
            Storage::disk('public')->delete($event->image);
            $eventData['image'] = null;
        }
        
        $event->update($eventData);
        
        return redirect()->route('events.show', $event)
                         ->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        // Check if the current user is the event creator
        if ($event->user_id !== Auth::id()) {
            return redirect()->route('events.show', $event)
                             ->with('error', 'You are not authorized to delete this event.');
        }
        
        // Delete event image if exists
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        
        $event->delete();
        
        return redirect()->route('events.index')
                         ->with('success', 'Event deleted successfully!');
    }
    
    /**
     * RSVP to an event.
     */
    public function rsvp(Request $request, Event $event)
    {
        $validated = $request->validate([
            'attending' => 'required|boolean',
        ]);
        
        $userId = Auth::id();
        
        if ($validated['attending']) {
            // Add user to attendees if not already attending
            if (!$event->attendees()->where('user_id', $userId)->exists()) {
                $event->attendees()->attach($userId);
            }
            $message = 'You are now attending this event!';
        } else {
            // Remove user from attendees
            $event->attendees()->detach($userId);
            $message = 'You are no longer attending this event.';
        }
        
        return redirect()->back()->with('success', $message);
    }
}
