<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CommunityController extends Controller
{
    /**
     * Display the community feed
     */
    public function feed()
    {
        $posts = Post::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $topContributors = User::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit(3)
            ->get();
            
        return view('community.feed', [
            'posts' => $posts,
            'topContributors' => $topContributors
        ]);
    }
    
    /**
     * Store a new community post
     */
    public function storePost(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:50',
        ]);
        
        $post = new Post;
        $post->user_id = Auth::id();
        $post->content = $validated['content'];
        $post->category = $validated['category'] ?? null;
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image_path = $imagePath;
        }
        
        $post->save();
        
        return redirect()->route('community.feed')->with('success', 'Post created successfully!');
    }
    
    /**
     * Show the form for editing a post
     */
    public function editPost(Post $post)
    {
        // Check if the user is authorized to edit this post
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('community.feed')->with('error', 'You are not authorized to edit this post.');
        }
        
        return view('community.edit', [
            'post' => $post
        ]);
    }
    
    /**
     * Update an existing post
     */
    public function updatePost(Request $request, Post $post)
    {
        // Check if the user is authorized to update this post
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('community.feed')->with('error', 'You are not authorized to update this post.');
        }
        
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'nullable|string|max:50',
        ]);
        
        $post->content = $validated['content'];
        $post->category = $validated['category'] ?? null;
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image_path = $imagePath;
        }
        
        $post->save();
        
        return redirect()->route('community.feed')->with('success', 'Post updated successfully!');
    }
    
    /**
     * Delete a post
     */
    public function destroyPost(Post $post)
    {
        // Check if the user is authorized to delete this post
        if (Auth::id() !== $post->user_id) {
            return redirect()->route('community.feed')->with('error', 'You are not authorized to delete this post.');
        }
        
        // Delete image if exists
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }
        
        $post->delete();
        
        return redirect()->route('community.feed')->with('success', 'Post deleted successfully!');
    }
}
