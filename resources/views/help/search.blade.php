@extends('layouts.app')

@section('title', 'Browse Help Requests - NeighbourNet')

@section('styles')
<style>
    :root {
        --help-primary-color: #3490dc;
        --help-primary-light: #eef5fc;
        --help-secondary-color: #f6993f;
        --help-danger-color: #e3342f;
        --help-success-color: #38c172;
        --help-gray-color: #6c757d;
        --help-light-gray: #f8f9fa;
        --help-card-shadow: 0 4px 12px rgba(0,0,0,0.05);
        --help-border-radius: 10px;
    }
    
    .help-search-container {
        padding: 2rem 0;
        background-color: #f9fafb;
        min-height: calc(100vh - 150px);
    }
    
    .search-header {
        margin-bottom: 2rem;
    }
    
    .search-header h1 {
        color: #333;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .search-header p {
        color: #6c757d;
        font-size: 1.1rem;
    }
    
    .search-box {
        background-color: white;
        border-radius: var(--help-border-radius);
        box-shadow: var(--help-card-shadow);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .search-form {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .search-input {
        flex: 1 0 250px;
        position: relative;
    }
    
    .search-input i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }
    
    .search-input input {
        padding-left: 2.5rem;
        border-radius: 30px;
    }
    
    .filter-dropdown {
        flex: 0 0 180px;
    }
    
    .category-filter {
        flex: 0 0 180px;
    }
    
    .search-button {
        border-radius: 30px;
        padding-left: 1.5rem;
        padding-right: 1.5rem;
    }
    
    .filters-section {
        margin-bottom: 1.5rem;
    }
    
    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .filter-badge {
        background-color: var(--help-primary-light);
        color: var(--help-primary-color);
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 500;
        display: flex;
        align-items: center;
    }
    
    .filter-badge i {
        margin-left: 0.5rem;
        cursor: pointer;
    }
    
    .filter-badge i:hover {
        color: var(--help-danger-color);
    }
    
    .results-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        color: #6c757d;
    }
    
    .sort-options {
        display: flex;
        align-items: center;
    }
    
    .sort-options label {
        margin-right: 0.5rem;
        font-size: 0.9rem;
    }
    
    .sort-options select {
        border-radius: 30px;
        padding: 0.25rem 0.75rem;
        font-size: 0.9rem;
    }
    
    .request-card {
        background-color: white;
        border-radius: var(--help-border-radius);
        box-shadow: var(--help-card-shadow);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: transform 0.2s;
    }
    
    .request-card:hover {
        transform: translateY(-5px);
    }
    
    .request-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    
    .request-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #333;
        font-size: 1.25rem;
    }
    
    .request-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .request-meta span {
        color: #6c757d;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
    }
    
    .request-meta i {
        margin-right: 0.25rem;
    }
    
    .request-badge {
        background-color: var(--help-primary-light);
        color: var(--help-primary-color);
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        white-space: nowrap;
    }
    
    .badge-emergency {
        background-color: #fdf2f2;
        color: var(--help-danger-color);
    }
    
    .request-description {
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }
    
    .request-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .requester-info {
        display: flex;
        align-items: center;
    }
    
    .requester-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin-right: 0.5rem;
        object-fit: cover;
    }
    
    .requester-name {
        font-size: 0.9rem;
        font-weight: 500;
        color: #333;
    }
    
    .request-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .category-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }
    
    .category-tab {
        padding: 0.5rem 1rem;
        border-radius: 30px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        background-color: var(--help-light-gray);
        color: #6c757d;
    }
    
    .category-tab:hover {
        background-color: #e9ecef;
    }
    
    .category-tab.active {
        background-color: var(--help-primary-color);
        color: white;
    }
    
    .emergency-toggle {
        display: flex;
        align-items: center;
        margin-top: 0.5rem;
    }
    
    .emergency-toggle label {
        margin-left: 0.5rem;
        font-size: 0.9rem;
        cursor: pointer;
    }
    
    .skill-match {
        display: inline-block;
        background-color: #d1e7dd;
        color: #0f5132;
        padding: 0.25rem 0.5rem;
        border-radius: 3px;
        font-size: 0.8rem;
        margin-left: 0.5rem;
        vertical-align: middle;
    }
    
    .pagination-container {
        margin-top: 2rem;
    }
    
    .no-results {
        text-align: center;
        padding: 3rem 2rem;
        background-color: white;
        border-radius: var(--help-border-radius);
        box-shadow: var(--help-card-shadow);
    }
    
    .no-results-icon {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }
    
    .no-results-message {
        font-size: 1.25rem;
        color: #6c757d;
        margin-bottom: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .search-form {
            flex-direction: column;
        }
        
        .search-input, 
        .filter-dropdown, 
        .category-filter {
            flex: 1 0 100%;
        }
        
        .request-header {
            flex-direction: column;
        }
        
        .request-badge {
            align-self: flex-start;
            margin-top: 0.5rem;
        }
        
        .request-footer {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .request-actions {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="help-search-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="search-header">
                    <h1>Browse Help Requests</h1>
                    <p>Find neighbors in need of assistance</p>
                </div>
                
                <div class="search-box">
                    <form action="{{ route('help.search') }}" method="GET" class="search-form">
                        <div class="search-input">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" name="q" value="{{ request('q') }}" placeholder="Search by keyword...">
                        </div>
                        
                        <div class="category-filter">
                            <select class="form-select" name="category">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="filter-dropdown">
                            <select class="form-select" name="status">
                                <option value="open" {{ request('status') == 'open' || !request('status') ? 'selected' : '' }}>Open Requests</option>
                                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Requests</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary search-button">Search</button>
                    </form>
                    
                    <div class="emergency-toggle mt-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="emergency_only" name="emergency_only" {{ request('emergency_only') ? 'checked' : '' }} onchange="this.form.submit()">
                            <label class="form-check-label" for="emergency_only">Show urgent requests only</label>
                        </div>
                    </div>
                    
                    @if(request('q') || request('category') || request('status') != 'open' || request('emergency_only'))
                    <div class="active-filters">
                        @if(request('q'))
                        <div class="filter-badge">
                            Search: "{{ request('q') }}"
                            <a href="{{ route('help.search', array_merge(request()->except('q'), ['page' => 1])) }}"><i class="fas fa-times"></i></a>
                        </div>
                        @endif
                        
                        @if(request('category'))
                        <div class="filter-badge">
                            Category: {{ $categories->find(request('category'))->name }}
                            <a href="{{ route('help.search', array_merge(request()->except('category'), ['page' => 1])) }}"><i class="fas fa-times"></i></a>
                        </div>
                        @endif
                        
                        @if(request('status') && request('status') != 'open')
                        <div class="filter-badge">
                            Status: {{ ucfirst(request('status')) }}
                            <a href="{{ route('help.search', array_merge(request()->except('status'), ['page' => 1])) }}"><i class="fas fa-times"></i></a>
                        </div>
                        @endif
                        
                        @if(request('emergency_only'))
                        <div class="filter-badge">
                            Urgent Only
                            <a href="{{ route('help.search', array_merge(request()->except('emergency_only'), ['page' => 1])) }}"><i class="fas fa-times"></i></a>
                        </div>
                        @endif
                        
                        <a href="{{ route('help.search') }}" class="btn btn-sm btn-outline-secondary">Clear All</a>
                    </div>
                    @endif
                </div>
                
                <div class="category-tabs">
                    <a href="{{ route('help.search') }}" class="category-tab {{ !request('category') ? 'active' : '' }}">All</a>
                    @foreach($categories as $category)
                    <a href="{{ route('help.search', ['category' => $category->id]) }}" class="category-tab {{ request('category') == $category->id ? 'active' : '' }}">
                        <i class="fas {{ $category->icon }} me-1"></i> {{ $category->name }}
                    </a>
                    @endforeach
                </div>
                
                @if($helpRequests->total() > 0)
                <div class="results-info">
                    <div>
                        Showing {{ $helpRequests->firstItem() }}-{{ $helpRequests->lastItem() }} of {{ $helpRequests->total() }} request(s)
                    </div>
                    <div class="sort-options">
                        <label for="sort">Sort:</label>
                        <select id="sort" class="form-select form-select-sm" onchange="window.location = this.value;">
                            <option value="{{ route('help.search', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>Newest</option>
                            <option value="{{ route('help.search', array_merge(request()->except('sort'), ['sort' => 'oldest'])) }}" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                            <option value="{{ route('help.search', array_merge(request()->except('sort'), ['sort' => 'urgent'])) }}" {{ request('sort') == 'urgent' ? 'selected' : '' }}>Urgent First</option>
                            @auth
                            <option value="{{ route('help.search', array_merge(request()->except('sort'), ['sort' => 'skill_match'])) }}" {{ request('sort') == 'skill_match' ? 'selected' : '' }}>Skill Match</option>
                            @endauth
                        </select>
                    </div>
                </div>
                
                @foreach($helpRequests as $request)
                <div class="request-card">
                    <div class="request-header">
                        <div>
                            <h3 class="request-title">{{ $request->title }}</h3>
                            <div class="request-meta">
                                <span><i class="fas {{ $request->category->icon }}"></i> {{ $request->category->name }}</span>
                                <span><i class="fas fa-map-marker-alt"></i> {{ $request->location ?: 'No location specified' }}</span>
                                <span><i class="fas fa-clock"></i> {{ $request->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div>
                            @if($request->is_emergency)
                            <span class="request-badge badge-emergency">Urgent</span>
                            @endif
                            
                            @if($request->status != 'open')
                            <span class="request-badge" style="background-color: {{ $request->status == 'in_progress' ? '#cfe2ff' : '#d3d3d3' }}; color: {{ $request->status == 'in_progress' ? '#084298' : '#333' }};">
                                {{ $request->status == 'in_progress' ? 'In Progress' : ucfirst($request->status) }}
                            </span>
                            @endif
                            
                            @auth
                                @if(request('sort') == 'skill_match' && auth()->user()->hasMatchingSkills($request))
                                <span class="skill-match">Skill Match</span>
                                @endif
                            @endauth
                        </div>
                    </div>
                    
                    <p class="request-description">{{ Str::limit($request->description, 150) }}</p>
                    
                    <div class="request-footer">
                        <div class="requester-info">
                            <img src="{{ asset('storage/' . ($request->user->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $request->user->name }}" class="requester-avatar">
                            <span class="requester-name">{{ $request->user->name }}</span>
                        </div>
                        <div class="request-actions">
                            <a href="{{ route('help.show', $request->id) }}" class="btn btn-sm btn-primary">View Details</a>
                            @if($request->status == 'open' && auth()->id() != $request->user_id)
                            <a href="{{ route('help.offer.create', $request->id) }}" class="btn btn-sm btn-outline-secondary">Offer to Help</a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                
                <div class="pagination-container d-flex justify-content-center">
                    {{ $helpRequests->appends(request()->except('page'))->links() }}
                </div>
                @else
                <div class="no-results">
                    <div class="no-results-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="no-results-message">
                        No help requests found matching your criteria
                    </div>
                    <p class="text-muted mb-4">Try adjusting your search filters or browse all requests</p>
                    <a href="{{ route('help.search') }}" class="btn btn-primary">Browse All Requests</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const emergencyToggle = document.getElementById('emergency_only');
        
        emergencyToggle.addEventListener('change', function() {
            const currentUrl = new URL(window.location.href);
            
            if (this.checked) {
                currentUrl.searchParams.set('emergency_only', '1');
            } else {
                currentUrl.searchParams.delete('emergency_only');
            }
            
            window.location.href = currentUrl.toString();
        });
    });
</script>
@endsection
