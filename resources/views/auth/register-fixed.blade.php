@extends('layouts.app')

@section('styles')
<style>
/* Register Page Styles */
.register-page {
    background: #f8f9fa;
    min-height: calc(100vh - 80px);
    padding: 30px 0;
}

.register-container {
    max-width: 800px;
    margin: 0 auto;
}

.register-header {
    background: linear-gradient(135deg, #E8F0FE 0%, #FFFFFF 100%);
    border-radius: 16px;
    padding: 40px;
    margin-bottom: 30px;
    text-align: center;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.register-header h1 {
    color: #4a90e2;
    font-size: 32px;
    font-weight: 700;
    margin: 0 0 10px 0;
}

.register-header p {
    color: #6b7280;
    font-size: 16px;
    margin: 0;
}

.register-form {
    background: white;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 24px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    display: block;
    color: #2d3748;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
}

.form-input, .form-select {
    width: 100%;
    height: 48px;
    background: #f7fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 0 16px;
    font-size: 16px;
    color: #2d3748;
    transition: all 0.3s ease;
    font-family: inherit;
    box-sizing: border-box;
}

.form-input:focus, .form-select:focus {
    outline: none;
    border-color: #4182F9;
    background: white;
    box-shadow: 0 0 0 3px rgba(65, 130, 249, 0.1);
}

.form-input::placeholder {
    color: #a0aec0;
}

.form-select {
    cursor: pointer;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 12px center;
    background-repeat: no-repeat;
    background-size: 16px;
    padding-right: 40px;
    appearance: none;
}

.form-textarea {
    height: 120px;
    resize: vertical;
    padding: 16px;
}

.password-container {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    padding: 4px;
}

.password-toggle:hover {
    color: #4182F9;
}

.btn-primary {
    width: 100%;
    background: #4182F9;
    color: white;
    border: none;
    border-radius: 12px;
    padding: 16px 24px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(65, 130, 249, 0.3);
}

.btn-primary:hover {
    background: #3366d6;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(65, 130, 249, 0.4);
}

.auth-footer {
    text-align: center;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

.auth-footer p {
    color: #6b7280;
    margin: 0;
}

.auth-footer a {
    color: #4182F9;
    text-decoration: none;
    font-weight: 600;
}

.auth-footer a:hover {
    color: #3366d6;
    text-decoration: underline;
}

.error-message {
    color: #e53e3e;
    font-size: 14px;
    margin-top: 6px;
    display: block;
}

.form-input.error {
    border-color: #e53e3e;
    background: #fed7d7;
}

/* Responsive Design */
@media (max-width: 768px) {
    .register-page {
        padding: 20px 0;
    }
    
    .register-header {
        padding: 30px 20px;
        margin-bottom: 20px;
    }
    
    .register-form {
        padding: 30px 20px;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}
</style>
@endsection

@section('content')
<div class="register-page">
    <div class="container">
        <div class="register-container">
            <!-- Register Header -->
            <div class="register-header">
                <h1>Create Account</h1>
                <p>Join The NeighbourNet community today</p>
            </div>

            <!-- Register Form -->
            <div class="register-form">
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
                            <label for="email" class="form-label">Email Address</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-input @error('email') error @enderror"
                                value="{{ old('email') }}" 
                                required 
                                placeholder="Enter your email address"
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
                                class="form-select @error('gender') error @enderror"
                                required
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
                            <div class="password-container">
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="form-input @error('password') error @enderror"
                                    required 
                                    placeholder="Enter your password"
                                >
                                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <div class="password-container">
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    class="form-input @error('password_confirmation') error @enderror"
                                    required 
                                    placeholder="Confirm your password"
                                >
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">
                        Create Account
                    </button>

                    <div class="auth-footer">
                        <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.className = 'fas fa-eye-slash';
        } else {
            field.type = 'password';
            icon.className = 'fas fa-eye';
        }
    }
</script>
@endsection
