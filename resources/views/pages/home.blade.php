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
        background-image: url('{{ asset('assets/images/home.png') }}');
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
        /* bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.4) 100%); */
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
        text-align: center;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        max-width: 100%;
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
        .hero p {
            font-size: 1rem;
            padding: 0 15px;
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
        text-align: center;
        margin: 0 auto;
        max-width: 100%;
        padding: 0 20px;
    }

    @media (max-width: 768px) {
        #mypara {
            padding: 0 15px;
        }
    }

    /* Form styling */
    .search-section .form-label {
        margin-bottom: 0.5rem;
        margin-inline-start: 0;
        font-weight: 500;
        display: block;
        text-align: left;
    }

    .search-section .form-select-wrapper {
        position: relative;
    }

    .search-section .form-select-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
        z-index: 10;
        font-size: 1rem;
    }

    .search-section .form-select {
        padding-left: 40px;
        height: 38px;
        position: relative;
        z-index: 1;
    }

    .search-section .btn-primary {
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.375rem 0.75rem;
    }

    .search-section .row {
        align-items: flex-end;
    }

    .search-section .mb-3 {
        margin-bottom: 1rem !important;
    }

    .search-section .row {
        display: flex;
        flex-wrap: wrap;
    }

    .search-section .col-lg-5,
    .search-section .col-lg-4,
    .search-section .col-lg-3 {
        flex: 1 1 auto;
        min-width: 0;
    }

    .popular-routes{
        align-items: left;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-left: 25px;
        margin-bottom: 2rem;
    }

    .route-tag {
        text-align: center;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        background: #f4faff;
        color: #000;
    }

    /* Cards section styling */
    .popular-routes-section {
        margin: 2rem 0;
    }

    .popular-routes-section .row {
        margin: 2rem 0;
    }

    .popular-routes-section .card {
        margin-bottom: 1.5rem;
        transition: box-shadow 0.3s ease;
        overflow: hidden;
    }

    .popular-routes-section .card:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
    }

    .popular-routes-section .card-img-top {
        transition: transform 0.5s ease;
        width: 100%;
    }

    .popular-routes-section .card:hover .card-img-top {
        transform: scale(1.1);
    }

    /* Performance stats section */
    .performance-section-wrapper {
        margin-top: 3rem;
    }

    .performance-card {
        background: linear-gradient(90deg, #1d4ed8, #2563eb, #1e40af);
        border-radius: 24px;
        color: #fff;
        padding: 2.5rem 1.5rem;
        box-shadow: 0 15px 30px rgba(15, 23, 42, 0.35);
    }

    .performance-card h2 {
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .performance-card p.lead {
        font-size: 0.95rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    .performance-card .stat-number {
        font-size: 1.8rem;
        font-weight: 800;
        color: yellow;
    }

    .performance-card .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    /* Ready to Travel Section */
    .ready-to-travel-section {
        margin-bottom: 0 !important;
    }

    .ready-to-travel-section .container-fluid:last-child {
        margin-bottom: 0 !important;
        padding-bottom: 4rem !important;
    }

    @media (min-width: 768px) {
        .popular-routes-section {
            margin: 3rem 0;
        }
    }

    /* Remove hover effect from View all routes button */
    .view-all-routes-btn {
        transition: none;
    }

    .view-all-routes-btn:hover {
        transform: none !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3) !important;
    }

    .view-all-routes-btn:active {
        transform: none !important;
    }

    @media (min-width: 992px) {
        .search-section .col-lg-5 {
            flex: 0 0 40%;
            max-width: 40%;
        }
        .search-section .col-lg-4 {
            flex: 0 0 35%;
            max-width: 35%;
        }
        .search-section .col-lg-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }
    }
</style> 


@section('content')
    <!-- Hero Section -->
    <section class="hero" id="home" style="background-image: url('{{ asset('assets/images/home.png') }}');">
        <div class="hero-content" id="hero-content">
            <h1>Travel anywhere in <span>Cameroon</span><br>with peace of mind</h1>
            <p id="mypara">Discover bus schedules, fares and directly contact transport<br>agencies across Cameroon.</p>
            <div class="hero-buttons">
                <a type="button" class="button button-primary" href="{{ route('marketplace') }}">
                    Choose my city
                </a>

                <a type="button" class="button button-secondary" href="{{ route('agency') }}">
                    View agencies
                </a>
            </div>
        </div>
    </section>

    <main class="main-content">

        <!-- Welcome Section -->
        <section class="welcome-section" style="margin: 70px; background: white; padding: 80px 0;">
            <div class="container">
                <h2>Find Your Perfect Journey</h2>
                <p>Search and instantly book your trip with the best transport agencies in Cameroon</p>

                <div class="search-section" style="border-radius: 10px;">
                    <div class="card shadow">
                        {{-- DYNAMIC FORM --}}
                        <form action="{{ route('home.search') }}" method="GET" id="homeSearchForm">
                            <div class="row p-4 g-3">
                                <div class="col-lg-5 col-md-6 mb-3">
                                    <label for="from" class="form-label">From</label>
                                    <div class="form-select-wrapper">
                                        <i class="fas fa-map-marker-alt" style="color: green;"></i>
                                        <select name="from" id="from" class="form-select" required>
                                            <option value="">Departure city</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->name }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="to" class="form-label">To</label>
                                    <div class="form-select-wrapper">
                                        <i class="fas fa-map-marker-alt" style="color: red;"></i>
                                        <select name="to" id="to" class="form-select" required>
                                            <option value="">Destination</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->name }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-12 mb-3">
                                    <label for="search" class="form-label">Search</label>
                                    <button type="submit" class="btn btn-primary w-100" id="search">
                                        <i class="fas fa-search"></i>
                                        Search
                                    </button>
                                </div>
                            </div>
                        </form>

                        {{-- DYNAMIC POPULAR ROUTES --}}
                        <h6 style="text-align: left; margin-left: 25px;">Popular routes</h6>
                        <div class="popular-routes">
                            @if($popularRoutes && $popularRoutes->count() > 0)
                                @foreach($popularRoutes->take(3) as $route)
                                    <span class="route-tag" style="cursor: pointer;" 
                                        onclick="fillSearchForm('{{ $route->fromCity->name }}', '{{ $route->toCity->name }}')">
                                        {{ $route->fromCity->name }} ? {{ $route->toCity->name }}
                                    </span>
                                @endforeach
                            @else
                                {{-- Fallback static routes --}}
                                <span class="route-tag" style="cursor: pointer;" onclick="fillSearchForm('Bertoua', 'Yaound�')">
                                    Bertou->Yaoundé
                                </span>
                                <span class="route-tag" style="cursor: pointer;" onclick="fillSearchForm('Yaound�', 'Douala')">
                                    Yaound->Douala
                                </span>
                                <span class="route-tag" style="cursor: pointer;" onclick="fillSearchForm('Douala', 'Bafoussam')">
                                    Doual->Bafoussam
                                </span>
                            @endif
                        </div>
                    </div>
                </div> 
            </div>
        </section>

        {{-- JavaScript for popular routes quick-select --}}
        <script>
            function fillSearchForm(from, to) {
                // Fill the form fields
                document.getElementById('from').value = from;
                document.getElementById('to').value = to;
                
                // Optionally auto-submit
                // document.getElementById('homeSearchForm').submit();
            }
        </script>
        
        {{-- Stats Section --}}
        <section class="py-5" style="background-color: #f4faff; height=: 500px;">
            <div class="container">
                <div class="row text-center gy-4">

                    <!-- Partner Agencies -->
                    <div class="col-6 col-md-3">
                        <div class="mb-5">
                            <i class="fas fa-bus fa-2x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-0">45+</h3>
                        <p class="text-muted mb-0">Partner Agencies</p>
                    </div>

                    <!-- Active Routes -->
                    <div class="col-6 col-md-3">
                        <div class="mb-5">
                            <i class="fas fa-route fa-2x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-0">200+</h3>
                        <p class="text-muted mb-0">Active Routes</p>
                    </div>

                    <!-- Happy Travelers -->
                    <div class="col-6 col-md-3">
                        <div class="mb-5">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                        <h3 class="fw-bold mb-0">50K+</h3>
                        <p class="text-muted mb-0">Happy Travelers</p>
                    </div>

                    <!-- Average Rating -->
                    <div class="col-6 col-md-3">
                        <div class="mb-5">
                            <i class="fas fa-star fa-2x text-warning"></i>
                        </div>
                        <h3 class="fw-bold mb-0">4.8/5</h3>
                        <p class="text-muted mb-0">Average Rating</p>
                    </div>

                </div>
            </div>
        </section>

        {{-- Popular Routes Section --}}
        <section class="py-5 popular-routes-section">
            <div class="container-fluid px-0 px-md-5">
                <h1>Most Popular Routes</h1>
                <p>Travel safely through Cameroon's routes</p>

                @php
                    $routeCardImages = [
                        'routes.png',
                        'douala.png',
                        'yaounde.png',
                        'bafoussam.png',
                        'destination-image.png',
                        'beau.png',
                    ];
                @endphp
                <div class="row g-3 mb-4 mt-4">
                    @forelse($popularRoutes as $route)
                        @php
                            $routeImage = $routeCardImages[$loop->index % count($routeCardImages)];
                        @endphp
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                                <!-- Top image with overlay text -->
                                <div class="position-relative d-flex align-items-end p-3"
                                    style="height: 180px; background-image: url('{{ asset('assets/images/' . $routeImage) }}'); background-size: cover; background-position: center;">
                                    <div class="position-absolute top-0 start-0 w-100 h-100"
                                        style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);">
                                    </div>
                                    <div class="position-relative text-white" style="z-index: 1;">
                                        <h5 class="fw-bold mb-1">
                                            {{ $route->fromCity->name }} ? {{ $route->toCity->name }}
                                        </h5>
                                        <p class="mb-0 text-white-50">
                                            {{ $route->travelers_per_month }}+ travelers/month
                                        </p>
                                    </div>
                                </div>

                                <!-- Card body: prices, duration, rating -->
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <small class="text-muted">Starting from</small>
                                            <h6 class="fw-bold mb-0">{{ number_format($route->min_price, 0, ',', ' ') }} XAF</h6>
                                        </div>

                                        <div class="text-end">
                                            <small class="text-muted">Duration</small>
                                            <h6 class="fw-bold mb-0">
                                                @php
                                                    $hours = floor($route->estimated_duration_min / 60);
                                                    $minutes = $route->estimated_duration_min % 60;
                                                @endphp
                                                {{ $hours }}h {{ $minutes }}min
                                            </h6>
                                        </div>

                                        <div class="text-warning fw-bold">
                                            ? 4.{{ rand(2, 8) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                                <div class="position-relative d-flex align-items-end p-3"
                                    style="height: 180px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);"></div>
                                    <div class="position-relative text-white" style="z-index: 1;">
                                        <h5 class="fw-bold mb-1">Yaound� ? Douala</h5>
                                        <p class="mb-0 text-white-50">980+ travelers/month</p>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div><small class="text-muted">Starting from</small><h6 class="fw-bold mb-0">4,500 XAF</h6></div>
                                        <div class="text-end"><small class="text-muted">Duration</small><h6 class="fw-bold mb-0">4h 15min</h6></div>
                                        <div class="text-warning fw-bold">? 4.2</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('marketplace') }}" class="button button-primary m-2 view-all-routes-btn" style="text-decoration: none;">
                        View all routes
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </section>

        {{-- Our Partner Agencies Section --}}
        <section class="py-5">  
            <div class="container">
                <h1>Our Partner Agencies</h1>
                <p>Travel safely through Cameroon's routes</p>

                @php
                    $agencyCardImages = [
                        'agency1.png',
                        'agency2.png',
                        'agency3.png',
                        'agency-image.png',
                        'download.jpg',
                        'licensed-image2.jpeg',
                    ];
                @endphp
                <div class="row g-3 mb-4 mt-4">
                    @forelse($partnerAgencies as $company)
                        @php
                            if (!empty($company->logo)) {
                                if (\Illuminate\Support\Str::startsWith($company->logo, ['http://', 'https://'])) {
                                    $agencyImage = $company->logo;
                                } elseif (\Illuminate\Support\Str::startsWith($company->logo, ['assets/', 'storage/'])) {
                                    $agencyImage = asset($company->logo);
                                } else {
                                    $agencyImage = asset('storage/' . ltrim($company->logo, '/'));
                                }
                            } else {
                                $agencyImage = asset('assets/images/' . $agencyCardImages[$loop->index % count($agencyCardImages)]);
                            }
                        @endphp
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card shadow-sm rounded-4 overflow-hidden" style="width: 100%;">
                                <!-- Image section -->
                                <div class="position-relative">
                                    <img 
                                        src="{{ $agencyImage }}"
                                        class="card-img-top" 
                                        alt="{{ $company->name }}"
                                        style="height: 200px; object-fit: cover;"
                                    >
                                    <!-- Rating badge -->
                                    <span class="badge bg-light text-dark position-absolute top-0 end-0 m-2 px-3 py-2 rounded-pill">
                                        ? {{ number_format($company->rating, 1) }}
                                    </span>
                                </div>

                                <!-- Card body -->
                                <div class="card-body">
                                    <!-- Agency name -->
                                    <h5 class="card-title fw-bold mb-1">
                                        {{ $company->name }}
                                    </h5>

                                    <!-- Location -->
                                    @if($company->main_agency)
                                        <p class="text-muted mb-2">
                                            <i class="bi bi-geo-alt-fill"></i> 
                                            {{ $company->main_agency->city->name }}, {{ $company->main_agency->city->region }}
                                        </p>
                                    @endif

                                    <!-- Routes -->
                                    <p class="mb-2">
                                        <strong>Principales routes :</strong><br>
                                        @if($company->unique_routes->count() > 0)
                                            {{ $company->unique_routes->take(2)->implode(', ') }}
                                            @if($company->unique_routes->count() > 2)
                                                +{{ $company->unique_routes->count() - 2 }}
                                            @endif
                                        @else
                                            Multiple destinations
                                        @endif
                                    </p>

                                    <!-- Services tags -->
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        @foreach($company->available_services->take(3) as $service)
                                            <span class="route-tag">{{ $service }} Service</span>
                                        @endforeach
                                    </div>

                                    <!-- Actions -->
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('agency_details', $company->slug) }}" class="btn btn-primary flex-grow-1" style="justify-content: center;">
                                            View details
                                        </a>
                                        <button class="btn btn-outline-secondary">
                                            <i class="fas fa-phone"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card shadow-sm rounded-4 overflow-hidden" style="width: 100%;">
                                <div class="position-relative">
                                    <img src="{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}" class="card-img-top" alt="Agency" style="height: 200px; object-fit: cover;">
                                    <span class="badge bg-light text-dark position-absolute top-0 end-0 m-2 px-3 py-2 rounded-pill">? 4.9</span>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold mb-1">Transport Agency</h5>
                                    <p class="text-muted mb-2"><i class="bi bi-geo-alt-fill"></i> Cameroon</p>
                                    <p class="mb-2"><strong>Principales routes :</strong><br>Multiple destinations</p>
                                    <div class="d-flex flex-wrap gap-2 mb-3"><span class="route-tag">VIP Service</span></div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('agency') }}" class="btn btn-primary flex-grow-1">View details</a>
                                        <button class="btn btn-outline-secondary"><i class="fas fa-phone"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('agency') }}" class="button button-primary m-2 view-all-routes-btn" style="text-decoration: none;">
                        View all agencies
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </section>

        {{-- Popular Destinations Section --}}
        <section class="py-5 popular-routes-section">
                <div class="container">
                    <h1>Most Popular Destinations</h1>
                    <p>Travel safely through Cameroon's routes</p>

                    @php
                        $destinationCardImages = [
                            'bafoussam.png',
                            'douala.png',
                            'yaounde.png',
                            'destination-image.png',
                            'beau.png',
                            'routes.png',
                        ];
                    @endphp
                    <div class="row g-3 mb-4 mt-4">
                        @forelse($popularDestinations as $destination)
                            @php
                                $destinationImage = $destinationCardImages[$loop->index % count($destinationCardImages)];
                            @endphp
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card shadow-sm rounded-4 overflow-hidden" style="max-width: 400px;">
                                    <!-- Image -->
                                    <div class="position-relative d-flex align-items-end p-3"
                                        style="height: 220px; background-image: url('{{ asset('assets/images/' . $destinationImage) }}'); background-size: cover; background-position: center;">
                                        <div class="position-absolute top-0 start-0 w-100 h-100"
                                            style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);">
                                        </div>
                                        <div class="position-relative text-white" style="z-index: 1;">
                                            <h5 class="fw-bold mb-1">
                                                {{ $destination->name }}
                                            </h5>
                                            <p class="mb-0 text-white-50">
                                                {{ $destination->travelers_per_month }}+ travelers/month
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="card-body">
                                        <!-- Bottom row -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <!-- Infos -->
                                            <div class="text-muted">
                                                <i class="bi bi-building"></i> {{ $destination->agencies_count }} agencies
                                                <span class="mx-2">�</span>
                                                <i class="bi bi-signpost-2"></i> {{ $destination->routes_count }} routes
                                            </div>

                                            <!-- Explore -->
                                            <a href="{{ route('marketplace.city', $destination->slug) }}" class="text-decoration-none fw-semibold">
                                                Explore
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card shadow-sm rounded-4 overflow-hidden" style="max-width: 400px;">
                                    <div class="position-relative d-flex align-items-end p-3" style="height: 220px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);"></div>
                                        <div class="position-relative text-white" style="z-index: 1;">
                                            <h5 class="fw-bold mb-1">Yaound�</h5>
                                            <p class="mb-0 text-white-50">980+ travelers/month</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="text-muted"><i class="bi bi-building"></i> 45 agencies <span class="mx-2">�</span> <i class="bi bi-signpost-2"></i> 28 routes</div>
                                            <a href="{{ route('destinations') }}" class="text-decoration-none fw-semibold">Explore</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('destinations') }}" class="button button-primary m-2 view-all-routes-btn" style="text-decoration: none;">
                            View all destinations
                            <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </section>

        {{-- Why Choose Us Section --}}
        <section class="py-5" style="background: white;">  
            <div class="container">
                <div class="text-center mb-5">
                    <h1>Why choose us?</h1>
                    <p class="text-muted mb-0">
                        Services designed to make your trips simpler, safer, and more transparent.
                    </p>
                </div>

                <div class="row g-4">
                    <!-- Verified agencies -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="text-center p-4 h-100" style="background: #f8fafc; border-radius: 16px;">
                            <div class="mb-3">
                                <i class="fas fa-shield-alt fa-2x" style="color: #2563eb;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Verified agencies</h5>
                            <p class="text-muted">All our partner agencies are verified and certified for your safety</p>
                        </div>
                    </div>

                    <!-- Real-Time Schedules -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="text-center p-4 h-100" style="background: #f0fdf4; border-radius: 16px;">
                            <div class="mb-3">
                                <i class="fas fa-clock fa-2x" style="color: #16a34a;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Real-Time Schedules</h5>
                            <p class="text-muted">Check schedules in real time and book your tickets instantly</p>
                        </div>
                    </div>

                    <!-- Support 24/7 -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="text-center p-4 h-100" style="background: #f5f3ff; border-radius: 16px;">
                            <div class="mb-3">
                                <i class="fas fa-headset fa-2x" style="color: #7c3aed;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Support 24/7</h5>
                            <p class="text-muted">Our team is available 24/7 to answer all your questions</p>
                        </div>
                    </div>

                    <!-- Transparent Pricing -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="text-center p-4 h-100" style="background: #fef2f2; border-radius: 16px;">
                            <div class="mb-3">
                                <i class="fas fa-tag fa-2x" style="color: #dc2626;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Transparent Pricing</h5>
                            <p class="text-muted">Clear and transparent pricing with no hidden fees for confident booking</p>
                        </div>
                    </div>
                </div>

                <!-- Our Performance section -->
                <div class="performance-section-wrapper">
                    <div class="performance-card text-center">
                        <h2>Our Performance</h2>
                        <p class="lead">Numbers that reflect our commitment to delivering the best service.</p>

                        <div class="row text-center gy-4 gx-4">
                            <div class="col-6 col-md-3">
                                <div class="stat-number">150+</div>
                                <div class="stat-label">Partner Agencies</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-number">50K+</div>
                                <div class="stat-label">Satisfied Travelers</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-number">300+</div>
                                <div class="stat-label">Available Routes</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-number">99%</div>
                                <div class="stat-label">Satisfaction Rate</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Ready to Travel Section -->
        <section class="ready-to-travel-section" style="margin-bottom: 0;">
            <!-- Light Grey Hero Section -->
            <div class="container-fluid py-5" style="background: #f8f9fa;">
                <div class="container text-center py-5">
                    <h1 class="display-4 fw-bold mb-4">Ready to Travel?</h1>
                    <p class="lead mb-5">Join thousands of travelers who trust us for their trips across Cameroon.</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('marketplace') }}" class="btn btn-primary btn-lg px-5 py-3" style="border-radius: 10px; font-weight: 600;">
                            Search for a Trip
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-lg px-5 py-3" style="border-radius: 10px; font-weight: 600; border-width: 2px;">
                            Become a Partner
                        </a>
                    </div>
                </div>
            </div>

            <!-- Blue CTA Section -->
            <div class="container-fluid py-5" style="background: #2563eb; margin-bottom: 0;">
                <div class="container text-center py-5">
                    <h2 class="text-white fw-bold mb-3" style="font-size: 2.5rem;">Prêt à voyager ?</h2>
                    <p class="text-white lead mb-5">Rejoignez les milliers de voyageurs qui font confiance à Routier+ pour leurs voyages.</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('marketplace') }}" class="btn btn-light btn-lg px-5 py-3" style="border-radius: 10px; font-weight: 600;">
                            rechercher un voyage
                        </a>
                        <a href="{{ route('sign_up') }}" class="btn btn-outline-light btn-lg px-5 py-3" style="border-radius: 10px; font-weight: 600; border-width: 2px;">
                            <i class="fas fa-user-plus" style="margin-right: 5px;"></i>
                            inscrivez-vous gratuitement
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
