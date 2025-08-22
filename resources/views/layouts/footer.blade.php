<div class="back-to-top">
  <a href="#" id="backToTopBtn">
    <i class="fas fa-arrow-up"></i>
  </a>
</div>

<footer class="site-footer">
  <div class="container">
    <div class="footer-content">
      <!-- About NeighbourNet Column -->
      <div class="footer-section about-section">
        <h3>About NeighbourNet</h3>
        <p class="mission-statement">
          Building stronger communities by connecting neighbors, fostering local engagement, and creating a platform where everyone can contribute to a better neighborhood.
        </p>
        <div class="footer-logo">
          <img src="{{ asset('images/nnnet-peeps.png') }}" alt="NeighbourNet" width="120">
        </div>
      </div>
      
      <!-- Quick Links Column -->
      <div class="footer-section links-section">
        <h3>Quick Links</h3>
        <ul class="quick-links">
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ route('community.feed') }}">Community</a></li>
          <li><a href="{{ route('events.index') }}">Events</a></li>
          <li><a href="{{ route('marketplace.index') }}">Marketplace</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Service</a></li>
          <li><a href="#">Community Guidelines</a></li>
          <li><a href="mailto:hello@neighbournet.com">Contact Us</a></li>
        </ul>
      </div>
      
      <!-- Newsletter Signup Column -->
      <div class="footer-section newsletter-section">
        <h3>Stay Connected</h3>
        <p>Get updates about community events and news.</p>
        
        <form class="newsletter-form">
          <div class="form-group">
            <input type="email" class="form-control" placeholder="Your email address" required>
            <button type="submit" class="btn btn-primary">Subscribe</button>
          </div>
        </form>
        
        <div class="social-media">
          <a href="#" class="social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-icon" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" class="social-icon" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        </div>
      </div>
    </div>
    
    <div class="copyright">
      <small>&copy; {{ date('Y') }} The NeighbourNet. All rights reserved.</small>
    </div>
  </div>
</footer>

<script>
  // Back to top functionality
  document.getElementById('backToTopBtn').addEventListener('click', function(e) {
    e.preventDefault();
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
  
  // Show/hide back to top button based on scroll position
  window.addEventListener('scroll', function() {
    const backToTopBtn = document.getElementById('backToTopBtn');
    if (window.scrollY > 300) {
      backToTopBtn.classList.add('visible');
    } else {
      backToTopBtn.classList.remove('visible');
    }
  });
</script>
