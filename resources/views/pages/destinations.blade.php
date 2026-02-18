@extends('layouts.app')

@section('title', 'Find Your Perfect Journey')

@section('content')

<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        /* Header */
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            z-index: 1000;
            padding: 1rem 0;
        }
        
        .nav {
            width: 100%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1rem;
        }  
        
        /* Hero Section */
        .hero-section {
            min-height: 70vh;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url('{{ asset("assets/images/destination-image.png") }}') center/cover no-repeat;
        }
        
        /* Main Content */
        .main-content {
            background: #f8fafc;
            margin-top: -20px;
            position: relative;
            padding: 4rem 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 3rem;
        }
        
        .filters {
            display: flex;
            gap: .7rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .filter-btn {
            padding: 5px 15px;
            background: #f4faff;
            color: #667eea;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
        }
        
        .filter-btn.active,
        .filter-btn:hover {
            background: #2563eb;
            color: white !important;
        }

        .city-card {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 8px 22px rgba(0,0,0,0.12);
            transition: all 0.4s ease;
        }

        .city-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 45px rgba(0,0,0,0.25);
        }

        /* IMAGE */
        .city-image-wrapper {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .city-image-wrapper img,
        .city-image-wrapper > div {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        /* VOILE */
        .city-image-wrapper .overlay-veil {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(
                to top,
                rgba(0,0,0,0.7) 0%,
                rgba(0,0,0,0.3) 50%,
                transparent 100%
            );
            transform: translateY(0);
            transition: transform 0.4s ease;
            z-index: 1;
            pointer-events: none;
        }

        /* HOVER EFFECT - Only on image section */
        .city-image-wrapper:hover .overlay-veil {
            transform: translateY(-30px);
        }

        .city-image-wrapper:hover > div {
            transform: scale(1.08);
        }

        .city-image-wrapper .image-bg {
            transition: transform 0.4s ease;
        }

        /* Region badge */
        .region-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #2563eb;
            color: white;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 600;
            border-radius: 20px;
            z-index: 10;
        }

        /* Text inside image - left aligned */
        .city-image-text {
            position: absolute;
            bottom: 12px;
            left: 12px;
            text-align: left;
            z-index: 2;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .nav {
                padding: 0 1rem;
            }
            
            .filters {
                justify-content: flex-start;
                overflow-x: auto;
                padding-bottom: 0.5rem;
            }
        }
</style>   

    {{-- Hero Section --}}
    <section class="hero-section d-flex align-items-center text-center text-white" style="height: 100%;">
        <div class="container position-relative">
            <h1 class="fw-bold display-5 mb-3">
                Explore Cameroon
            </h1>

            <p class="lead mb-4">
                Discover all destinations served by our partner agencies.
                From north to south, and east to west, travel all across Cameroon.
            </p>

            <!-- Stats -->
            <div class="d-flex justify-content-center gap-4 flex-wrap small">
                <span style="color: white;">
                    <i class="fas fa-map me-1"></i>
                    {{ $totalRegions }} regions
                </span>
                <span style="color: white;">
                    <i class="fas fa-city me-1"></i>
                    {{ $totalDestinations }} destinations
                </span>
                <span style="color: white;">
                    <i class="fas fa-building me-1"></i>
                    {{ $totalAgencies }} agencies
                </span>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <main class="main-content">
        <div class="container">
            <h2 class="section-title">Our Destinations</h2>
            
            <!-- Filters -->
            <div class="filters">
                <a href="{{ route('destinations') }}" 
                   class="filter-btn {{ !$regionFilter || $regionFilter == 'all' ? 'active' : '' }}">
                    All regions
                </a>
                @foreach($regions as $region)
                    <a href="{{ route('destinations', ['region' => $region]) }}" 
                       class="filter-btn {{ $regionFilter == $region ? 'active' : '' }}">
                        {{ $region }}
                    </a>
                @endforeach
            </div>
            
            <!-- Cities Grid -->
            <div class="row g-3 py-1">
                @forelse($cities as $city)
                    <div class="col-md-6 col-lg-4">
                        <div class="city-card">
                            <!-- IMAGE -->
                            <div class="city-image-wrapper">
                                <div class="position-relative image-bg" 
                                     style="height: 220px; background-image: url('{{ asset('assets/images/douala.png') }}'); background-size: cover; background-position: center;">
                                    <div class="overlay-veil"></div>
                                    
                                    <!-- Region badge -->
                                    <span class="region-badge">{{ $city->region }}</span>
                                    
                                    <!-- Text inside image - left aligned -->
                                    <div class="city-image-text text-white">
                                        <h5 class="fw-bold mb-1">{{ $city->name }}</h5>
                                        <p class="mb-0 text-white-50 small">{{ $city->description }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- CONTENT -->
                            <div class="p-3">
                                <div class="d-flex justify-content-between text-center">
                                    <div>
                                        <strong>{{ $city->population }}</strong><br>
                                        <small class="text-muted">Population</small>
                                    </div>

                                    <div>
                                        <strong>{{ $city->agencies_count }}</strong><br>
                                        <small class="text-muted">{{ $city->agencies_count > 1 ? 'Agencies' : 'Agency' }}</small>
                                    </div>

                                    <div>
                                        <strong>{{ $city->routes_count }}</strong><br>
                                        <small class="text-muted">{{ $city->routes_count > 1 ? 'Trips' : 'Trip' }}</small>
                                    </div>
                                </div>

                                <a href="{{ route('marketplace.city', $city->slug) }}" 
                                   class="mt-3 text-decoration-none fw-semibold d-inline-block text-primary">
                                    View trips <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-city" style="font-size: 64px; color: #ccc; margin-bottom: 20px;"></i>
                            <h4 class="fw-bold mb-2">No destinations found</h4>
                            <p class="text-muted">
                                @if($regionFilter && $regionFilter != 'all')
                                    No destinations available in the region {{ $regionFilter }}.
                                @else
                                    No destinations are currently available.
                                @endif
                            </p>
                            <a href="{{ route('destinations') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-refresh"></i> View all destinations
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($cities->count() > 0)
                <div class="text-center mt-5">
                    <p class="text-muted">
                        Showing {{ $cities->count() }} 
                        {{ $cities->count() > 1 ? 'destinations' : 'destination' }}
                        @if($regionFilter && $regionFilter != 'all')
                            in the region {{ $regionFilter }}
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </main>

    <script>
        // Add entrance animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.city-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Smooth scroll when clicking filter
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>

@endsection