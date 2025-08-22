<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MarketplaceController extends Controller
{
    /**
     * Display a listing of the items.
     */
    public function index(Request $request)
    {
        // Get items from cache if no filters are applied
        $cacheKey = 'marketplace-items-' . md5(json_encode($request->all()));
        $itemsPerPage = 12;
        
        $items = \Cache::remember($cacheKey, 5, function () use ($request, $itemsPerPage) {
            $query = Item::query();

            // Filter by category
            if ($request->has('category') && $request->category !== 'all') {
                $query->where('category', $request->category);
            }

            // Filter by type
            if ($request->has('type') && $request->type !== 'all') {
                $query->where('type', $request->type);
            }

            // Filter by search term
            if ($request->has('search') && !empty($request->search)) {
                $query->where(function($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }

            // Sort items
            $sortField = $request->sort ?? 'created_at';
            $sortDirection = $request->direction ?? 'desc';

            if ($sortField === 'price') {
                // Handle sorting by price, with free items at the end when sorting asc
                if ($sortDirection === 'asc') {
                    $query->orderByRaw('CASE WHEN price = 0 THEN 1 ELSE 0 END, price ASC');
                } else {
                    $query->orderBy('price', 'desc');
                }
            } else {
                $query->orderBy($sortField, $sortDirection);
            }

            // Get only active items
            $query->where('status', 'available');

            // Select only needed fields to reduce query size
            $query->select('id', 'user_id', 'title', 'slug', 'category', 'type', 'price', 'image', 'created_at');

            // Eager load just what we need from the user relationship
            // 'name' is a computed attribute, so we need to load the first_name and last_name fields
            $query->with(['user:id,first_name,last_name,avatar']);

            return $query->paginate($itemsPerPage)->withQueryString();
        });

        // Get unique categories for the filter - use cache with longer duration
        $categories = \Cache::remember('marketplace-categories', 60 * 60, function () {
            return Item::where('status', 'available')
                ->distinct()
                ->pluck('category')
                ->filter()
                ->sort()
                ->values();
        });

        return view('marketplace.index', compact('items', 'categories'));
    }

    /**
     * Show the form for creating a new item.
     */
    public function create()
    {
        return view('marketplace.create');
    }

    /**
     * Store a newly created item in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:50',
            'type' => 'required|string|in:for-sale,free,rent,wanted',
            'price' => 'required_unless:type,free|nullable|numeric|min:0',
            'condition' => 'nullable|string|max:50',
            'brand' => 'nullable|string|max:100',
            'location' => 'required|string|max:255',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'hide_location' => 'boolean',
            'contact_message' => 'boolean',
            'contact_phone' => 'boolean',
        ]);
        
        // Log the image upload request for debugging
        if ($request->hasFile('images')) {
            \Log::info('Image files received: ' . count($request->file('images')));
            foreach($request->file('images') as $index => $file) {
                \Log::info("Image $index: {$file->getClientOriginalName()}, type: {$file->getMimeType()}, size: {$file->getSize()}");
            }
        } else {
            \Log::info('No image files received in the request');
            // Check if images field exists in the request
            \Log::info('Images field exists in request: ' . ($request->has('images') ? 'Yes' : 'No'));
        }

        // Set price to 0 if the type is free
        if ($request->type === 'free') {
            $request->merge(['price' => 0]);
        }

        $item = new Item();
        $item->user_id = Auth::id();
        $item->title = $request->title;
        $item->description = $request->description;
        $item->category = $request->category;
        $item->type = $request->type;
        $item->price = $request->price;
        $item->condition = $request->condition;
        $item->brand = $request->brand;
        $item->location = $request->location;
        $item->status = 'available';
        $item->hide_location = $request->has('hide_location');
        $item->contact_message = $request->has('contact_message');
        $item->contact_phone = $request->has('contact_phone');
        
        // Generate a slug
        $item->slug = Str::slug($request->title) . '-' . uniqid();

        $item->save();

        // Handle image uploads
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $gallery = [];
            
            foreach ($images as $index => $image) {
                $path = $image->store('marketplace', 'public');
                
                // First image becomes the main image
                if ($index === 0) {
                    $item->image = $path;
                } else {
                    $gallery[] = $path;
                }
            }
            
            if (!empty($gallery)) {
                $item->gallery = $gallery;
                $item->save();
            }
        }

        return redirect()->route('marketplace.show', $item)
            ->with('success', 'Your item has been listed successfully!');
    }

    /**
     * Display the specified item.
     */
    public function show(Item $item)
    {
        // Don't allow viewing unavailable items (except by the owner)
        if ($item->status !== 'available' && $item->user_id !== Auth::id()) {
            abort(404);
        }

        // Load the user relationship if not already loaded
        if (!$item->relationLoaded('user')) {
            $item->load('user');
        }

        // Get related items
        $relatedItems = Item::where('category', $item->category)
            ->where('id', '!=', $item->id)
            ->where('status', 'available')
            ->with('user')
            ->take(4)
            ->get();

        return view('marketplace.show', compact('item', 'relatedItems'));
    }

    /**
     * Show the form for editing the specified item.
     */
    public function edit(Item $item)
    {
        // Check if the user is the owner of the item
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('marketplace.edit', compact('item'));
    }

    /**
     * Update the specified item in storage.
     */
    public function update(Request $request, Item $item)
    {
        // Check if the user is the owner of the item
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:50',
            'type' => 'required|string|in:for-sale,free,rent,wanted',
            'price' => 'required_unless:type,free|nullable|numeric|min:0',
            'condition' => 'nullable|string|max:50',
            'brand' => 'nullable|string|max:100',
            'location' => 'required|string|max:255',
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|string|in:available,pending,sold',
            'hide_location' => 'boolean',
            'contact_message' => 'boolean',
            'contact_phone' => 'boolean',
        ]);

        // Set price to 0 if the type is free
        if ($request->type === 'free') {
            $request->merge(['price' => 0]);
        }

        $item->title = $request->title;
        $item->description = $request->description;
        $item->category = $request->category;
        $item->type = $request->type;
        $item->price = $request->price;
        $item->condition = $request->condition;
        $item->brand = $request->brand;
        $item->location = $request->location;
        $item->status = $request->status;
        $item->hide_location = $request->has('hide_location');
        $item->contact_message = $request->has('contact_message');
        $item->contact_phone = $request->has('contact_phone');

        // Handle removing existing images
        $gallery = $item->gallery ?? [];

        // If the user unchecked the main image
        if (!$request->has('keep_main_image') && $item->image) {
            Storage::disk('public')->delete($item->image);
            $item->image = null;
        }

        // Check which gallery images to keep
        $keepGallery = $request->keep_gallery ?? [];
        $newGallery = [];

        foreach ($gallery as $index => $image) {
            if (in_array((string)$index, $keepGallery)) {
                $newGallery[] = $image;
            } else {
                Storage::disk('public')->delete($image);
            }
        }

        // Handle making a gallery image the main image
        if ($request->has('main_image') && isset($gallery[$request->main_image])) {
            if ($item->image) {
                // Move current main image to gallery
                $newGallery[] = $item->image;
            }
            
            // Set selected gallery image as main
            $item->image = $gallery[$request->main_image];
            
            // Remove from gallery
            unset($newGallery[array_search($gallery[$request->main_image], $newGallery)]);
            $newGallery = array_values($newGallery);
        }

        $item->gallery = $newGallery;

        // Handle new image uploads
        if ($request->hasFile('new_images')) {
            $newImages = $request->file('new_images');
            $currentCount = ($item->image ? 1 : 0) + count($newGallery);
            $maxNewImages = 5 - $currentCount;
            
            // Only process up to the maximum allowed images
            $imagesToProcess = array_slice($newImages, 0, $maxNewImages);
            
            foreach ($imagesToProcess as $image) {
                $path = $image->store('marketplace', 'public');
                
                // If there's no main image, make this the main image
                if (!$item->image) {
                    $item->image = $path;
                } else {
                    $newGallery[] = $path;
                }
            }
            
            $item->gallery = $newGallery;
        }

        $item->save();

        return redirect()->route('marketplace.show', $item)
            ->with('success', 'Your item has been updated successfully!');
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy(Item $item)
    {
        // Check if the user is the owner of the item
        if ($item->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete images
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }

        if ($item->gallery) {
            foreach ($item->gallery as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $item->delete();

        return redirect()->route('marketplace.index')
            ->with('success', 'Your item has been deleted successfully!');
    }

    /**
     * Display user's own marketplace listings.
     */
    public function myListings()
    {
        $items = Item::where('user_id', Auth::id())
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('marketplace.my-listings', compact('items'));
    }
}
