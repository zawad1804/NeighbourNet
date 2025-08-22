<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?php echo e(config('app.name', 'The NeighbourNet')); ?></title>
    <link rel="icon" href="<?php echo e(secure_url_asset('favicon.ico')); ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo e(secure_url_asset('css/login.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-page">
        <!-- Navbar -->
        <header>
            <div class="container">
                <nav>
                    <a href="<?php echo e(url('/')); ?>" class="logo">The <span>NeighbourNet</span></a>
                    
                    <!-- Mobile Menu Button -->
                    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </button>
                    
                    <ul class="nav-links">
                        <li><a href="<?php echo e(url('/#features')); ?>">Features</a></li>
                        <li><a href="<?php echo e(url('/#how-it-works')); ?>">How It Works</a></li>
                        <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
                        <li><a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Sign Up</a></li>
                    </ul>
                    
                    <!-- Mobile Menu -->
                    <div class="mobile-menu" id="mobileMenu">
                        <ul class="mobile-nav-links">
                            <li><a href="<?php echo e(url('/#features')); ?>">Features</a></li>
                            <li><a href="<?php echo e(url('/#how-it-works')); ?>">How It Works</a></li>
                            <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
                            <li><a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Sign Up</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <div class="login-content">
            <div class="login-container">
                <h1 class="login-title">Login</h1>
                
                <form method="POST" action="<?php echo e(route('login')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input 
                            id="email" 
                            type="email" 
                            class="form-input <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                            name="email" 
                            value="<?php echo e(old('email')); ?>" 
                            placeholder="username@gmail.com"
                            required 
                            autocomplete="email" 
                            autofocus
                        >
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-message"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-field">
                            <input 
                                id="password" 
                                type="password" 
                                class="form-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                name="password" 
                                placeholder="Password"
                                required 
                                autocomplete="current-password"
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="passwordToggleIcon"></i>
                            </button>
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="error-message"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="remember-me">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="remember" 
                            id="remember" 
                            <?php echo e(old('remember') ? 'checked' : ''); ?>

                        >
                        <label for="remember">Remember Me</label>
                    </div>

                    <div class="forgot-password">
                        <?php if(Route::has('password.request')): ?>
                            <a href="<?php echo e(route('password.request')); ?>">Forgot Password?</a>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="login-button">
                        Sign in
                    </button>

                    <div class="register-link">
                        Don't have an account yet?
                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>">Register for free</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('passwordToggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
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
<?php /**PATH E:\Projects\herd-laravel\neighbournet-laravel\resources\views/auth/login.blade.php ENDPATH**/ ?>