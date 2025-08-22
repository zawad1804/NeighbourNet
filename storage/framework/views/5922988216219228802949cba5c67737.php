

<?php $__env->startSection('title', 'Marketplace - The NeighbourNet'); ?>

<?php $__env->startSection('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/marketplace.css')); ?>">
<style>
  /* Add placeholder loading animation */
  .placeholder-item {
    position: relative;
    overflow: hidden;
    background-color: #f6f7f9;
    border-radius: 8px;
  }
  
  .placeholder-item::after {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    transform: translateX(-100%);
    background-image: linear-gradient(
      90deg,
      rgba(255, 255, 255, 0) 0,
      rgba(255, 255, 255, 0.2) 20%,
      rgba(255, 255, 255, 0.5) 60%,
      rgba(255, 255, 255, 0)
    );
    animation: shimmer 2s infinite;
  }
  
  @keyframes shimmer {
    100% {
      transform: translateX(100%);
    }
  }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<main class="marketplace-page">
  <div class="container">
    <div class="neighborhood-marketplace">
      <h1>Neighborhood Marketplace</h1>
      
      <div class="marketplace-actions">
        <a href="<?php echo e(route('marketplace.create')); ?>" class="post-btn">
          Post an Item
        </a>
        
        <div class="search-container">
          <input type="text" placeholder="Search items..." id="item-search" value="<?php echo e(request('search')); ?>">
          <button type="submit" class="search-btn">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </div>
    
    <div class="marketplace-tabs">
      <button class="tab-btn <?php echo e(request('type') ? '' : 'active'); ?>" data-filter="all">All</button>
      <button class="tab-btn <?php echo e(request('type') == 'for-sale' ? 'active' : ''); ?>" data-filter="for-sale">For Sale</button>
      <button class="tab-btn <?php echo e(request('type') == 'free' ? 'active' : ''); ?>" data-filter="free">Free</button>
      <button class="tab-btn <?php echo e(request('type') == 'rent' ? 'active' : ''); ?>" data-filter="rent">To Rent</button>
      <button class="tab-btn <?php echo e(request('type') == 'wanted' ? 'active' : ''); ?>" data-filter="wanted">Wanted</button>
      
      <div class="tab-options">
        <button class="tab-btn <?php echo e(request('sort') == 'featured' ? 'active' : ''); ?>" data-sort="featured">Featured</button>
        <button class="tab-btn <?php echo e(request('sort') == 'popular' ? 'active' : ''); ?>" data-sort="popular">Popular</button>
        <button class="tab-btn <?php echo e(request('sort') == 'created_at' && request('direction') == 'desc' ? 'active' : ''); ?>" data-sort="new">New</button>
      </div>
    </div>
    
    <div class="marketplace-grid" id="marketplace-items">
      <!-- Implement the Blade loop for actual data -->
      <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="item-card" data-category="<?php echo e($item->category); ?>" data-type="<?php echo e($item->type); ?>">
          <div class="item-image">
            <img src="<?php echo e($item->image ? asset('storage/'.$item->image) : asset('images/placeholder-item.jpg')); ?>" 
                 alt="<?php echo e($item->title); ?>" 
                 loading="lazy"
                 onerror="this.src='<?php echo e(asset('images/placeholder-item.jpg')); ?>'"
                 class="lazy-image"
                 data-src="<?php echo e($item->image ? asset('storage/'.$item->image) : asset('images/placeholder-item.jpg')); ?>">
            <span class="item-tag <?php echo e($item->type == 'sale' ? 'for-sale' : $item->type); ?>">
              <?php echo e(ucfirst($item->type == 'sale' ? 'For Sale' : $item->type)); ?>

            </span>
            <button class="heart-btn">
              <i class="far fa-heart"></i>
            </button>
          </div>
          <div class="item-details">
            <h3><?php echo e($item->title); ?></h3>
            <div class="item-price"><?php echo e($item->formattedPrice()); ?></div>
            <div class="item-meta">
              <span><?php echo e(ucfirst($item->category)); ?></span>
              <span><?php echo e($item->distance ?? '0.5 mi'); ?></span>
            </div>
            <div class="rating">
              <div class="stars">
                <?php for($i = 0; $i < 5; $i++): ?>
                  <?php if($i < ($item->rating ?? 4)): ?>
                    <i class="fa fa-star"></i>
                  <?php else: ?>
                    <i class="fa fa-star-o"></i>
                  <?php endif; ?>
                <?php endfor; ?>
              </div>
              <span class="rating-count">(<?php echo e($item->review_count ?? (($item->id % 14) + 2)); ?>)</span>
            </div>
            <div class="view-details">
              <a href="<?php echo e(route('marketplace.show', $item)); ?>">View Details</a>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="empty-state">
          <div class="empty-state-icon">
            <i class="fa fa-shopping-basket"></i>
          </div>
          <h3>No items found</h3>
          <p>Try adjusting your search or filters to find what you're looking for.</p>
          <button class="btn btn-primary" onclick="resetFilters()">Reset Filters</button>
        </div>
      <?php endif; ?>
    </div>
    
    <!-- Pagination -->
    <div class="marketplace-pagination">
      <?php echo e($items->links()); ?>

    </div>
  </div>
