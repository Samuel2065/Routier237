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
    }

    .logo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .company-name {
        font-size: 1.1rem;
        color: #666;
        font-weight: 600;
    }

    .hero-section {
        position: relative;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url('{{ asset("assets/images/agency-image.png") }}') center/cover no-repeat;
        min-height: 400px;
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
</style>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center">
        <h1 class="mb-3" style="font-size: 2.5rem; font-weight: bold;">Our Partner Agencies</h1>
        <p class="mb-4" style="font-size: 1.2rem;">Discover all verified transport agencies of Cameroon</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('sign_up') }}" class="btn btn-primary btn-lg">Become a Partner</a>
            <a href="{{ route('marketplace') }}" class="btn btn-outline-light btn-lg">Search a Trip</a>
        </div>
    </div>
</section>

<!-- Agencies Section -->
<main class="main-content py-5">
    <div class="container">
        <h5 class="mb-3">Filter by Service Type</h5>
        
        <!-- Filters -->
        <div class="d-flex gap-2 mb-4 flex-wrap">
            <button class="btn btn-sm btn-outline-primary active">All Services</button>
            <button class="btn btn-sm btn-outline-primary">VIP</button>
            <button class="btn btn-sm btn-outline-primary">Classic</button>
            <button class="btn btn-sm btn-outline-primary">Express</button>
            <button class="btn btn-sm btn-outline-primary">Luxury</button>
        </div>
    </div>

    <div class="container">
        <div class="row">
            @forelse($agencies as $agency)
            <div class="col-12 col-md-6 col-lg-4">
                <div class="travel-card">
                    <div class="d-flex align-items-start mb-3">
                        <div class="logo-box me-3">
                            @if($agency->company->logo)
                                <img src="{{ asset('storage/' . $agency->company->logo) }}" alt="{{ $agency->company->name }}">
                            @else
                                <i class="fas fa-building fa-2x text-muted"></i>
                            @endif
                        </div>
                        <div>
                            <div class="company-name">{{ $agency->name }}</div>
                            <div class="text-warning mb-1">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                4.7
                            </div>
                            <div class="text-muted" style="font-size: 0.85rem;">
                                <i class="bi bi-geo-alt"></i> {{ $agency->city }}, {{ $agency->district }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3" style="font-style: italic; color: #666;">
                        {{ $agency->company->description ?? 'Votre confort, notre priorité' }}
                    </div>
                    
                    <div class="mb-2">
                        <strong style="font-size: 0.9rem;">Contact</strong>
                        <div class="text-muted">
                            <i class="fas fa-phone"></i> {{ $agency->phone }}
                        </div>
                        @if($agency->email)
                        <div class="text-muted">
                            <i class="fas fa-envelope"></i> {{ $agency->email }}
                        </div>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <strong style="font-size: 0.9rem;">Address</strong>
                        <div class="text-muted" style="font-size: 0.85rem;">
                            {{ $agency->full_address }}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <strong style="font-size: 0.9rem;">Services</strong>
                        <div class="d-flex flex-wrap gap-1 mt-1">
                            <span class="pill">Classic</span>
                            <span class="pill">VIP</span>
                            <span class="pill">Express</span>
                        </div>
                    </div>
                    
                    @auth
                    <div class="d-grid">
                        <a href="{{ route('agency_details') }}" class="btn btn-primary">
                            View Full Profile <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                    @else
                    <div class="text-center p-3" style="background: #f4faff; border-radius: 8px;">
                        <div class="mb-2">
                            <i class="fas fa-lock fa-2x text-muted"></i>
                        </div>
                        <p class="mb-2" style="font-size: 0.9rem;">Login to view full details and book</p>
                        <a href="{{ route('sign_in') }}" class="btn btn-primary btn-sm">Login to View</a>
                    </div>
                    @endauth
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> No agencies available at the moment.
                </div>
            </div>
            @endforelse
        </div>

        @if($agencies->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $agencies->links() }}
        </div>
        @endif
    </div>
</main>
@endsection