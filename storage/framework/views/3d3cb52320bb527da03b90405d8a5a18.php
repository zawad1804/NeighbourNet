<?php $__env->startSection('content'); ?>
<main class="events-page">
  <div class="container">
    <div class="page-header">
      <h1>Community Events</h1>
      <div class="button-wrapper">
        <button onclick="window.location.href='<?php echo e(route('events.create')); ?>'" class="plain-button">
          <i class="fas fa-plus"></i>&nbsp;&nbsp;Create Event
        </button>
      </div>
    </div>

    <style>
      .button-wrapper {
        display: inline-block;
      }
      .plain-button {
        background-color: #4a86e8;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 10px 20px;
        font-family: Arial, sans-serif;
        font-size: 16px;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      }
      .plain-button:hover {
        background-color: #3a76d8;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
      }
    </style>
    
    <?php if(session('success')): ?>
      <div class="alert alert-success">
        <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>
    
    <?php if(session('error')): ?>
      <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

      </div>
    <?php endif; ?>
    
    <div class="events-filter">
      <div class="filter-options">
        <button class="filter-btn active">Upcoming</button>
        <button class="filter-btn">This Week</button>
        <button class="filter-btn">This Month</button>
        <button class="filter-btn">My Events</button>
      </div>
      <div class="filter-search">
        <input type="text" placeholder="Search events..." class="search-input">
      </div>
    </div>
    
    <div class="events-grid">
      <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="event-card">
          <div class="event-date">
            <span class="date-day"><?php echo e(\Carbon\Carbon::parse($event->start_date)->format('d')); ?></span>
            <span class="date-month"><?php echo e(\Carbon\Carbon::parse($event->start_date)->format('M')); ?></span>
          </div>
          <div class="event-details">
            <h3><a href="<?php echo e(route('events.show', $event)); ?>"><?php echo e($event->title); ?></a></h3>
            <div class="event-meta">
              <span><i class="far fa-clock"></i> <?php echo e(\Carbon\Carbon::parse($event->start_date)->format('l')); ?>, <?php echo e($event->start_time); ?> - <?php echo e($event->end_time ?? 'TBD'); ?></span>
              <span><i class="fas fa-map-marker-alt"></i> <?php echo e($event->location); ?></span>
              <span><i class="fas fa-tag"></i> <?php echo e($event->category); ?></span>
            </div>
            <div class="event-organizer">
              <img src="<?php echo e(user_avatar($event->user)); ?>" alt="<?php echo e($event->user->name); ?>" class="avatar-sm">
              <span>Organized by <?php echo e($event->user->name); ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="no-events">
          <p>No upcoming events found.</p>
          <a href="<?php echo e(route('events.create')); ?>" class="btn btn-primary">Create the first event</a>
        </div>
      <?php endif; ?>
    </div>
    
    <div class="pagination">
      <?php echo e($events->links()); ?>

    </div>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Filter buttons functionality
  const filterButtons = document.querySelectorAll('.filter-btn');
  
  filterButtons.forEach(button => {
    button.addEventListener('click', function() {
      // Remove active class from all buttons
      filterButtons.forEach(btn => btn.classList.remove('active'));
      
      // Add active class to clicked button
      this.classList.add('active');
      
      // Here you would typically filter the events based on the selected filter
      // For now, we'll just show all events
    });
  });
  
  // Search functionality
  const searchInput = document.querySelector('.search-input');
  const eventCards = document.querySelectorAll('.event-card');
  
  searchInput.addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase().trim();
    
    eventCards.forEach(card => {
      const eventTitle = card.querySelector('h3').textContent.toLowerCase();
      const eventLocation = card.querySelector('.event-meta span:nth-child(2)').textContent.toLowerCase();
      const eventCategory = card.querySelector('.event-meta span:nth-child(3)').textContent.toLowerCase();
      
      if (eventTitle.includes(searchTerm) || eventLocation.includes(searchTerm) || eventCategory.includes(searchTerm)) {
        card.style.display = 'flex';
      } else {
        card.style.display = 'none';
      }
    });
  });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\neighbournet-laravel-backup\resources\views/events/index.blade.php ENDPATH**/ ?>