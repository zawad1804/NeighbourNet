@extends('layouts.app')

@section('title', 'Helper Profile - NeighbourNet')

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
    
    .helper-profile-container {
        padding: 2rem 0;
        background-color: #f9fafb;
        min-height: calc(100vh - 150px);
    }
    
    .helper-profile-card {
        background-color: white;
        border-radius: var(--help-border-radius);
        box-shadow: var(--help-card-shadow);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .profile-header {
        margin-bottom: 2rem;
        text-align: center;
    }
    
    .profile-header h1 {
        color: #333;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .profile-header p {
        color: #6c757d;
    }
    
    .profile-section {
        margin-bottom: 2rem;
    }
    
    .profile-section-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
    }
    
    .profile-section-description {
        font-size: 0.9rem;
        color: #6c757d;
        margin-bottom: 1.5rem;
    }
    
    .form-floating {
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
    
    .skills-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .skill-item {
        background-color: white;
        border: 1px solid #eee;
        border-radius: var(--help-border-radius);
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .skill-item:hover {
        border-color: var(--help-primary-color);
        transform: translateY(-3px);
    }
    
    .skill-item.selected {
        border-color: var(--help-primary-color);
        background-color: var(--help-primary-light);
    }
    
    .skill-icon {
        font-size: 1.25rem;
        margin-right: 0.75rem;
        color: var(--help-primary-color);
    }
    
    .skill-details {
        flex: 1;
    }
    
    .skill-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .skill-description {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .availability-container {
        margin-bottom: 1.5rem;
    }
    
    .schedule-row {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        background-color: var(--help-light-gray);
        padding: 0.75rem;
        border-radius: 5px;
    }
    
    .schedule-day {
        flex: 0 0 100px;
        font-weight: 500;
    }
    
    .schedule-times {
        flex: 1;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .time-chip {
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 30px;
        padding: 0.25rem 0.75rem;
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .time-chip:hover {
        border-color: var(--help-primary-color);
    }
    
    .time-chip.selected {
        background-color: var(--help-primary-color);
        color: white;
        border-color: var(--help-primary-color);
    }
    
    .verification-section {
        background-color: var(--help-light-gray);
        padding: 1.5rem;
        border-radius: var(--help-border-radius);
        margin-bottom: 1.5rem;
        border: 1px solid #ddd;
    }
    
    .verification-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .verification-icon {
        font-size: 1.5rem;
        margin-right: 1rem;
        color: var(--help-primary-color);
    }
    
    .verification-title {
        font-weight: 600;
        color: #333;
    }
    
    .verification-description {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .verification-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }
    
    .badge-verified {
        background-color: #d1e7dd;
        color: #0f5132;
    }
    
    .badge-pending {
        background-color: #fff3cd;
        color: #664d03;
    }
    
    .badge-unverified {
        background-color: #f8d7da;
        color: #842029;
    }
    
    .custom-skill-form {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px dashed #ddd;
    }
    
    .custom-skill-inputs {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }
    
    .profile-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .stat-item {
        background-color: var(--help-light-gray);
        padding: 1rem;
        border-radius: var(--help-border-radius);
        text-align: center;
    }
    
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--help-primary-color);
    }
    
    .stat-label {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .helper-achievements {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .achievement-badge {
        background-color: white;
        border: 1px solid #eee;
        border-radius: var(--help-border-radius);
        padding: 1rem;
        text-align: center;
        width: calc(33.333% - 0.67rem);
        transition: transform 0.2s;
    }
    
    .achievement-badge:hover {
        transform: translateY(-5px);
    }
    
    .achievement-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 0.75rem;
        object-fit: contain;
    }
    
    .achievement-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #333;
    }
    
    .achievement-description {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .empty-state {
        text-align: center;
        padding: 2rem 0;
    }
    
    .empty-state-icon {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }
    
    .empty-state-message {
        font-size: 1.1rem;
        color: #6c757d;
        margin-bottom: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .skills-container {
            flex-direction: column;
        }
        
        .profile-stats {
            grid-template-columns: 1fr;
        }
        
        .achievement-badge {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="helper-profile-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="helper-profile-card">
                    <div class="profile-header">
                        <h1>Helper Profile</h1>
                        <p>Set up your profile to offer help to neighbors in need</p>
                    </div>
                    
                    <form action="{{ route('help.profile.update') }}" method="POST" class="helper-form">
                        @csrf
                        @method('PUT')
                        
                        <div class="profile-section">
                            <h3 class="profile-section-title">About You</h3>
                            <p class="profile-section-description">Tell us a bit about yourself and how you can help others.</p>
                            
                            <div class="mb-3">
                                <label for="helper_title" class="form-label">Your Helper Title</label>
                                <input type="text" class="form-control @error('helper_title') is-invalid @enderror" id="helper_title" name="helper_title" value="{{ old('helper_title', $helperProfile->helper_title ?? '') }}" placeholder="e.g. Experienced Handyman, Computer Expert, etc.">
                                <div class="form-text">A short description of your expertise (max 50 characters)</div>
                                @error('helper_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="bio" class="form-label">Your Bio</label>
                                <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4" placeholder="Share a bit about yourself, your experience, and why you want to help...">{{ old('bio', $helperProfile->bio ?? '') }}</textarea>
                                <div class="form-text">This will be shown to people looking for help</div>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="experience" class="form-label">Years of Experience</label>
                                <select class="form-select @error('experience') is-invalid @enderror" id="experience" name="experience">
                                    <option value="">Select years of experience...</option>
                                    <option value="0-1" {{ old('experience', $helperProfile->experience ?? '') == '0-1' ? 'selected' : '' }}>Less than 1 year</option>
                                    <option value="1-3" {{ old('experience', $helperProfile->experience ?? '') == '1-3' ? 'selected' : '' }}>1-3 years</option>
                                    <option value="3-5" {{ old('experience', $helperProfile->experience ?? '') == '3-5' ? 'selected' : '' }}>3-5 years</option>
                                    <option value="5-10" {{ old('experience', $helperProfile->experience ?? '') == '5-10' ? 'selected' : '' }}>5-10 years</option>
                                    <option value="10+" {{ old('experience', $helperProfile->experience ?? '') == '10+' ? 'selected' : '' }}>10+ years</option>
                                </select>
                                @error('experience')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="profile-section">
                            <h3 class="profile-section-title">Your Skills</h3>
                            <p class="profile-section-description">Select the skills and categories where you can offer help.</p>
                            
                            <div class="skills-container">
                                @foreach($helpSkills as $skill)
                                <div class="skill-item {{ in_array($skill->id, $userSkillIds ?? []) ? 'selected' : '' }}" data-skill-id="{{ $skill->id }}">
                                    <div class="skill-icon">
                                        <i class="fas {{ $skill->icon }}"></i>
                                    </div>
                                    <div class="skill-details">
                                        <div class="skill-name">{{ $skill->name }}</div>
                                        <div class="skill-description">{{ Str::limit($skill->description, 50) }}</div>
                                    </div>
                                    <div class="skill-checkbox">
                                        <input type="checkbox" name="skills[]" value="{{ $skill->id }}" class="d-none" {{ in_array($skill->id, $userSkillIds ?? []) ? 'checked' : '' }}>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <div class="custom-skill-form">
                                <label class="form-label">Add a Custom Skill (Optional)</label>
                                <div class="custom-skill-inputs">
                                    <input type="text" class="form-control" name="custom_skill_name" placeholder="Skill name...">
                                    <input type="text" class="form-control" name="custom_skill_description" placeholder="Brief description...">
                                </div>
                                <div class="form-text">If your skill isn't listed above, you can add it here</div>
                            </div>
                        </div>
                        
                        <div class="profile-section">
                            <h3 class="profile-section-title">Your Availability</h3>
                            <p class="profile-section-description">Let us know when you're typically available to help.</p>
                            
                            <div class="availability-container">
                                @php
                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                    $timeSlots = ['Morning', 'Afternoon', 'Evening'];
                                    $availableTimes = json_decode($helperProfile->available_times ?? '[]', true) ?: [];
                                @endphp
                                
                                @foreach($days as $day)
                                <div class="schedule-row">
                                    <div class="schedule-day">{{ $day }}</div>
                                    <div class="schedule-times">
                                        @foreach($timeSlots as $timeSlot)
                                        <div class="time-chip {{ in_array(['day' => $day, 'time' => $timeSlot], $availableTimes) ? 'selected' : '' }}" data-day="{{ $day }}" data-time="{{ $timeSlot }}">
                                            {{ $timeSlot }}
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <input type="hidden" id="available_times" name="available_times" value="{{ old('available_times', $helperProfile->available_times ?? '') }}">
                            
                            <div class="mb-3">
                                <label for="travel_distance" class="form-label">Maximum Travel Distance</label>
                                <select class="form-select @error('travel_distance') is-invalid @enderror" id="travel_distance" name="travel_distance">
                                    <option value="1" {{ old('travel_distance', $helperProfile->travel_distance ?? '') == '1' ? 'selected' : '' }}>Within 1 mile</option>
                                    <option value="3" {{ old('travel_distance', $helperProfile->travel_distance ?? '') == '3' ? 'selected' : '' }}>Within 3 miles</option>
                                    <option value="5" {{ old('travel_distance', $helperProfile->travel_distance ?? '5') == '5' ? 'selected' : '' }}>Within 5 miles</option>
                                    <option value="10" {{ old('travel_distance', $helperProfile->travel_distance ?? '') == '10' ? 'selected' : '' }}>Within 10 miles</option>
                                    <option value="any" {{ old('travel_distance', $helperProfile->travel_distance ?? '') == 'any' ? 'selected' : '' }}>Any distance</option>
                                </select>
                                <div class="form-text">How far are you willing to travel to help?</div>
                                @error('travel_distance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="profile-section">
                            <h3 class="profile-section-title">Verification</h3>
                            <p class="profile-section-description">Get verified to build trust with your neighbors.</p>
                            
                            <div class="verification-section">
                                <div class="verification-header">
                                    <div class="verification-icon">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                    <div class="verification-title">Helper Verification</div>
                                </div>
                                
                                <div class="verification-description">
                                    Verified helpers are more likely to be chosen and trusted by neighbors. Our verification process is simple and secure.
                                </div>
                                
                                @if($helperProfile && $helperProfile->is_verified)
                                <div class="verification-badge badge-verified">
                                    <i class="fas fa-check-circle me-1"></i> Verified Helper
                                </div>
                                <p class="small">You've been verified as a trusted helper!</p>
                                @elseif($helperProfile && $helperProfile->verification_requested_at)
                                <div class="verification-badge badge-pending">
                                    <i class="fas fa-clock me-1"></i> Verification Pending
                                </div>
                                <p class="small">Your verification request is being reviewed. We'll notify you once it's approved.</p>
                                @else
                                <div class="verification-badge badge-unverified">
                                    <i class="fas fa-times-circle me-1"></i> Not Verified
                                </div>
                                <p class="small">Become a verified helper to build trust and get more help requests.</p>
                                <div class="mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="request_verification" name="request_verification" value="1">
                                        <label class="form-check-label" for="request_verification">
                                            Request Verification
                                        </label>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <a href="{{ route('help.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Profile</button>
                        </div>
                    </form>
                </div>
                
                @if($helperProfile)
                <div class="helper-profile-card">
                    <h3 class="profile-section-title">Helper Stats & Achievements</h3>
                    
                    <div class="profile-stats">
                        <div class="stat-item">
                            <div class="stat-value">{{ $completedHelps }}</div>
                            <div class="stat-label">Neighbors Helped</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ number_format($averageRating, 1) }}</div>
                            <div class="stat-label">Average Rating</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $helpPoints }}</div>
                            <div class="stat-label">Help Points</div>
                        </div>
                    </div>
                    
                    @if($achievements->count() > 0)
                    <div class="helper-achievements">
                        @foreach($achievements as $achievement)
                        <div class="achievement-badge">
                            <img src="{{ asset('storage/' . ($achievement->badge_image ?: 'badges/default.png')) }}" alt="{{ $achievement->name }}" class="achievement-icon">
                            <div class="achievement-name">{{ $achievement->name }}</div>
                            <div class="achievement-description">{{ $achievement->description }}</div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div class="empty-state-message">
                            You haven't earned any achievements yet.
                        </div>
                        <p class="text-muted">Complete help requests to earn badges and achievements!</p>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Skills selection
        const skillItems = document.querySelectorAll('.skill-item');
        
        skillItems.forEach(item => {
            item.addEventListener('click', function() {
                this.classList.toggle('selected');
                const checkbox = this.querySelector('input[type="checkbox"]');
                checkbox.checked = !checkbox.checked;
            });
        });
        
        // Availability time chips
        const timeChips = document.querySelectorAll('.time-chip');
        const availableTimesInput = document.getElementById('available_times');
        let selectedTimes = availableTimesInput.value ? JSON.parse(availableTimesInput.value) : [];
        
        timeChips.forEach(chip => {
            chip.addEventListener('click', function() {
                const day = this.dataset.day;
                const time = this.dataset.time;
                
                if (this.classList.contains('selected')) {
                    // Remove from selected times
                    this.classList.remove('selected');
                    selectedTimes = selectedTimes.filter(t => !(t.day === day && t.time === time));
                } else {
                    // Add to selected times
                    this.classList.add('selected');
                    selectedTimes.push({ day, time });
                }
                
                availableTimesInput.value = JSON.stringify(selectedTimes);
            });
        });
    });
</script>
@endsection
