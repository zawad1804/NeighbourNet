@extends('layouts.app')

@section('content')
<main class="event-detail-page">
  <div class="container">
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
    
    <div class="event-header">
      <a href="{{ route('events.index') }}" class="back-link">← Back to Events</a>
      
      @if(auth()->id() == $event->user_id)
        <div class="event-actions">
          <a href="{{ route('events.edit', $event) }}" class="btn btn-outline">Edit Event</a>
          <form action="{{ route('events.destroy', $event) }}" method="POST" class="inline-form" onsubmit="return confirm('Are you sure you want to delete this event?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Event</button>
          </form>
        </div>
      @endif
    </div>
    
    <div class="event-detail-container">
      <div class="event-main">
        <div class="event-image">
          @if($event->image)
            <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}">
          @else
            <div class="placeholder-image">
              <span>{{ strtoupper(substr($event->title, 0, 2)) }}</span>
            </div>
          @endif
        </div>
        
        <h1 class="event-title">{{ $event->title }}</h1>
        
        <div class="event-meta">
          <div class="meta-item">
            <i class="fas fa-calendar"></i>
            <div>
              <span>{{ \Carbon\Carbon::parse($event->start_date)->format('l, F d, Y') }}</span>
              <span>{{ $event->start_time }} - {{ $event->end_time ?? 'TBD' }}</span>
            </div>
          </div>
          
          <div class="meta-item">
            <i class="fas fa-map-marker-alt"></i>
            <div>
              <span>{{ $event->location }}</span>
              @if($event->location_details)
                <span>{{ $event->location_details }}</span>
              @endif
            </div>
          </div>
          
          <div class="meta-item">
            <i class="fas fa-user"></i>
            <div>
              <span>Organized by <a href="#">{{ $event->user->name }}</a></span>
            </div>
          </div>
        </div>
        
        <div class="event-description">
          <h3>About this event</h3>
          <p>{!! nl2br(e($event->description)) !!}</p>
        </div>
      </div>
      
      <div class="event-sidebar">
        <div class="event-attendance">
          <h3>Attendance</h3>
          <div class="attendance-count">
            <span>{{ $event->attendees->count() }}</span> attending
          </div>
          
          <div class="attendance-action">
            @if(auth()->check())
              @if($event->attendees->contains(auth()->user()))
                <form action="{{ route('events.rsvp', $event) }}" method="POST">
                  @csrf
                  <input type="hidden" name="attending" value="0">
                  <button type="submit" class="btn btn-outline btn-block">Cancel RSVP</button>
                </form>
              @else
                <form action="{{ route('events.rsvp', $event) }}" method="POST">
                  @csrf
                  <input type="hidden" name="attending" value="1">
                  <button type="submit" class="btn btn-primary btn-block">RSVP to Event</button>
                </form>
              @endif
            @else
              <a href="{{ route('login') }}" class="btn btn-primary btn-block">Login to RSVP</a>
            @endif
          </div>
          
          <div class="attendees-list">
            <h4>Who's coming</h4>
            @forelse($event->attendees as $attendee)
              <div class="attendee">
                <img src="{{ user_avatar($attendee) }}" alt="{{ $attendee->name }}" class="avatar-sm">
                <span>{{ $attendee->name }}</span>
              </div>
            @empty
              <p>Be the first to RSVP to this event!</p>
            @endforelse
          </div>
        </div>
        
        @if($event->is_public)
          <div class="event-share">
            <h3>Share this event</h3>
            <div class="share-links">
              <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('events.show', $event)) }}" target="_blank" class="share-btn facebook">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="https://twitter.com/intent/tweet?text={{ urlencode($event->title) }}&url={{ urlencode(route('events.show', $event)) }}" target="_blank" class="share-btn twitter">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="mailto:?subject={{ urlencode($event->title) }}&body={{ urlencode(route('events.show', $event)) }}" class="share-btn email">
                <i class="fas fa-envelope"></i>
              </a>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</main>
@endsection
