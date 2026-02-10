
@extends('layouts.app')

@section('title', 'Agency')

@section('content')
<style>
    .travel-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 20px;
        transition: transform 0.3s;
    }

    .travel-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }

    .logo-box {
        width: 80px;
        height: 80px;
        border: 2px solid #ddd;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        background: #f0f4ff;
    }

    .logo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .logo-text {
        font-size: 24px;
        font-weight: bold;
        color: #1f6eff;
    }

    .company-name {
        font-size: 1.1rem;
        color: #666;
        font-weight: 600;
    }

    .hero-section {
        position: relative;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url('/assets/images/agency-image.png') center/cover no-repeat;
        min-height: 455px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .pill {
        background-color: #f4faff;
        border-radius: 20px;
        padding: 5px 15px;
        font-size: 0.85rem;
        color: #666;
        display: inline-block;
        margin: 2px;
    }

    .filter-btn {
        transition: all 0.3s ease;
    }

    .filter-btn.active {
        background-color: #1f6eff !important;
        color: white !important;
        border-color: #1f6eff !important;
    }

    .route-pill {
        background-color: #e8f4ff;
        border-radius: 15px;
        padding: 4px 12px;
        font-size: 0.8rem;
        color: #1f6eff;
        display: inline-block;
        margin: 2px;
        font-weight: 500;
    }

    .established-badge {
        background: #f0f0f0;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.75rem;
        color: #666;
        display: inline-block;
    }

    .filter-btn{
        border-radius: 50px;
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
        border-radius: 15px;
        text-align: center;
        backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
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
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center">
        <h1 class="mb-3" style="font-size: 2.5rem; font-weight: bold;">
            Our Partner Agencies
        </h1>
        <p class="mb-4" style="font-size: 1.2rem;">
            Discover all verified transport agencies of Cameroon
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="#" class="btn btn-primary btn-lg" style="border-radius: 15px;">Become a Partner</a>
            <a href="{{ route('marketplace') }}" class="button button-secondary" style="color: white;">Search a Trip</a>
        </div>
    </div>
</section>

<!-- Agencies Section -->
<main class="main-content py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Filter by Service Type</h5>
            <div class="text-muted">
                <strong>{{ $companies->count() }}</strong> {{ $companies->count() > 1 ? 'agencies' : 'agency' }} found
            </div>
        </div>

        <div class="d-flex gap-2 mb-4 flex-wrap filter-btn">
            <a href="{{ route('agency') }}" 
               class="btn btn-sm btn-outline-primary filter-btn {{ !$serviceFilter || $serviceFilter == 'all' ? 'active' : '' }}">
                All Services
            </a>
            <a href="{{ route('agency', ['service' => 'VIP']) }}" 
               class="btn btn-sm btn-outline-primary filter-btn {{ $serviceFilter == 'VIP' ? 'active' : '' }}">
                VIP
            </a>
            <a href="{{ route('agency', ['service' => 'Normal']) }}" 
               class="btn btn-sm btn-outline-primary filter-btn {{ $serviceFilter == 'Normal' ? 'active' : '' }}">
                Classic
            </a>
            <a href="{{ route('agency', ['service' => 'Express']) }}" 
               class="btn btn-sm btn-outline-primary filter-btn {{ $serviceFilter == 'Express' ? 'active' : '' }}">
                Express
            </a>
        </div>

        <div class="row g-3">
            @forelse($companies as $company)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="travel-card">
                        <div class="d-flex align-items-start mb-3">
                            <div class="logo-box me-3">
                                @if($company->logo)
                                    <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}">
                                @else
                                    <div class="logo-text">{{ strtoupper(substr($company->acronym ?? $company->name, 0, 2)) }}</div>
                                @endif
                            </div>
                            <div>
                                <div class="company-name">{{ $company->name }}</div>
                                <div class="text-warning mb-1">
                                    @php
                                        $rating = 4.5 + (rand(0, 4) / 10);
                                        $fullStars = floor($rating);
                                        $halfStar = ($rating - $fullStars) >= 0.5;
                                    @endphp
                                    @for($i = 0; $i < $fullStars; $i++)
                                        ★
                                    @endfor
                                    @if($halfStar)
                                        ★
                                    @endif
                                    @for($i = 0; $i < (5 - $fullStars - ($halfStar ? 1 : 0)); $i++)
                                        ☆
                                    @endfor
                                    {{ number_format($rating, 1) }}
                                </div>
                                @if($company->main_agency)
                                    <div class="text-muted" style="font-size: 0.85rem;">
                                        <i class="bi bi-geo-alt"></i> {{ $company->main_agency->city->name }}, {{ $company->main_agency->district }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3" style="font-style: italic; color: #666;">
                            {{ $company->description ?? 'Votre confort, notre priorité' }}
                        </div>

                        <div class="mb-3">
                            <strong class="d-flex">Routes</strong>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                @foreach($company->destinations->take(3) as $destination)
                                    <span class="route-pill">{{ $destination }}</span>
                                @endforeach
                                @if($company->destinations->count() > 3)
                                    <span class="route-pill">+{{ $company->destinations->count() - 3 }} more</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <strong class="d-flex">Services</strong>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                @foreach($company->available_services as $service)
                                    <span class="pill">{{ $service }}</span>
                                @endforeach
                            </div>
                        </div>

                        @if($company->min_price > 0)
                            <div class="mb-3">
                                <strong style="font-size: 0.9rem; margin-left: -230px;">Price Range</strong>
                                <div class="fw-bold text-primary">
                                    {{ number_format($company->min_price, 0, ',', ' ') }} 
                                    @if($company->max_price > $company->min_price)
                                        - {{ number_format($company->max_price, 0, ',', ' ') }}
                                    @endif
                                    FCFA
                                </div>
                            </div>
                        @endif

                        <div class="details" style="background-color: #e8f4ff; border-radius: 5px; margin-bottom: 10px;">
                            <i class="fas fa-lock text-muted"></i>
                            <h6 class="text-muted">login to view contact details and book directly</h6>
                            <a href="{{ route('sign_in') }}" class="btn btn-primary mb-3">Login to View Details <i class="fas fa-arrow-right"></i></a>
                        </div>

                        <div class="d-grid d-flex">
                            <a href="{{ route('agency_details', $company->slug) }}" style="text-decoration: none;">
                                View Full Profile <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-building" style="font-size: 64px; color: #ccc; margin-bottom: 20px;"></i>
                        <h4 class="fw-bold mb-2">No Agencies Found</h4>
                        <p class="text-muted">
                            @if($serviceFilter && $serviceFilter != 'all')
                                No agencies offer {{ $serviceFilter }} service at the moment.
                            @else
                                No agencies are currently registered in the system.
                            @endif
                        </p>
                        <a href="{{ route('agency') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-refresh"></i> Show All Agencies
                        </a>
                    </div>
                </div>
            @endforelse

        </div>

        @if($companies->count() > 0)
            <div class="text-center mt-5">
                <p class="text-muted">
                    Showing all {{ $companies->count() }} verified transport 
                    {{ $companies->count() > 1 ? 'agencies' : 'agency' }}
                    @if($serviceFilter && $serviceFilter != 'all')
                        offering {{ $serviceFilter }} service
                    @endif
                </p>
            </div>
        @endif
    </div>
</main>

@endsection
