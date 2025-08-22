<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - {{ config('app.name', 'The NeighbourNet') }}</title>
    <link rel="icon" href="{{ secure_url_asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ secure_url_asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Additional styles for register page */
        .login-container {
            max-width: 900px;
            padding: 50px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        .form-textarea {
            height: 100px;
            resize: vertical;
            padding: 16px;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .login-container {
                padding: 40px 30px;
                max-width: 500px;
            }
        }
        
        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-page">
        <!-- Navbar -->
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
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <div class="login-content">
            <div class="login-container">
                <h1 class="login-title">Create Account</h1>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="form-grid">
                        <!-- First Name -->
                        <div class="form-group">
                            <label for="first_name" class="form-label">First Name</label>
                            <input 
                                type="text" 
                                id="first_name" 
                                name="first_name" 
                                class="form-input @error('first_name') error @enderror"
                                value="{{ old('first_name') }}" 
                                required 
                                placeholder="Enter your first name"
                            >
                            @error('first_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Last Name -->
                        <div class="form-group">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input 
                                type="text" 
                                id="last_name" 
                                name="last_name" 
                                class="form-input @error('last_name') error @enderror"
                                value="{{ old('last_name') }}" 
                                required 
                                placeholder="Enter your last name"
                            >
                            @error('last_name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group full-width">
                            <label for="email" class="form-label">Email</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input @error('email') error @enderror"
                                value="{{ old('email') }}" 
                                required 
                                placeholder="username@gmail.com"
                            >
                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="form-group">
                            <label for="gender" class="form-label">Gender</label>
                            <select 
                                id="gender" 
                                name="gender" 
                                class="form-input @error('gender') error @enderror"
                                required
                                style="background-image: url('data:image/svg+xml,%3csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 20 20\'%3e%3cpath stroke=\'%236b7280\' stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'1.5\' d=\'m6 8 4 4 4-4\'/%3e%3c/svg%3e'); background-position: right 12px center; background-repeat: no-repeat; background-size: 16px; padding-right: 40px; appearance: none; cursor: pointer;"
                            >
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                class="form-input @error('phone') error @enderror"
                                value="{{ old('phone') }}" 
                                required 
                                placeholder="Enter your phone number"
                            >
                            @error('phone')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="form-group">
                            <label for="city" class="form-label">City</label>
                            <input 
                                type="text" 
                                id="city" 
                                name="city" 
                                class="form-input @error('city') error @enderror"
                                value="{{ old('city') }}" 
                                required 
                                placeholder="Enter your city"
                            >
                            @error('city')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Post Code -->
                        <div class="form-group">
                            <label for="post_code" class="form-label">Post Code</label>
                            <input 
                                type="text" 
                                id="post_code" 
                                name="post_code" 
                                class="form-input @error('post_code') error @enderror"
                                value="{{ old('post_code') }}" 
                                required 
                                placeholder="Enter your post code"
                            >
                            @error('post_code')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="form-group full-width">
                            <label for="address" class="form-label">Address</label>
                            <textarea 
                                id="address" 
                                name="address" 
                                class="form-input form-textarea @error('address') error @enderror"
                                required 
                                placeholder="Enter your full address"
                            >{{ old('address') }}</textarea>
                            @error('address')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-field">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="form-input @error('password') error @enderror"
                                    required 
                                    placeholder="Password"
                                >
                                <button type="button" class="password-toggle" onclick="togglePassword('password', 'passwordIcon')">
                                    <i class="fas fa-eye" id="passwordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="password-field">
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    class="form-input @error('password_confirmation') error @enderror"
                                    required 
                                    placeholder="Confirm Password"
                                >
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'passwordConfirmIcon')">
                                    <i class="fas fa-eye" id="passwordConfirmIcon"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="login-button">
                        Create Account
                    </button>

                    <div class="register-link">
                        Already have an account?
                        <a href="{{ route('login') }}">Sign in</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, iconId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
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
</body>
</html>
