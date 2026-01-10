@extends('layouts.app')

@section('title', 'About Us')

<link rel="stylesheet" href="{{ asset('css/about.css') }}"

@section('content')
    <!-- Hero Section -->
    <section class="hero" id="about-hero">
        <div class="hero-content">
            <h1>About YourTrip</h1>
            <p>Your trusted travel companion across Cameroon</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="welcome-section">
        <div class="container">
            <h2>Our Story</h2>
            <p class="lead">
                YourTrip is your trusted travel companion, helping you discover amazing destinations and plan unforgettable journeys across Cameroon.
            </p>
            
            <div class="services-grid" id="mission">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Our Mission</h3>
                    <p>We aim to make travel planning simple, enjoyable, and accessible for everyone. Whether you're seeking adventure, relaxation, or cultural experiences, YourTrip provides the tools and inspiration you need.</p>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>Our Values</h3>
                    <p>We believe in transparency, reliability, and exceptional service. Our commitment is to provide you with the best travel experience possible.</p>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3>Our Community</h3>
                    <p>Join thousands of satisfied travelers who trust YourTrip for their journey planning needs across Cameroon.</p>
                </div>
            </div>

            <div class="text-center mt-5">
                <p class="lead">
                    Have questions or need assistance? <a href="{{ route('contact') }}" class="btn btn-primary">Contact our team</a>
                </p>
            </div>
        </div>
    </section>
@endsection