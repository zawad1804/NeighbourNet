@extends('layouts.app')

@section('title', 'Help Network - The NeighbourNet')

@section('styles')
<style>
    :root {
        --help-primary-color: #3490dc;
        --help-primary-light: #eef5fc;
        --help-secondary-color: #f6993f;
        --help-success-color: #38c172;
        --help-danger-color: #e3342f;
        --help-gray-color: #6c757d;
        --help-light-gray: #f8f9fa;
        --help-card-shadow: 0 4px 12px rgba(0,0,0,0.05);
        --help-border-radius: 10px;
    }
    
    /* Help Dashboard Layout */
    .help-dashboard {
        background-color: #f9fafb;
        padding: 2rem 0;
    }
    
    .dashboard-header {
        margin-bottom: 2rem;
    }
    
    .dashboard-header h1 {
        color: #333;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .dashboard-header p {
        color: #6c757d;
        font-size: 1.1rem;
    }
    
    .dashboard-stats {
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background-color: white;
        border-radius: var(--help-border-radius);
        box-shadow: var(--help-card-shadow);
        padding: 1.5rem;
        height: 100%;
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--help-primary-color);
    }
    
    .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: #333;
    }
    
    .stat-label {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    /* Help Categories */
    .help-categories {
        margin-bottom: 3rem;
    }
    
    .help-categories h2 {
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #333;
    }
    
    .category-card {
        background-color: white;
        border-radius: var(--help-border-radius);
        box-shadow: var(--help-card-shadow);
        padding: 1.5rem;
        height: 100%;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
        text-decoration: none;
        color: #333;
        display: flex;
        flex-direction: column;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        color: #333;
    }
    
    .category-card:hover .category-icon {
        transform: scale(1.1);
    }
    
    .category-icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: var(--help-primary-color);
        transition: transform 0.3s;
    }
    
    .category-card h3 {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .category-card p {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .category-footer {
        margin-top: auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .request-count {
        background-color: var(--help-primary-light);
        color: var(--help-primary-color);
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    /* Active Requests Section */
    .active-requests {
        margin-bottom: 3rem;
    }
    
    .active-requests h2 {
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #333;
    }
    
    .request-card {
        background-color: white;
        border-radius: var(--help-border-radius);
        box-shadow: var(--help-card-shadow);
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: transform 0.2s;
    }
    
    .request-card:hover {
        transform: translateY(-3px);
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
    }
    
    .request-meta {
        display: flex;
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
        margin-bottom: 1rem;
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
    
    /* Leaderboard Section */
    .leaderboard {
        margin-bottom: 3rem;
    }
    
    .leaderboard h2 {
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: #333;
    }
    
    .leaderboard-card {
        background-color: white;
        border-radius: var(--help-border-radius);
        box-shadow: var(--help-card-shadow);
        padding: 1.5rem;
    }
    
    .helper-row {
        display: flex;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #eee;
    }
    
    .helper-row:last-child {
        border-bottom: none;
    }
    
    .helper-rank {
        font-size: 1.25rem;
        font-weight: 700;
        color: #6c757d;
        min-width: 30px;
    }
    
    .rank-1 {
        color: gold;
    }
    
    .rank-2 {
        color: silver;
    }
    
    .rank-3 {
        color: #cd7f32; /* bronze */
    }
    
    .helper-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 1rem;
        object-fit: cover;
    }
    
    .helper-info {
        flex: 1;
    }
    
    .helper-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #333;
    }
    
    .helper-meta {
        display: flex;
        gap: 1rem;
    }
    
    .helper-meta span {
        color: #6c757d;
        font-size: 0.85rem;
    }
    
    .helper-badges {
        display: flex;
        margin-left: auto;
    }
    
    .helper-badge {
        width: 24px;
        height: 24px;
        margin-left: 0.25rem;
        filter: drop-shadow(0 1px 1px rgba(0,0,0,0.1));
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .action-btn {
        background-color: white;
        border: 1px solid #eee;
        border-radius: var(--help-border-radius);
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #333;
        font-weight: 500;
        flex: 1;
        box-shadow: var(--help-card-shadow);
        transition: all 0.2s;
    }
    
    .action-btn:hover {
        transform: translateY(-3px);
        border-color: var(--help-primary-color);
        color: var(--help-primary-color);
    }
    
    .action-btn i {
        font-size: 1.5rem;
        margin-right: 1rem;
    }
    
    .action-btn.primary {
        background-color: var(--help-primary-color);
        color: white;
        border-color: var(--help-primary-color);
    }
    
    .action-btn.primary:hover {
        background-color: #2779bd;
        color: white;
    }
    
    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }
        
        .stat-card, .category-card, .request-card {
            margin-bottom: 1rem;
        }
    }
</style>
@endsection

@section('content')
<main class="help-dashboard">
    <div class="container">
        <div class="dashboard-header">
            <h1>NeighbourNet Help Network</h1>
            <p>Connect with neighbors to get help or offer assistance</p>
        </div>
        
        <div class="action-buttons">
            <a href="{{ route('help.create') }}" class="action-btn primary">
                <i class="fas fa-hand-holding-heart"></i>
                Request Help
            </a>
            <a href="{{ route('help.profile.edit') }}" class="action-btn">
                <i class="fas fa-hands-helping"></i>
                Offer to Help
            </a>
            <a href="{{ route('help.search') }}" class="action-btn">
                <i class="fas fa-search"></i>
                Browse Requests
            </a>
        </div>
        
        <div class="dashboard-stats">
            <div class="row">
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-card text-center">
                        <div class="stat-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="stat-value">{{ App\Models\HelpRequest::where('status', 'completed')->count() }}</div>
                        <div class="stat-label">NEIGHBORS HELPED</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-card text-center">
                        <div class="stat-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <div class="stat-value">{{ App\Models\HelpRequest::where('status', 'open')->count() }}</div>
                        <div class="stat-label">ACTIVE REQUESTS</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-card text-center">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-value">{{ App\Models\User::whereHas('helpOffers', function($q) { $q->where('status', 'accepted'); })->count() }}</div>
                        <div class="stat-label">ACTIVE HELPERS</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-card text-center">
                        <div class="stat-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-value">{{ number_format(App\Models\HelpFeedback::avg('overall_rating') ?: 0, 1) }}</div>
                        <div class="stat-label">AVG. RATING</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="help-categories">
            <h2>How can we help you?</h2>
            <div class="row">
                @foreach($categories as $category)
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="{{ route('help.category', $category->slug) }}" class="category-card">
                        <div class="category-icon">
                            <i class="fas {{ $category->icon }}"></i>
                        </div>
                        <h3>{{ $category->name }}</h3>
                        <p>{{ Str::limit($category->description, 100) }}</p>
                        <div class="category-footer">
                            <span class="request-count">
                                {{ App\Models\HelpRequest::where('help_category_id', $category->id)->where('status', 'open')->count() }} open requests
                            </span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="active-requests">
                    <h2>Recent Help Requests</h2>
                    @forelse($openRequests as $request)
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
                            @if($request->is_emergency)
                            <span class="request-badge badge-emergency">Urgent</span>
                            @endif
                        </div>
                        <p class="request-description">{{ Str::limit($request->description, 150) }}</p>
                        <div class="request-footer">
                            <div class="requester-info">
                                <img src="{{ asset('storage/' . ($request->user->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $request->user->name }}" class="requester-avatar">
                                <span class="requester-name">{{ $request->user->name }}</span>
                            </div>
                            <a href="{{ route('help.show', $request->id) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                        </div>
                    </div>
                    @empty
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> There are no open help requests at the moment.
                    </div>
                    @endforelse
                    
                    @if($openRequests->count() > 0)
                    <div class="text-center mt-3">
                        <a href="{{ route('help.search') }}" class="btn btn-outline-primary">View All Requests</a>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="leaderboard">
                    <h2>Top Helpers</h2>
                    <div class="leaderboard-card">
                        @forelse($topHelpers as $index => $helper)
                        <div class="helper-row">
                            <div class="helper-rank {{ 'rank-'.($index+1) }}">{{ $index + 1 }}</div>
                            <img src="{{ asset('storage/' . ($helper->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $helper->name }}" class="helper-avatar">
                            <div class="helper-info">
                                <div class="helper-name">{{ $helper->name }}</div>
                                <div class="helper-meta">
                                    <span><i class="fas fa-hands-helping"></i> {{ $helper->completed_helps }} helps</span>
                                    <span><i class="fas fa-star"></i> {{ number_format($helper->getAverageRating(), 1) }}</span>
                                </div>
                            </div>
                            <div class="helper-badges">
                                @foreach($helper->achievements()->take(3)->get() as $achievement)
                                <img src="{{ asset('storage/' . ($achievement->badge_image ?: 'badges/default.png')) }}" alt="{{ $achievement->name }}" class="helper-badge" title="{{ $achievement->name }}">
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <p class="text-center text-muted my-3">No helpers have completed requests yet.</p>
                        @endforelse
                        
                        @if($topHelpers->count() > 0)
                        <div class="text-center mt-3">
                            <a href="{{ route('help.leaderboard') }}" class="btn btn-sm btn-outline-primary">View Full Leaderboard</a>
                        </div>
                        @endif
                    </div>
                </div>
                
                @auth
                <div class="my-requests mb-4">
                    <h2>My Requests</h2>
                    <div class="leaderboard-card">
                        @if($userRequests && $userRequests->count() > 0)
                            @foreach($userRequests as $request)
                            <div class="helper-row">
                                <div class="helper-info">
                                    <div class="helper-name">{{ Str::limit($request->title, 30) }}</div>
                                    <div class="helper-meta">
                                        <span><i class="fas {{ $request->category->icon }}"></i> {{ $request->category->name }}</span>
                                        <span><i class="fas fa-clock"></i> {{ $request->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <span class="badge bg-{{ $request->status === 'open' ? 'success' : ($request->status === 'completed' ? 'secondary' : 'primary') }}">
                                    {{ ucfirst($request->status) }}
                                </span>
                            </div>
                            @endforeach
                            <div class="text-center mt-3">
                                <a href="{{ route('help.my-requests') }}" class="btn btn-sm btn-outline-primary">View All My Requests</a>
                            </div>
                        @else
                            <p class="text-center text-muted my-3">You haven't created any help requests yet.</p>
                            <div class="text-center">
                                <a href="{{ route('help.create') }}" class="btn btn-sm btn-primary">Create Your First Request</a>
                            </div>
                        @endif
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </div>
</main>
@endsection
