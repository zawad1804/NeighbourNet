@extends('layouts.app')

@section('title', 'Edit Item - Marketplace')

@section('styles')
<style>
  .marketplace-form {
    padding: 2rem 0;
  }

  .form-container {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 2rem;
  }

  .form-header {
    margin-bottom: 1.5rem;
  }

  .form-header h1 {
    margin-bottom: 0.5rem;
  }

  .form-section {
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid var(--border-color);
  }

  .form-section:last-child {
    border-bottom: none;
  }

  .form-section h2 {
    margin-bottom: 1rem;
    font-size: 1.3rem;
  }

  .form-row {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1rem;
    margin-bottom: 1rem;
  }

  @media (min-width: 768px) {
    .form-row {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  .form-group {
    margin-bottom: 1rem;
  }

  .form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
  }

  .required-indicator::after {
    content: "*";
    color: red;
    margin-left: 0.25rem;
  }

  .form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    font-size: 1rem;
  }

  .form-control:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 2px rgba(var(--primary-rgb), 0.25);
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
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s;
  }

  .upload-container:hover {
    border-color: var(--primary-color);
  }

  .upload-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--text-muted);
  }

  .image-preview-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
  }

  .image-preview {
    position: relative;
    height: 150px;
    border-radius: 4px;
    overflow: hidden;
  }

  .image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .image-remove {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: rgba(0,0,0,0.5);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    font-size: 14px;
    cursor: pointer;
  }

  .existing-image {
    border: 2px solid var(--border-color);
  }

  .existing-image.is-main {
    border-color: var(--primary-color);
  }

  .main-image-badge {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
  }

  .item-type-options {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 1rem;
  }

  @media (min-width: 768px) {
    .item-type-options {
      grid-template-columns: repeat(4, 1fr);
    }
  }

  .item-type-option {
    padding: 1rem;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
  }

  .item-type-option:hover {
    border-color: var(--primary-color);
    background-color: var(--bg-light);
  }

  .item-type-option.active {
    border-color: var(--primary-color);
    background-color: rgba(var(--primary-rgb), 0.1);
  }

  .item-type-icon {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
  }

  .form-actions {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
  }

  .danger-zone {
    margin-top: 2rem;
    padding: 1.5rem;
    border: 1px solid var(--danger-color);
    border-radius: 8px;
    background-color: rgba(var(--danger-rgb), 0.05);
  }

  .danger-zone h3 {
    color: var(--danger-color);
    margin-bottom: 1rem;
  }
</style>
@endsection

