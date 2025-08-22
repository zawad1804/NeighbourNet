@extends('layouts.app')

@section('content')
<main class="events-page">
  <div class="container">
    <div class="page-header">
      <h1>Community Events</h1>
      <div class="button-wrapper">
        <button onclick="window.location.href='{{ route('events.create') }}'" class="plain-button">
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
    
    @if(session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    
    @if(session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif
    
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
      @forelse($events as $event)
        <div class="event-card">
          <div class="event-date">
            <span class="date-day">{{ \Carbon\Carbon::parse($event->start_date)->format('d') }}</span>
            <span class="date-month">{{ \Carbon\Carbon::parse($event->start_date)->format('M') }}</span>
          </div>
          <div class="event-details">
            <h3><a href="{{ route('events.show', $event) }}">{{ $event->title }}</a></h3>
            <div class="event-meta">
              <span><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($event->start_date)->format('l') }}, {{ $event->start_time }} - {{ $event->end_time ?? 'TBD' }}</span>
              <span><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</span>
              <span><i class="fas fa-tag"></i> {{ $event->category }}</span>
            </div>
            <div class="event-organizer">
              <img src="{{ user_avatar($event->user) }}" alt="{{ $event->user->name }}" class="avatar-sm">
              <span>Organized by {{ $event->user->name }}</span>
            </div>
          </div>
        </div>
      @empty
        <div class="no-events">
          <p>No upcoming events found.</p>
          <a href="{{ route('events.create') }}" class="btn btn-primary">Create the first event</a>
        </div>
      @endforelse
    </div>
    
    <div class="pagination">
      {{ $events->links() }}
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
@endsection
