

<?php $__env->startSection('content'); ?>
<div class="dashboard-page">
    <div class="container">
        <div class="dashboard-grid">
            <aside class="sidebar">
                <div class="profile-card">
                    <img src="<?php echo e(user_avatar(Auth::user(), 'lg')); ?>" alt="<?php echo e(Auth::user()->first_name); ?>" class="profile-avatar">
                    <h3><?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?></h3>
                    <p class="text-muted"><?php echo e(Auth::user()->address ?? 'No address added'); ?></p>
                    <div class="reputation-score">
                        <span class="score">4.8</span>
                        <span class="stars">★★★★★</span>
                        <small>(24 reviews)</small>
                    </div>
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline w-100 mt-2">View Profile</a>
                </div>
                
                <div class="sidebar-menu">
                    <h4>Menu</h4>
                    <ul>
                        <li><a href="<?php echo e(route('dashboard')); ?>" class="active"><span>🏠</span> Dashboard</a></li>
                        <li><a href="<?php echo e(route('profile.show')); ?>"><span>👤</span> Profile</a></li>
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
                    <h2>Welcome back, <?php echo e(explode(' ', Auth::user()->name)[0]); ?>!</h2>
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
                        <a href="<?php echo e(route('community.feed')); ?>" class="btn btn-outline">View All</a>
                    </div>
                    <div class="posts-list">
                        <?php $__empty_1 = true; $__currentLoopData = $recentPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="post-card">
                                <div class="post-header">
                                    <img src="<?php echo e(user_avatar($post->user)); ?>" alt="<?php echo e($post->user->name); ?>" class="post-avatar">
                                    <div>
                                        <h4><?php echo e($post->user->name); ?></h4>
                                        <small><?php echo e($post->created_at->diffForHumans()); ?> <?php if($post->category): ?>· <?php echo e($post->category); ?><?php endif; ?></small>
                                    </div>
                                </div>
                                <div class="post-content">
                                    <p><?php echo e($post->content); ?></p>
                                    <?php if($post->image_path): ?>
                                        <div class="post-image">
                                            <img src="<?php echo e(asset('storage/' . $post->image_path)); ?>" alt="Post image" class="img-fluid">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="post-actions">
                                    <button class="btn-like">👍 <?php echo e($post->likes_count); ?></button>
                                    <button class="btn-comment">💬 <?php echo e($post->comments_count); ?></button>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="no-posts">
                                <p>No recent posts in your community.</p>
                                <a href="<?php echo e(route('community.feed')); ?>" class="btn btn-outline">Make the first post</a>
                            </div>
                        <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\neighbournet-laravel-backup\resources\views/dashboard.blade.php ENDPATH**/ ?>