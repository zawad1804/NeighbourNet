@extends('layouts.app')

@section('content')
<div class="dashboard-page">
    <div class="container">
        <div class="dashboard-grid">
            <aside class="sidebar">
                <div class="profile-card">
                    <img src="{{ user_avatar(Auth::user(), 'lg') }}" alt="{{ Auth::user()->first_name }}" class="profile-avatar">
                    <h3>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h3>
                    <p class="text-muted">{{ Auth::user()->address ?? 'No address added' }}</p>
                    <div class="reputation-score">
                        <span class="score">4.8</span>
                        <span class="stars">★★★★★</span>
                        <small>(24 reviews)</small>
                    </div>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline w-100 mt-2">View Profile</a>
                </div>
                
                <div class="sidebar-menu">
                    <h4>Menu</h4>
                    <ul>
                        <li><a href="{{ route('dashboard') }}" class="active"><span>🏠</span> Dashboard</a></li>
                        <li><a href="{{ route('profile.show') }}"><span>👤</span> Profile</a></li>
                        <li><a href="#"><span>✉️</span> Messages <span class="badge">3</span></a></li>
                        <li><a href="#"><span>🎉</span> Events</a></li>
                        <li><a href="#"><span>🤝</span> Help Requests</a></li>
                        <li><a href="#"><span>🛒</span> Marketplace</a></li>
                        <li><a href="#"><span>🚨</span> Safety Alerts</a></li>
                        <li><a href="#"><span>⚙️</span> Settings</a></li>
                    </ul>
                </div>
            </aside>
            
            <div class="main-content">
                <div class="welcome-card">
                    <h2>Welcome back, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
                    <p>Here's what's happening in your neighborhood today.</p>
                </div>
                
                <div class="quick-actions">
                    <h3>Quick Actions</h3>
                    <div class="actions-grid">
                        <a href="#" class="action-card">
                            <span>�</span>
                            <h4>Community Post</h4>
                        </a>
                        <a href="#" class="action-card">
                            <span>🎉</span>
                            <h4>Create Event</h4>
                        </a>
                        <a href="#" class="action-card">
                            <span>🤝</span>
                            <h4>Offer Help</h4>
                        </a>
                        <a href="#" class="action-card">
                            <span>🛒</span>
                            <h4>Sell Item</h4>
                        </a>
                    </div>
                </div>
                
                <div class="dashboard-section">
                    <div class="section-header">
                        <h3>Recent Community Posts</h3>
                        <a href="{{ route('community.feed') }}" class="btn btn-outline">View All</a>
                    </div>
                    <div class="posts-list">
                        @forelse($recentPosts as $post)
                            <div class="post-card">
                                <div class="post-header">
                                    <img src="{{ user_avatar($post->user) }}" alt="{{ $post->user->name }}" class="post-avatar">
                                    <div>
                                        <h4>{{ $post->user->name }}</h4>
                                        <small>{{ $post->created_at->diffForHumans() }} @if($post->category)· {{ $post->category }}@endif</small>
                                    </div>
                                </div>
                                <div class="post-content">
                                    <p>{{ $post->content }}</p>
                                    @if($post->image_path)
                                        <div class="post-image">
                                            <img src="{{ asset('storage/' . $post->image_path) }}" alt="Post image" class="img-fluid">
                                        </div>
                                    @endif
                                </div>
                                <div class="post-actions">
                                    <button class="btn-like">👍 {{ $post->likes_count }}</button>
                                    <button class="btn-comment">💬 {{ $post->comments_count }}</button>
                                </div>
                            </div>
                        @empty
                            <div class="no-posts">
                                <p>No recent posts in your community.</p>
                                <a href="{{ route('community.feed') }}" class="btn btn-outline">Make the first post</a>
                            </div>
                        @endforelse
                    </div>
                </div>
                
                <div class="dashboard-section">
                    <div class="section-header">
                        <h3>Upcoming Events</h3>
                        <a href="#" class="btn btn-outline">View All</a>
                    </div>
                    <div class="events-grid">
                        <div class="event-card">
                            <div class="event-date">
                                <span class="day">15</span>
                                <span class="month">Aug</span>
                            </div>
                            <div class="event-details">
                                <h4>Block Party 2025</h4>
                                <p>Saturday, 3:00 PM - 8:00 PM</p>
                                <p>Maple Street Park</p>
                                <div class="event-rsvp">
                                    <span>12 attending</span>
                                    <button class="btn btn-primary btn-sm">RSVP</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="event-card">
                            <div class="event-date">
                                <span class="day">22</span>
                                <span class="month">Aug</span>
                            </div>
                            <div class="event-details">
                                <h4>Yard Sale</h4>
                                <p>Saturday, 8:00 AM - 2:00 PM</p>
                                <p>123 Maple Street</p>
                                <div class="event-rsvp">
                                    <span>5 attending</span>
                                    <button class="btn btn-primary btn-sm">RSVP</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <aside class="right-sidebar">
                <div class="leaderboard-card">
                    <h3>Top Helpers This Month</h3>
                    <div class="leaderboard-list">
                        <div class="leaderboard-item">
                            <span class="rank">1</span>
                            <img src="https://via.placeholder.com/40" alt="User" class="leaderboard-avatar">
                            <div>
                                <h4>Maria Garcia</h4>
                                <small>25 helps</small>
                            </div>
                            <span class="points">⭐ 4.9</span>
                        </div>
                        <div class="leaderboard-item">
                            <span class="rank">2</span>
                            <img src="https://via.placeholder.com/40" alt="User" class="leaderboard-avatar">
                            <div>
                                <h4>David Kim</h4>
                                <small>18 helps</small>
                            </div>
                            <span class="points">⭐ 4.8</span>
                        </div>
                        <div class="leaderboard-item">
                            <span class="rank">3</span>
                            <img src="https://via.placeholder.com/40" alt="User" class="leaderboard-avatar">
                            <div>
                                <h4>Sarah Johnson</h4>
                                <small>15 helps</small>
                            </div>
                            <span class="points">⭐ 4.7</span>
                        </div>
                        <div class="leaderboard-item">
                            <span class="rank">4</span>
                            <img src="https://via.placeholder.com/40" alt="User" class="leaderboard-avatar">
                            <div>
                                <h4>James Wilson</h4>
                                <small>12 helps</small>
                            </div>
                            <span class="points">⭐ 4.6</span>
                        </div>
                        <div class="leaderboard-item">
                            <span class="rank">5</span>
                            <img src="https://via.placeholder.com/40" alt="User" class="leaderboard-avatar">
                            <div>
                                <h4>Priya Patel</h4>
                                <small>10 helps</small>
                            </div>
                            <span class="points">⭐ 4.5</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-outline w-100 mt-2">View Full Leaderboard</a>
                </div>
                
                <div class="neighbors-card mt-3">
                    <h3>New Neighbors</h3>
                    <div class="neighbors-list">
                        <div class="neighbor-item">
                            <img src="https://via.placeholder.com/40" alt="User" class="neighbor-avatar">
                            <div>
                                <h4>Alex Turner</h4>
                                <small>Moved in 2 days ago</small>
                            </div>
                            <button class="btn btn-outline btn-sm">Welcome</button>
                        </div>
                        <div class="neighbor-item">
                            <img src="https://via.placeholder.com/40" alt="User" class="neighbor-avatar">
                            <div>
                                <h4>Emma Roberts</h4>
                                <small>Moved in 1 week ago</small>
                            </div>
                            <button class="btn btn-outline btn-sm">Welcome</button>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
