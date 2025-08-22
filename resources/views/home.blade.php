@extends('layouts.app')

@section('styles')
<style>
    :root {
        --primary-color: #4A6FA5;
        --primary-light: #EBF2FF;
        --accent-color: #47B475;
        --text-dark: #2D3748;
        --text-light: #718096;
        --bg-light: #F7FAFC;
        --transition: all 0.3s ease;
    }

    .hero-section {
        position: relative;
        min-height: 80vh;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, var(--primary-light) 0%, #ffffff 100%);
        overflow: hidden;
        padding: 4rem 0; /* ensure breathing room */
    }

    .hero-container {
        display: grid;
        grid-template-columns: 1.2fr 1fr; /* favor text block */
        gap: 3rem;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .hero-content {
        padding-right: 1rem;
    }

    .hero-eyebrow {
        display: inline-block;
        font-weight: 600;
        color: var(--primary-color);
        background: var(--primary-light);
        padding: .5rem 1rem;
        border-radius: 999px;
        margin-bottom: 1.2rem;
        font-size: clamp(1.1rem, 1.5vw, 1.3rem);
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .hero-title {
        font-size: clamp(2rem, 4.2vw, 3.5rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1rem;
        background: linear-gradient(to right, var(--primary-color), #6A8BBF);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        font-size: clamp(1.05rem, 1.6vw, 1.25rem);
        line-height: 1.6;
        color: var(--text-light);
        margin-bottom: 2rem;
        max-width: 48ch;
    }

    .hero-actions {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
        padding: 0.9rem 1.6rem;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        transition: var(--transition);
        box-shadow: 0 8px 20px rgba(74, 111, 165, 0.2);
        font-size: 1.05rem;
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(74, 111, 165, 0.3); }

    .btn-secondary {
        background-color: #fff;
        color: var(--primary-color);
        padding: 0.9rem 1.4rem;
        border-radius: 12px;
        font-weight: 700;
        border: 1px solid var(--primary-color);
        transition: var(--transition);
        font-size: 1.05rem;
    }
    .btn-secondary:hover { background-color: var(--primary-light); }

    /* Slideshow hero visual */
    .hero-visual {
        position: relative;
        width: 100%;
        height: clamp(260px, 46vw, 480px);
        border-radius: 22px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        overflow: hidden;
        isolation: isolate;
    }
    
    .slideshow {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    
    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        transition: opacity 1s ease-in-out;
    }
    
    .slide.active {
        opacity: 1;
    }
    
    .slide-controls {
        position: absolute;
        bottom: 20px;
        left: 0;
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 10px;
        z-index: 5;
    }
    
    .slide-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
    
    .slide-dot.active {
        background-color: white;
    }
    
    .hero-visual::after { /* soft gradient overlay for readability */
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(255,255,255,0) 20%, rgba(0,0,0,0.05) 100%);
        pointer-events: none;
        z-index: 2;
    }

    .shape { position: absolute; z-index: 0; }
    .shape-1 { top: -120px; right: -120px; width: 300px; height: 300px; border-radius: 50%;
        background: radial-gradient(var(--primary-light), rgba(74,111,165,.10)); }
    .shape-2 { bottom: -160px; left: -160px; width: 420px; height: 420px; border-radius: 50%;
        background: radial-gradient(var(--primary-light), rgba(74,111,165,.06)); }

    @media (max-width: 1024px) {
        .hero-container { grid-template-columns: 1fr; }
        .hero-content { text-align: center; padding-right: 0; }
        .hero-actions { justify-content: center; }
        .hero-visual { order: -1; max-width: 720px; margin: 0 auto 1rem; }
    }

    @media (max-width: 640px) {
        .hero-section { padding: 2rem 0 3rem; }
        .hero-actions { flex-direction: column; }
    }
</style>
@endsection

@section('content')
    @php
        // Define the images for the slideshow
        $images = [
            [
                'path' => 'images/nnnet-peeps.png', 
                'fallback' => 'https://images.unsplash.com/photo-1536317203120-03881381d3db?auto=format&fit=crop&w=1400&q=80'
            ],
            [
                'path' => 'images/bb.jpg',
                'fallback' => 'https://images.unsplash.com/photo-1543269865-cbf427effbad?auto=format&fit=crop&w=1400&q=80'
            ],
            [
                'path' => 'images/brac.jpg',
                'fallback' => 'https://images.unsplash.com/photo-1526976668912-1a811878dd37?auto=format&fit=crop&w=1400&q=80'
            ],
            [
                'path' => 'images/neighborhood-community.jpg',
                'fallback' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1400&q=80'
            ]
        ];
    @endphp
    <section class="hero-section">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="container hero-container">
            <div class="hero-content">
                <div class="hero-eyebrow">Welcome to The NeighbourNet</div>
                <h1 class="hero-title">Connect With Your Community</h1>
                <p class="hero-subtitle">
                    Build stronger neighborhoods through meaningful connections, local events, and neighbor-to-neighbor support.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('register') }}" class="btn-primary">Get Started</a>
                    <a href="#how-it-works" class="btn-secondary">See How It Works</a>
                </div>
            </div>

            <!-- Slideshow implementation -->
            <div class="hero-visual">
                <div class="slideshow">
                    @foreach($images as $index => $image)
                        @php
                            $imageUrl = file_exists(public_path($image['path'])) 
                                ? asset($image['path']) 
                                : $image['fallback'];
                        @endphp
                        <div class="slide {{ $index === 0 ? 'active' : '' }}" style="background-image: url('{{ $imageUrl }}');"></div>
                    @endforeach
                </div>
                <div class="slide-controls">
                    @foreach($images as $index => $image)
                        <div class="slide-dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="features-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Features</span>
                <h2 class="section-title">Everything You Need for a Connected Neighborhood</h2>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13M16 3.13C16.8604 3.3503 17.623 3.8507 18.1676 4.55231C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89317 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7Z" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3>Community Feed</h3>
                    <p>Stay updated with what's happening in your neighborhood through categorized posts and discussions.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 4C16 2.9 16.9 2 18 2C19.1 2 20 2.9 20 4C20 5.1 19.1 6 18 6M12 11H16C17.1 11 18 10.1 18 9V7M1 14C1 12.9 1.9 12 3 12H16C17.1 12 18 12.9 18 14V20C18 21.1 17.1 22 16 22H3C1.9 22 1 21.1 1 20M5 12V7C5 5.9 5.9 5 7 5H11C12.1 5 13 5.9 13 7V12" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3>Help Network</h3>
                    <p>Request or offer help for things like elderly support, pet sitting, or groceries when neighbors need assistance.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 4H5C3.89543 4 3 4.89543 3 6V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V6C21 4.89543 20.1046 4 19 4Z" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 2V6" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 2V6" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3 10H21" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 16L11 18L15 14" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3>Local Events</h3>
                    <p>Create or join neighborhood events like BBQs, block parties, or community gatherings to foster connections.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 2L3 6V20C3 20.5304 3.21071 21.0391 3.58579 21.4142C3.96086 21.7893 4.46957 22 5 22H19C19.5304 22 20.0391 21.7893 20.4142 21.4142C20.7893 21.0391 21 20.5304 21 20V6L18 2H6Z" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3 6H21" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 10C16 11.0609 15.5786 12.0783 14.8284 12.8284C14.0783 13.5786 13.0609 14 12 14C10.9391 14 9.92172 13.5786 9.17157 12.8284C8.42143 12.0783 8 11.0609 8 10" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3>Marketplace</h3>
                    <p>Sell, lend, give away, or barter items with your trusted neighbors in our local community marketplace.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.29 3.86002L1.82 18C1.64537 18.3024 1.55296 18.6453 1.55199 18.9945C1.55101 19.3437 1.6415 19.6871 1.81443 19.9905C1.98737 20.2939 2.23672 20.5467 2.53761 20.7238C2.83849 20.901 3.18058 20.9962 3.53 21H20.47C20.8194 20.9962 21.1615 20.901 21.4624 20.7238C21.7633 20.5467 22.0126 20.2939 22.1856 19.9905C22.3585 19.6871 22.449 19.3437 22.448 18.9945C22.447 18.6453 22.3546 18.3024 22.18 18L13.71 3.86002C13.5317 3.56611 13.2807 3.32313 12.9812 3.15449C12.6817 2.98585 12.3437 2.89725 12 2.89725C11.6563 2.89725 11.3183 2.98585 11.0188 3.15449C10.7193 3.32313 10.4683 3.56611 10.29 3.86002Z" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 9V13" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 17H12.01" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3>Safety Alerts</h3>
                    <p>Report and receive alerts about safety issues in your area, with the option to remain anonymous.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.21 13.89L7 23L12 20L17 23L15.79 13.88M15 7C15 8.65685 13.6569 10 12 10C10.3431 10 9 8.65685 9 7C9 5.34315 10.3431 4 12 4C13.6569 4 15 5.34315 15 7ZM20 7C20 10.866 16.418 14 12 14C7.582 14 4 10.866 4 7C4 3.13401 7.582 0 12 0C16.418 0 20 3.13401 20 7Z" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3>Leaderboard</h3>
                    <p>Recognize top helpers in your community with our volunteer leaderboard to encourage community participation.</p>
                </div>
            </div>
        </div>
    </section>

    <style>
        .features-section {
            padding: 6rem 0;
            background-color: var(--bg-light);
        }
        
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        
        .section-badge {
            display: inline-block;
            background-color: var(--primary-light);
            color: var(--primary-color);
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.2;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }
        
        .feature-card {
            background-color: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            transition: var(--transition);
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }
        
        .feature-icon {
            margin-bottom: 1.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 60px;
            height: 60px;
            background-color: var(--primary-light);
            border-radius: 12px;
        }
        
        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }
        
        .feature-card p {
            color: var(--text-light);
            line-height: 1.6;
        }
        
        @media (max-width: 1024px) {
            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 640px) {
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .features-section {
                padding: 4rem 0;
            }
        }
    </style>

    <section id="how-it-works" class="how-it-works-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">How It Works</span>
                <h2 class="section-title">Three Simple Steps to Get Started</h2>
            </div>
            
            <div class="steps-container">
                <div class="steps-line"></div>
                <div class="steps">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13M16 3.13C16.8604 3.3503 17.623 3.8507 18.1676 4.55231C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89317 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7Z" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h3>Create Your Profile</h3>
                            <p>Sign up and verify your address to connect with real neighbors in your community. Your profile helps build trust.</p>
                        </div>
                    </div>
                    
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 16L16 12L12 8" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8 12H16" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h3>Explore Your Neighborhood</h3>
                            <p>Browse community posts, upcoming events, marketplace listings, and connect with neighbors in your area.</p>
                        </div>
                    </div>
                    
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18 8C19.6569 8 21 6.65685 21 5C21 3.34315 19.6569 2 18 2C16.3431 2 15 3.34315 15 5C15 6.65685 16.3431 8 18 8Z" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6 15C7.65685 15 9 13.6569 9 12C9 10.3431 7.65685 9 6 9C4.34315 9 3 10.3431 3 12C3 13.6569 4.34315 15 6 15Z" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M18 22C19.6569 22 21 20.6569 21 19C21 17.3431 19.6569 16 18 16C16.3431 16 15 17.3431 15 19C15 20.6569 16.3431 22 18 22Z" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8.59 13.51L15.42 17.49" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15.41 6.51L8.59 10.49" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h3>Engage & Connect</h3>
                            <p>Participate in community discussions, offer help, attend local events, and build meaningful relationships with neighbors.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="cta-container">
                <a href="{{ route('register') }}" class="btn-primary">Join Your Neighborhood</a>
            </div>
        </div>
    </section>

    <style>
        .how-it-works-section {
            padding: 6rem 0;
            background-color: white;
        }
        
        .steps-container {
            position: relative;
            margin: 4rem 0;
        }
        
        .steps-line {
            position: absolute;
            top: 3rem;
            left: 2.5rem;
            width: calc(100% - 5rem);
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--accent-color));
            z-index: 0;
            border-radius: 4px;
        }
        
        .steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .step-card {
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            padding: 3rem 2rem 2rem;
            position: relative;
            transition: var(--transition);
        }
        
        .step-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }
        
        .step-number {
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), #6A8BBF);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.5rem;
            box-shadow: 0 10px 20px rgba(74, 111, 165, 0.2);
        }
        
        .step-content {
            text-align: center;
        }
        
        .step-icon {
            background-color: var(--primary-light);
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }
        
        .step-card h3 {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }
        
        .step-card p {
            color: var(--text-light);
            line-height: 1.6;
        }
        
        .cta-container {
            text-align: center;
            margin-top: 2rem;
        }
        
        @media (max-width: 1024px) {
            .steps {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 0 auto;
            }
            
            .steps-line {
                display: none;
            }
            
            .step-card {
                margin-top: 2rem;
            }
        }
    </style>

    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge">Testimonials</span>
                <h2 class="section-title">What Our Community Members Say</h2>
            </div>
            
            <div class="testimonials-slider">
                <div class="testimonials-container">
                    <div class="testimonial-card">
                        <div class="quote-icon">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 11H6C4.89543 11 4 10.1046 4 9V7C4 5.89543 4.89543 5 6 5H8C9.10457 5 10 5.89543 10 7V11ZM10 11V13C10 16 8 17 6 17.5" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M20 11H16C14.8954 11 14 10.1046 14 9V7C14 5.89543 14.8954 5 16 5H18C19.1046 5 20 5.89543 20 7V11ZM20 11V13C20 16 18 17 16 17.5" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="testimonial-content">
                            <p>"The NeighbourNet helped me find someone to walk my dog when I was sick. Within an hour, a neighbor volunteered! This platform has been such a lifesaver and really shows the power of community."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/women/54.jpg" alt="Sarah J." class="author-avatar" onerror="this.src='https://via.placeholder.com/60'">
                            <div class="author-info">
                                <h4>Sarah J.</h4>
                                <p>Maple Street</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-card">
                        <div class="quote-icon">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 11H6C4.89543 11 4 10.1046 4 9V7C4 5.89543 4.89543 5 6 5H8C9.10457 5 10 5.89543 10 7V11ZM10 11V13C10 16 8 17 6 17.5" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M20 11H16C14.8954 11 14 10.1046 14 9V7C14 5.89543 14.8954 5 16 5H18C19.1046 5 20 5.89543 20 7V11ZM20 11V13C20 16 18 17 16 17.5" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="testimonial-content">
                            <p>"Our block party was a huge success thanks to the event planning tools! We had over 50 neighbors attend, many meeting for the first time. NeighbourNet has transformed how we connect in our community."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Michael T." class="author-avatar" onerror="this.src='https://via.placeholder.com/60'">
                            <div class="author-info">
                                <h4>Michael T.</h4>
                                <p>Oak Avenue</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="testimonial-card">
                        <div class="quote-icon">
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 11H6C4.89543 11 4 10.1046 4 9V7C4 5.89543 4.89543 5 6 5H8C9.10457 5 10 5.89543 10 7V11ZM10 11V13C10 16 8 17 6 17.5" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M20 11H16C14.8954 11 14 10.1046 14 9V7C14 5.89543 14.8954 5 16 5H18C19.1046 5 20 5.89543 20 7V11ZM20 11V13C20 16 18 17 16 17.5" stroke="#4A6FA5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="testimonial-content">
                            <p>"I've made great friends and even found a reliable babysitter through this platform. As someone new to the neighborhood, NeighbourNet made me feel welcome and connected from day one."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/women/28.jpg" alt="Priya K." class="author-avatar" onerror="this.src='https://via.placeholder.com/60'">
                            <div class="author-info">
                                <h4>Priya K.</h4>
                                <p>Pine Road</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-indicators">
                    <span class="indicator active"></span>
                    <span class="indicator"></span>
                    <span class="indicator"></span>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container cta-container">
            <div class="cta-content">
                <h2>Ready to Connect With Your Neighborhood?</h2>
                <p>Join thousands of neighbors building stronger, safer, and more connected communities.</p>
                <a href="{{ route('register') }}" class="btn-primary">Get Started Now</a>
            </div>
        </div>
    </section>

    <style>
        .testimonials-section {
            padding: 6rem 0;
            background-color: var(--bg-light);
        }
        
        .testimonials-slider {
            margin-top: 4rem;
            position: relative;
        }
        
        .testimonials-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }
        
        .testimonial-card {
            background-color: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            transition: var(--transition);
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }
        
        .quote-icon {
            margin-bottom: 1rem;
            opacity: 0.6;
        }
        
        .testimonial-content {
            flex-grow: 1;
            margin-bottom: 1.5rem;
        }
        
        .testimonial-content p {
            color: var(--text-dark);
            font-size: 1.1rem;
            line-height: 1.7;
            font-style: italic;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .author-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .author-info h4 {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
        }
        
        .author-info p {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .testimonial-indicators {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 3rem;
        }
        
        .indicator {
            width: 12px;
            height: 12px;
            background-color: var(--primary-light);
            border-radius: 50%;
            cursor: pointer;
            transition: var(--transition);
        }
        
        .indicator.active {
            background-color: var(--primary-color);
            transform: scale(1.2);
        }
        
        .cta-section {
            background: linear-gradient(135deg, var(--primary-color), #3A5A84);
            padding: 5rem 0;
            color: white;
            text-align: center;
        }
        
        .cta-content {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .cta-content h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .cta-content p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .cta-content .btn-primary {
            background-color: white;
            color: var(--primary-color);
            font-size: 1.2rem;
            padding: 1rem 2rem;
        }
        
        .cta-content .btn-primary:hover {
            background-color: var(--bg-light);
        }
        
        @media (max-width: 1024px) {
            .testimonials-container {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 0 auto;
            }
            
            .testimonial-card {
                margin-bottom: 2rem;
            }
            
            .testimonial-indicators {
                margin-top: 1rem;
            }
        }
        
        @media (max-width: 640px) {
            .cta-content h2 {
                font-size: 2rem;
            }
            
            .cta-content p {
                font-size: 1.1rem;
            }
            
            .testimonials-section, .cta-section {
                padding: 4rem 0;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simple testimonial slider navigation
            const indicators = document.querySelectorAll('.indicator');
            
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function() {
                    // Remove active class from all indicators
                    document.querySelectorAll('.indicator').forEach(ind => {
                        ind.classList.remove('active');
                    });
                    
                    // Add active class to clicked indicator
                    this.classList.add('active');
                    
                    // Here you would normally slide to the corresponding testimonial
                    // For now, we'll just keep it simple
                });
            });
            
            // Hero slideshow functionality
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.slide-dot');
            let currentSlide = 0;
            let slideInterval;
            
            // Function to show a specific slide
            function showSlide(index) {
                // Hide all slides
                slides.forEach(slide => slide.classList.remove('active'));
                dots.forEach(dot => dot.classList.remove('active'));
                
                // Show the selected slide
                slides[index].classList.add('active');
                dots[index].classList.add('active');
                
                // Update current slide index
                currentSlide = index;
            }
            
            // Function to show the next slide
            function nextSlide() {
                // Calculate the index of the next slide
                const next = (currentSlide + 1) % slides.length;
                showSlide(next);
            }
            
            // Start the slideshow
            function startSlideshow() {
                slideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
            }
            
            // Event listeners for the dot controls
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    showSlide(index);
                    
                    // Reset the interval when manually changing slides
                    clearInterval(slideInterval);
                    startSlideshow();
                });
            });
            
            // Start the slideshow when the page loads
            startSlideshow();
        });
    </script>
@endsection
