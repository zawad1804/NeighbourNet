

<?php $__env->startSection('content'); ?>
<div class="dashboard-page">
    <div class="container">
        <div class="dashboard-grid">
            <aside class="sidebar">
                <div class="profile-card">
                    <img src="<?php echo e(user_avatar($user, 'lg')); ?>" alt="<?php echo e($user->name); ?>" class="profile-avatar">
                    <h3><?php echo e($user->name); ?></h3>
                    <p class="text-muted"><?php echo e($user->address ?? 'No address added'); ?></p>
                    <div class="reputation-score">
                        <span class="score">4.8</span>
                        <span class="stars">★★★★★</span>
                        <small>(24 reviews)</small>
                    </div>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-outline w-100 mt-2">Edit Profile</a>
                </div>
                
                <div class="sidebar-menu">
                    <h4>Menu</h4>
                    <ul>
                        <li><a href="<?php echo e(route('dashboard')); ?>"><span>🏠</span> Dashboard</a></li>
                        <li><a href="<?php echo e(route('profile.show')); ?>" class="active"><span>👤</span> Profile</a></li>
                        <li><a href="#"><span>✉️</span> Messages <span class="badge">3</span></a></li>
                        <li><a href="#"><span>🎉</span> Events</a></li>
                        <li><a href="#"><span>🤝</span> Help Requests</a></li>
                        <li><a href="#"><span>🛒</span> Marketplace</a></li>
                        <li><a href="#"><span>🚨</span> Safety Alerts</a></li>
                        <li><a href="#"><span>⚙️</span> Settings</a></li>
                    </ul>
                </div>
            </aside>

            <main class="main-content">
                <?php if(session('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>

                <div class="profile-sections">
                    <section class="profile-section">
                        <h2>About Me</h2>
                        <div class="profile-details">
                            <div class="detail-row">
                                <div class="detail-label">Name</div>
                                <div class="detail-value"><?php echo e($user->name); ?></div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Email</div>
                                <div class="detail-value"><?php echo e($user->email); ?></div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Phone</div>
                                <div class="detail-value"><?php echo e($user->phone); ?></div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">City</div>
                                <div class="detail-value"><?php echo e($user->city); ?></div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Address</div>
                                <div class="detail-value"><?php echo e($user->address); ?></div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-label">Post Code</div>
                                <div class="detail-value"><?php echo e($user->post_code); ?></div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>

            <aside class="right-sidebar">
                <div class="community-stats">
                    <h3>Your Contribution</h3>
                    <div class="stat-cards">
                        <div class="stat-card">
                            <div class="stat-number">12</div>
                            <div class="stat-label">Posts</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">5</div>
                            <div class="stat-label">Events</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">8</div>
                            <div class="stat-label">Helped</div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\neighbournet-laravel-backup\resources\views/profile/show.blade.php ENDPATH**/ ?>