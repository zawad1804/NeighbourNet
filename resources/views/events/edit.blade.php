@extends('layouts.app')

@section('content')
<main class="create-event-page">
    <div class="container">
        <div class="page-header">
            <h1>Edit Event</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data" class="event-form">
            @csrf
            @method('PUT')
            
            <div class="form-section">
                <h2>Basic Information</h2>
                <div class="form-group">
                    <label for="title">Event Title*</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="description">Event Description*</label>
                    <textarea id="description" name="description" rows="5" required class="form-control">{{ old('description', $event->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="category">Category*</label>
                    <select id="category" name="category" required class="form-control">
                        <option value="">Select a category</option>
                        <option value="Social" {{ old('category', $event->category) == 'Social' ? 'selected' : '' }}>Social</option>
                        <option value="Education" {{ old('category', $event->category) == 'Education' ? 'selected' : '' }}>Education</option>
                        <option value="Sports" {{ old('category', $event->category) == 'Sports' ? 'selected' : '' }}>Sports</option>
                        <option value="Community" {{ old('category', $event->category) == 'Community' ? 'selected' : '' }}>Community</option>
                        <option value="Other" {{ old('category', $event->category) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            <div class="form-section">
                <h2>Date & Time</h2>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="start_date">Start Date*</label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $event->start_date) }}" required class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="start_time">Start Time*</label>
                        <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $event->start_time) }}" required class="form-control">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="end_date">End Date</label>
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $event->end_date) }}" class="form-control">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="end_time">End Time</label>
                        <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $event->end_time) }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2>Location</h2>
                <div class="form-group">
                    <label for="location">Location*</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $event->location) }}" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="location_details">Location Details</label>
                    <textarea id="location_details" name="location_details" rows="2" class="form-control">{{ old('location_details', $event->location_details) }}</textarea>
                    <small class="form-text text-muted">Additional details about the location, like room number, floor, or special instructions.</small>
                </div>
            </div>

            <div class="form-section">
                <h2>Event Image</h2>
                <div class="form-group">
                    <label for="image">Event Image</label>
                    <input type="file" id="image" name="image" class="form-control-file">
                    <small class="form-text text-muted">Upload an image for your event. Recommended size: 1200x630px.</small>
                    
                    @if($event->image)
                        <div class="current-image mt-2">
                            <p>Current image:</p>
                            <img src="{{ asset('storage/' . $event->image) }}" alt="Current event image" style="max-width: 200px; max-height: 200px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                <label class="form-check-label" for="remove_image">
                                    Remove current image
                                </label>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-section">
                <h2>Options</h2>
                <div class="form-group">
                    <label for="max_attendees">Maximum Attendees</label>
                    <input type="number" id="max_attendees" name="max_attendees" value="{{ old('max_attendees', $event->max_attendees) }}" min="1" class="form-control">
                    <small class="form-text text-muted">Leave empty for unlimited attendees.</small>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="is_public" name="is_public" value="1" {{ old('is_public', $event->is_public) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_public">
                        Public Event
                    </label>
                    <small class="form-text text-muted d-block">Public events can be shared and are visible to everyone in the community.</small>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rsvp_enabled" name="rsvp_enabled" value="1" {{ old('rsvp_enabled', $event->rsvp_enabled) ? 'checked' : '' }}>
                    <label class="form-check-label" for="rsvp_enabled">
                        Enable RSVPs
                    </label>
                    <small class="form-text text-muted d-block">Allow users to RSVP to this event.</small>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('events.show', $event) }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Event</button>
            </div>
        </form>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle end date/time fields based on multi-day checkbox
        const startDateField = document.getElementById('start_date');
        const startTimeField = document.getElementById('start_time');
        const endDateField = document.getElementById('end_date');
        const endTimeField = document.getElementById('end_time');
        
        // Auto-populate end date with start date if empty
        startDateField.addEventListener('change', function() {
            if (!endDateField.value) {
                endDateField.value = this.value;
            }
        });
        
        // Form validation
        const form = document.querySelector('.event-form');
        form.addEventListener('submit', function(event) {
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            const location = document.getElementById('location').value.trim();
            const category = document.getElementById('category').value;
            const startDate = document.getElementById('start_date').value;
            const startTime = document.getElementById('start_time').value;
            
            let isValid = true;
            let errorMessages = [];
            
            if (!title) {
                errorMessages.push('Event title is required');
                isValid = false;
            }
            
            if (!description) {
                errorMessages.push('Event description is required');
                isValid = false;
            }
            
            if (!location) {
                errorMessages.push('Event location is required');
                isValid = false;
            }
            
            if (!category) {
                errorMessages.push('Please select a category');
                isValid = false;
            }
            
            if (!startDate) {
                errorMessages.push('Start date is required');
                isValid = false;
            }
            
            if (!startTime) {
                errorMessages.push('Start time is required');
                isValid = false;
            }
            
            if (!isValid) {
                event.preventDefault();
                alert('Please fix the following errors:\n' + errorMessages.join('\n'));
            }
        });
    });
</script>
@endsection
