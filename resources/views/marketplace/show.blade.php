@extends('layouts.app')

@section('title', $item->title . ' - Marketplace')

@section('styles')
<style>
  .marketplace-item {
    padding: 2rem 0;
  }

  .item-container {
    background-color: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  }

  .item-header {
    padding: 1.75rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
  }

  .item-title-group h1 {
    margin: 0;
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-dark);
  }

  .item-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.25rem;
    margin-top: 0.75rem;
    font-size: 0.95rem;
    color: var(--text-muted);
  }

  .item-tag {
    display: inline-block;
    background: var(--primary-color);
    color: white;
    padding: 0.35rem 1rem;
    border-radius: 30px;
    font-size: 0.85rem;
    font-weight: 600;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
  }
  
  .item-tag:hover {
    transform: translateY(-2px);
  }

  .item-tag.free {
    background-color: #28a745;
  }

  .item-tag.rent {
    background-color: #fd7e14;
  }

  .item-tag.wanted {
    background-color: #dc3545;
  }

  .item-tag.barter {
    background-color: #6f42c1;
  }

  .item-price {
    font-size: 2rem;
    font-weight: bold;
    color: var(--primary-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .item-content {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    padding: 2rem;
  }

  @media (min-width: 768px) {
    .item-content {
      grid-template-columns: 3fr 2fr;
    }
  }

  .item-gallery {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 15px rgba(0,0,0,0.05);
  }

  .item-main-image {
    width: 100%;
    height: 400px;
    object-fit: contain;
    border-radius: 8px;
    background-color: #f8f9fa;
  }

  .item-thumbnails {
    display: flex;
    gap: 0.75rem;
    margin-top: 1rem;
    overflow-x: auto;
    padding: 0.5rem 0;
  }

  .item-thumbnail {
    width: 90px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    opacity: 0.7;
    transition: all 0.2s ease;
    border: 2px solid transparent;
  }

  .item-thumbnail:hover,
  .item-thumbnail.active {
    opacity: 1;
    border-color: var(--primary-color);
    transform: scale(1.05);
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
  }

  .item-thumbnail:hover {
    opacity: 0.9;
    transform: translateY(-2px);
  }

  .item-description {
    white-space: pre-line;
    line-height: 1.6;
  }

  .item-detail {
    margin-bottom: 0.5rem;
  }

  .item-detail-label {
    font-weight: 600;
    margin-right: 0.5rem;
    color: var(--text-dark);
  }

  .item-seller {
    background-color: white;
    padding: 1.75rem;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  }

  .seller-header {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    margin-bottom: 1.5rem;
  }

  .seller-avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid white;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  }

  .seller-info h3 {
    margin: 0 0 0.25rem 0;
    font-size: 1.3rem;
    font-weight: 600;
    color: var(--text-dark);
  }

  .seller-meta {
    font-size: 0.9rem;
    color: var(--text-muted);
    line-height: 1.5;
  }

  .contact-options {
    display: grid;
    gap: 0.75rem;
  }

  .related-items {
    margin-top: 3rem;
  }

  .related-header {
    margin-bottom: 1.75rem;
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 1rem;
  }

  .related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
  }
  
  .back-link {
    margin-bottom: 1.5rem;
  }
  
  .back-link a {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-muted);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
  }
  
  .back-link a:hover {
    color: var(--primary-color);
  }
  
  .back-link i {
    font-size: 0.9rem;
  }
</style>
@endsection

