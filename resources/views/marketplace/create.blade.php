@extends('layouts.app')

@section('title', 'Post an Item - Marketplace')

@section('styles')
<style>
  :root {
    --primary-color: #4a6fa5;
    --primary-light: #eef2f8;
    --primary-dark: #3a5a8c;
    --accent-color: #47b475;
    --danger-color: #dc3545;
    --border-color: #e1e4e8;
    --text-muted: #6c757d;
    --card-shadow: 0 2px 15px rgba(0,0,0,0.08);
    --transition-speed: 0.2s;
  }

  .marketplace-form {
    padding: 2rem 0;
    background-color: #f8f9fa;
  }

  .form-container {
    background-color: white;
    border-radius: 12px;
    box-shadow: var(--card-shadow);
    padding: 2rem;

  .form-header {
    margin-bottom: 2rem;
    text-align: center;
  }

  .form-header h1 {
    margin-bottom: 0.5rem;
    color: var(--primary-color);
    font-weight: 700;
  }

  .form-section {
    margin-bottom: 2.5rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--border-color);
  }

  .form-section:last-child {
    border-bottom: none;
  }

  .form-section h2 {
    margin-bottom: 1.25rem;
    font-size: 1.4rem;
    font-weight: 600;
    color: var(--text-dark);
  }

  .form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
    margin-bottom: 1.5rem;
  }

  @media (min-width: 768px) {
    .form-row {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  .form-group {
    margin-bottom: 1.5rem;
  }

  .form-label {
    display: block;
    margin-bottom: 0.75rem;
    font-weight: 500;
    color: var(--text-dark);
  }

  .required-indicator::after {
    content: "*";
    color: var(--danger-color);
    margin-left: 0.25rem;
  }

  .form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 1rem;
    transition: all var(--transition-speed);
    background-color: #f9f9f9;
  }

  .form-control:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 3px rgba(74, 111, 165, 0.2);
    background-color: white;
  }

  .is-invalid {
    border-color: var(--danger-color);
  }

  .invalid-feedback {
    color: var(--danger-color);
    font-size: 0.875rem;
    margin-top: 0.25rem;
  }

  .form-text {
    font-size: 0.875rem;
    color: var(--text-muted);
    margin-top: 0.25rem;
  }

  .upload-container {
    border: 2px dashed var(--border-color);
    border-radius: 12px;
    padding: 2.5rem 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all var(--transition-speed);
    background-color: #f9f9f9;
    position: relative;
  }

  .upload-container:hover {
    border-color: var(--primary-color);
    background-color: var(--primary-light);
  }

  .upload-icon {
    font-size: 3rem;
    margin-bottom: 1.25rem;
    color: var(--primary-color);
    opacity: 0.7;
    transition: all var(--transition-speed);
  }
  
  .upload-container:hover .upload-icon {
    opacity: 1;
    transform: scale(1.1);
  }

  .image-preview-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1.25rem;
    margin-top: 1.5rem;
  }

  .image-preview {
    position: relative;
    height: 150px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
  }
  
  .image-preview:hover {
    transform: translateY(-3px);
  }

  .image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }
  
  .image-preview:hover img {
    transform: scale(1.08);
  }

  .image-remove {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: rgba(0,0,0,0.6);
    color: white;
    border: none;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.2s ease;
  }
  
  .image-preview:hover .image-remove {
    opacity: 1;
  }

  .item-type-options {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  @media (min-width: 768px) {
    .item-type-options {
      grid-template-columns: repeat(4, 1fr);
    }
  }

  .item-type-option {
    padding: 1.25rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    text-align: center;
    cursor: pointer;
    transition: all var(--transition-speed);
    position: relative;
    overflow: hidden;
    background-color: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  }

  .item-type-option:hover {
    border-color: var(--primary-color);
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transform: translateY(-2px);
  }

  .item-type-option.active {
    border-color: var(--primary-color);
    background-color: var(--primary-light);
    box-shadow: 0 5px 15px rgba(74, 111, 165, 0.15);
  }

  .item-type-option.active::before {
    content: '✓';
    position: absolute;
    top: 10px;
    right: 10px;
    width: 20px;
    height: 20px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .item-type-icon {
    font-size: 2rem;
    margin-bottom: 0.75rem;
    transition: all var(--transition-speed);
  }
  
  .item-type-option:hover .item-type-icon {
    transform: scale(1.1);
  }
  
  .item-type-name {
    font-weight: 600;
    color: #444;
  }

  .form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
  }
</style>
@endsection

@section('content')
<main class="marketplace-form">
  <div class="container">
    <div class="back-link mb-3">
      <a href="{{ route('marketplace.index') }}" class="text-decoration-none" id="back-to-marketplace"><i class="fas fa-arrow-left me-1"></i> Back to Marketplace</a>
    </div>
    
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="form-container">
          <div class="form-header">
            <h1>Post an Item</h1>
            <p class="text-muted">Share items with your neighbors for sale, rent, trade, or free</p>
          </div>
          
          @if ($errors->any())
            <div class="alert alert-danger mb-4">
              <h4 class="d-flex align-items-center"><i class="fas fa-exclamation-triangle me-2"></i> Please fix the following errors:</h4>
              <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          
          <form action="{{ route('marketplace.store') }}" method="POST" enctype="multipart/form-data" id="marketplace-form">
        @csrf
        
        <div class="form-section">
          <h2>Item Type</h2>
          <p class="form-text mb-3">What would you like to do with this item?</p>
          
          <div class="item-type-options">
            <div class="item-type-option @if(old('type', 'for-sale') == 'for-sale') active @endif" data-type="for-sale">
              <div class="item-type-icon">
                <i class="fas fa-tags"></i>
              </div>
              <div class="item-type-name">For Sale</div>
            </div>
            <div class="item-type-option @if(old('type') == 'free') active @endif" data-type="free">
              <div class="item-type-icon">
                <i class="fas fa-gift"></i>
              </div>
              <div class="item-type-name">Free</div>
            </div>
            <div class="item-type-option @if(old('type') == 'rent') active @endif" data-type="rent">
              <div class="item-type-icon">
                <i class="fas fa-clock"></i>
              </div>
              <div class="item-type-name">To Rent</div>
            </div>
            <div class="item-type-option @if(old('type') == 'wanted') active @endif" data-type="wanted">
              <div class="item-type-icon">
                <i class="fas fa-search"></i>
              </div>
              <div class="item-type-name">Wanted</div>
            </div>
          </div>
          <input type="hidden" name="type" id="type-input" value="{{ old('type', 'for-sale') }}">
        </div>
        
        <div class="form-section">
          <h2>Item Details</h2>
          
          <div class="form-group">
            <label for="title" class="form-label required-indicator">Title</label>
            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                  value="{{ old('title') }}" required placeholder="e.g. Wooden Dining Table">
            @error('title')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="form-row">
            <div class="form-group">
              <label for="category" class="form-label required-indicator">Category</label>
              <select id="category" name="category" class="form-control @error('category') is-invalid @enderror" required>
                <option value="">Select a category</option>
                <option value="furniture" @if(old('category') == 'furniture') selected @endif>Furniture</option>
                <option value="electronics" @if(old('category') == 'electronics') selected @endif>Electronics</option>
                <option value="clothing" @if(old('category') == 'clothing') selected @endif>Clothing</option>
                <option value="tools" @if(old('category') == 'tools') selected @endif>Tools</option>
                <option value="toys" @if(old('category') == 'toys') selected @endif>Toys</option>
                <option value="books" @if(old('category') == 'books') selected @endif>Books</option>
                <option value="sports" @if(old('category') == 'sports') selected @endif>Sports</option>
                <option value="other" @if(old('category') == 'other') selected @endif>Other</option>
              </select>
              @error('category')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            
            <div class="form-group" id="price-group">
              <label for="price" class="form-label required-indicator">Price</label>
              <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" 
                      value="{{ old('price') }}" min="0" step="0.01" required>
              </div>
              @error('price')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
              <span class="form-text price-hint for-sale">Set a fair price for your item</span>
              <span class="form-text price-hint rent" style="display: none;">Price per day</span>
              <span class="form-text price-hint wanted" style="display: none;">Your budget for this item</span>
            </div>
          </div>
          
          <div class="form-group">
            <label for="description" class="form-label required-indicator">Description</label>
            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" 
                      rows="5" required placeholder="Describe your item (condition, features, why you're selling it, etc.)">{{ old('description') }}</textarea>
            @error('description')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="form-row">
            <div class="form-group">
              <label for="condition" class="form-label">Condition</label>
              <select id="condition" name="condition" class="form-control @error('condition') is-invalid @enderror">
                <option value="">Select condition</option>
                <option value="new" @if(old('condition') == 'new') selected @endif>New</option>
                <option value="like-new" @if(old('condition') == 'like-new') selected @endif>Like New</option>
                <option value="good" @if(old('condition') == 'good') selected @endif>Good</option>
                <option value="fair" @if(old('condition') == 'fair') selected @endif>Fair</option>
                <option value="poor" @if(old('condition') == 'poor') selected @endif>Poor</option>
              </select>
              @error('condition')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            
            <div class="form-group">
              <label for="brand" class="form-label">Brand (optional)</label>
              <input type="text" id="brand" name="brand" class="form-control @error('brand') is-invalid @enderror" 
                    value="{{ old('brand') }}" placeholder="e.g. IKEA, Samsung, etc.">
              @error('brand')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </div>
        
        <div class="form-section">
          <h2>Images</h2>
          <p class="form-text mb-3">Add up to 5 images of your item. First image will be the main image.</p>
          
          <div class="upload-container" id="image-upload">
            <div class="upload-icon">
              <i class="fas fa-cloud-upload-alt"></i>
            </div>
            <div class="upload-text">
              <strong>Click or drag images here</strong>
              <p class="form-text">JPG, PNG or GIF, max 5MB per image</p>
            </div>
            <input type="file" id="images" name="images[]" style="display: none;" multiple accept="image/jpeg,image/png,image/gif">
          </div>
          
          @error('images')
            <span class="invalid-feedback d-block mt-2">{{ $message }}</span>
          @enderror
          
          @error('images.*')
            <span class="invalid-feedback d-block mt-2">{{ $message }}</span>
          @enderror
          
          <div class="image-preview-container mt-3" id="image-previews"></div>
        </div>
        
        <div class="form-section">
          <h2>Location</h2>
          
          <div class="form-group">
            <label for="location" class="form-label required-indicator">Location</label>
            <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" 
                  value="{{ old('location') }}" required placeholder="Enter an approximate location (neighborhood, block, etc.)">
            @error('location')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <span class="form-text">For your safety, don't provide your exact address. We'll show an approximate location to other users.</span>
          </div>
          
          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" id="hide_location" name="hide_location" class="form-check-input" value="1" 
                    {{ old('hide_location') ? 'checked' : '' }}>
              <label for="hide_location" class="form-check-label">Only show approximate location to interested buyers</label>
              <small class="form-text text-muted d-block">Your exact location will be hidden until you choose to share it.</small>
            </div>
          </div>
        </div>
        
        <div class="form-section">
          <h2>Contact Preferences</h2>
          
          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" id="contact_message" name="contact_message" class="form-check-input" value="1" 
                    {{ old('contact_message', true) ? 'checked' : '' }}>
              <label for="contact_message" class="form-check-label">Allow users to contact me through NeighbourNet messages</label>
            </div>
          </div>
          
          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" id="contact_phone" name="contact_phone" class="form-check-input" value="1" 
                    {{ old('contact_phone') ? 'checked' : '' }}>
              <label for="contact_phone" class="form-check-label">Allow users to request my phone number</label>
              <small class="form-text text-muted d-block">Your phone number will only be shared if you approve a request.</small>
            </div>
          </div>
        </div>
        
        <div class="form-actions">
          <a href="{{ route('marketplace.index') }}" class="btn btn-outline-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary" id="submit-btn">
            <i class="fas fa-plus-circle me-1"></i> Post Item
          </button>
        </div>
      </form>
    </div>
  </div>
</main>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Item type selection
    const typeOptions = document.querySelectorAll('.item-type-option');
    const typeInput = document.getElementById('type-input');
    const priceGroup = document.getElementById('price-group');
    const priceInput = document.getElementById('price');
    const priceHints = document.querySelectorAll('.price-hint');
    
    typeOptions.forEach(option => {
      option.addEventListener('click', function() {
        // Remove active class from all options
        typeOptions.forEach(opt => opt.classList.remove('active'));
        
        // Add active class to clicked option
        this.classList.add('active');
        
        // Set the hidden input value
        const type = this.dataset.type;
        typeInput.value = type;
        
        // Handle price field based on type
        if (type === 'free') {
          priceGroup.style.display = 'none';
          priceInput.required = false;
          priceInput.value = 0;
        } else {
          priceGroup.style.display = 'block';
          priceInput.required = true;
          
          // Hide all price hints
          priceHints.forEach(hint => hint.style.display = 'none');
          
          // Show relevant price hint
          const relevantHint = document.querySelector(`.price-hint.${type}`);
          if (relevantHint) {
            relevantHint.style.display = 'block';
          } else {
            document.querySelector('.price-hint.for-sale').style.display = 'block';
          }
        }
      });
    });
    
    // Initialize type selection if we have a previously selected value
    if (typeInput.value) {
      const selectedOption = document.querySelector(`.item-type-option[data-type="${typeInput.value}"]`);
      if (selectedOption) {
        selectedOption.click();
      }
    }
    
    // Image upload
    const uploadContainer = document.getElementById('image-upload');
    const imagesInput = document.getElementById('images');
    const previewsContainer = document.getElementById('image-previews');
    
    if (uploadContainer && imagesInput && previewsContainer) {
      uploadContainer.addEventListener('click', function() {
        imagesInput.click();
      });
      
      uploadContainer.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-primary');
        this.style.backgroundColor = 'var(--primary-light)';
      });
      
      uploadContainer.addEventListener('dragleave', function() {
        this.classList.remove('border-primary');
        this.style.backgroundColor = '';
      });
      
      uploadContainer.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-primary');
        this.style.backgroundColor = '';
        
        if (e.dataTransfer.files.length) {
          imagesInput.files = e.dataTransfer.files;
          handleImageFiles(e.dataTransfer.files);
        }
      });
      
      imagesInput.addEventListener('change', function() {
        handleImageFiles(this.files);
      });
    }
    
    function handleImageFiles(files) {
      if (!files || !files.length) return;
      
      if (files.length > 5) {
        // Show more user-friendly error
        const errorMsg = document.createElement('div');
        errorMsg.className = 'alert alert-danger mt-2';
        errorMsg.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i> You can upload a maximum of 5 images.';
        previewsContainer.parentNode.insertBefore(errorMsg, previewsContainer);
        
        setTimeout(() => {
          errorMsg.remove();
        }, 5000);
        
        imagesInput.value = '';
        return;
      }
      
      previewsContainer.innerHTML = '';
      uploadContainer.classList.add('border-success');
      
      let validFiles = 0;
      const errors = [];
      
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        
        // Validate file type
        if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
          errors.push(`${file.name} is not a supported image type (use JPG, PNG, or GIF).`);
          continue;
        }
        
        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
          errors.push(`${file.name} exceeds the 5MB size limit.`);
          continue;
        }
        
        validFiles++;
        
        const reader = new FileReader();
        reader.onload = function(e) {
          const previewDiv = document.createElement('div');
          previewDiv.className = 'image-preview';
          
          const img = document.createElement('img');
          img.src = e.target.result;
          
          const removeBtn = document.createElement('button');
          removeBtn.className = 'image-remove';
          removeBtn.innerHTML = '<i class="fas fa-times"></i>';
          removeBtn.setAttribute('type', 'button');
          removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            previewDiv.remove();
            
            // Check if no previews left
            if (previewsContainer.children.length === 0) {
              uploadContainer.classList.remove('border-success');
            }
          });
          
          // Add main image indicator for first image
          if (i === 0) {
            const mainBadge = document.createElement('span');
            mainBadge.className = 'position-absolute top-0 start-0 bg-primary text-white rounded-pill m-2 px-2 py-1';
            mainBadge.style.fontSize = '0.75rem';
            mainBadge.style.fontWeight = '600';
            mainBadge.innerHTML = '<i class="fas fa-star me-1"></i> Main Image';
            previewDiv.appendChild(mainBadge);
          }
          
          previewDiv.appendChild(img);
          previewDiv.appendChild(removeBtn);
          previewsContainer.appendChild(previewDiv);
        };
        
        reader.readAsDataURL(file);
      }
      
      // Display any errors
      if (errors.length > 0) {
        const errorContainer = document.createElement('div');
        errorContainer.className = 'alert alert-warning mt-3';
        
        const errorTitle = document.createElement('h5');
        errorTitle.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i> The following issues were found:';
        errorContainer.appendChild(errorTitle);
        
        const errorList = document.createElement('ul');
        errorList.className = 'mb-0 mt-2';
        errors.forEach(error => {
          const li = document.createElement('li');
          li.textContent = error;
          errorList.appendChild(li);
        });
        errorContainer.appendChild(errorList);
        
        previewsContainer.parentNode.insertBefore(errorContainer, previewsContainer.nextSibling);
        
        setTimeout(() => {
          errorContainer.remove();
        }, 7000);
      }
      
      if (validFiles === 0) {
        uploadContainer.classList.remove('border-success');
      }
    }
    
    // Form validation
    const form = document.getElementById('marketplace-form');
    const submitBtn = document.getElementById('submit-btn');
    
    // Add visual feedback when fields are filled correctly
    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
      field.addEventListener('blur', function() {
        if (this.value.trim()) {
          this.classList.remove('is-invalid');
          this.classList.add('border-success');
        } else {
          this.classList.remove('border-success');
        }
      });
    });
    
    form.addEventListener('submit', function(e) {
      let isValid = true;
      let errorSummary = [];
      
      // Check all required fields
      requiredFields.forEach(field => {
        const label = field.previousElementSibling ? field.previousElementSibling.textContent.trim() : 'Field';
        
        if (!field.value.trim()) {
          isValid = false;
          field.classList.add('is-invalid');
          field.classList.remove('border-success');
          
          // Create error message if it doesn't exist
          if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
            const errorMessage = document.createElement('span');
            errorMessage.className = 'invalid-feedback';
            errorMessage.textContent = 'This field is required';
            field.parentNode.insertBefore(errorMessage, field.nextElementSibling);
          }
          
          errorSummary.push(`${label} is required`);
        } else {
          field.classList.remove('is-invalid');
        }
      });
      
      // Validate image upload for better user experience
      if (previewsContainer && previewsContainer.children.length === 0) {
        // Non-blocking warning for images
        const warningEl = document.createElement('div');
        warningEl.className = 'alert alert-warning mt-3';
        warningEl.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i> No images selected. Images help your item get noticed!';
        uploadContainer.parentNode.insertBefore(warningEl, uploadContainer.nextSibling);
        
        setTimeout(() => {
          warningEl.remove();
        }, 5000);
      }
      
      if (!isValid) {
        e.preventDefault();
        
        // Show error summary at the top
        const errorAlert = document.createElement('div');
        errorAlert.className = 'alert alert-danger mb-4 animate__animated animate__shakeX';
        
        let errorHTML = `<h5><i class="fas fa-exclamation-triangle me-2"></i> Please fix the following errors:</h5><ul class="mb-0 mt-2">`;
        errorSummary.forEach(error => {
          errorHTML += `<li>${error}</li>`;
        });
        errorHTML += '</ul>';
        
        errorAlert.innerHTML = errorHTML;
        form.prepend(errorAlert);
        
        // Scroll to first invalid field with smooth animation
        const firstInvalid = form.querySelector('.is-invalid');
        if (firstInvalid) {
          firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
          setTimeout(() => {
            firstInvalid.focus();
          }, 500);
        }
        
        // Remove error summary after a while
        setTimeout(() => {
          errorAlert.remove();
        }, 8000);
        
        return false;
      }
      
      // Show loading state and disable button to prevent double submission
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Posting Item...';
    });
    
    // Optimize back to marketplace navigation
    const backButton = document.getElementById('back-to-marketplace');
    if (backButton) {
      backButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Save form state if needed
        localStorage.setItem('marketplace_form_state', JSON.stringify({
          timeLeft: new Date().getTime(),
          fields: {}
        }));
        
        // Show loading indicator in the button
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Going back...';
        
        // Use fetch to preload the marketplace page in the background
        fetch('{{ route("marketplace.index") }}')
          .then(() => {
            // Navigate to the marketplace after a small delay
            window.location.href = '{{ route("marketplace.index") }}';
          })
          .catch(() => {
            // If fetch fails, navigate directly
            window.location.href = '{{ route("marketplace.index") }}';
          });
      });
    }
  });
</script>
@endsection
