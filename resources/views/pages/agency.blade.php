@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/agency.css') }}">
<style>
    .agency-card {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        background: white;
        height: auto;
        min-height: 300px;
        display: flex;
        flex-direction: column;
    }

    .agency-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    .agency-logo {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        margin-bottom: 1rem;
        object-fit: cover;
    }

    .agency-header {
        padding: .4rem;
        text-align: center;
        border-bottom: 1px solid #e0e0e0;
    }

    .agency-name {
        font-size: 1.5rem;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .agency-rating {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .rating-stars {
        color: #ffd700;
    }

    .rating-number {
        color: #666;
    }

    .agency-established {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: .5rem;
    }

    .agency-description {
        color: #444;
        margin-bottom: 1rem;
        line-height: 1.4;
        font-size: 0.98rem;
        max-height: 40px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .agency-details {
        padding: .5rem;
        flex-grow: 1;
    }

    .detail-section {
        margin-bottom: .5rem;
    }

    .detail-title {
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
    }

    .routes-list, .services-list {
        justify-content: center;
        align-items: center;
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: .5rem;
    }

    .route-tag, .service-tag {
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.9rem;
    }

    .route-tag {
        background: #e8f0fe;
        align-items: center;
        justify-content: center;
        color: #1a73e8;
    }

    .service-tag.classic {
        background: #e8f5e9;
        align-items: center;
        justify-content: center;
        color: #2e7d32;
    }

    .service-tag.vip {
        background: #fef8e6;
        align-items: center;
        justify-content: center;
        color: #f9a825;
    }

    .service-tag.express {
        background: #fbe9e7;
        align-items: center;
        justify-content: center;
        color: #d84315;
    }

    .price-range {
        color: #333;
        font-weight: 500;
    }

    .agency-footer {
        padding: 1rem;
        border-top: 1px solid #e0e0e0;
        text-align: center;
    }

    .btn-view-details {
        background: #4A90E2;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        transition: background 0.3s;
        font-size: 0.98rem;
    }

    .btn-view-details:hover {
        background: #357ABD;
    }

    .hero-section {
        position: relative;
        min-height: 350px;
        background: url('{{ asset('assets/images/freepik__the-style-is-candid-image-photography-with-natural__90269.png') }}') center center/cover no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.4);
        z-index: 1;
    }

    .hero-title, .hero-subtitle {
        position: relative;
        z-index: 2;
        color: #fff;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        margin-bottom: 2rem;
    }

    .hero-buttons {
        position: relative;
        z-index: 2;
        display: flex;
        gap: 20px;
        justify-content: center;
        margin-top: 2rem;
    }
</style>
@section('title', 'Agency')

    <!-- resources/views/agencies/index.blade.php -->

@section('content')

<body>
    <!-- Hero Section -->
    <section class="hero-section">

     
        <div class="hero-overlay"></div>
        <div class="container text-center">
            <h1 class="hero-title">Discover the Best Road Travel Agencies for Your Next Adventure</h1>
            <p class="hero-subtitle">Find your perfect journey with our trusted travel partners</p>
            <!-- <div class="hero-buttons">
                <a type="button" class="button button-primary">
                    Choose my city
                </a>
                <a type="button" class="button button-secondary" href="{{ route('marketplace') }}">
                    View agencies
                </a>
            </div> -->
        </div>
    </section>

        <div class="search-section">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-3">
                    <select name="" id="" class="form-select">
                        <option value="">Search for an agency</option>
                        <option value="touristique">Touristique Voyage</option>
                        <option value="overline">Overline Voyage</option>
                        <option value="danai">Danai Voyage</option>
                        <option value="planet">Planet Voyage</option>
                        <option value="naral">Naral Voyage</option>
                    </select>
                    <!-- <input type="text" class="form-control" id="searchInput" placeholder="Search for an agency..."> -->
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <select class="form-select">
                        <option value="">All regions</option>
                        <option value="littoral">Coastal</option>
                        <option value="centre">Central</option>
                        <option value="ouest">West</option>
                        <option value="nord">North</option>
                        <option value="sud">South</option>
                        <option value="est">East</option>
                        <option value="sud-ouest">South-West</option>
                        <option value="nord-ouest">North-West</option>
                        <option value="adamaoua">Adamawa</option>
                        <option value="extreme-nord">Far North</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <select class="form-select">
                        <option value="">Travel Type</option>
                        <option value="urbain">Urban Transport</option>
                        <option value="inter-urbain">Inter-urban Transport</option>
                        <option value="tourisme">Tourism</option>
                        <option value="location">Rental</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-6 mb-3">
                    <button class="btn btn-primary w-100" style="text-align: center; justify-content: center;">
                        Search
                    </button>
                </div>
            </div>
        </div>
    </div>  
    <!-- Agencies Section -->
    <section class="agencies-section">
        <div class="container">
            <h2 class="section-title fade-in">Our Trusted Agencies</h2>      
            <div class="row">
                @for ($i = 0; $i < 6; $i++)
                <div class="col-lg-4 col-md-6 mb-3 fade-in agency-item">
                    <div class="agency-card">
                        <div class="agency-header">
                            <div class="agency-rating">
                                <span class="rating-stars">★★★★★</span>
                                <span class="rating-number">4.5 (234 reviews)</span>
                            </div>
                            <div class="agency-established">Est. 2015</div>
                        </div>
                        <div class="agency-details">
                            <p class="agency-description">
                                Safe and comfortable transport throughout Cameroon
                            </p>
                            <div class="detail-section">
                                <h4 class="detail-title">Routes</h4>
                                <div class="routes-list">
                                    <span class="route-tag">Yaoundé</span>
                                    <span class="route-tag">Douala</span>
                                    <span class="route-tag">Bafoussam</span>
                                </div>
                            </div>
                            <div class="detail-section">
                                <h4 class="detail-title">Services</h4>
                                <div class="services-list">
                                    <span class="service-tag classic">Classic</span>
                                    <span class="service-tag vip">VIP</span>
                                </div>
                            </div>
                            <div class="detail-section">
                                <h4 class="detail-title">Price Range</h4>
                                <div class="price-range">3,500 - 8,000 FCFA</div>
                            </div>
                        </div>
                        <div class="agency-footer">
                            <p class="text-muted mb-2">Login to view contact details and book directly</p>
                            <a href="{{ route('sign_in') }}" class="btn-view-details">Login to View Details</a>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
    </section>

    

</body>
@endsection