@section('content')
<main class="marketplace-form">
  <div class="container">
    <div class="back-link mb-3">
      <a href="{{ route('marketplace.show', $item) }}"><i class="fas fa-arrow-left"></i> Back to Item</a>
    </div>
    
    <div class="form-container">
      <div class="form-header">
        <h1>Edit Item</h1>
        <p>Update your listing in the Neighborhood Marketplace</p>
      </div>
      
      @if ($errors->any())
        <div class="alert alert-danger mb-4">
          <h4><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h4>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      
      <form action="{{ route('marketplace.update', $item) }}" method="POST" enctype="multipart/form-data" id="marketplace-form">
        @csrf
        @method('PUT')
        
        <div class="form-section">
          <h2>Item Type</h2>
          <p class="form-text mb-3">What would you like to do with this item?</p>
          
          <div class="item-type-options">
            <div class="item-type-option @if(old('type', $item->type) == 'for-sale') active @endif" data-type="for-sale">
              <div class="item-type-icon">💰</div>
              <div class="item-type-name">For Sale</div>
            </div>
            <div class="item-type-option @if(old('type', $item->type) == 'free') active @endif" data-type="free">
              <div class="item-type-icon">🎁</div>
              <div class="item-type-name">Free</div>
            </div>
            <div class="item-type-option @if(old('type', $item->type) == 'rent') active @endif" data-type="rent">
              <div class="item-type-icon">⏱️</div>
              <div class="item-type-name">To Rent</div>
            </div>
            <div class="item-type-option @if(old('type', $item->type) == 'wanted') active @endif" data-type="wanted">
              <div class="item-type-icon">🔍</div>
              <div class="item-type-name">Wanted</div>
            </div>
          </div>
          <input type="hidden" name="type" id="type-input" value="{{ old('type', $item->type) }}">
        </div>
        
        <div class="form-section">
          <h2>Item Details</h2>
          
          <div class="form-group">
            <label for="title" class="form-label required-indicator">Title</label>
            <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" 
                  value="{{ old('title', $item->title) }}" required>
            @error('title')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="form-row">
            <div class="form-group">
              <label for="category" class="form-label required-indicator">Category</label>
              <select id="category" name="category" class="form-control @error('category') is-invalid @enderror" required>
                <option value="">Select a category</option>
                <option value="furniture" @if(old('category', $item->category) == 'furniture') selected @endif>Furniture</option>
                <option value="electronics" @if(old('category', $item->category) == 'electronics') selected @endif>Electronics</option>
                <option value="clothing" @if(old('category', $item->category) == 'clothing') selected @endif>Clothing</option>
                <option value="tools" @if(old('category', $item->category) == 'tools') selected @endif>Tools</option>
                <option value="toys" @if(old('category', $item->category) == 'toys') selected @endif>Toys</option>
                <option value="books" @if(old('category', $item->category) == 'books') selected @endif>Books</option>
                <option value="sports" @if(old('category', $item->category) == 'sports') selected @endif>Sports</option>
                <option value="other" @if(old('category', $item->category) == 'other') selected @endif>Other</option>
              </select>
              @error('category')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            
            <div class="form-group" id="price-group" @if($item->type == 'free') style="display: none;" @endif>
              <label for="price" class="form-label required-indicator">Price</label>
              <div class="input-group">
                <span class="input-group-text">$</span>
                <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" 
                      value="{{ old('price', $item->price) }}" min="0" step="0.01" @if($item->type != 'free') required @endif>
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
                      rows="5" required>{{ old('description', $item->description) }}</textarea>
            @error('description')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
          </div>
          
          <div class="form-row">
            <div class="form-group">
              <label for="condition" class="form-label">Condition</label>
              <select id="condition" name="condition" class="form-control @error('condition') is-invalid @enderror">
                <option value="">Select condition</option>
                <option value="new" @if(old('condition', $item->condition) == 'new') selected @endif>New</option>
                <option value="like-new" @if(old('condition', $item->condition) == 'like-new') selected @endif>Like New</option>
                <option value="good" @if(old('condition', $item->condition) == 'good') selected @endif>Good</option>
                <option value="fair" @if(old('condition', $item->condition) == 'fair') selected @endif>Fair</option>
                <option value="poor" @if(old('condition', $item->condition) == 'poor') selected @endif>Poor</option>
              </select>
              @error('condition')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
            
            <div class="form-group">
              <label for="brand" class="form-label">Brand (optional)</label>
              <input type="text" id="brand" name="brand" class="form-control @error('brand') is-invalid @enderror" 
                    value="{{ old('brand', $item->brand) }}">
              @error('brand')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
            </div>
          </div>
        </div>
        
        <div class="form-section">
          <h2>Images</h2>
          
          @if($item->image || ($item->gallery && count($item->gallery) > 0))
            <div class="mb-3">
              <h4>Current Images</h4>
              <p class="form-text">Uncheck any images you want to remove. The first image is the main image shown in listings.</p>
              
              <div class="image-preview-container">
                @if($item->image)
                  <div class="image-preview existing-image is-main">
                    <span class="main-image-badge">Main</span>
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                    <div class="form-check mt-1">
                      <input type="checkbox" id="keep_main_image" name="keep_main_image" class="form-check-input" value="1" checked>
                      <label for="keep_main_image" class="form-check-label">Keep</label>
                    </div>
                  </div>
                @endif
                
                @if($item->gallery)
                  @foreach($item->gallery as $index => $image)
                    <div class="image-preview existing-image">
                      <img src="{{ asset('storage/' . $image) }}" alt="{{ $item->title }}">
                      <div class="form-check mt-1">
                        <input type="checkbox" id="keep_image_{{ $index }}" name="keep_gallery[]" class="form-check-input" value="{{ $index }}" checked>
                        <label for="keep_image_{{ $index }}" class="form-check-label">Keep</label>
                      </div>
                      <div class="form-check mt-1">
                        <input type="radio" id="make_main_{{ $index }}" name="main_image" class="form-check-input" value="{{ $index }}">
                        <label for="make_main_{{ $index }}" class="form-check-label">Make Main</label>
                      </div>
                    </div>
                  @endforeach
                @endif
              </div>
            </div>
          @endif
          
          <p class="form-text mb-3">Add up to {{ 5 - ($item->gallery ? count($item->gallery) : 0) - ($item->image ? 1 : 0) }} more images of your item.</p>
          
          <div class="upload-container" id="image-upload">
            <div class="upload-icon">
              <i class="fas fa-cloud-upload-alt"></i>
            </div>
            <div class="upload-text">
              <strong>Click or drag new images here</strong>
              <p class="form-text">JPG, PNG or GIF, max 2MB per image</p>
            </div>
            <input type="file" id="images" name="new_images[]" style="display: none;" multiple accept="image/jpeg,image/png,image/gif">
          </div>
          
          @error('new_images')
            <span class="invalid-feedback d-block">{{ $message }}</span>
          @enderror
          
          @error('new_images.*')
            <span class="invalid-feedback d-block">{{ $message }}</span>
          @enderror
          
          <div class="image-preview-container" id="image-previews"></div>
        </div>
        
        <div class="form-section">
          <h2>Location</h2>
          
          <div class="form-group">
            <label for="location" class="form-label required-indicator">Location</label>
            <input type="text" id="location" name="location" class="form-control @error('location') is-invalid @enderror" 
                  value="{{ old('location', $item->location) }}" required>
            @error('location')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <span class="form-text">For your safety, don't provide your exact address. We'll show an approximate location to other users.</span>
          </div>
          
          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" id="hide_location" name="hide_location" class="form-check-input" value="1" 
                    {{ old('hide_location', $item->hide_location) ? 'checked' : '' }}>
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
                    {{ old('contact_message', $item->contact_message) ? 'checked' : '' }}>
              <label for="contact_message" class="form-check-label">Allow users to contact me through NeighbourNet messages</label>
            </div>
          </div>
          
          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" id="contact_phone" name="contact_phone" class="form-check-input" value="1" 
                    {{ old('contact_phone', $item->contact_phone) ? 'checked' : '' }}>
              <label for="contact_phone" class="form-check-label">Allow users to request my phone number</label>
              <small class="form-text text-muted d-block">Your phone number will only be shared if you approve a request.</small>
            </div>
          </div>
        </div>
        
        <div class="form-section">
          <h2>Item Status</h2>
          
          <div class="form-group">
            <label for="status" class="form-label">Status</label>
            <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
              <option value="available" @if(old('status', $item->status) == 'available') selected @endif>Available</option>
              <option value="pending" @if(old('status', $item->status) == 'pending') selected @endif>Pending Sale/Pickup</option>
              <option value="sold" @if(old('status', $item->status) == 'sold') selected @endif>Sold/No Longer Available</option>
            </select>
            @error('status')
              <span class="invalid-feedback">{{ $message }}</span>
            @enderror
            <span class="form-text">If your item is no longer available, you can mark it as sold instead of deleting it.</span>
          </div>
        </div>
        
        <div class="form-actions">
          <a href="{{ route('marketplace.show', $item) }}" class="btn btn-outline">Cancel</a>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Update Item
          </button>
        </div>
        
        <div class="danger-zone">
          <h3><i class="fas fa-exclamation-triangle"></i> Danger Zone</h3>
          <p>Permanently delete this listing from the marketplace. This action cannot be undone.</p>
          <form action="{{ route('marketplace.destroy', $item) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this listing? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
              <i class="fas fa-trash"></i> Delete Item
            </button>
          </form>
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
    
    // Initialize price hints
    const currentType = typeInput.value;
    if (currentType) {
      priceHints.forEach(hint => hint.style.display = 'none');
      
      if (currentType === 'free') {
        priceGroup.style.display = 'none';
        priceInput.required = false;
      } else {
        const relevantHint = document.querySelector(`.price-hint.${currentType}`);
        if (relevantHint) {
          relevantHint.style.display = 'block';
        } else {
          document.querySelector('.price-hint.for-sale').style.display = 'block';
        }
      }
    }
    
    // Image upload
    const uploadContainer = document.getElementById('image-upload');
    const imagesInput = document.getElementById('images');
    const previewsContainer = document.getElementById('image-previews');
    
    uploadContainer.addEventListener('click', function() {
      imagesInput.click();
    });
    
    uploadContainer.addEventListener('dragover', function(e) {
      e.preventDefault();
      this.classList.add('border-primary');
    });
    
    uploadContainer.addEventListener('dragleave', function() {
      this.classList.remove('border-primary');
    });
    
    uploadContainer.addEventListener('drop', function(e) {
      e.preventDefault();
      this.classList.remove('border-primary');
      
      if (e.dataTransfer.files.length) {
        imagesInput.files = e.dataTransfer.files;
        handleImageFiles(e.dataTransfer.files);
      }
    });
    
    imagesInput.addEventListener('change', function() {
      handleImageFiles(this.files);
    });
    
    function handleImageFiles(files) {
      const maxImages = 5 - {{ ($item->gallery ? count($item->gallery) : 0) + ($item->image ? 1 : 0) }};
      
      if (files.length > maxImages) {
        alert(`You can upload a maximum of ${maxImages} more images.`);
        imagesInput.value = '';
        return;
      }
      
      previewsContainer.innerHTML = '';
      
      for (let i = 0; i < files.length; i++) {
        const file = files[i];
        
        // Validate file type
        if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
          alert(`File ${file.name} is not a supported image type.`);
          continue;
        }
        
        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
          alert(`File ${file.name} exceeds the 2MB size limit.`);
          continue;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
          const previewDiv = document.createElement('div');
          previewDiv.className = 'image-preview';
          
          const img = document.createElement('img');
          img.src = e.target.result;
          
          const removeBtn = document.createElement('button');
          removeBtn.className = 'image-remove';
          removeBtn.innerHTML = '×';
          removeBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            previewDiv.remove();
            // This doesn't actually remove from the file input, but we'll handle that on the server
          });
          
          previewDiv.appendChild(img);
          previewDiv.appendChild(removeBtn);
          previewsContainer.appendChild(previewDiv);
        };
        
        reader.readAsDataURL(file);
      }
    }
    
    // Form validation
    const form = document.getElementById('marketplace-form');
    form.addEventListener('submit', function(e) {
      let isValid = true;
      const requiredFields = form.querySelectorAll('[required]');
      
      requiredFields.forEach(field => {
        if (!field.value.trim()) {
          isValid = false;
          field.classList.add('is-invalid');
          
          // Create error message if it doesn't exist
          if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
            const errorMessage = document.createElement('span');
            errorMessage.className = 'invalid-feedback';
            errorMessage.textContent = 'This field is required';
            field.parentNode.insertBefore(errorMessage, field.nextElementSibling);
          }
        } else {
          field.classList.remove('is-invalid');
        }
      });
      
      if (!isValid) {
        e.preventDefault();
        // Scroll to first invalid field
        const firstInvalid = form.querySelector('.is-invalid');
        if (firstInvalid) {
          firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
          firstInvalid.focus();
        }
        return false;
      }
      
      // Disable submit button to prevent double submission
      const submitBtn = form.querySelector('button[type="submit"]');
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';
    });
  });
</script>
@endsection
