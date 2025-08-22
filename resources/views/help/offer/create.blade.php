@extends('layouts.app')

@section('title', 'Offer Help - NeighbourNet')

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
    
    .help-offer-container {
        padding: 2rem 0;
        background-color: #f9fafb;
        min-height: calc(100vh - 150px);
    }
    
    .help-offer-card {
        background-color: white;
        border-radius: var(--help-border-radius);
        box-shadow: var(--help-card-shadow);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .form-header {
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .form-header h1 {
        color: #333;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .form-header p {
        color: #6c757d;
    }
    
    .request-summary {
        background-color: var(--help-light-gray);
        border-radius: var(--help-border-radius);
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .request-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #333;
        font-size: 1.25rem;
    }
    
    .request-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1rem;
        color: #6c757d;
    }
    
    .request-meta-item {
        display: flex;
        align-items: center;
    }
    
    .request-meta-item i {
        margin-right: 0.5rem;
    }
    
    .request-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }
    
    .badge-emergency {
        background-color: #fdf2f2;
        color: var(--help-danger-color);
    }
    
    .request-description {
        margin-top: 1rem;
        color: #6c757d;
    }
    
    .requester-info {
        display: flex;
        align-items: center;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid #eee;
    }
    
    .requester-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        margin-right: 0.75rem;
        object-fit: cover;
    }
    
    .requester-details {
        flex: 1;
    }
    
    .requester-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #333;
    }
    
    .requester-meta {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .form-section {
        margin-bottom: 2rem;
    }
    
    .form-section-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
    }
    
    .form-section-description {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 1.5rem;
    }
    
    .helper-form label {
        font-weight: 500;
        color: #333;
    }
    
    .form-text {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .availability-options {
        margin-bottom: 1.5rem;
    }
    
    .availability-option {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
        padding: 0.75rem;
        border: 1px solid #eee;
        border-radius: var(--help-border-radius);
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .availability-option:hover {
        border-color: var(--help-primary-color);
        background-color: #fafafa;
    }
    
    .availability-option.selected {
        border-color: var(--help-primary-color);
        background-color: var(--help-primary-light);
    }
    
    .availability-radio {
        margin-right: 0.75rem;
    }
    
    .availability-details {
        flex: 1;
    }
    
    .availability-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #333;
    }
    
    .availability-description {
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .date-time-selectors {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .date-time-selectors > div {
        flex: 1;
    }
    
    .profile-match {
        background-color: #d1e7dd;
        color: #0f5132;
        padding: 1rem;
        border-radius: var(--help-border-radius);
        margin-bottom: 1.5rem;
    }
    
    .profile-match-title {
        display: flex;
        align-items: center;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .profile-match-title i {
        margin-right: 0.5rem;
    }
    
    .profile-match-details {
        font-size: 0.9rem;
    }
    
    .matched-skills {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .matched-skill {
        background-color: white;
        color: #0f5132;
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.85rem;
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }
    
    @media (max-width: 768px) {
        .date-time-selectors {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="help-offer-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="help-offer-card">
                    <div class="form-header">
                        <h1>Offer to Help</h1>
                        <p>You're about to offer assistance to a neighbor in need</p>
                    </div>
                    
                    <div class="request-summary">
                        <h3 class="request-title">
                            {{ $helpRequest->title }}
                            @if($helpRequest->is_emergency)
                            <span class="request-badge badge-emergency">Urgent</span>
                            @endif
                        </h3>
                        
                        <div class="request-meta">
                            <div class="request-meta-item">
                                <i class="fas {{ $helpRequest->category->icon }}"></i>
                                {{ $helpRequest->category->name }}
                            </div>
                            <div class="request-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $helpRequest->location ?: 'No location specified' }}
                            </div>
                            <div class="request-meta-item">
                                <i class="fas fa-clock"></i>
                                {{ $helpRequest->created_at->diffForHumans() }}
                            </div>
                        </div>
                        
                        <div class="request-description">
                            {{ Str::limit($helpRequest->description, 200) }}
                            @if(strlen($helpRequest->description) > 200)
                            <a href="{{ route('help.show', $helpRequest->id) }}" class="ms-1">Read more</a>
                            @endif
                        </div>
                        
                        <div class="requester-info">
                            <img src="{{ asset('storage/' . ($helpRequest->user->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $helpRequest->user->name }}" class="requester-avatar">
                            <div class="requester-details">
                                <div class="requester-name">{{ $helpRequest->user->name }}</div>
                                <div class="requester-meta">Member since {{ $helpRequest->user->created_at->format('M Y') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    @if(auth()->user()->helperProfile && $matchedSkills && count($matchedSkills) > 0)
                    <div class="profile-match">
                        <div class="profile-match-title">
                            <i class="fas fa-check-circle"></i>
                            Your skills match this request!
                        </div>
                        <div class="profile-match-details">
                            You have skills that are relevant to this help request:
                            <div class="matched-skills">
                                @foreach($matchedSkills as $skill)
                                <div class="matched-skill">{{ $skill->name }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <form action="{{ route('help.offer.store', $helpRequest->id) }}" method="POST" class="helper-form">
                        @csrf
                        
                        <div class="form-section">
                            <h3 class="form-section-title">Your Offer</h3>
                            <p class="form-section-description">Provide details about how you can help with this request.</p>
                            
                            <div class="mb-3">
                                <label for="message" class="form-label">Message to Requester <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="4" required placeholder="Introduce yourself and explain how you can help...">{{ old('message') }}</textarea>
                                <div class="form-text">Be friendly and concise about your relevant experience</div>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3 class="form-section-title">Availability</h3>
                            <p class="form-section-description">Let the requester know when you're available to help.</p>
                            
                            @if($helpRequest->schedule_type == 'specific')
                            <div class="availability-options">
                                <div class="availability-option {{ old('availability_type') != 'alternative' ? 'selected' : '' }}" data-availability="confirmed">
                                    <div class="availability-radio">
                                        <input type="radio" name="availability_type" id="availability_confirmed" value="confirmed" {{ old('availability_type') != 'alternative' ? 'checked' : '' }}>
                                    </div>
                                    <div class="availability-details">
                                        <div class="availability-title">I can help at the requested time</div>
                                        <div class="availability-description">
                                            {{ \Carbon\Carbon::parse($helpRequest->help_date)->format('l, F j, Y') }} at 
                                            {{ \Carbon\Carbon::parse($helpRequest->help_time)->format('g:i A') }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="availability-option {{ old('availability_type') == 'alternative' ? 'selected' : '' }}" data-availability="alternative">
                                    <div class="availability-radio">
                                        <input type="radio" name="availability_type" id="availability_alternative" value="alternative" {{ old('availability_type') == 'alternative' ? 'checked' : '' }}>
                                    </div>
                                    <div class="availability-details">
                                        <div class="availability-title">I can help at a different time</div>
                                        <div class="availability-description">Suggest an alternative time that works for you</div>
                                        
                                        <div id="alternative-time-selector" class="{{ old('availability_type') == 'alternative' ? '' : 'd-none' }}">
                                            <div class="date-time-selectors">
                                                <div>
                                                    <label for="alternative_date" class="form-label">Date</label>
                                                    <input type="date" class="form-control @error('alternative_date') is-invalid @enderror" id="alternative_date" name="alternative_date" value="{{ old('alternative_date') ?? date('Y-m-d') }}">
                                                    @error('alternative_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div>
                                                    <label for="alternative_time" class="form-label">Time</label>
                                                    <input type="time" class="form-control @error('alternative_time') is-invalid @enderror" id="alternative_time" name="alternative_time" value="{{ old('alternative_time') ?? '09:00' }}">
                                                    @error('alternative_time')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="mb-3">
                                <label for="availability_note" class="form-label">Your Availability <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('availability_note') is-invalid @enderror" id="availability_note" name="availability_note" rows="3" required placeholder="Describe when you're available to help...">{{ old('availability_note') }}</textarea>
                                <div class="form-text">Be specific about days and times you can help</div>
                                @error('availability_note')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @endif
                        </div>
                        
                        <div class="form-section">
                            <h3 class="form-section-title">Additional Information</h3>
                            
                            <div class="mb-3">
                                <label for="notes" class="form-label">Additional Notes (Optional)</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any other details you'd like to share...">{{ old('notes') }}</textarea>
                                <div class="form-text">Include any questions or information that might be helpful</div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms_accepted" name="terms_accepted" value="1" {{ old('terms_accepted') ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="terms_accepted">
                                        I understand that this is a volunteer opportunity to help a neighbor, and I agree to the <a href="#" target="_blank">NeighbourNet Help Guidelines</a>
                                    </label>
                                    @error('terms_accepted')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <a href="{{ route('help.show', $helpRequest->id) }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit Offer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Availability option selection
        const availabilityOptions = document.querySelectorAll('.availability-option');
        const alternativeTimeSelector = document.getElementById('alternative-time-selector');
        
        availabilityOptions.forEach(option => {
            option.addEventListener('click', function() {
                const radioInput = this.querySelector('input[type="radio"]');
                radioInput.checked = true;
                
                availabilityOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                
                if (radioInput.value === 'alternative') {
                    alternativeTimeSelector.classList.remove('d-none');
                } else {
                    alternativeTimeSelector.classList.add('d-none');
                }
            });
        });
    });
</script>
@endsection
