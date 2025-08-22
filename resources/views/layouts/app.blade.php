<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'The NeighbourNet') }} - Connect with Your Community</title>
    <link rel="icon" href="{{ secure_url_asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ secure_url_asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ secure_url_asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ secure_url_asset('css/events.css') }}">
    <link rel="stylesheet" href="{{ secure_url_asset('css/marketplace.css') }}">
    <link rel="stylesheet" href="{{ secure_url_asset('css/help.css') }}">
    <link rel="stylesheet" href="{{ secure_url_asset('css/button-fix.css') }}">
    <link rel="stylesheet" href="{{ secure_url_asset('css/custom-button.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')   {{-- allow page-specific CSS (e.g., home hero) --}}
</head>
<body>
    <!-- Loading overlay -->
    <div id="loading-overlay" class="loading-overlay">
        <div class="spinner"></div>
    </div>

    <header>
        <div class="container">
            <nav>
                <a href="{{ url('/') }}" class="logo">The <span>NeighbourNet</span></a>
                
                <!-- Mobile Menu Button -->
                <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
                
                @guest
                <ul class="nav-links">
                    <li><a href="{{ url('/#features') }}">Features</a></li>
                    <li><a href="{{ url('/#how-it-works') }}">How It Works</a></li>
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a></li>
                </ul>
                
                <!-- Mobile Menu -->
                <div class="mobile-menu" id="mobileMenu">
                    <ul class="mobile-nav-links">
                        <li><a href="{{ url('/#features') }}">Features</a></li>
                        <li><a href="{{ url('/#how-it-works') }}">How It Works</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a></li>
                    </ul>
                </div>
                @else
                <ul class="nav-links">
                    <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                    <li><a href="{{ route('community.feed') }}" class="{{ request()->routeIs('community.feed') ? 'active' : '' }}">Community</a></li>
                    <li><a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*') ? 'active' : '' }}">Events</a></li>
                    <li><a href="{{ route('marketplace.index') }}" class="{{ request()->routeIs('marketplace.*') ? 'active' : '' }}">Marketplace</a></li>
                    <li><a href="{{ route('help.index') }}" class="{{ request()->routeIs('help.*') ? 'active' : '' }}">Help Network</a></li>
                </ul>
                
                <!-- Mobile Menu for Authenticated Users -->
                <div class="mobile-menu" id="mobileMenu">
                    <ul class="mobile-nav-links">
                        <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                        <li><a href="{{ route('community.feed') }}" class="{{ request()->routeIs('community.feed') ? 'active' : '' }}">Community</a></li>
                        <li><a href="{{ route('events.index') }}" class="{{ request()->routeIs('events.*') ? 'active' : '' }}">Events</a></li>
                        <li><a href="{{ route('marketplace.index') }}" class="{{ request()->routeIs('marketplace.*') ? 'active' : '' }}">Marketplace</a></li>
                        <li><a href="{{ route('help.index') }}" class="{{ request()->routeIs('help.*') ? 'active' : '' }}">Help Network</a></li>
                        <li class="mobile-user-menu">
                            <div class="mobile-user-info">
                                <img src="{{ user_avatar(Auth::user()) }}" alt="{{ Auth::user()->first_name }}" class="user-avatar">
                                <span>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                            </div>
                            <div class="mobile-dropdown">
                                <a href="{{ route('profile.show') }}">My Profile</a>
                                <a href="{{ route('profile.edit') }}">Edit Profile</a>
                                <a href="{{ route('marketplace.my-listings') }}">My Listings</a>
                                <a href="#">Settings</a>
                                <a href="{{ route('logout') }}" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <div class="user-menu">
                    <img src="{{ user_avatar(Auth::user()) }}" alt="{{ Auth::user()->first_name }}" class="user-avatar">
                    <span class="notification-badge">3</span>
                    
                    <div class="dropdown-menu">
                        <a href="{{ route('profile.show') }}">My Profile</a>
                        <a href="{{ route('profile.edit') }}">Edit Profile</a>
                        <a href="{{ route('marketplace.my-listings') }}">My Listings</a>
                        <a href="#">Settings</a>
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
                @endguest
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>The NeighbourNet</h3>
                    <p>Building stronger communities one neighborhood at a time.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/#features') }}">Features</a></li>
                        <li><a href="{{ url('/#how-it-works') }}">How It Works</a></li>
                        <li><a href="{{ route('login') }}">Login</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Legal</h3>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Community Guidelines</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Contact</h3>
                    <ul>
                        <li><a href="mailto:hello@neighbournet.com">hello@neighbournet.com</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Feedback</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; {{ date('Y') }} The NeighbourNet. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Loading overlay functionality
            const loadingOverlay = document.getElementById('loading-overlay');
            
            // Show loading on all navigation links that aren't hashtags
            document.querySelectorAll('a:not([href^="#"])').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Don't show loading for downloads, same page, or external links
                    if (this.getAttribute('download') || this.getAttribute('target') === '_blank' || 
                        this.getAttribute('href') === '#' || this.getAttribute('href') === window.location.href) {
                        return;
                    }
                    
                    // Show loading for normal navigation
                    loadingOverlay.classList.add('active');
                });
            });

            // Show loading on form submissions
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    loadingOverlay.classList.add('active');
                });
            });
            
            // Hide loading when page is fully loaded
            window.addEventListener('load', function() {
                loadingOverlay.classList.remove('active');
            });
            
            // Hide loading if still visible after 5 seconds (fallback)
            setTimeout(function() {
                loadingOverlay.classList.remove('active');
            }, 5000);
        });
        
        // Mobile Menu Toggle Function
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            
            if (mobileMenu.classList.contains('active')) {
                mobileMenu.classList.remove('active');
                mobileMenuBtn.classList.remove('active');
                document.body.style.overflow = 'auto';
            } else {
                mobileMenu.classList.add('active');
                mobileMenuBtn.classList.add('active');
                document.body.style.overflow = 'hidden';
            }
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            
            if (mobileMenu && mobileMenuBtn) {
                if (!mobileMenu.contains(event.target) && !mobileMenuBtn.contains(event.target)) {
                    mobileMenu.classList.remove('active');
                    mobileMenuBtn.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            }
        });
        
        // Close mobile menu on window resize if window becomes larger
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const mobileMenu = document.getElementById('mobileMenu');
                const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
                
                if (mobileMenu && mobileMenuBtn) {
                    mobileMenu.classList.remove('active');
                    mobileMenuBtn.classList.remove('active');
                    document.body.style.overflow = 'auto';
                }
            }
        });
    </script>
    @yield('scripts')      {{-- optional: page-specific JS --}}
</body>
</html>
