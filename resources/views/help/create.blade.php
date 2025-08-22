@extends('layouts.app')

@section('title', 'Create Help Request - NeighbourNet')

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
    
    .help-form-container {
        padding: 2rem 0;
        background-color: #f9fafb;
        min-height: calc(100vh - 150px);
    }
    
    .help-form-card {
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
    
    .form-floating {
        margin-bottom: 1.5rem;
    }
    
    .help-form label {
        font-weight: 500;
        color: #333;
    }
    
    .form-text {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .category-options {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .category-option {
        flex: 1 0 calc(33.333% - 1rem);
        min-width: 180px;
        background-color: white;
        border: 1px solid #eee;
        border-radius: var(--help-border-radius);
        padding: 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .category-option:hover {
        border-color: var(--help-primary-color);
        transform: translateY(-3px);
    }
    
    .category-option.selected {
        border-color: var(--help-primary-color);
        background-color: var(--help-primary-light);
    }
    
    .category-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: var(--help-primary-color);
    }
    
    .category-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .category-description {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .toggle-container {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .toggle-label {
        margin-left: 0.5rem;
        font-weight: 500;
    }
    
    .date-time-selectors {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .date-time-selectors > div {
        flex: 1;
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
    
    .visibility-options {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .visibility-option {
        flex: 1;
        background-color: white;
        border: 1px solid #eee;
        border-radius: var(--help-border-radius);
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .visibility-option:hover {
        border-color: var(--help-primary-color);
    }
    
    .visibility-option.selected {
        border-color: var(--help-primary-color);
        background-color: var(--help-primary-light);
    }
    
    .visibility-icon {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: var(--help-primary-color);
    }
    
    .visibility-title {
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .visibility-description {
        font-size: 0.8rem;
        color: #6c757d;
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 2rem;
    }
    
    @media (max-width: 768px) {
        .category-option {
            flex: 1 0 100%;
        }
        
        .date-time-selectors {
            flex-direction: column;
        }
        
        .visibility-options {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
<div class="help-form-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="help-form-card">
                    <div class="form-header">
                        <h1>Request Help</h1>
                        <p>Share details about what you need help with, and we'll connect you with neighbors who can assist</p>
                    </div>
                    
                    <form action="{{ route('help.store') }}" method="POST" class="help-form">
                        @csrf
                        
                        <div class="form-section">
                            <h3 class="form-section-title">Request Details</h3>
                            <p class="form-section-description">Provide a clear description of what you need help with.</p>
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Request Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Help needed assembling furniture">
                                <div class="form-text">Be specific and concise (max 100 characters)</div>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="help_category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                <div class="category-options">
                                    @foreach($categories as $category)
                                    <div class="category-option" data-category-id="{{ $category->id }}">
                                        <div class="category-icon">
                                            <i class="fas {{ $category->icon }}"></i>
                                        </div>
                                        <div class="category-name">{{ $category->name }}</div>
                                        <div class="category-description">{{ Str::limit($category->description, 50) }}</div>
                                    </div>
                                    @endforeach
                                </div>
                                <input type="hidden" id="help_category_id" name="help_category_id" value="{{ old('help_category_id') }}">
                                @error('help_category_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required placeholder="Describe what you need help with in detail...">{{ old('description') }}</textarea>
                                <div class="form-text">Include all relevant details about your request</div>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}" placeholder="e.g. My home, 123 Main Street, or Community Center">
                                <div class="form-text">Where will this help be needed? (Optional)</div>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_emergency" name="is_emergency" value="1" {{ old('is_emergency') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_emergency">Mark as urgent</label>
                                </div>
                                <div class="form-text">Only mark as urgent if you need immediate assistance</div>
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3 class="form-section-title">Scheduling</h3>
                            <p class="form-section-description">When do you need help? Select specific times or a flexible range.</p>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_specific" value="specific" {{ old('schedule_type') != 'flexible' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="schedule_type_specific">
                                        Specific Date & Time
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="schedule_type" id="schedule_type_flexible" value="flexible" {{ old('schedule_type') == 'flexible' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="schedule_type_flexible">
                                        Flexible Schedule
                                    </label>
                                </div>
                            </div>
                            
                            <div id="specific-schedule" class="mb-3 {{ old('schedule_type') == 'flexible' ? 'd-none' : '' }}">
                                <div class="date-time-selectors">
                                    <div>
                                        <label for="help_date" class="form-label">Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('help_date') is-invalid @enderror" id="help_date" name="help_date" value="{{ old('help_date') ?? date('Y-m-d') }}">
                                        @error('help_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="help_time" class="form-label">Time <span class="text-danger">*</span></label>
                                        <input type="time" class="form-control @error('help_time') is-invalid @enderror" id="help_time" name="help_time" value="{{ old('help_time') ?? '09:00' }}">
                                        @error('help_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="duration" class="form-label">Estimated Duration</label>
                                    <select class="form-select @error('duration') is-invalid @enderror" id="duration" name="duration">
                                        <option value="30" {{ old('duration') == '30' ? 'selected' : '' }}>30 minutes</option>
                                        <option value="60" {{ old('duration') == '60' || old('duration') == null ? 'selected' : '' }}>1 hour</option>
                                        <option value="120" {{ old('duration') == '120' ? 'selected' : '' }}>2 hours</option>
                                        <option value="180" {{ old('duration') == '180' ? 'selected' : '' }}>3 hours</option>
                                        <option value="240" {{ old('duration') == '240' ? 'selected' : '' }}>4 hours</option>
                                        <option value="300" {{ old('duration') == '300' ? 'selected' : '' }}>5+ hours</option>
                                    </select>
                                    @error('duration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div id="flexible-schedule" class="mb-3 {{ old('schedule_type') != 'flexible' ? 'd-none' : '' }}">
                                <div class="schedule-container">
                                    @php
                                        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                        $timeSlots = ['Morning', 'Afternoon', 'Evening'];
                                    @endphp
                                    
                                    @foreach($days as $day)
                                        <div class="schedule-row">
                                            <div class="schedule-day">{{ $day }}</div>
                                            <div class="schedule-times">
                                                @foreach($timeSlots as $timeSlot)
                                                    <div class="time-chip" data-day="{{ $day }}" data-time="{{ $timeSlot }}">
                                                        {{ $timeSlot }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" id="available_times" name="available_times" value="{{ old('available_times') }}">
                                @error('available_times')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-section">
                            <h3 class="form-section-title">Visibility & Preferences</h3>
                            <p class="form-section-description">Control who can see your request and any specific preferences.</p>
                            
                            <div class="mb-3">
                                <label class="form-label">Who can see this request?</label>
                                <div class="visibility-options">
                                    <div class="visibility-option {{ old('visibility') != 'verified' ? 'selected' : '' }}" data-visibility="public">
                                        <div class="visibility-icon"><i class="fas fa-globe"></i></div>
                                        <div class="visibility-title">All Neighbors</div>
                                        <div class="visibility-description">Everyone in the community can see and respond</div>
                                    </div>
                                    <div class="visibility-option {{ old('visibility') == 'verified' ? 'selected' : '' }}" data-visibility="verified">
                                        <div class="visibility-icon"><i class="fas fa-user-check"></i></div>
                                        <div class="visibility-title">Verified Helpers Only</div>
                                        <div class="visibility-description">Only verified helpers can see and respond</div>
                                    </div>
                                </div>
                                <input type="hidden" id="visibility" name="visibility" value="{{ old('visibility') ?: 'public' }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="preferences" class="form-label">Preferences or Requirements (Optional)</label>
                                <textarea class="form-control" id="preferences" name="preferences" rows="3" placeholder="Any specific preferences for the helper? (e.g., must have experience with pets, etc.)">{{ old('preferences') }}</textarea>
                                <div class="form-text">Help us find the right neighbor to assist you</div>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <a href="{{ route('help.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit Request</button>
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
        // Category selection
        const categoryOptions = document.querySelectorAll('.category-option');
        const categoryInput = document.getElementById('help_category_id');
        
        categoryOptions.forEach(option => {
            if (option.dataset.categoryId === categoryInput.value) {
                option.classList.add('selected');
            }
            
            option.addEventListener('click', function() {
                categoryOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                categoryInput.value = this.dataset.categoryId;
            });
        });
        
        // Schedule type toggle
        const scheduleTypeSpecific = document.getElementById('schedule_type_specific');
        const scheduleTypeFlexible = document.getElementById('schedule_type_flexible');
        const specificSchedule = document.getElementById('specific-schedule');
        const flexibleSchedule = document.getElementById('flexible-schedule');
        
        scheduleTypeSpecific.addEventListener('change', function() {
            if (this.checked) {
                specificSchedule.classList.remove('d-none');
                flexibleSchedule.classList.add('d-none');
            }
        });
        
        scheduleTypeFlexible.addEventListener('change', function() {
            if (this.checked) {
                specificSchedule.classList.add('d-none');
                flexibleSchedule.classList.remove('d-none');
            }
        });
        
        // Flexible schedule time chips
        const timeChips = document.querySelectorAll('.time-chip');
        const availableTimesInput = document.getElementById('available_times');
        let selectedTimes = availableTimesInput.value ? JSON.parse(availableTimesInput.value) : [];
        
        // Initialize selected times
        if (selectedTimes.length > 0) {
            timeChips.forEach(chip => {
                const day = chip.dataset.day;
                const time = chip.dataset.time;
                
                if (selectedTimes.some(t => t.day === day && t.time === time)) {
                    chip.classList.add('selected');
                }
            });
        }
        
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
        
        // Visibility options
        const visibilityOptions = document.querySelectorAll('.visibility-option');
        const visibilityInput = document.getElementById('visibility');
        
        visibilityOptions.forEach(option => {
            option.addEventListener('click', function() {
                visibilityOptions.forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                visibilityInput.value = this.dataset.visibility;
            });
        });
    });
</script>
@endsection
