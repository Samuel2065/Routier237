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
                <h2>Find Your Pecfect journey</h2>
                <p>Search and instantly book your trip with the best transport agencies in Cameroon</p>

                <div class="search-section" style="border-radius: 10px;">
                    <div class="card shadow">
                        <form action="" method="post">
                            <div class="row p-4 g-3">
                                <div class="col-lg-5 col-md-6 mb-3">
                                    <label for="from" class="form-label">From</label>
                                    <div class="form-select-wrapper">
                                        <i class="fas fa-map-marker-alt" style="color: green;"></i>
                                        <select name="" id="from" class="form-select">
                                            <option value="">Departure city</option>
                                            <option value="">Yaounde</option>
                                            <option value="">Bertoua</option>
                                            <option value="">Douala</option>
                                            <option value="">Bamenda</option>
                                            <option value="">Beau</option>
                                            <option value="">Ngaoundere</option>
                                            <option value="">Maroua</option>
                                            <option value="">Garoua</option>
                                            <option value="">Bafoussam</option>
                                            <option value="">Ebolowa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <label for="To" class="form-label">To</label>
                                    <div class="form-select-wrapper">
                                        <i class="fas fa-map-marker-alt" style="color: red;"></i>
                                        <select name="" id="from" class="form-select">
                                            <option value="">Destination </option>
                                            <option value="">Yaounde</option>
                                            <option value="">Bertoua</option>
                                            <option value="">Douala</option>
                                            <option value="">Bamenda</option>
                                            <option value="">Beau</option>
                                            <option value="">Ngaoundere</option>
                                            <option value="">Maroua</option>
                                            <option value="">Garoua</option>
                                            <option value="">Bafoussam</option>
                                            <option value="">Ebolowa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-12 mb-3">
                                    <label for="search" class="form-label">Search</label>
                                    <button type="submit" class="btn btn-primary w-100" id="search">
                                        <i class="fas fa-search"></i>
                                        <a href="{{ route('marketplace') }}" style="text-decoration: none; color: white;">Search</a>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <h6 style="text-align: left; margin-left: 25px;">Popular routes</h6>
                        <div class="popular-routes">
                            <span class="route-tag">Bertoua->Yaounde</span>
                            <span class="route-tag">Yaounde->Douala</span>
                            <span class="route-tag">Douala->Kribi</span>
                        </div>
                    </div>
                </div> 
            </div>
        </section>

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
                <p>Travel savely through camerron's routes</p>

                <div class="row g-3 mb-4 mt-4">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

                            <!-- Top image with overlay text -->
                            <div class="position-relative d-flex align-items-end p-3"
                                 style="height: 180px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                     style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);">
                                </div>
                                <div class="position-relative text-white" style="z-index: 1;">
                                    <h5 class="fw-bold mb-1">
                                        Yaoundé → Douala
                                    </h5>
                                    <p class="mb-0 text-white-50">
                                        980+ travelers/month
                                    </p>
                                </div>
                            </div>

                            <!-- Card body: prices, duration, rating -->
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <small class="text-muted">Starting from</small>
                                        <h6 class="fw-bold mb-0">4,500 XAF</h6>
                                    </div>

                                    <div class="text-end">
                                        <small class="text-muted">Duration</small>
                                        <h6 class="fw-bold mb-0">4h 15min</h6>
                                    </div>

                                    <div class="text-warning fw-bold">
                                        ⭐ 4.2
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

                            <!-- Top image with overlay text -->
                            <div class="position-relative d-flex align-items-end p-3"
                                 style="height: 180px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                     style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);">
                                </div>
                                <div class="position-relative text-white" style="z-index: 1;">
                                    <h5 class="fw-bold mb-1">
                                        Yaoundé → Douala
                                    </h5>
                                    <p class="mb-0 text-white-50">
                                        980+ travelers/month
                                    </p>
                                </div>
                            </div>

                            <!-- Card body: prices, duration, rating -->
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <small class="text-muted">Starting from</small>
                                        <h6 class="fw-bold mb-0">4,500 XAF</h6>
                                    </div>

                                    <div class="text-end">
                                        <small class="text-muted">Duration</small>
                                        <h6 class="fw-bold mb-0">4h 15min</h6>
                                    </div>

                                    <div class="text-warning fw-bold">
                                        ⭐ 4.2
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">

                            <!-- Top image with overlay text -->
                            <div class="position-relative d-flex align-items-end p-3"
                                 style="height: 180px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                     style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);">
                                </div>
                                <div class="position-relative text-white" style="z-index: 1;">
                                    <h5 class="fw-bold mb-1">
                                        Yaoundé → Douala
                                    </h5>
                                    <p class="mb-0 text-white-50">
                                        980+ travelers/month
                                    </p>
                                </div>
                            </div>

                            <!-- Card body: prices, duration, rating -->
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <small class="text-muted">Starting from</small>
                                        <h6 class="fw-bold mb-0">4,500 XAF</h6>
                                    </div>

                                    <div class="text-end">
                                        <small class="text-muted">Duration</small>
                                        <h6 class="fw-bold mb-0">4h 15min</h6>
                                    </div>

                                    <div class="text-warning fw-bold">
                                        ⭐ 4.2
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                <p>Travel savely through cameroon's routes</p>

                <div class="row g-3 mb-4 mt-4">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm rounded-4 overflow-hidden" style="width: 100%;">
    
                            <!-- Image section -->
                            <div class="position-relative">
                                <img 
                                    src="{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}"
                                    class="card-img-top" 
                                    alt="Agency Image"
                                    style="height: 200px; object-fit: cover;"
                                >

                                <!-- Rating badge -->
                                <span class="badge bg-light text-dark position-absolute top-0 end-0 m-2 px-3 py-2 rounded-pill">
                                    ⭐ 4.9
                                </span>
                            </div>

                            <!-- Card body -->
                            <div class="card-body">

                                <!-- Agency name -->
                                <h5 class="card-title fw-bold mb-1">
                                    Baranti Express
                                </h5>

                                <!-- Location -->
                                <p class="text-muted mb-2">
                                    <i class="bi bi-geo-alt-fill"></i> Bertoua, Est
                                </p>

                                <!-- Routes -->
                                <p class="mb-2">
                                    <strong>Principales routes :</strong><br>
                                    Yaoundé – Douala, Douala – Bertoua +1
                                </p>

                                <!-- Services tags -->
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="route-tag">VIP Services</span>
                                    <span class="route-tag">Entertainment</span>
                                    <span class="route-tag">Refreshments</span>
                                </div>

                                <!-- Actions -->
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-primary flex-grow-1" style="justify-content: center;">
                                        Voir détails
                                    </a>

                                    <button class="btn btn-outline-secondary">
                                        <i class="fas fa-phone"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm rounded-4 overflow-hidden" style="width: 100%;">
    
                            <!-- Image section -->
                            <div class="position-relative">
                                <img 
                                    src="{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}"
                                    class="card-img-top" 
                                    alt="Agency Image"
                                    style="height: 200px; object-fit: cover;"
                                >

                                <!-- Rating badge -->
                                <span class="badge bg-light text-dark position-absolute top-0 end-0 m-2 px-3 py-2 rounded-pill">
                                    ⭐ 4.9
                                </span>
                            </div>

                            <!-- Card body -->
                            <div class="card-body">

                                <!-- Agency name -->
                                <h5 class="card-title fw-bold mb-1">
                                    Baranti Express
                                </h5>

                                <!-- Location -->
                                <p class="text-muted mb-2">
                                    <i class="bi bi-geo-alt-fill"></i> Bertoua, Est
                                </p>

                                <!-- Routes -->
                                <p class="mb-2">
                                    <strong>Principales routes :</strong><br>
                                    Yaoundé – Douala, Douala – Bertoua +1
                                </p>

                                <!-- Services tags -->
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="route-tag">VIP Services</span>
                                    <span class="route-tag">Entertainment</span>
                                    <span class="route-tag">Refreshments</span>
                                </div>

                                <!-- Actions -->
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-primary flex-grow-1" style="justify-content: center;">
                                        Voir détails
                                    </a>

                                    <button class="btn btn-outline-secondary">
                                        <i class="fas fa-phone"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm rounded-4 overflow-hidden" style="width: 100%;">
    
                            <!-- Image section -->
                            <div class="position-relative">
                                <img 
                                    src="{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}"
                                    class="card-img-top" 
                                    alt="Agency Image"
                                    style="height: 200px; object-fit: cover;"
                                >

                                <!-- Rating badge -->
                                <span class="badge bg-light text-dark position-absolute top-0 end-0 m-2 px-3 py-2 rounded-pill">
                                    ⭐ 4.9
                                </span>
                            </div>

                            <!-- Card body -->
                            <div class="card-body">

                                <!-- Agency name -->
                                <h5 class="card-title fw-bold mb-1">
                                    Baranti Express
                                </h5>

                                <!-- Location -->
                                <p class="text-muted mb-2">
                                    <i class="bi bi-geo-alt-fill"></i> Bertoua, Est
                                </p>

                                <!-- Routes -->
                                <p class="mb-2">
                                    <strong>Principales routes :</strong><br>
                                    Yaoundé – Douala, Douala – Bertoua +1
                                </p>

                                <!-- Services tags -->
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="route-tag">VIP Services</span>
                                    <span class="route-tag">Entertainment</span>
                                    <span class="route-tag">Refreshments</span>
                                </div>

                                <!-- Actions -->
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-primary flex-grow-1" style="justify-content: center;">
                                        Voir détails
                                    </a>

                                    <button class="btn btn-outline-secondary">
                                        <i class="fas fa-phone"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
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
                <p>Travel savely through cameroon's routes</p>

                <div class="row g-3 mb-4 mt-4">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm rounded-4 overflow-hidden" style="max-width: 400px;">
    
                            <!-- Image -->
                            <div class="position-relative d-flex align-items-end p-3"
                                 style="height: 220px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                     style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);">
                                </div>
                                <div class="position-relative text-white" style="z-index: 1;">
                                    <h5 class="fw-bold mb-1">
                                        Yaoundé → Douala
                                    </h5>
                                    <p class="mb-0 text-white-50">
                                        980+ travelers/month
                                    </p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="card-body">

                                <!-- Bottom row -->
                                <div class="d-flex justify-content-between align-items-center">

                                    <!-- Infos -->
                                    <div class="text-muted">
                                        <i class="bi bi-building"></i> 45 agences
                                        <span class="mx-2">•</span>
                                        <i class="bi bi-signpost-2"></i> 28 routes
                                    </div>

                                    <!-- Explore -->
                                    <a href="#" class="text-decoration-none fw-semibold">
                                        Explorer →
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm rounded-4 overflow-hidden" style="max-width: 400px;">
    
                            <!-- Image -->
                            <div class="position-relative d-flex align-items-end p-3"
                                 style="height: 220px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                     style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);">
                                </div>
                                <div class="position-relative text-white" style="z-index: 1;">
                                    <h5 class="fw-bold mb-1">
                                        Yaoundé → Douala
                                    </h5>
                                    <p class="mb-0 text-white-50">
                                        980+ travelers/month
                                    </p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="card-body">

                                <!-- Bottom row -->
                                <div class="d-flex justify-content-between align-items-center">

                                    <!-- Infos -->
                                    <div class="text-muted">
                                        <i class="bi bi-building"></i> 45 agences
                                        <span class="mx-2">•</span>
                                        <i class="bi bi-signpost-2"></i> 28 routes
                                    </div>

                                    <!-- Explore -->
                                    <a href="#" class="text-decoration-none fw-semibold">
                                        Explorer →
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm rounded-4 overflow-hidden" style="max-width: 400px;">
    
                            <!-- Image -->
                            <div class="position-relative d-flex align-items-end p-3"
                                 style="height: 220px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                     style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);">
                                </div>
                                <div class="position-relative text-white" style="z-index: 1;">
                                    <h5 class="fw-bold mb-1">
                                        Yaoundé → Douala
                                    </h5>
                                    <p class="mb-0 text-white-50">
                                        980+ travelers/month
                                    </p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="card-body">

                                <!-- Bottom row -->
                                <div class="d-flex justify-content-between align-items-center">

                                    <!-- Infos -->
                                    <div class="text-muted">
                                        <i class="bi bi-building"></i> 45 agences
                                        <span class="mx-2">•</span>
                                        <i class="bi bi-signpost-2"></i> 28 routes
                                    </div>

                                    <!-- Explore -->
                                    <a href="#" class="text-decoration-none fw-semibold">
                                        Explorer →
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm rounded-4 overflow-hidden" style="max-width: 400px;">
    
                            <!-- Image -->
                            <div class="position-relative d-flex align-items-end p-3"
                                 style="height: 220px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                     style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);">
                                </div>
                                <div class="position-relative text-white" style="z-index: 1;">
                                    <h5 class="fw-bold mb-1">
                                        Yaoundé → Douala
                                    </h5>
                                    <p class="mb-0 text-white-50">
                                        980+ travelers/month
                                    </p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="card-body">

                                <!-- Bottom row -->
                                <div class="d-flex justify-content-between align-items-center">

                                    <!-- Infos -->
                                    <div class="text-muted">
                                        <i class="bi bi-building"></i> 45 agences
                                        <span class="mx-2">•</span>
                                        <i class="bi bi-signpost-2"></i> 28 routes
                                    </div>

                                    <!-- Explore -->
                                    <a href="#" class="text-decoration-none fw-semibold">
                                        Explorer →
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm rounded-4 overflow-hidden" style="max-width: 400px;">
    
                            <!-- Image -->
                            <div class="position-relative d-flex align-items-end p-3"
                                 style="height: 220px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                     style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);">
                                </div>
                                <div class="position-relative text-white" style="z-index: 1;">
                                    <h5 class="fw-bold mb-1">
                                        Yaoundé → Douala
                                    </h5>
                                    <p class="mb-0 text-white-50">
                                        980+ travelers/month
                                    </p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="card-body">

                                <!-- Bottom row -->
                                <div class="d-flex justify-content-between align-items-center">

                                    <!-- Infos -->
                                    <div class="text-muted">
                                        <i class="bi bi-building"></i> 45 agences
                                        <span class="mx-2">•</span>
                                        <i class="bi bi-signpost-2"></i> 28 routes
                                    </div>

                                    <!-- Explore -->
                                    <a href="#" class="text-decoration-none fw-semibold">
                                        Explorer →
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow-sm rounded-4 overflow-hidden" style="max-width: 400px;">
    
                            <!-- Image -->
                            <div class="position-relative d-flex align-items-end p-3"
                                 style="height: 220px; background-image: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}'); background-size: cover; background-position: center;">
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                     style="background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);">
                                </div>
                                <div class="position-relative text-white" style="z-index: 1;">
                                    <h5 class="fw-bold mb-1">
                                        Yaoundé → Douala
                                    </h5>
                                    <p class="mb-0 text-white-50">
                                        980+ travelers/month
                                    </p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="card-body">

                                <!-- Bottom row -->
                                <div class="d-flex justify-content-between align-items-center">

                                    <!-- Infos -->
                                    <div class="text-muted">
                                        <i class="bi bi-building"></i> 45 agences
                                        <span class="mx-2">•</span>
                                        <i class="bi bi-signpost-2"></i> 28 routes
                                    </div>

                                    <!-- Explore -->
                                    <a href="#" class="text-decoration-none fw-semibold">
                                        Explorer →
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
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
                        Des services pensés pour rendre vos trajets plus simples, sûrs et transparents.
                    </p>
                </div>

                <div class="row g-4">
                    <!-- Agences Vérifiées -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="text-center p-4 h-100" style="background: #f8fafc; border-radius: 16px;">
                            <div class="mb-3">
                                <i class="fas fa-shield-alt fa-2x" style="color: #2563eb;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Agences Vérifiées</h5>
                            <p class="text-muted">Toutes nos agences partenaires sont vérifiées et certifiées pour votre sécurité</p>
                        </div>
                    </div>

                    <!-- Horaires Temps Réel -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="text-center p-4 h-100" style="background: #f0fdf4; border-radius: 16px;">
                            <div class="mb-3">
                                <i class="fas fa-clock fa-2x" style="color: #16a34a;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Horaires Temps Réel</h5>
                            <p class="text-muted">Consultez les horaires en temps réel et réservez vos billets instantanément</p>
                        </div>
                    </div>

                    <!-- Support 24/7 -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="text-center p-4 h-100" style="background: #f5f3ff; border-radius: 16px;">
                            <div class="mb-3">
                                <i class="fas fa-headset fa-2x" style="color: #7c3aed;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Support 24/7</h5>
                            <p class="text-muted">Notre équipe est disponible 24h/24 et 7j/7 pour répondre à toutes vos questions</p>
                        </div>
                    </div>

                    <!-- Tarifs Transparents -->
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="text-center p-4 h-100" style="background: #fef2f2; border-radius: 16px;">
                            <div class="mb-3">
                                <i class="fas fa-tag fa-2x" style="color: #dc2626;"></i>
                            </div>
                            <h5 class="fw-bold mb-3">Tarifs Transparents</h5>
                            <p class="text-muted">Des prix clairs et transparents sans frais cachés pour une réservation en toute confiance</p>
                        </div>
                    </div>
                </div>

                <!-- Nos Performances section -->
                <div class="performance-section-wrapper">
                    <div class="performance-card text-center">
                        <h2>Nos Performances</h2>
                        <p class="lead">Des chiffres qui témoignent de notre engagement à offrir le meilleur service.</p>

                        <div class="row text-center gy-4 gx-4">
                            <div class="col-6 col-md-3">
                                <div class="stat-number">150+</div>
                                <div class="stat-label">Agences Partenaires</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-number">50K+</div>
                                <div class="stat-label">Voyageurs Satisfaits</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-number">300+</div>
                                <div class="stat-label">Routes Disponibles</div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-number">99%</div>
                                <div class="stat-label">Taux de Satisfaction</div>
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
                    <h1 class="display-4 fw-bold mb-4">Prêt à Voyager?</h1>
                    <p class="lead mb-5">Rejoignez des milliers de voyageurs qui nous font confiance pour leurs déplacements au Cameroun.</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('marketplace') }}" class="btn btn-primary btn-lg px-5 py-3" style="border-radius: 10px; font-weight: 600;">
                            Rechercher un Trajet
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-lg px-5 py-3" style="border-radius: 10px; font-weight: 600; border-width: 2px;">
                            Devenir Partenaire
                        </a>
                    </div>
                </div>
            </div>

            <!-- Blue CTA Section -->
            <div class="container-fluid py-5" style="background: #2563eb; margin-bottom: 0;">
                <div class="container text-center py-5">
                    <h2 class="text-white fw-bold mb-3" style="font-size: 2.5rem;">Ready to Travel?</h2>
                    <p class="text-white lead mb-5">Join thousands of travelers who trust Routier+ for their journeys.</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('marketplace') }}" class="btn btn-light btn-lg px-5 py-3" style="border-radius: 10px; font-weight: 600;">
                            Rechercher un Trajet
                        </a>
                        <a href="{{ route('sign_up') }}" class="btn btn-outline-light btn-lg px-5 py-3" style="border-radius: 10px; font-weight: 600; border-width: 2px;">
                            <i class="fas fa-user-plus" style="margin-right: 5px;"></i>
                            Sign up free
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection