

<?php $__env->startSection('styles'); ?>
<style>
  /* Custom styles for file size restrictions */
  .file-restrictions .alert {
    font-size: 0.9rem;
    padding: 0.5rem;
    margin-bottom: 0.5rem;
  }
  
  .file-info {
    background: #f8f9fa;
    padding: 0.5rem;
    border-radius: 4px;
    margin-top: 0.5rem;
  }
  
  .badge.bg-success {
    background-color: #28a745 !important;
  }
  
  .badge.bg-danger {
    background-color: #dc3545 !important;
  }
  
  /* Pulsating animation for size warning */
  @keyframes pulse-warning {
    0% { opacity: 1; }
    50% { opacity: 0.7; }
    100% { opacity: 1; }
  }
  
  .alert-warning strong {
    animation: pulse-warning 2s infinite;
    display: inline-block;
  }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php if(config('app.debug')): ?>
<div class="debug-info" style="background:#f8f9fa; border:1px solid         <div class="image-upload">
          <div class="image-preview">
            <img src="https://via.placeholder.com/400x200" alt="Event Preview" id="event-image-preview">
            <label for="image" class="btn btn-outline change-image-btn">Choose Image</label>
            <input type="file" name="image" id="image" style="display: none;" 
                  class="<?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept=".jpg,.jpeg,.png,.gif">
            <div id="file-info" class="mt-2 file-info"></div>
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <span class="invalid-feedback"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <p class="text-muted">Upload an image to represent your event. Recommended size: 1200x600px. <strong>Supported formats: PNG, JPG, GIF (max 2MB)</strong></p>
        </div>g:15px; margin-bottom:20px; border-radius:5px; font-family:monospace; font-size:12px;">
  <h4>Debug Information (only visible in debug mode)</h4>
  <p>PHP Version: <?php echo e(phpversion()); ?></p>
  <p>Laravel Version: <?php echo e(app()->version()); ?></p>
  <p>Environment: <?php echo e(app()->environment()); ?></p>
  <p>Request Method: <?php echo e(request()->method()); ?></p>
  <p>User ID: <?php echo e(auth()->id()); ?></p>
</div>
<?php endif; ?>
<main class="create-event-page">
  <div class="container">
    <div class="page-header">
      <h1>Create New Event</h1>
      <p>Organize a gathering for your neighbors</p>
      <a href="<?php echo e(route('events.index')); ?>" class="back-link"><i class="fas fa-arrow-left"></i> Back to events</a>
    </div>
    
    <?php if($errors->any()): ?>
    <div class="alert alert-danger">
      <h4><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h4>
      <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
    <?php endif; ?>
    
    <?php if(session('error')): ?>
    <div class="alert alert-danger">
      <h4><i class="fas fa-exclamation-circle"></i> Error</h4>
      <p><?php echo e(session('error')); ?></p>
    </div>
    <?php endif; ?>
    
    <form class="event-form" method="POST" action="<?php echo e(route('events.store')); ?>" enctype="multipart/form-data" id="createEventForm">
      <?php echo csrf_field(); ?>
      <div class="form-progress">
        <div class="progress-bar">
          <div class="progress-fill" style="width: 0%"></div>
        </div>
        <div class="progress-steps">
          <span class="step active" data-step="1">Basic Info</span>
          <span class="step" data-step="2">Date & Time</span>
          <span class="step" data-step="3">Location</span>
          <span class="step" data-step="4">Details</span>
        </div>
      </div>
      <div class="form-section">
        <h2>Basic Information</h2>
        <div class="form-group">
          <label for="title" class="form-label required-indicator">Event Title</label>
          <input type="text" id="title" name="title" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                 placeholder="e.g. Block Party, Yard Sale" value="<?php echo e(old('title')); ?>" required>
          <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="invalid-feedback"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
          <label for="description" class="form-label required-indicator">Description</label>
          <textarea id="description" name="description" class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                    rows="4" placeholder="Tell neighbors what to expect..." required><?php echo e(old('description')); ?></textarea>
          <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="invalid-feedback"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="category" class="form-label required-indicator">Category</label>
            <select id="category" name="category" class="form-control <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
              <option value="">Select a category</option>
              <option value="Social" <?php echo e(old('category') == 'Social' ? 'selected' : ''); ?>>Social</option>
              <option value="Fundraiser" <?php echo e(old('category') == 'Fundraiser' ? 'selected' : ''); ?>>Fundraiser</option>
              <option value="Yard Sale" <?php echo e(old('category') == 'Yard Sale' ? 'selected' : ''); ?>>Yard Sale</option>
              <option value="Meeting" <?php echo e(old('category') == 'Meeting' ? 'selected' : ''); ?>>Meeting</option>
              <option value="Sports" <?php echo e(old('category') == 'Sports' ? 'selected' : ''); ?>>Sports</option>
              <option value="Other" <?php echo e(old('category') == 'Other' ? 'selected' : ''); ?>>Other</option>
            </select>
            <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <span class="invalid-feedback"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <div class="form-group">
            <label for="privacy" class="form-label">Privacy</label>
            <select id="privacy" name="privacy" class="form-control <?php $__errorArgs = ['privacy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
              <option value="public" <?php echo e(old('privacy') == 'public' ? 'selected' : ''); ?>>Public (Visible to all neighbors)</option>
              <option value="private" <?php echo e(old('privacy') == 'private' ? 'selected' : ''); ?>>Private (Invite only)</option>
            </select>
            <?php $__errorArgs = ['privacy'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <span class="invalid-feedback"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
        </div>
      </div>
      
      <div class="form-section">
        <h2>Date & Time</h2>
        <div class="form-row">
          <div class="form-group">
            <label for="start_date" class="form-label required-indicator">Date</label>
            <input type="date" id="start_date" name="start_date" class="form-control <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   value="<?php echo e(old('start_date', date('Y-m-d'))); ?>" required>
            <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <span class="invalid-feedback"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <div class="form-group">
            <label for="start_time" class="form-label required-indicator">Start Time</label>
            <input type="time" id="start_time" name="start_time" class="form-control <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   value="<?php echo e(old('start_time', '18:00')); ?>" required>
            <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <span class="invalid-feedback"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <div class="form-group">
            <label for="end_time" class="form-label">End Time</label>
            <input type="time" id="end_time" name="end_time" class="form-control <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                   value="<?php echo e(old('end_time')); ?>">
            <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <span class="invalid-feedback"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
        </div>

      </div>
      
      <div class="form-section">
        <h2>Location</h2>
        <div class="form-group">
          <label for="location" class="form-label">Address</label>
          <input type="text" id="location" name="location" class="form-control <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                 placeholder="Enter address or select below" value="<?php echo e(old('location')); ?>" required>
          <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="invalid-feedback"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="location-options">
          <button type="button" class="location-option" data-location="<?php echo e(Auth::user()->address); ?>">
            <span>🏠</span>
            <span>My Home</span>
          </button>
          <button type="button" class="location-option">
            <span>🏞️</span>
            <span>Park</span>
          </button>
          <button type="button" class="location-option">
            <span>🏢</span>
            <span>Community Center</span>
          </button>
          <button type="button" class="location-option">
            <span>📍</span>
            <span>Other</span>
          </button>
        </div>
        <div class="form-group mt-2">
          <label for="location_details" class="form-label">Location Details</label>
          <textarea id="location_details" name="location_details" class="form-control <?php $__errorArgs = ['location_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                    rows="2" placeholder="Additional details like which park, room number, etc."><?php echo e(old('location_details')); ?></textarea>
          <?php $__errorArgs = ['location_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class="invalid-feedback"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
      </div>
      
      <div class="form-section">
        <h2>Event Image</h2>
        <div class="image-upload">
          <div class="upload-preview">
            <img src="https://via.placeholder.com/400x200" alt="Event Preview" id="event-image-preview">
            <label for="image" class="btn btn-outline change-image-btn">Change Image</label>
            <input type="file" name="image" id="image" style="display: none;" 
                  class="<?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                  accept="image/jpeg,image/jpg,image/png,image/gif"
                  data-max-size="2097152"> <!-- 2MB in bytes -->
            <div id="file-info" class="mt-2 file-info text-muted small"></div>
            <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <span class="invalid-feedback"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div id="image-error-message" class="invalid-feedback" style="display: none;"></div>
          </div>
          <div class="file-restrictions mt-2">
            <p class="text-muted">Upload an image to represent your event.</p>
            <div class="alert alert-warning">
              <strong>File Size Restriction:</strong> Maximum file size is strictly limited to 2MB.
              Larger files will be automatically rejected.
            </div>
            <ul class="text-muted small">
              <li>Recommended size: 1200x600px</li> 
              <li>Supported formats: JPG, PNG, GIF</li>
              <li><strong>Maximum file size: 2MB</strong></li>
            </ul>
          </div>
        </div>
      </div>
      
      <div class="form-section">
        <h2>Additional Options</h2>
        <div class="form-group">
          <label for="max_attendees">Maximum Attendees</label>
          <input type="number" id="max_attendees" name="max_attendees" value="<?php echo e(old('max_attendees')); ?>" min="1" class="form-control">
          <small class="form-text text-muted">Leave empty for unlimited attendees.</small>
        </div>
        <div class="form-check">
          <input type="checkbox" id="is_public" name="is_public" class="form-check-input" value="1" 
                <?php echo e(old('is_public', true) ? 'checked' : ''); ?>>
          <label for="is_public" class="form-check-label">Public Event</label>
          <small class="form-text text-muted d-block">Public events can be shared and are visible to everyone in the community.</small>
        </div>
        <div class="form-check">
          <input type="checkbox" id="rsvp_enabled" name="rsvp_enabled" class="form-check-input" value="1"
                <?php echo e(old('rsvp_enabled', true) ? 'checked' : ''); ?>>
          <label for="rsvp_enabled" class="form-check-label">Enable RSVPs</label>
          <small class="form-text text-muted d-block">Allow users to RSVP to this event.</small>
        </div>
      </div>
      
      <div class="form-actions">
        <a href="<?php echo e(route('events.index')); ?>" class="btn btn-outline">Cancel</a>
        <button type="submit" class="btn btn-primary" id="submitEventBtn">
          <i class="fas fa-calendar-plus"></i> Create Event
        </button>
      </div>
      
      
      <input type="hidden" name="form_debug" value="1">
      <input type="hidden" name="csrf_token" value="<?php echo e(csrf_token()); ?>">
    </form>
    
    
    <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.8); z-index: 9999; justify-content: center; align-items: center; flex-direction: column;">
      <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="mt-3">Creating your event...</p>
    </div>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('createEventForm');
  const formSections = document.querySelectorAll('.form-section');
  const progressSteps = document.querySelectorAll('.step');
  const progressFill = document.querySelector('.progress-fill');
  
  // Initialize form submission handler
  form.addEventListener('submit', function(event) {
    // Perform file size check first before other validations
    const imageInput = document.getElementById('image');
    if (imageInput.files.length > 0) {
      const file = imageInput.files[0];
      const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB
      
      if (file.size > MAX_FILE_SIZE) {
        event.preventDefault();
        
        // Format file size for display
        const fileSizeKB = file.size / 1024;
        const fileSizeMB = fileSizeKB / 1024;
        const fileSizeFormatted = fileSizeMB >= 1 ? 
          fileSizeMB.toFixed(2) + ' MB' : 
          fileSizeKB.toFixed(2) + ' KB';
        
        // Create an error alert
        const errorContainer = document.querySelector('.image-upload');
        const existingAlert = errorContainer.querySelector('.alert-danger');
        
        // Remove existing alert if any
        if (existingAlert) {
          existingAlert.remove();
        }
        
        const errorAlert = document.createElement('div');
        errorAlert.className = 'alert alert-danger';
        errorAlert.innerHTML = `
          <strong>Cannot Submit Form - File Too Large!</strong>
          <p>Your image (${fileSizeFormatted}) exceeds the maximum size limit of 2MB.</p>
          <p>Please resize your image or choose a smaller file before submitting.</p>
        `;
        
        errorContainer.prepend(errorAlert);
        
        // Scroll to the error message
        errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        return false;
      }
    }
    
    // Form validation
    const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;
    let firstInvalidField = null;
    const errors = [];
    
    // Reset all validation states
    form.querySelectorAll('.is-invalid').forEach(field => {
      field.classList.remove('is-invalid');
    });
    
    // Check required fields
    requiredFields.forEach(field => {
      if (!field.value.trim()) {
        isValid = false;
        field.classList.add('is-invalid');
        if (!firstInvalidField) {
          firstInvalidField = field;
        }
        errors.push(`Field ${field.name || field.id} is required`);
      } else {
        field.classList.remove('is-invalid');
      }
    });
    
    // Validate image if selected
    const imageInput = document.getElementById('image');
    if (imageInput.files.length > 0) {
      const file = imageInput.files[0];
      const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
      const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB
      const fileSizeKB = file.size / 1024;
      const fileSizeMB = fileSizeKB / 1024;
      const fileSizeFormatted = fileSizeMB >= 1 ? 
        fileSizeMB.toFixed(2) + ' MB' : 
        fileSizeKB.toFixed(2) + ' KB';
      
      // Double-check file type
      if (!validTypes.includes(file.type.toLowerCase())) {
        isValid = false;
        imageInput.classList.add('is-invalid');
        document.getElementById('image-error-message').textContent = 'Please select a valid image file (JPG, PNG, or GIF)';
        document.getElementById('image-error-message').style.display = 'block';
        errors.push(`Invalid image type: ${file.type}`);
        
        if (!firstInvalidField) {
          firstInvalidField = imageInput;
        }
      }
      
      // Triple check file size as a final validation
      if (file.size > MAX_FILE_SIZE) {
        isValid = false;
        imageInput.classList.add('is-invalid');
        document.getElementById('image-error-message').textContent = `File size limit exceeded: ${fileSizeFormatted} (max: 2MB)`;
        document.getElementById('image-error-message').style.display = 'block';
        errors.push(`File too large: ${fileSizeFormatted}`);
        
        if (!firstInvalidField) {
          firstInvalidField = imageInput;
        }
        
        // Add a critical error message to the top of the form
        const formTop = document.querySelector('.page-header');
        const criticalError = document.createElement('div');
        criticalError.className = 'alert alert-danger alert-dismissible fade show';
        criticalError.innerHTML = `
          <strong>Error: File Size Limit Exceeded</strong>
          <p>Your image (${fileSizeFormatted}) is too large. Maximum allowed size is 2MB.</p>
          <p>Please resize your image or select a smaller file.</p>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        formTop.after(criticalError);
        
        // Clear the file input
        imageInput.value = '';
        
        // Prevent form submission
        event.preventDefault();
        return false;
      }
      
      // Log JPG file info specifically to debug any issues
      if (file.type.toLowerCase() === 'image/jpeg' || file.type.toLowerCase() === 'image/jpg') {
        console.log('JPG file details before submission:', {
          name: file.name,
          type: file.type,
          size: file.size,
          sizeFormatted: fileSizeFormatted,
          lastModified: new Date(file.lastModified).toISOString()
        });
      }
    }
    
    // Validate date logic
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date')?.value;
    
    if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
      isValid = false;
      const endDateField = document.getElementById('end_date');
      endDateField.classList.add('is-invalid');
      
      const errorMsg = endDateField.nextElementSibling || document.createElement('span');
      errorMsg.className = 'invalid-feedback';
      errorMsg.textContent = 'End date cannot be before start date';
      
      if (!endDateField.nextElementSibling) {
        endDateField.parentNode.appendChild(errorMsg);
      }
      
      errors.push('End date cannot be before start date');
      
      if (!firstInvalidField) {
        firstInvalidField = endDateField;
      }
    }
    
    if (!isValid) {
      event.preventDefault();
      if (firstInvalidField) {
        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
        firstInvalidField.focus();
      }
      
      console.error('Form validation failed:', errors);
      alert('Please fix the errors in the form before submitting.');
      return false;
    }
    
    // If form is valid, show loading overlay and disable submit button
    document.getElementById('submitEventBtn').disabled = true;
    document.getElementById('submitEventBtn').innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...';
    document.getElementById('loading-overlay').style.display = 'flex';
    console.log('Form submission started');
  });
  
  // Calculate form progress based on filled fields
  function updateFormProgress() {
    let totalFields = 0;
    let filledFields = 0;
    
    // Count required fields
    const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
    totalFields = requiredFields.length;
    
    // Count filled required fields
    requiredFields.forEach(field => {
      if (field.value.trim() !== '') {
        filledFields++;
      }
    });
    
    // Update progress bar
    const progress = totalFields > 0 ? (filledFields / totalFields) * 100 : 0;
    progressFill.style.width = `${progress}%`;
    
    // Update steps
    progressSteps.forEach((step, index) => {
      const stepProgress = (index + 1) / progressSteps.length;
      if (progress >= stepProgress * 100) {
        step.classList.add('complete');
      } else {
        step.classList.remove('complete');
      }
    });
  }
  
  // Monitor form field changes
  form.addEventListener('input', function() {
    updateFormProgress();
  });
  
  // Initial progress calculation
  setTimeout(updateFormProgress, 100);
  
  // Step navigation
  progressSteps.forEach(step => {
    step.addEventListener('click', function() {
      const stepNum = parseInt(this.getAttribute('data-step'));
      const targetSection = document.querySelector(`.form-section:nth-child(${stepNum + 1})`);
      
      if (targetSection) {
        // Smooth scroll to section
        window.scrollTo({
          top: targetSection.offsetTop - 100,
          behavior: 'smooth'
        });
        
        // Update active step
        progressSteps.forEach(s => s.classList.remove('active'));
        this.classList.add('active');
      }
    });
  });
});
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
  // Preview uploaded image with enhanced validation
  document.getElementById('image').addEventListener('change', function(e) {
    const preview = document.getElementById('event-image-preview');
    const file = e.target.files[0];
    const reader = new FileReader();
    const fileInfoElement = document.getElementById('file-info');
    const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2MB in bytes
    
    // Check if there's an error display element, if not, create one
    let errorMsg = document.getElementById('image-error-message');
    if (!errorMsg) {
      errorMsg = document.createElement('div');
      errorMsg.id = 'image-error-message';
      errorMsg.className = 'invalid-feedback';
      errorMsg.style.display = 'none';
      this.parentNode.appendChild(errorMsg);
    }
    
    // Reset error message and file info
    errorMsg.textContent = '';
    errorMsg.style.display = 'none';
    fileInfoElement.innerHTML = '';
    
    if (!file) {
      preview.src = 'https://via.placeholder.com/400x200?text=No+Image+Selected';
      return;
    }
    
    // Log file information for debugging
    console.log('File selected:', file.name, 'Size:', file.size, 'Type:', file.type);
    
    // Format the file size for display
    const fileSizeKB = file.size / 1024;
    const fileSizeMB = fileSizeKB / 1024;
    const fileSizeFormatted = fileSizeMB >= 1 ? 
      fileSizeMB.toFixed(2) + ' MB' : 
      fileSizeKB.toFixed(2) + ' KB';
    
    // Early, aggressive file size check - immediately reject files over 2MB
    if (file.size > MAX_FILE_SIZE) {
      // Create a prominent error alert
      const errorAlert = document.createElement('div');
      errorAlert.className = 'alert alert-danger mt-3';
      errorAlert.innerHTML = `
        <strong>File Too Large!</strong> 
        <p>Your image (${fileSizeFormatted}) exceeds the maximum size limit of 2MB.</p>
        <p>Please resize your image or choose a smaller file.</p>
      `;
      
      // Insert error alert before the file info element
      fileInfoElement.parentNode.insertBefore(errorAlert, fileInfoElement);
      
      // Show file info with error highlighting
      fileInfoElement.innerHTML = `
        <div class="text-danger">
          <strong>File:</strong> ${file.name}<br>
          <strong>Size:</strong> ${fileSizeFormatted} <span class="badge bg-danger">Too Large</span><br>
          <strong>Type:</strong> ${file.type}
        </div>
      `;
      
      // Clear the file input to force the user to select another file
      this.value = '';
      
      // Display default image with error message
      preview.src = 'https://via.placeholder.com/400x200?text=File+Too+Large';
      
      // Set a timeout to remove the alert after 10 seconds
      setTimeout(() => {
        if (errorAlert.parentNode) {
          errorAlert.parentNode.removeChild(errorAlert);
        }
      }, 10000);
      
      return;
    }
      }
      
    // Show file info for valid files
    fileInfoElement.innerHTML = `
      <div class="file-info-container">
        <strong>File:</strong> ${file.name}<br>
        <strong>Size:</strong> ${fileSizeFormatted} <span class="badge bg-success">✓ OK</span><br>
        <strong>Type:</strong> ${file.type}
      </div>
    `;
    
    // Validate file type explicitly
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
    const fileType = file.type.toLowerCase();
    
    if (!validTypes.includes(fileType)) {
      errorMsg.textContent = 'Please select a valid image file (JPG, PNG, or GIF)';
      errorMsg.style.display = 'block';
      fileInfoElement.innerHTML += '<div class="text-danger mt-1">❌ Invalid file type</div>';
      this.value = ''; // Clear the input
      return;
    }
    
    // Show loading state
    preview.src = 'https://via.placeholder.com/400x200?text=Loading...';
    
    reader.onload = function() {
      preview.src = reader.result;
      
      // Second validation with the actual image data
      const img = new Image();
      img.onload = function() {
        // Check dimensions
        if (img.width < 400 || img.height < 200) {
          fileInfoElement.innerHTML += '<div class="text-warning mt-1">⚠️ Image is smaller than recommended size (1200x600px)</div>';
        }
      };
      img.src = reader.result;
    }
      
      reader.onerror = function() {
        errorMsg.textContent = 'Error reading file';
        errorMsg.style.display = 'block';
        preview.src = 'https://via.placeholder.com/400x200?text=Error';
      }
      
      reader.readAsDataURL(file);
    }
  });
  
  // Location options quick select
  document.querySelectorAll('.location-option').forEach(button => {
    button.addEventListener('click', function() {
      // Remove active class from all buttons
      document.querySelectorAll('.location-option').forEach(btn => {
        btn.classList.remove('active');
      });
      
      // Add active class to clicked button
      this.classList.add('active');
      
      // Set location value if data-location is provided
      const location = this.getAttribute('data-location');
      if (location) {
        document.getElementById('location').value = location;
      }
    });
  });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\Projects\herd-laravel\neighbournet-laravel\resources\views/events/create.blade.php ENDPATH**/ ?>