@section('content')
<main class="marketplace-item">
  <div class="container">
    <div class="back-link">
      <a href="{{ route('marketplace.index') }}">
        <i class="fas fa-arrow-left"></i> 
        <span>Back to Marketplace</span>
      </a>
    </div>
    
    <div class="item-container">
      <div class="item-header">
        <div class="item-title-group">
          <h1>{{ $item->title }}</h1>
          <div class="item-meta">
            <span>
              @if($item->category == 'furniture')
                🛋️
              @elseif($item->category == 'electronics')
                💻
              @elseif($item->category == 'clothing')
                👕
              @elseif($item->category == 'tools')
                🛠️
              @elseif($item->category == 'toys')
                🧸
              @elseif($item->category == 'books')
                📚
              @elseif($item->category == 'sports')
                🚲
              @else
                📦
              @endif
              {{ ucfirst($item->category) }}
            </span>
            <span>📍 {{ $item->distance }}</span>
            <span>📅 Posted {{ $item->created_at->diffForHumans() }}</span>
          </div>
        </div>
        
        <div class="item-price-tag">
          <span class="item-tag {{ $item->type }}">{{ ucfirst($item->type) }}</span>
          <div class="item-price">
            @if($item->type == 'free')
              Free
            @elseif($item->type == 'wanted')
              Budget: ${{ $item->price }}
            @elseif($item->type == 'rent')
              ${{ $item->price }}/day
            @elseif($item->type == 'barter')
              Trade for...
            @else
              ${{ $item->price }}
            @endif
          </div>
        </div>
      </div>
      
      <div class="item-content">
        <div class="item-main">
          <div class="item-gallery">
            <img src="{{ $item->image ? asset('storage/'.$item->image) : 'https://via.placeholder.com/800x600' }}" alt="{{ $item->title }}" class="item-main-image" id="main-image">
            
            @if($item->gallery && count($item->gallery) > 0)
              <div class="item-thumbnails">
                <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}" class="item-thumbnail active" onclick="changeMainImage(this.src)">
                @foreach($item->gallery as $image)
                  <img src="{{ asset('storage/'.$image) }}" alt="{{ $item->title }}" class="item-thumbnail" onclick="changeMainImage(this.src)">
                @endforeach
              </div>
            @endif
          </div>
          
          <div class="item-details mt-4">
            <h2>Description</h2>
            <div class="item-description">
              {{ $item->description }}
            </div>
            
            <div class="item-specs mt-4">
              <h3>Details</h3>
              <div class="item-detail">
                <span class="item-detail-label">Condition:</span>
                <span>{{ $item->condition ?? 'Not specified' }}</span>
              </div>
              
              @if($item->brand)
                <div class="item-detail">
                  <span class="item-detail-label">Brand:</span>
                  <span>{{ $item->brand }}</span>
                </div>
              @endif
              
              @if($item->dimensions)
                <div class="item-detail">
                  <span class="item-detail-label">Dimensions:</span>
                  <span>{{ $item->dimensions }}</span>
                </div>
              @endif
            </div>
            
            @if($item->type == 'barter')
              <div class="item-trade mt-4">
                <h3>Looking to Trade For</h3>
                <p>{{ $item->trade_for ?? 'Open to offers' }}</p>
              </div>
            @endif
          </div>
        </div>
        
        <div class="item-sidebar">
          <div class="item-seller">
            <div class="seller-header">
              <img src="{{ user_avatar($item->user, 'md') }}" alt="{{ $item->user->name }}" class="seller-avatar">
              <div class="seller-info">
                <h3>{{ $item->user->name }}</h3>
                <div class="seller-meta">
                  <div>Member since {{ $item->user->created_at->format('M Y') }}</div>
                  <div>{{ $item->user->items_count ?? 0 }} items listed</div>
                </div>
              </div>
            </div>
            
            @if(Auth::check() && Auth::id() != $item->user_id)
              <div class="contact-options">
                <button class="btn btn-primary btn-block btn-lg">
                  <i class="fas fa-comment-alt me-2"></i> Message Seller
                </button>
                <button class="btn btn-outline-secondary btn-block mt-2">
                  <i class="fas fa-phone me-2"></i> Request Phone Number
                </button>
              </div>
            @elseif(Auth::check() && Auth::id() == $item->user_id)
              <div class="contact-options">
                <a href="{{ route('marketplace.edit', $item) }}" class="btn btn-primary btn-block btn-lg">
                  <i class="fas fa-edit me-2"></i> Edit Listing
                </a>
                <form action="{{ route('marketplace.destroy', $item) }}" method="POST" class="mt-2" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-outline-danger btn-block">
                    <i class="fas fa-trash me-2"></i> Delete Listing
                  </button>
                </form>
              </div>
            @else
              <div class="contact-options">
                <a href="{{ route('login') }}" class="btn btn-primary btn-block">
                  Login to Contact
                </a>
              </div>
            @endif
            
            <div class="item-location mt-4">
              <h4>Location</h4>
              <div>{{ $item->location ?? 'Approximate location shown to members only' }}</div>
            </div>
          </div>
          
          <div class="item-safety mt-4">
            <h4>Safety Tips</h4>
            <ul class="small text-muted">
              <li>Meet in a public place</li>
              <li>Don't pay in advance</li>
              <li>Check the item before paying</li>
              <li>Report suspicious users</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    @if(isset($relatedItems) && count($relatedItems) > 0)
      <div class="related-items">
        <div class="related-header">
          <h2>Similar Items</h2>
        </div>
        
        <div class="related-grid">
          @foreach($relatedItems as $relItem)
            <div class="item-card">
              <div class="item-image" style="background-image: url('{{ $relItem->image ? asset('storage/'.$relItem->image) : 'https://via.placeholder.com/300x200' }}')">
                <span class="item-tag {{ $relItem->type }}">{{ ucfirst($relItem->type) }}</span>
              </div>
              <div class="item-details">
                <h3>{{ $relItem->title }}</h3>
                <div class="item-price">
                  @if($relItem->type == 'free')
                    Free
                  @elseif($relItem->type == 'wanted')
                    Budget: ${{ $relItem->price }}
                  @elseif($relItem->type == 'rent')
                    ${{ $relItem->price }}/day
                  @elseif($relItem->type == 'barter')
                    Trade for...
                  @else
                    ${{ $relItem->price }}
                  @endif
                </div>
                <a href="{{ route('marketplace.show', $relItem) }}" class="btn btn-sm btn-outline mt-2">View</a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</main>
@endsection

@section('scripts')
<script>
  function changeMainImage(src) {
    document.getElementById('main-image').src = src;
    
    // Update active thumbnail
    const thumbnails = document.querySelectorAll('.item-thumbnail');
    thumbnails.forEach(thumbnail => {
      if (thumbnail.src === src) {
        thumbnail.classList.add('active');
      } else {
        thumbnail.classList.remove('active');
      }
    });
  }
  
  // Initialize first thumbnail as active
  document.addEventListener('DOMContentLoaded', function() {
    const firstThumbnail = document.querySelector('.item-thumbnail');
    if (firstThumbnail) {
      firstThumbnail.classList.add('active');
    }
  });
</script>
@endsection
