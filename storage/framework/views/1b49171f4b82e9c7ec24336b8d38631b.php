

<?php $__env->startSection('title', 'Help Network - The NeighbourNet'); ?>

<?php $__env->startSection('styles'); ?>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<main class="help-dashboard">
    <div class="container">
        <div class="dashboard-header">
            <h1>NeighbourNet Help Network</h1>
            <p>Connect with neighbors to get help or offer assistance</p>
        </div>
        
        <div class="action-buttons">
            <a href="<?php echo e(route('help.create')); ?>" class="action-btn primary">
                <i class="fas fa-hand-holding-heart"></i>
                Request Help
            </a>
            <a href="<?php echo e(route('help.profile.edit')); ?>" class="action-btn">
                <i class="fas fa-hands-helping"></i>
                Offer to Help
            </a>
            <a href="<?php echo e(route('help.search')); ?>" class="action-btn">
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
                        <div class="stat-value"><?php echo e(App\Models\HelpRequest::where('status', 'completed')->count()); ?></div>
                        <div class="stat-label">NEIGHBORS HELPED</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-card text-center">
                        <div class="stat-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <div class="stat-value"><?php echo e(App\Models\HelpRequest::where('status', 'open')->count()); ?></div>
                        <div class="stat-label">ACTIVE REQUESTS</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-card text-center">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-value"><?php echo e(App\Models\User::whereHas('helpOffers', function($q) { $q->where('status', 'accepted'); })->count()); ?></div>
                        <div class="stat-label">ACTIVE HELPERS</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="stat-card text-center">
                        <div class="stat-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="stat-value"><?php echo e(number_format(App\Models\HelpFeedback::avg('overall_rating') ?: 0, 1)); ?></div>
                        <div class="stat-label">AVG. RATING</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="help-categories">
            <h2>How can we help you?</h2>
            <div class="row">
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <a href="<?php echo e(route('help.category', $category->slug)); ?>" class="category-card">
                        <div class="category-icon">
                            <i class="fas <?php echo e($category->icon); ?>"></i>
                        </div>
                        <h3><?php echo e($category->name); ?></h3>
                        <p><?php echo e(Str::limit($category->description, 100)); ?></p>
                        <div class="category-footer">
                            <span class="request-count">
                                <?php echo e(App\Models\HelpRequest::where('help_category_id', $category->id)->where('status', 'open')->count()); ?> open requests
                            </span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8">
                <div class="active-requests">
                    <h2>Recent Help Requests</h2>
                    <?php $__empty_1 = true; $__currentLoopData = $openRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="request-card">
                        <div class="request-header">
                            <div>
                                <h3 class="request-title"><?php echo e($request->title); ?></h3>
                                <div class="request-meta">
                                    <span><i class="fas <?php echo e($request->category->icon); ?>"></i> <?php echo e($request->category->name); ?></span>
                                    <span><i class="fas fa-map-marker-alt"></i> <?php echo e($request->location ?: 'No location specified'); ?></span>
                                    <span><i class="fas fa-clock"></i> <?php echo e($request->created_at->diffForHumans()); ?></span>
                                </div>
                            </div>
                            <?php if($request->is_emergency): ?>
                            <span class="request-badge badge-emergency">Urgent</span>
                            <?php endif; ?>
                        </div>
                        <p class="request-description"><?php echo e(Str::limit($request->description, 150)); ?></p>
                        <div class="request-footer">
                            <div class="requester-info">
                                <img src="<?php echo e(asset('storage/' . ($request->user->avatar ?: 'avatars/default.jpg'))); ?>" alt="<?php echo e($request->user->name); ?>" class="requester-avatar">
                                <span class="requester-name"><?php echo e($request->user->name); ?></span>
                            </div>
                            <a href="<?php echo e(route('help.show', $request->id)); ?>" class="btn btn-sm btn-outline-primary">View Details</a>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> There are no open help requests at the moment.
                    </div>
                    <?php endif; ?>
                    
                    <?php if($openRequests->count() > 0): ?>
                    <div class="text-center mt-3">
                        <a href="<?php echo e(route('help.search')); ?>" class="btn btn-outline-primary">View All Requests</a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="leaderboard">
                    <h2>Top Helpers</h2>
                    <div class="leaderboard-card">
                        <?php $__empty_1 = true; $__currentLoopData = $topHelpers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $helper): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="helper-row">
                            <div class="helper-rank <?php echo e('rank-'.($index+1)); ?>"><?php echo e($index + 1); ?></div>
                            <img src="<?php echo e(asset('storage/' . ($helper->avatar ?: 'avatars/default.jpg'))); ?>" alt="<?php echo e($helper->name); ?>" class="helper-avatar">
                            <div class="helper-info">
                                <div class="helper-name"><?php echo e($helper->name); ?></div>
                                <div class="helper-meta">
                                    <span><i class="fas fa-hands-helping"></i> <?php echo e($helper->completed_helps); ?> helps</span>
                                    <span><i class="fas fa-star"></i> <?php echo e(number_format($helper->getAverageRating(), 1)); ?></span>
                                </div>
                            </div>
                            <div class="helper-badges">
                                <?php $__currentLoopData = $helper->achievements()->take(3)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $achievement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <img src="<?php echo e(asset('storage/' . ($achievement->badge_image ?: 'badges/default.png'))); ?>" alt="<?php echo e($achievement->name); ?>" class="helper-badge" title="<?php echo e($achievement->name); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-center text-muted my-3">No helpers have completed requests yet.</p>
                        <?php endif; ?>
                        
                        <?php if($topHelpers->count() > 0): ?>
                        <div class="text-center mt-3">
                            <a href="<?php echo e(route('help.leaderboard')); ?>" class="btn btn-sm btn-outline-primary">View Full Leaderboard</a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if(auth()->guard()->check()): ?>
                <div class="my-requests mb-4">
                    <h2>My Requests</h2>
                    <div class="leaderboard-card">
                        <?php if($userRequests && $userRequests->count() > 0): ?>
                            <?php $__currentLoopData = $userRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="helper-row">
                                <div class="helper-info">
                                    <div class="helper-name"><?php echo e(Str::limit($request->title, 30)); ?></div>
                                    <div class="helper-meta">
                                        <span><i class="fas <?php echo e($request->category->icon); ?>"></i> <?php echo e($request->category->name); ?></span>
                                        <span><i class="fas fa-clock"></i> <?php echo e($request->created_at->diffForHumans()); ?></span>
                                    </div>
                                </div>
                                <span class="badge bg-<?php echo e($request->status === 'open' ? 'success' : ($request->status === 'completed' ? 'secondary' : 'primary')); ?>">
                                    <?php echo e(ucfirst($request->status)); ?>

                                </span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="text-center mt-3">
                                <a href="<?php echo e(route('help.my-requests')); ?>" class="btn btn-sm btn-outline-primary">View All My Requests</a>
                            </div>
                        <?php else: ?>
                            <p class="text-center text-muted my-3">You haven't created any help requests yet.</p>
                            <div class="text-center">
                                <a href="<?php echo e(route('help.create')); ?>" class="btn btn-sm btn-primary">Create Your First Request</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\herd-laravel\neighbournet-laravel\resources\views/help/index.blade.php ENDPATH**/ ?>