</main>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Optimize image loading
    const lazyImages = document.querySelectorAll('img.lazy-image');
    
    if ('IntersectionObserver' in window) {
      const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.getAttribute('data-src');
            img.classList.remove('lazy-image');
            imageObserver.unobserve(img);
          }
        });
      });
      
      lazyImages.forEach(img => {
        imageObserver.observe(img);
      });
    } else {
      // Fallback for browsers without IntersectionObserver
      lazyImages.forEach(img => {
        img.src = img.getAttribute('data-src');
      });
    }
    
    // Handle search with debounce for better performance
    const searchInput = document.getElementById('item-search');
    let searchTimeout = null;
    
    if (searchInput) {
      searchInput.addEventListener('input', function() {
        if (searchTimeout) {
          clearTimeout(searchTimeout);
        }
        
        searchTimeout = setTimeout(() => {
          const searchValue = this.value.trim();
          // Add search parameter to current URL and redirect
          const url = new URL(window.location.href);
          if (searchValue) {
            url.searchParams.set('search', searchValue);
          } else {
            url.searchParams.delete('search');
          }
          window.location.href = url.toString();
        }, 500); // Debounce for 500ms
      });
    }
    
    // Optimize tab button clicks
    const tabButtons = document.querySelectorAll('.tab-btn');
    
    tabButtons.forEach(btn => {
      btn.addEventListener('click', function() {
        // Only process if not already active
        if (!this.classList.contains('active')) {
          // Use dataset attribute to determine if it's a filter or sort button
          const filter = this.getAttribute('data-filter');
          const sort = this.getAttribute('data-sort');
          
          // Use URL parameters instead of client-side filtering for better performance
          const url = new URL(window.location.href);
          
          if (filter) {
            // Remove active class from all filter buttons
            document.querySelectorAll('.tab-btn[data-filter]').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            if (filter !== 'all') {
              url.searchParams.set('type', filter);
            } else {
              url.searchParams.delete('type');
            }
          }
          
          if (sort) {
            // Remove active class from all sort buttons
            document.querySelectorAll('.tab-btn[data-sort]').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            if (sort === 'new') {
              url.searchParams.set('sort', 'created_at');
              url.searchParams.set('direction', 'desc');
            } else {
              url.searchParams.set('sort', sort);
              url.searchParams.delete('direction');
            }
          }
          
          window.location.href = url.toString();
        }
      });
    });
    
    // Function to reset filters
    window.resetFilters = function() {
      window.location.href = '<?php echo e(route('marketplace.index')); ?>';
    };
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\neighbournet-laravel-backup\resources\views/marketplace/index.blade.php ENDPATH**/ ?>