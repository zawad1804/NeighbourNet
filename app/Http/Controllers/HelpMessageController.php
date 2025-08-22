<?php

namespace App\Http\Controllers;

use App\Models\HelpMessage;
use App\Models\HelpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HelpMessageController extends Controller
{
    /**
     * Store a newly created message in storage.
     */
    public function store(Request $request, HelpRequest $helpRequest)
    {
        // Check if the user is authorized to send messages
        $isRequester = Auth::id() === $helpRequest->user_id;
        $isHelper = false;
        
        // Check if the user is the assigned helper
        $acceptedOffer = $helpRequest->offers()->where('status', 'accepted')->first();
        if ($acceptedOffer) {
            $isHelper = Auth::id() === $acceptedOffer->user_id;
        }
        
        if (!$isRequester && !$isHelper) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the help request is active
        if (in_array($helpRequest->status, ['cancelled', 'completed'])) {
            return back()->with('error', 'You cannot send messages to a request that is cancelled or completed.');
        }
        
        // Validate the request
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:jpeg,png,jpg,gif,pdf,doc,docx|max:5120',
        ]);
        
        // Handle attachments
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('help-attachments', 'public');
                $attachments[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ];
            }
        }
        
        // Create the message
        $message = new HelpMessage();
        $message->help_request_id = $helpRequest->id;
        $message->user_id = Auth::id();
        $message->message = $validated['message'];
        $message->attachments = !empty($attachments) ? $attachments : null;
        $message->is_system_message = false;
        $message->save();
        
        return redirect()->route('help.show', $helpRequest)
            ->with('success', 'Your message has been sent successfully.');
    }
    
    /**
     * Delete the specified message.
     */
    public function destroy(HelpMessage $message)
    {
        // Check if the user is authorized to delete this message
        if (Auth::id() !== $message->user_id) {
            abort(403, 'Unauthorized action.');
        }
        
        // Can't delete system messages
        if ($message->is_system_message) {
            return back()->with('error', 'System messages cannot be deleted.');
        }
        
        // Delete attachments if any
        if (!empty($message->attachments)) {
            foreach ($message->attachments as $attachment) {
                if (isset($attachment['path'])) {
                    Storage::disk('public')->delete($attachment['path']);
                }
            }
        }
        
        // Delete the message
        $message->delete();
        
        return back()->with('success', 'Message deleted successfully.');
    }
    
    /**
     * Download an attachment from a message.
     */
    public function downloadAttachment(HelpMessage $message, $index)
    {
        // Check if the user is authorized to download this attachment
        $helpRequest = $message->helpRequest;
        $isRequester = Auth::id() === $helpRequest->user_id;
        $isHelper = false;
        
        // Check if the user is the assigned helper
        $acceptedOffer = $helpRequest->offers()->where('status', 'accepted')->first();
        if ($acceptedOffer) {
            $isHelper = Auth::id() === $acceptedOffer->user_id;
        }
        
        if (!$isRequester && !$isHelper) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if the attachment exists
        $attachments = $message->attachments;
        if (empty($attachments) || !isset($attachments[$index])) {
            abort(404, 'Attachment not found.');
        }
        
        $attachment = $attachments[$index];
        
        // Check if the file exists
        if (!Storage::disk('public')->exists($attachment['path'])) {
            abort(404, 'File not found.');
        }
        
        // Return the file
        return Storage::disk('public')->download(
            $attachment['path'],
            $attachment['name'],
            ['Content-Type' => $attachment['type']]
        );
    }
}
