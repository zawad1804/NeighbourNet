@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="h5 mb-0">Edit Post</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('community.post.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5" required>{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                <option value="">-- Select Category --</option>
                                <option value="general" {{ old('category', $post->category) == 'general' ? 'selected' : '' }}>General</option>
                                <option value="announcement" {{ old('category', $post->category) == 'announcement' ? 'selected' : '' }}>Announcement</option>
                                <option value="help" {{ old('category', $post->category) == 'help' ? 'selected' : '' }}>Help Needed</option>
                                <option value="recommendation" {{ old('category', $post->category) == 'recommendation' ? 'selected' : '' }}>Recommendation</option>
                                <option value="alert" {{ old('category', $post->category) == 'alert' ? 'selected' : '' }}>Alert</option>
                                <option value="lost-found" {{ old('category', $post->category) == 'lost-found' ? 'selected' : '' }}>Lost & Found</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Image (optional)</label>
                            @if($post->image_path)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $post->image_path) }}" class="img-fluid rounded mb-2" style="max-height: 200px;">
                                    <p class="text-muted small">Current image. Upload a new one to replace it.</p>
                                </div>
                            @endif
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('community.feed') }}" class="btn btn-outline-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
