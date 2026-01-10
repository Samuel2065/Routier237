@extends('layouts.app')

@section('title', 'Home')

<style>
    /* Navbar adjustments */
    .navbar {
        position: fixed;
        width: 100%;
        top: 0;
        z-index: 1000;
        background-color: white !important;
    }

    /* Hero section */
    .hero {
        height: 100vh;
        width: 100%;
        background-image: url('{{ asset('assets/images/hero-bg.jpg') }}');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.4) 100%);
        z-index: 1;
    }

    .hero-content {
        text-align: center;
        max-width: 1000px;
        padding: 0 20px;
        margin-top: 0;
        padding-top: 80px;
        align-items: center;
    }

    .hero h1 {
        font-size: 3.5rem;
        margin-bottom: 1.5rem;
        font-weight: 700;
        align-items: center;
    }

    .hero h1 span {
        color: #FFD700;
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 2rem;
        opacity: 0.9;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin-top: 2rem;
    }

    .hero-features {
        display: flex;
        justify-content: center;
        gap: 2rem;
    }

    .hero-features .feature {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: white;
    }

    .hero-features .feature i {
        font-size: 1.2rem;
        background: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .hero {
            margin-top: -76px;
            padding-top: 76px;
        }
        .hero h1 {
            font-size: 2.5rem;
        }
        .hero-buttons {
            flex-direction: column;
            align-items: center;
        }
    }

    .button {
        padding: 16px 32px;
        border-radius: 5px;
        border: none;
        font-size: 18px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        min-width: 180px;
        text-align: center;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        }

        .button:active {
            transform: translateY(0);
        }

        .button-primary {
            background: #097cffff;
            color: white;
        }

        .button-primary:hover {
            background: #1482ffff;
            color: white;
        }

        .button-secondary {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .button-secondary:hover {
            background: rgba(255, 255, 255, 0.25);
            color: white;
        }

        h2{
            color: blue;
        }

        .main-content {
            position: relative;
            z-index: 2;
            background: white;
            margin-top: 100vh;
            text-align: center;
            justify-content: center;
            align-items: center;
        }

        #hero-content{
            text-align: center;
            justify-content: center;
            align-items: center;
        }

        .welcome-section {
            padding: 80px 0;
            background: white;
        }

        .features-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        .testimonials-section {
            padding: 80px 0;
            background: white;
        }

        .stats-section {
            padding: 80px 0;
            background: #f8f9fa;
        }

        #mypara{
            justify-content: center;
            text-align: center;
            align-items: center;
            margin-left: 150px;
        }
</style> 
@section('content')
    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content" id="hero-content">
            <h1>Travel anywhere in <span>Cameroon</span><br>with peace of mind</h1>
            <p id="mypara">Discover bus schedules, fares and directly contact transport<br>agencies across Cameroon.</p>
            <div class="hero-buttons">
                <a type="button" class="button button-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Choose my city
                </a>

                <a type="button" class="button button-secondary" href="{{ route('marketplace') }}">
                    View agencies
                </a>
            </div>
        </div>
    </section>

    <main class="main-content">

        <!-- Welcome Section -->
        <section class="welcome-section" style="margin-top: 40px; background: white; padding: 80px 0;">
            <div class="container">
                <h2>Welcome to our platform</h2>
                <p>YourTrip connects multiple road travel agencies to offer you the best transportation service across Cameroon. Discover our partner agencies and travel with complete peace of mind.</p>
                
                <div class="services-grid" id="services">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-bus"></i>
                        </div>
                        <h3>Inter-city Transport</h3>
                        <p>Travel comfortably between Cameroon's main cities with our modern and secure buses.</p>
                    </div>
                    
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <h3>Multiple Destinations</h3>
                        <p>Access a wide network of destinations throughout Cameroon territory.</p>
                    </div>
                    
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Safe Travel</h3>
                        <p>Our partner agencies comply with the strictest safety standards.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features-section">
            <div class="container">
                <h2 style="text-align: center; margin-bottom: 2rem; color: #2c3e50;">Why choose Routier+?</h2>
                <div class="features-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>24/7 Booking</h3>
                        <p>Book your tickets anytime, anywhere</p>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <h3>Mobile Application</h3>
                        <p>Interface optimized for all your devices</p>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3>Customer Support</h3>
                        <p>Dedicated assistance for all your needs</p>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <h3>Secure Payment</h3>
                        <p>Protected transactions and multiple options</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials-section">
            <div class="container">
                <h2 style="color: #2c3e50; margin-bottom: 1rem;">What our customers say</h2>
                <p>Discover the experiences of our satisfied users</p>
                
                <div class="testimonials-slider">
                    <div class="testimonial active">
                        <img src="{{ asset('assets/images/testimonials.png') }}" alt="Marie Kamga" class="testimonial-avatar">
                        <div class="testimonial-text">
                            "Excellent service! I was able to easily book my trip from Douala to Yaoundé. The bus was comfortable and on time."
                        </div>
                        <div class="testimonial-author">Marie Kamga - Douala</div>
                    </div>
                    
                    <div class="testimonial">
                        <img src="{{ asset('assets/images/testimonials.png') }}" alt="Jean Ngono" class="testimonial-avatar">
                        <div class="testimonial-text">
                            "YourTrip saved me a lot of time. No need to travel to buy my tickets anymore!"
                        </div>
                        <div class="testimonial-author">Jean Ngono - Yaoundé</div>
                    </div>
                    
                    <div class="testimonial">
                        <img src="{{ asset('assets/images/testimonials.png') }}" alt="Aminata Talla" class="testimonial-avatar">
                        <div class="testimonial-text">
                            "Simple and intuitive interface. Customer service is very responsive. I highly recommend!"
                        </div>
                        <div class="testimonial-author">Aminata Talla - Bamenda</div>
                    </div>
                    
                    <div class="testimonial">
                        <img src="{{ asset('assets/images/testimonials.png') }}" alt="Paul Fosso" class="testimonial-avatar">
                        <div class="testimonial-text">
                            "Thanks to YourTrip, I easily compare prices and schedules from different agencies. Very convenient!"
                        </div>
                        <div class="testimonial-author">Paul Fosso - Bafoussam</div>
                    </div>
                </div>
                
                <div class="slider-nav">
                    <span class="slider-dot active" onclick="showTestimonial(0)"></span>
                    <span class="slider-dot" onclick="showTestimonial(1)"></span>
                    <span class="slider-dot" onclick="showTestimonial(2)"></span>
                    <span class="slider-dot" onclick="showTestimonial(3)"></span>
                </div>
            </div>
        </section>
    </main>
@endsection