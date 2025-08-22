@extends('layouts.app')

@section('title', $helpRequest->title . ' - NeighbourNet Help')

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
    
    .help-detail-container {
        padding: 2rem 0;
        background-color: #f9fafb;
        min-height: calc(100vh - 150px);
    }
    
    .help-detail-card {
        background-color: white;
        border-radius: var(--help-border-radius);
        box-shadow: var(--help-card-shadow);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .help-status {
        display: inline-block;
        padding: 0.25rem 1rem;
        border-radius: 30px;
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 1rem;
    }
    
    .status-open {
        background-color: #d1e7dd;
        color: #0f5132;
    }
    
    .status-pending {
        background-color: #fff3cd;
        color: #664d03;
    }
    
    .status-in-progress {
        background-color: #cfe2ff;
        color: #084298;
    }
    
    .status-completed {
        background-color: #d3d3d3;
        color: #333;
    }
    
    .status-cancelled {
        background-color: #f8d7da;
        color: #842029;
    }
    
    .help-title {
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .help-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
        color: #6c757d;
    }
    
    .help-meta-item {
        display: flex;
        align-items: center;
    }
    
    .help-meta-item i {
        margin-right: 0.5rem;
    }
    
    .help-emergency-badge {
        background-color: #fdf2f2;
        color: var(--help-danger-color);
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-left: 1rem;
    }
    
    .help-description {
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
    }
    
    .schedule-info {
        margin-bottom: 2rem;
    }
    
    .schedule-type {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .schedule-details {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .schedule-detail {
        background-color: var(--help-light-gray);
        padding: 0.5rem 1rem;
        border-radius: 5px;
        display: flex;
        align-items: center;
    }
    
    .schedule-detail i {
        margin-right: 0.5rem;
    }
    
    .availability-calendar {
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 1.5rem;
    }
    
    .calendar-day {
        flex: 0 0 calc(100% / 7);
        padding: 0.5rem;
        border: 1px solid #eee;
        text-align: center;
    }
    
    .calendar-day-name {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .calendar-times {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .calendar-time {
        background-color: var(--help-primary-light);
        color: var(--help-primary-color);
        padding: 0.25rem 0.5rem;
        border-radius: 3px;
        font-size: 0.8rem;
    }
    
    .requester-info {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .requester-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1rem;
    }
    
    .requester-details {
        flex: 1;
    }
    
    .requester-name {
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.25rem;
    }
    
    .requester-meta {
        color: #6c757d;
        font-size: 0.9rem;
        display: flex;
        gap: 1rem;
    }
    
    .requester-rating {
        display: flex;
        align-items: center;
    }
    
    .requester-rating i {
        color: #f6993f;
        margin-right: 0.25rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .action-btn {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: var(--help-border-radius);
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .action-btn:hover {
        transform: translateY(-3px);
    }
    
    .helper-section {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
    }
    
    .helper-card {
        display: flex;
        align-items: center;
        background-color: var(--help-light-gray);
        padding: 1rem;
        border-radius: var(--help-border-radius);
        margin-bottom: 1rem;
    }
    
    .helper-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1rem;
    }
    
    .helper-details {
        flex: 1;
    }
    
    .helper-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .helper-meta {
        display: flex;
        gap: 1rem;
        color: #6c757d;
        font-size: 0.85rem;
    }
    
    .helper-actions {
        display: flex;
        gap: 0.5rem;
    }
    
    .messages-section {
        margin-top: 2rem;
    }
    
    .message-list {
        margin-bottom: 1.5rem;
    }
    
    .message-item {
        display: flex;
        margin-bottom: 1.5rem;
    }
    
    .message-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1rem;
    }
    
    .message-content {
        flex: 1;
        background-color: #f8f9fa;
        padding: 1rem;
        border-radius: 10px;
        position: relative;
    }
    
    .message-content::before {
        content: '';
        position: absolute;
        top: 15px;
        left: -8px;
        width: 0;
        height: 0;
        border-top: 8px solid transparent;
        border-bottom: 8px solid transparent;
        border-right: 8px solid #f8f9fa;
    }
    
    .message-sender {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .message-time {
        color: #6c757d;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }
    
    .message-text {
        line-height: 1.5;
    }
    
    .current-user-message {
        flex-direction: row-reverse;
    }
    
    .current-user-message .message-avatar {
        margin-right: 0;
        margin-left: 1rem;
    }
    
    .current-user-message .message-content {
        background-color: var(--help-primary-light);
    }
    
    .current-user-message .message-content::before {
        left: auto;
        right: -8px;
        border-right: none;
        border-left: 8px solid var(--help-primary-light);
    }
    
    .message-form {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    .message-input {
        flex: 1;
        border-radius: 30px;
        padding: 0.75rem 1.25rem;
        border: 1px solid #ddd;
    }
    
    .message-submit {
        border-radius: 30px;
        padding: 0.5rem 1.5rem;
        background-color: var(--help-primary-color);
        color: white;
        border: none;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .message-submit:hover {
        background-color: #2779bd;
    }
    
    .helper-badge {
        background-color: var(--help-primary-light);
        color: var(--help-primary-color);
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .help-meta {
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .schedule-details {
            flex-direction: column;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .calendar-day {
            flex: 0 0 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="help-detail-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="help-detail-card">
                    <div class="help-status status-{{ $helpRequest->status }}">
                        {{ ucfirst($helpRequest->status) }}
                    </div>
                    
                    <h1 class="help-title">
                        {{ $helpRequest->title }}
                        @if($helpRequest->is_emergency)
                        <span class="help-emergency-badge">Urgent</span>
                        @endif
                    </h1>
                    
                    <div class="help-meta">
                        <div class="help-meta-item">
                            <i class="fas {{ $helpRequest->category->icon }}"></i>
                            {{ $helpRequest->category->name }}
                        </div>
                        <div class="help-meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $helpRequest->location ?: 'No location specified' }}
                        </div>
                        <div class="help-meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $helpRequest->created_at->format('M d, Y') }}
                        </div>
                        <div class="help-meta-item">
                            <i class="fas fa-clock"></i>
                            {{ $helpRequest->created_at->diffForHumans() }}
                        </div>
                    </div>
                    
                    <div class="help-description">
                        {{ $helpRequest->description }}
                    </div>
                    
                    <div class="schedule-info">
                        <h3 class="section-title">Schedule</h3>
                        
                        @if($helpRequest->schedule_type == 'specific')
                        <div class="schedule-type">Specific Date & Time</div>
                        <div class="schedule-details">
                            <div class="schedule-detail">
                                <i class="fas fa-calendar-day"></i>
                                {{ \Carbon\Carbon::parse($helpRequest->help_date)->format('l, F j, Y') }}
                            </div>
                            <div class="schedule-detail">
                                <i class="fas fa-clock"></i>
                                {{ \Carbon\Carbon::parse($helpRequest->help_time)->format('g:i A') }}
                            </div>
                            <div class="schedule-detail">
                                <i class="fas fa-hourglass-half"></i>
                                {{ $helpRequest->duration }} minutes
                            </div>
                        </div>
                        @else
                        <div class="schedule-type">Flexible Schedule</div>
                        <div class="availability-calendar">
                            @php
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                $availableTimes = json_decode($helpRequest->available_times, true) ?: [];
                                $groupedTimes = collect($availableTimes)->groupBy('day');
                            @endphp
                            
                            @foreach($days as $day)
                            <div class="calendar-day">
                                <div class="calendar-day-name">{{ $day }}</div>
                                <div class="calendar-times">
                                    @if($groupedTimes->has($day))
                                        @foreach($groupedTimes[$day] as $timeSlot)
                                        <div class="calendar-time">{{ $timeSlot['time'] }}</div>
                                        @endforeach
                                    @else
                                        <small class="text-muted">Not available</small>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    
                    @if($helpRequest->preferences)
                    <div class="preferences-section">
                        <h3 class="section-title">Preferences</h3>
                        <p>{{ $helpRequest->preferences }}</p>
                    </div>
                    @endif
                    
                    <div class="requester-info">
                        <img src="{{ asset('storage/' . ($helpRequest->user->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $helpRequest->user->name }}" class="requester-avatar">
                        <div class="requester-details">
                            <div class="requester-name">{{ $helpRequest->user->name }}</div>
                            <div class="requester-meta">
                                <div>Member since {{ $helpRequest->user->created_at->format('M Y') }}</div>
                                <div class="requester-rating">
                                    <i class="fas fa-star"></i>
                                    {{ number_format($helpRequest->user->getAverageRating(), 1) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($helpRequest->status == 'open')
                        @if(auth()->id() != $helpRequest->user_id)
                        <div class="action-buttons">
                            <a href="{{ route('help.offer.create', $helpRequest->id) }}" class="action-btn btn btn-primary">
                                <i class="fas fa-hands-helping"></i>
                                Offer to Help
                            </a>
                            <a href="{{ route('help.message.create', $helpRequest->id) }}" class="action-btn btn btn-outline-secondary">
                                <i class="fas fa-comment-alt"></i>
                                Ask a Question
                            </a>
                        </div>
                        @else
                        <div class="action-buttons">
                            <a href="{{ route('help.edit', $helpRequest->id) }}" class="action-btn btn btn-outline-primary">
                                <i class="fas fa-edit"></i>
                                Edit Request
                            </a>
                            <form action="{{ route('help.cancel', $helpRequest->id) }}" method="POST" class="flex-fill">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="action-btn btn btn-outline-danger w-100">
                                    <i class="fas fa-times-circle"></i>
                                    Cancel Request
                                </button>
                            </form>
                        </div>
                        @endif
                    @endif
                    
                    @if($helpRequest->helpOffers->count() > 0 && (auth()->id() == $helpRequest->user_id || auth()->user()->hasOfferedHelp($helpRequest->id)))
                    <div class="helper-section">
                        <h3 class="section-title">Help Offers ({{ $helpRequest->helpOffers->count() }})</h3>
                        
                        @foreach($helpRequest->helpOffers as $offer)
                        <div class="helper-card">
                            <img src="{{ asset('storage/' . ($offer->user->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $offer->user->name }}" class="helper-avatar">
                            <div class="helper-details">
                                <div class="helper-name">
                                    {{ $offer->user->name }}
                                    @if($helpRequest->helper_id == $offer->user_id)
                                    <span class="helper-badge">Selected Helper</span>
                                    @endif
                                </div>
                                <div class="helper-meta">
                                    <div><i class="fas fa-hands-helping"></i> {{ $offer->user->completedHelps()->count() }} helps</div>
                                    <div><i class="fas fa-star"></i> {{ number_format($offer->user->getAverageRating(), 1) }}</div>
                                    <div><i class="fas fa-clock"></i> {{ $offer->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            @if(auth()->id() == $helpRequest->user_id && $helpRequest->status == 'open')
                            <div class="helper-actions">
                                <a href="{{ route('help.message.create', ['helpRequest' => $helpRequest->id, 'recipient' => $offer->user_id]) }}" class="btn btn-sm btn-outline-primary">Message</a>
                                
                                @if(!$helpRequest->helper_id)
                                <form action="{{ route('help.accept-offer', ['helpRequest' => $helpRequest->id, 'helpOffer' => $offer->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Accept</button>
                                </form>
                                @endif
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                    
                    @if($messages->count() > 0 || auth()->id() == $helpRequest->user_id || ($helpRequest->helper_id && auth()->id() == $helpRequest->helper_id))
                    <div class="messages-section">
                        <h3 class="section-title">Messages</h3>
                        
                        <div class="message-list">
                            @foreach($messages as $message)
                            <div class="message-item {{ auth()->id() == $message->sender_id ? 'current-user-message' : '' }}">
                                <img src="{{ asset('storage/' . ($message->sender->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $message->sender->name }}" class="message-avatar">
                                <div class="message-content">
                                    <div class="message-sender">{{ $message->sender->name }}</div>
                                    <div class="message-time">{{ $message->created_at->format('M d, Y h:i A') }}</div>
                                    <div class="message-text">{{ $message->message }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($helpRequest->status != 'cancelled' && $helpRequest->status != 'completed' && (auth()->id() == $helpRequest->user_id || auth()->id() == $helpRequest->helper_id || auth()->user()->hasOfferedHelp($helpRequest->id)))
                        <form action="{{ route('help.message.store', $helpRequest->id) }}" method="POST" class="message-form">
                            @csrf
                            <input type="hidden" name="recipient_id" value="{{ auth()->id() == $helpRequest->user_id ? $helpRequest->helper_id : $helpRequest->user_id }}">
                            <input type="text" name="message" class="message-input form-control" placeholder="Type your message..." required>
                            <button type="submit" class="message-submit">Send</button>
                        </form>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="help-detail-card">
                    <h3 class="section-title">Request Status</h3>
                    
                    <div class="status-timeline">
                        @php
                            $statusTimeline = [
                                'created' => ['label' => 'Created', 'date' => $helpRequest->created_at, 'icon' => 'fa-file-alt', 'completed' => true],
                                'help_offered' => ['label' => 'Help Offered', 'date' => $helpRequest->helpOffers->count() > 0 ? $helpRequest->helpOffers->sortBy('created_at')->first()->created_at : null, 'icon' => 'fa-hands-helping', 'completed' => $helpRequest->helpOffers->count() > 0],
                                'in_progress' => ['label' => 'In Progress', 'date' => $helpRequest->status == 'in_progress' ? $helpRequest->updated_at : null, 'icon' => 'fa-spinner', 'completed' => in_array($helpRequest->status, ['in_progress', 'completed'])],
                                'completed' => ['label' => 'Completed', 'date' => $helpRequest->status == 'completed' ? $helpRequest->updated_at : null, 'icon' => 'fa-check-circle', 'completed' => $helpRequest->status == 'completed'],
                            ];
                            
                            if ($helpRequest->status == 'cancelled') {
                                $statusTimeline['cancelled'] = ['label' => 'Cancelled', 'date' => $helpRequest->updated_at, 'icon' => 'fa-times-circle', 'completed' => true];
                            }
                        @endphp
                        
                        <ul class="list-group list-group-flush">
                            @foreach($statusTimeline as $status => $details)
                            <li class="list-group-item d-flex align-items-center {{ !$details['completed'] ? 'text-muted' : '' }}">
                                <i class="fas {{ $details['icon'] }} me-3 {{ $details['completed'] ? 'text-success' : '' }}"></i>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">{{ $details['label'] }}</div>
                                    @if($details['date'])
                                    <small>{{ $details['date']->format('M d, Y h:i A') }}</small>
                                    @endif
                                </div>
                                @if($details['completed'])
                                <i class="fas fa-check text-success"></i>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    @if($helpRequest->status == 'in_progress' && (auth()->id() == $helpRequest->user_id || auth()->id() == $helpRequest->helper_id))
                    <div class="mt-4">
                        @if(auth()->id() == $helpRequest->user_id)
                        <form action="{{ route('help.complete', $helpRequest->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success w-100 mb-2">
                                <i class="fas fa-check-circle me-2"></i> Mark as Completed
                            </button>
                        </form>
                        @endif
                        
                        @if(auth()->id() == $helpRequest->helper_id)
                        <a href="{{ route('help.update-progress', $helpRequest->id) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-clipboard-list me-2"></i> Update Progress
                        </a>
                        @endif
                    </div>
                    @endif
                    
                    @if($helpRequest->status == 'completed' && auth()->id() == $helpRequest->user_id && !$helpRequest->hasFeedback())
                    <div class="mt-4">
                        <a href="{{ route('help.feedback.create', $helpRequest->id) }}" class="btn btn-primary w-100">
                            <i class="fas fa-star me-2"></i> Leave Feedback
                        </a>
                    </div>
                    @endif
                </div>
                
                <div class="help-detail-card">
                    <h3 class="section-title">Similar Requests</h3>
                    
                    @php
                        $similarRequests = App\Models\HelpRequest::where('help_category_id', $helpRequest->help_category_id)
                            ->where('id', '!=', $helpRequest->id)
                            ->where('status', 'open')
                            ->latest()
                            ->take(3)
                            ->get();
                    @endphp
                    
                    @if($similarRequests->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($similarRequests as $similar)
                            <li class="list-group-item p-0 border-0 mb-3">
                                <a href="{{ route('help.show', $similar->id) }}" class="text-decoration-none">
                                    <div class="d-flex p-3 bg-light rounded">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 text-dark">{{ Str::limit($similar->title, 40) }}</h6>
                                            <div class="small text-muted d-flex gap-2">
                                                <span><i class="fas fa-clock me-1"></i> {{ $similar->created_at->diffForHumans() }}</span>
                                                <span><i class="fas fa-map-marker-alt me-1"></i> {{ Str::limit($similar->location, 15) ?: 'No location' }}</span>
                                            </div>
                                        </div>
                                        <div class="ms-2 d-flex align-items-center">
                                            <i class="fas fa-chevron-right text-primary"></i>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        
                        <div class="text-center mt-3">
                            <a href="{{ route('help.category', $helpRequest->category->slug) }}" class="btn btn-sm btn-outline-primary">View More</a>
                        </div>
                    @else
                        <p class="text-muted text-center my-3">No similar requests found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
