

<?php $__env->startSection('title', 'My Marketplace Listings'); ?>

<?php $__env->startSection('styles'); ?>
<style>
  .my-listings {
    padding: 2rem 0;
  }

  .card-listing {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
    overflow: hidden;
    transition: box-shadow 0.2s;
  }

  .card-listing:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
  }

  .listing-image {
    height: 180px;
    background-color: #f0f0f0;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }

  .listing-image-placeholder {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #aaa;
  }

  .listing-content {
    padding: 1rem;
  }

  .listing-title {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    height: 50px;
  }

  .listing-price {
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
  }

  .listing-meta {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 0.5rem;
  }

  .listing-status {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
  }

  .status-available {
    background-color: #e3f9e5;
    color: #0a7021;
  }

  .status-pending {
    background-color: #fff8e1;
    color: #b76e00;
  }

  .status-sold {
    background-color: #f1f1f1;
    color: #666;
  }

  .listing-actions {
    margin-top: 1rem;
    display: flex;
    justify-content: space-between;
  }

  .btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
  }

  .empty-state {
    text-align: center;
    padding: 3rem 1rem;
    border-radius: 8px;
    background-color: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }

  .empty-state-icon {
    font-size: 3rem;
    color: #ddd;
    margin-bottom: 1rem;
  }

  .empty-state-title {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
  }

  .empty-state-text {
    color: #666;
    margin-bottom: 1.5rem;
  }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<main class="my-listings">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1>My Marketplace Listings</h1>
      <a href="<?php echo e(route('marketplace.create')); ?>" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add New Listing
      </a>
    </div>
    
    <?php if(session('success')): ?>
      <div class="alert alert-success mb-4">
        <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>
    
    <?php if($items->count() > 0): ?>
      <div class="row">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="col-md-6 col-lg-4">
            <div class="card-listing">
              <div class="listing-image" style="background-image: url('<?php echo e($item->image ? asset('storage/' . $item->image) : ''); ?>')">
                <?php if(!$item->image): ?>
                  <div class="listing-image-placeholder">
                    <i class="fas fa-image"></i>
                  </div>
                <?php endif; ?>
              </div>
              <div class="listing-content">
                <div class="d-flex justify-content-between align-items-start">
                  <span class="badge <?php echo e($item->getTypeBadgeClass()); ?>">
                    <?php echo e(ucfirst(str_replace('-', ' ', $item->type))); ?>

                  </span>
                  <span class="listing-status status-<?php echo e($item->status); ?>">
                    <?php echo e($item->getStatusLabel()); ?>

                  </span>
                </div>
                <h3 class="listing-title"><?php echo e($item->title); ?></h3>
                <div class="listing-price"><?php echo e($item->formattedPrice()); ?></div>
                <div class="listing-meta">
                  <i class="fas fa-map-marker-alt"></i> <?php echo e($item->location); ?>

                </div>
                <div class="listing-meta">
                  <i class="fas fa-calendar"></i> Listed <?php echo e($item->created_at->diffForHumans()); ?>

                </div>
                <div class="listing-actions">
                  <a href="<?php echo e(route('marketplace.show', $item)); ?>" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> View
                  </a>
                  <a href="<?php echo e(route('marketplace.edit', $item)); ?>" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <form action="<?php echo e(route('marketplace.destroy', $item)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                      <i class="fas fa-trash"></i> Delete
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      
      <div class="d-flex justify-content-center mt-4">
        <?php echo e($items->links()); ?>

      </div>
    <?php else: ?>
      <div class="empty-state">
        <div class="empty-state-icon">
          <i class="fas fa-store"></i>
        </div>
        <h2 class="empty-state-title">No Listings Yet</h2>
        <p class="empty-state-text">You haven't created any marketplace listings yet. Start selling, sharing, or requesting items in your neighborhood.</p>
        <a href="<?php echo e(route('marketplace.create')); ?>" class="btn btn-primary">
          <i class="fas fa-plus"></i> Create Your First Listing
        </a>
      </div>
    <?php endif; ?>
  </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\herd-laravel\neighbournet-laravel\resources\views/marketplace/my-listings.blade.php ENDPATH**/ ?>