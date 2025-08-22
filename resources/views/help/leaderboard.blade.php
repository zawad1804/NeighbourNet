@extends('layouts.app')

@section('title', 'Help Network Leaderboard - NeighbourNet')

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
    
    .leaderboard-container {
        padding: 2rem 0;
        background-color: #f9fafb;
        min-height: calc(100vh - 150px);
    }
    
    .leaderboard-header {
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .leaderboard-header h1 {
        color: #333;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .leaderboard-header p {
        color: #6c757d;
        font-size: 1.1rem;
    }
    
    .leaderboard-card {
        background-color: white;
        border-radius: var(--help-border-radius);
        box-shadow: var(--help-card-shadow);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .top-helpers {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        margin-bottom: 3rem;
    }
    
    .top-helper {
        text-align: center;
        padding: 1.5rem;
        position: relative;
    }
    
    .top-rank {
        position: absolute;
        top: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.25rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .rank-1 {
        background-color: gold;
        color: #333;
    }
    
    .rank-2 {
        background-color: silver;
        color: #333;
    }
    
    .rank-3 {
        background-color: #cd7f32; /* bronze */
        color: white;
    }
    
    .top-helper-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin: 0 auto 1rem;
        border: 3px solid white;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    
    .top-helper-1 .top-helper-avatar {
        width: 140px;
        height: 140px;
        border: 4px solid gold;
    }
    
    .top-helper-2 .top-helper-avatar {
        border: 3px solid silver;
    }
    
    .top-helper-3 .top-helper-avatar {
        border: 3px solid #cd7f32;
    }
    
    .top-helper-name {
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .top-helper-1 .top-helper-name {
        font-size: 1.5rem;
    }
    
    .top-helper-stats {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .top-helper-stat {
        color: #6c757d;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .top-helper-stat i {
        margin-right: 0.25rem;
    }
    
    .top-helper-badges {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .top-helper-badge {
        width: 30px;
        height: 30px;
        filter: drop-shadow(0 1px 2px rgba(0,0,0,0.1));
    }
    
    .leaderboard-table {
        width: 100%;
    }
    
    .leaderboard-table th {
        font-weight: 600;
        color: #333;
        padding: 1rem;
        border-bottom: 2px solid #eee;
    }
    
    .leaderboard-row {
        border-bottom: 1px solid #eee;
        transition: background-color 0.2s;
    }
    
    .leaderboard-row:hover {
        background-color: var(--help-light-gray);
    }
    
    .leaderboard-row td {
        padding: 1rem;
        vertical-align: middle;
    }
    
    .helper-rank {
        font-weight: 700;
        color: #6c757d;
        width: 50px;
        text-align: center;
    }
    
    .top-3 {
        font-weight: 700;
    }
    
    .rank-1-row {
        color: gold;
    }
    
    .rank-2-row {
        color: silver;
    }
    
    .rank-3-row {
        color: #cd7f32;
    }
    
    .helper-info {
        display: flex;
        align-items: center;
    }
    
    .helper-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 1rem;
        object-fit: cover;
    }
    
    .helper-details {
        flex: 1;
    }
    
    .helper-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #333;
    }
    
    .helper-title {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .helper-stats {
        display: flex;
        gap: 1.5rem;
    }
    
    .helper-stat {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .helper-stat i {
        color: var(--help-primary-color);
        margin-right: 0.25rem;
    }
    
    .helper-badges {
        display: flex;
        gap: 0.5rem;
    }
    
    .helper-badge {
        width: 24px;
        height: 24px;
        filter: drop-shadow(0 1px 1px rgba(0,0,0,0.1));
    }
    
    .view-profile-btn {
        background-color: var(--help-primary-light);
        color: var(--help-primary-color);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .view-profile-btn:hover {
        background-color: var(--help-primary-color);
        color: white;
    }
    
    .leaderboard-tabs {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .leaderboard-tab {
        padding: 0.75rem 1.5rem;
        background-color: white;
        border-radius: 30px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .leaderboard-tab:hover {
        transform: translateY(-3px);
    }
    
    .leaderboard-tab.active {
        background-color: var(--help-primary-color);
        color: white;
    }
    
    .stats-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .stats-title {
        font-weight: 600;
        color: #333;
        font-size: 1.25rem;
    }
    
    .stats-period {
        display: flex;
        gap: 0.5rem;
    }
    
    .period-option {
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s;
        background-color: var(--help-light-gray);
    }
    
    .period-option.active {
        background-color: var(--help-primary-color);
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
    }
    
    .empty-state-icon {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }
    
    .empty-state-message {
        font-size: 1.25rem;
        color: #6c757d;
        margin-bottom: 1.5rem;
    }
    
    .your-rank {
        background-color: var(--help-primary-light);
        border-radius: var(--help-border-radius);
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    
    .your-rank-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--help-primary-color);
        text-align: center;
        min-width: 80px;
    }
    
    .your-rank-details {
        flex: 1;
    }
    
    .your-rank-title {
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .your-rank-stats {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .your-rank-stat {
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .your-rank-stat i {
        margin-right: 0.25rem;
        color: var(--help-primary-color);
    }
    
    .your-rank-progress {
        margin-top: 0.75rem;
        font-size: 0.9rem;
    }
    
    .progress {
        height: 8px;
        margin-bottom: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .top-helpers {
            flex-direction: column;
            align-items: center;
        }
        
        .helper-stats {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .helper-actions {
            display: none;
        }
        
        .helper-badges {
            display: none;
        }
        
        .leaderboard-table {
            font-size: 0.9rem;
        }
        
        .your-rank {
            flex-direction: column;
            text-align: center;
        }
        
        .your-rank-stats {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="leaderboard-container">
    <div class="container">
        <div class="leaderboard-header">
            <h1>Help Network Leaderboard</h1>
            <p>Celebrating our most active helpers in the community</p>
        </div>
        
        <div class="leaderboard-tabs">
            <a href="{{ route('help.leaderboard', ['type' => 'all_time']) }}" class="leaderboard-tab {{ request('type', 'all_time') == 'all_time' ? 'active' : '' }}">All Time</a>
            <a href="{{ route('help.leaderboard', ['type' => 'monthly']) }}" class="leaderboard-tab {{ request('type') == 'monthly' ? 'active' : '' }}">This Month</a>
            <a href="{{ route('help.leaderboard', ['type' => 'categories']) }}" class="leaderboard-tab {{ request('type') == 'categories' ? 'active' : '' }}">By Category</a>
        </div>
        
        @auth
            @if($userRank)
            <div class="your-rank">
                <div class="your-rank-number">
                    #{{ $userRank }}
                </div>
                <div class="your-rank-details">
                    <div class="your-rank-title">Your Ranking</div>
                    <div class="your-rank-stats">
                        <div class="your-rank-stat"><i class="fas fa-hands-helping"></i> {{ $userStats['helps'] }} helps</div>
                        <div class="your-rank-stat"><i class="fas fa-star"></i> {{ number_format($userStats['rating'], 1) }} avg. rating</div>
                        <div class="your-rank-stat"><i class="fas fa-trophy"></i> {{ $userStats['points'] }} help points</div>
                        <div class="your-rank-stat"><i class="fas fa-medal"></i> {{ $userStats['achievements'] }} achievements</div>
                    </div>
                    
                    @if($nextRankPoints > 0)
                    <div class="your-rank-progress">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ ($userStats['points'] / $nextRankPoints) * 100 }}%" aria-valuenow="{{ $userStats['points'] }}" aria-valuemin="0" aria-valuemax="{{ $nextRankPoints }}"></div>
                        </div>
                        <small>{{ $nextRankPoints - $userStats['points'] }} more points to reach rank #{{ $userRank - 1 }}</small>
                    </div>
                    @endif
                </div>
                <div>
                    <a href="{{ route('help.profile.edit') }}" class="btn btn-primary">View Your Profile</a>
                </div>
            </div>
            @endif
        @endauth
        
        <div class="leaderboard-card">
            @if(request('type') == 'categories')
                <div class="stats-header">
                    <div class="stats-title">Top Helpers by Category</div>
                    <div class="stats-period">
                        <a href="{{ route('help.leaderboard', ['type' => 'categories', 'category' => '']) }}" class="period-option {{ !request('category') ? 'active' : '' }}">All</a>
                        @foreach($categories as $category)
                        <a href="{{ route('help.leaderboard', ['type' => 'categories', 'category' => $category->id]) }}" class="period-option {{ request('category') == $category->id ? 'active' : '' }}">
                            <i class="fas {{ $category->icon }}"></i> {{ $category->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                
                @if(count($helpers) > 0)
                <table class="leaderboard-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Helper</th>
                            <th>Stats</th>
                            <th>Badges</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($helpers as $index => $helper)
                        <tr class="leaderboard-row">
                            <td class="helper-rank {{ $index < 3 ? 'top-3 rank-'.($index+1).'-row' : '' }}">{{ $index + 1 }}</td>
                            <td>
                                <div class="helper-info">
                                    <img src="{{ asset('storage/' . ($helper->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $helper->name }}" class="helper-avatar">
                                    <div class="helper-details">
                                        <div class="helper-name">{{ $helper->name }}</div>
                                        <div class="helper-title">{{ $helper->helperProfile->helper_title ?? 'Community Helper' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="helper-stats">
                                    <div class="helper-stat"><i class="fas fa-hands-helping"></i> {{ $helper->category_helps_count }} helps</div>
                                    <div class="helper-stat"><i class="fas fa-star"></i> {{ number_format($helper->average_category_rating, 1) }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="helper-badges">
                                    @foreach($helper->achievements()->take(3)->get() as $achievement)
                                    <img src="{{ asset('storage/' . ($achievement->badge_image ?: 'badges/default.png')) }}" alt="{{ $achievement->name }}" class="helper-badge" title="{{ $achievement->name }}">
                                    @endforeach
                                </div>
                            </td>
                            <td class="helper-actions">
                                <a href="{{ route('help.profile.show', $helper->id) }}" class="view-profile-btn">View Profile</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="empty-state-message">
                        No helpers found for this category yet
                    </div>
                    <p class="text-muted mb-4">Be the first to help in this category!</p>
                    <a href="{{ route('help.search') }}" class="btn btn-primary">Browse Help Requests</a>
                </div>
                @endif
                
            @else
                @if(count($topHelpers) >= 3)
                <div class="top-helpers">
                    <div class="top-helper top-helper-2">
                        <div class="top-rank rank-2">2</div>
                        <img src="{{ asset('storage/' . ($topHelpers[1]->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $topHelpers[1]->name }}" class="top-helper-avatar">
                        <div class="top-helper-name">{{ $topHelpers[1]->name }}</div>
                        <div class="top-helper-stats">
                            <div class="top-helper-stat"><i class="fas fa-hands-helping"></i> {{ $topHelpers[1]->completed_helps_count }} helps</div>
                            <div class="top-helper-stat"><i class="fas fa-star"></i> {{ number_format($topHelpers[1]->average_rating, 1) }}</div>
                            <div class="top-helper-stat"><i class="fas fa-trophy"></i> {{ $topHelpers[1]->help_points }} points</div>
                        </div>
                        <div class="top-helper-badges">
                            @foreach($topHelpers[1]->achievements()->take(3)->get() as $achievement)
                            <img src="{{ asset('storage/' . ($achievement->badge_image ?: 'badges/default.png')) }}" alt="{{ $achievement->name }}" class="top-helper-badge" title="{{ $achievement->name }}">
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="top-helper top-helper-1">
                        <div class="top-rank rank-1">1</div>
                        <img src="{{ asset('storage/' . ($topHelpers[0]->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $topHelpers[0]->name }}" class="top-helper-avatar">
                        <div class="top-helper-name">{{ $topHelpers[0]->name }}</div>
                        <div class="top-helper-stats">
                            <div class="top-helper-stat"><i class="fas fa-hands-helping"></i> {{ $topHelpers[0]->completed_helps_count }} helps</div>
                            <div class="top-helper-stat"><i class="fas fa-star"></i> {{ number_format($topHelpers[0]->average_rating, 1) }}</div>
                            <div class="top-helper-stat"><i class="fas fa-trophy"></i> {{ $topHelpers[0]->help_points }} points</div>
                        </div>
                        <div class="top-helper-badges">
                            @foreach($topHelpers[0]->achievements()->take(3)->get() as $achievement)
                            <img src="{{ asset('storage/' . ($achievement->badge_image ?: 'badges/default.png')) }}" alt="{{ $achievement->name }}" class="top-helper-badge" title="{{ $achievement->name }}">
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="top-helper top-helper-3">
                        <div class="top-rank rank-3">3</div>
                        <img src="{{ asset('storage/' . ($topHelpers[2]->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $topHelpers[2]->name }}" class="top-helper-avatar">
                        <div class="top-helper-name">{{ $topHelpers[2]->name }}</div>
                        <div class="top-helper-stats">
                            <div class="top-helper-stat"><i class="fas fa-hands-helping"></i> {{ $topHelpers[2]->completed_helps_count }} helps</div>
                            <div class="top-helper-stat"><i class="fas fa-star"></i> {{ number_format($topHelpers[2]->average_rating, 1) }}</div>
                            <div class="top-helper-stat"><i class="fas fa-trophy"></i> {{ $topHelpers[2]->help_points }} points</div>
                        </div>
                        <div class="top-helper-badges">
                            @foreach($topHelpers[2]->achievements()->take(3)->get() as $achievement)
                            <img src="{{ asset('storage/' . ($achievement->badge_image ?: 'badges/default.png')) }}" alt="{{ $achievement->name }}" class="top-helper-badge" title="{{ $achievement->name }}">
                            @endforeach
                        </div>
                    </div>
                </div>
                
                @if(count($helpers) > 3)
                <table class="leaderboard-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Helper</th>
                            <th>Stats</th>
                            <th>Badges</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($helpers->slice(3) as $index => $helper)
                        <tr class="leaderboard-row {{ auth()->check() && auth()->id() == $helper->id ? 'bg-light' : '' }}">
                            <td class="helper-rank">{{ $index + 4 }}</td>
                            <td>
                                <div class="helper-info">
                                    <img src="{{ asset('storage/' . ($helper->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $helper->name }}" class="helper-avatar">
                                    <div class="helper-details">
                                        <div class="helper-name">{{ $helper->name }}</div>
                                        <div class="helper-title">{{ $helper->helperProfile->helper_title ?? 'Community Helper' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="helper-stats">
                                    <div class="helper-stat"><i class="fas fa-hands-helping"></i> {{ $helper->completed_helps_count }} helps</div>
                                    <div class="helper-stat"><i class="fas fa-star"></i> {{ number_format($helper->average_rating, 1) }}</div>
                                    <div class="helper-stat"><i class="fas fa-trophy"></i> {{ $helper->help_points }} points</div>
                                </div>
                            </td>
                            <td>
                                <div class="helper-badges">
                                    @foreach($helper->achievements()->take(3)->get() as $achievement)
                                    <img src="{{ asset('storage/' . ($achievement->badge_image ?: 'badges/default.png')) }}" alt="{{ $achievement->name }}" class="helper-badge" title="{{ $achievement->name }}">
                                    @endforeach
                                </div>
                            </td>
                            <td class="helper-actions">
                                <a href="{{ route('help.profile.show', $helper->id) }}" class="view-profile-btn">View Profile</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="empty-state-message">
                        No helpers found for this period yet
                    </div>
                    <p class="text-muted mb-4">Be the first to help someone and earn your place on the leaderboard!</p>
                    <a href="{{ route('help.search') }}" class="btn btn-primary">Browse Help Requests</a>
                </div>
                @endif
            @endif
        </div>
        
        <div class="leaderboard-card">
            <div class="stats-header">
                <div class="stats-title">Recently Earned Achievements</div>
            </div>
            
            @if(count($recentAchievements) > 0)
            <div class="recent-achievements">
                <div class="row">
                    @foreach($recentAchievements as $achievement)
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <img src="{{ asset('storage/' . ($achievement->badge_image ?: 'badges/default.png')) }}" alt="{{ $achievement->name }}" class="mb-3" style="width: 64px; height: 64px; object-fit: contain;">
                                <h5 class="card-title">{{ $achievement->name }}</h5>
                                <p class="card-text small text-muted">{{ $achievement->description }}</p>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <img src="{{ asset('storage/' . ($achievement->user->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $achievement->user->name }}" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                    <span class="small">Earned by <strong>{{ $achievement->user->name }}</strong></span>
                                </div>
                                <div class="small text-muted mt-2">{{ $achievement->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="text-center py-4">
                <div class="text-muted">
                    <i class="fas fa-medal fa-3x mb-3 text-light"></i>
                    <p>No achievements have been earned recently.</p>
                </div>
            </div>
            @endif
        </div>
        
        <div class="text-center mb-5">
            <p class="text-muted mb-3">Want to help your neighbors and climb the leaderboard?</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('help.search') }}" class="btn btn-primary">Browse Help Requests</a>
                <a href="{{ route('help.profile.edit') }}" class="btn btn-outline-secondary">Set Up Your Helper Profile</a>
            </div>
        </div>
    </div>
</div>
@endsection
