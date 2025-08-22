@extends('layouts.app')

@section('title', 'Leave Feedback - NeighbourNet Help')

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
    
    .feedback-container {
        padding: 2rem 0;
        background-color: #f9fafb;
        min-height: calc(100vh - 150px);
    }
    
    .feedback-card {
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
    
    .helper-info {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #eee;
    }
    
    .helper-avatar {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        margin-right: 1rem;
        object-fit: cover;
    }
    
    .helper-details {
        flex: 1;
    }
    
    .helper-name {
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
        color: #333;
    }
    
    .helper-meta {
        color: #6c757d;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .helper-meta span {
        display: flex;
        align-items: center;
    }
    
    .helper-meta i {
        margin-right: 0.25rem;
    }
    
    .request-info {
        background-color: var(--help-light-gray);
        padding: 1rem;
        border-radius: var(--help-border-radius);
        margin-bottom: 2rem;
    }
    
    .request-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .request-meta {
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
    
    .rating-container {
        margin-bottom: 1.5rem;
    }
    
    .rating-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #333;
    }
    
    .star-rating {
        display: flex;
        gap: 0.5rem;
    }
    
    .star-rating input {
        display: none;
    }
    
    .star-rating label {
        color: #ddd;
        font-size: 1.75rem;
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: #f6993f;
    }
    
    .rating-help {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }
    
    .rating-categories {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .rating-category {
        background-color: var(--help-light-gray);
        padding: 1rem;
        border-radius: var(--help-border-radius);
    }
    
    .category-name {
        font-weight: 500;
        margin-bottom: 0.75rem;
        color: #333;
    }
    
    .skill-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .skill-badge {
        background-color: white;
        border: 1px solid #ddd;
        padding: 0.35rem 0.75rem;
        border-radius: 30px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .skill-badge:hover {
        border-color: var(--help-primary-color);
    }
    
    .skill-badge.selected {
        background-color: var(--help-primary-color);
        color: white;
        border-color: var(--help-primary-color);
    }
    
    .badge-success {
        background-color: var(--help-success-color);
        color: white;
    }
    
    .achievements-section {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #eee;
    }
    
    .achievement-title {
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .achievements-list {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .achievement-badge {
        width: 80px;
        text-align: center;
    }
    
    .achievement-icon {
        width: 64px;
        height: 64px;
        object-fit: contain;
        margin-bottom: 0.5rem;
    }
    
    .achievement-name {
        font-size: 0.85rem;
        color: #333;
    }
    
    .achievement-unlock {
        background-color: #d1e7dd;
        color: #0f5132;
        padding: 1rem;
        border-radius: var(--help-border-radius);
        margin-top: 1rem;
        display: flex;
        align-items: center;
    }
    
    .achievement-unlock-icon {
        font-size: 1.5rem;
        margin-right: 1rem;
    }
    
    .achievement-unlock-details {
        flex: 1;
    }
    
    .achievement-unlock-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .achievement-unlock-description {
        font-size: 0.9rem;
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }
    
    @media (max-width: 768px) {
        .helper-info {
            flex-direction: column;
            text-align: center;
        }
        
        .helper-avatar {
            margin-right: 0;
            margin-bottom: 1rem;
        }
        
        .helper-meta {
            justify-content: center;
        }
        
        .rating-categories {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="feedback-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="feedback-card">
                    <div class="form-header">
                        <h1>Leave Feedback</h1>
                        <p>Share your experience with {{ $helpRequest->helper->name }}</p>
                    </div>
                    
                    <div class="helper-info">
                        <img src="{{ asset('storage/' . ($helpRequest->helper->avatar ?: 'avatars/default.jpg')) }}" alt="{{ $helpRequest->helper->name }}" class="helper-avatar">
                        <div class="helper-details">
                            <div class="helper-name">{{ $helpRequest->helper->name }}</div>
                            <div class="helper-meta">
                                <span><i class="fas fa-hands-helping"></i> {{ $helpRequest->helper->completedHelps()->count() }} neighbors helped</span>
                                <span><i class="fas fa-star"></i> {{ number_format($helpRequest->helper->getAverageRating(), 1) }} average rating</span>
                                <span><i class="fas fa-calendar-alt"></i> Helped on {{ $helpRequest->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="request-info">
                        <div class="request-title">{{ $helpRequest->title }}</div>
                        <div class="request-meta">
                            <div><i class="fas {{ $helpRequest->category->icon }} me-1"></i> {{ $helpRequest->category->name }}</div>
                        </div>
                    </div>
                    
                    <form action="{{ route('help.feedback.store', $helpRequest->id) }}" method="POST" class="feedback-form">
                        @csrf
                        
                        <div class="form-section">
                            <h3 class="form-section-title">Overall Experience</h3>
                            <p class="form-section-description">Rate your overall experience with this helper.</p>
                            
                            <div class="rating-container">
                                <div class="rating-label">Overall Rating <span class="text-danger">*</span></div>
                                <div class="star-rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="overall-star{{ $i }}" name="overall_rating" value="{{ $i }}" {{ old('overall_rating') == $i ? 'checked' : '' }} required>
                                    <label for="overall-star{{ $i }}"><i class="fas fa-star"></i></label>
                                    @endfor
                                </div>
                                <div class="rating-help">1 = Poor, 5 = Excellent</div>
                                @error('overall_rating')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="feedback_text" class="form-label">Your Feedback <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('feedback_text') is-invalid @enderror" id="feedback_text" name="feedback_text" rows="4" required placeholder="Tell us about your experience with this helper...">{{ old('feedback_text') }}</textarea>
                                <div class="form-text">Your feedback helps other neighbors and improves our community</div>
                                @error('feedback_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3 class="form-section-title">Specific Ratings</h3>
                            <p class="form-section-description">Rate different aspects of your experience.</p>
                            
                            <div class="rating-categories">
                                <div class="rating-category">
                                    <div class="category-name">Punctuality</div>
                                    <div class="star-rating">
                                        @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="punctuality-star{{ $i }}" name="punctuality_rating" value="{{ $i }}" {{ old('punctuality_rating') == $i ? 'checked' : '' }}>
                                        <label for="punctuality-star{{ $i }}"><i class="fas fa-star"></i></label>
                                        @endfor
                                    </div>
                                </div>
                                
                                <div class="rating-category">
                                    <div class="category-name">Communication</div>
                                    <div class="star-rating">
                                        @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="communication-star{{ $i }}" name="communication_rating" value="{{ $i }}" {{ old('communication_rating') == $i ? 'checked' : '' }}>
                                        <label for="communication-star{{ $i }}"><i class="fas fa-star"></i></label>
                                        @endfor
                                    </div>
                                </div>
                                
                                <div class="rating-category">
                                    <div class="category-name">Helpfulness</div>
                                    <div class="star-rating">
                                        @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="helpfulness-star{{ $i }}" name="helpfulness_rating" value="{{ $i }}" {{ old('helpfulness_rating') == $i ? 'checked' : '' }}>
                                        <label for="helpfulness-star{{ $i }}"><i class="fas fa-star"></i></label>
                                        @endfor
                                    </div>
                                </div>
                                
                                <div class="rating-category">
                                    <div class="category-name">Skill Level</div>
                                    <div class="star-rating">
                                        @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="skill-star{{ $i }}" name="skill_rating" value="{{ $i }}" {{ old('skill_rating') == $i ? 'checked' : '' }}>
                                        <label for="skill-star{{ $i }}"><i class="fas fa-star"></i></label>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3 class="form-section-title">Highlight Skills</h3>
                            <p class="form-section-description">Which skills did this helper demonstrate? Select all that apply.</p>
                            
                            <div class="skill-badges">
                                @foreach($skills as $skill)
                                <div class="skill-badge" data-skill-id="{{ $skill->id }}">
                                    {{ $skill->name }}
                                    <input type="checkbox" name="skills[]" value="{{ $skill->id }}" class="d-none" {{ in_array($skill->id, old('skills', [])) ? 'checked' : '' }}>
                                </div>
                                @endforeach
                                
                                <div class="skill-badge badge-success" data-skill-id="add">
                                    <i class="fas fa-plus"></i> Add Skill
                                </div>
                            </div>
                            
                            <div id="custom-skill-form" class="mb-3 d-none">
                                <label for="custom_skill" class="form-label">Add a Custom Skill</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="custom_skill" name="custom_skill" placeholder="e.g. Great with pets">
                                    <button class="btn btn-outline-secondary" type="button" id="add-custom-skill">Add</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3 class="form-section-title">Additional Feedback</h3>
                            
                            <div class="mb-3">
                                <label for="private_notes" class="form-label">Private Notes (Optional)</label>
                                <textarea class="form-control" id="private_notes" name="private_notes" rows="3" placeholder="Any additional notes that will only be visible to administrators...">{{ old('private_notes') }}</textarea>
                                <div class="form-text">These notes will not be shared with the helper</div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="would_recommend" name="would_recommend" value="1" {{ old('would_recommend') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="would_recommend">
                                        I would recommend this helper to other neighbors
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="achievements-section">
                            <div class="achievement-title">Achievement Progress</div>
                            
                            @if($unlockedAchievements && $unlockedAchievements->count() > 0)
                            <div class="achievement-unlock">
                                <div class="achievement-unlock-icon">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div class="achievement-unlock-details">
                                    <div class="achievement-unlock-title">
                                        Your feedback has unlocked {{ $unlockedAchievements->count() > 1 ? 'achievements' : 'an achievement' }} for {{ $helpRequest->helper->name }}!
                                    </div>
                                    <div class="achievement-unlock-description">
                                        Your feedback helps recognize neighbors who go above and beyond
                                    </div>
                                </div>
                            </div>
                            
                            <div class="achievements-list mt-3">
                                @foreach($unlockedAchievements as $achievement)
                                <div class="achievement-badge">
                                    <img src="{{ asset('storage/' . ($achievement->badge_image ?: 'badges/default.png')) }}" alt="{{ $achievement->name }}" class="achievement-icon">
                                    <div class="achievement-name">{{ $achievement->name }}</div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        
                        <div class="form-actions">
                            <a href="{{ route('help.show', $helpRequest->id) }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit Feedback</button>
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
        // Skill badges selection
        const skillBadges = document.querySelectorAll('.skill-badge');
        const customSkillForm = document.getElementById('custom-skill-form');
        const customSkillInput = document.getElementById('custom_skill');
        const addCustomSkillBtn = document.getElementById('add-custom-skill');
        
        skillBadges.forEach(badge => {
            if (badge.dataset.skillId === 'add') {
                badge.addEventListener('click', function() {
                    customSkillForm.classList.toggle('d-none');
                    if (!customSkillForm.classList.contains('d-none')) {
                        customSkillInput.focus();
                    }
                });
            } else {
                // Check if the badge was previously selected
                const checkbox = badge.querySelector('input[type="checkbox"]');
                if (checkbox.checked) {
                    badge.classList.add('selected');
                }
                
                badge.addEventListener('click', function() {
                    this.classList.toggle('selected');
                    const checkbox = this.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;
                });
            }
        });
        
        // Add custom skill
        addCustomSkillBtn.addEventListener('click', function() {
            const skillName = customSkillInput.value.trim();
            
            if (skillName) {
                const skillBadgesContainer = document.querySelector('.skill-badges');
                const newBadge = document.createElement('div');
                newBadge.className = 'skill-badge selected';
                
                const customSkillId = 'custom_' + Date.now(); // Generate a unique ID
                newBadge.dataset.skillId = customSkillId;
                
                newBadge.innerHTML = `
                    ${skillName}
                    <input type="hidden" name="custom_skills[]" value="${skillName}">
                    <input type="checkbox" name="skills[]" value="${customSkillId}" class="d-none" checked>
                `;
                
                // Insert before the "Add Skill" button
                skillBadgesContainer.insertBefore(newBadge, document.querySelector('.skill-badge[data-skill-id="add"]'));
                
                // Add event listener to the new badge
                newBadge.addEventListener('click', function() {
                    this.classList.toggle('selected');
                    const checkbox = this.querySelector('input[type="checkbox"]');
                    checkbox.checked = !checkbox.checked;
                });
                
                // Clear the input and hide the form
                customSkillInput.value = '';
                customSkillForm.classList.add('d-none');
            }
        });
        
        // Allow pressing Enter to add a custom skill
        customSkillInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addCustomSkillBtn.click();
            }
        });
    });
</script>
@endsection
