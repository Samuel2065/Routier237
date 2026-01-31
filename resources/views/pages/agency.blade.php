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
            <a href="#" class="btn btn-primary btn-lg">Become a Partner</a>
            <a href="{{ route('marketplace') }}" class="btn btn-outline-light btn-lg">Search a Trip</a>
        </div>
    </div>
</section>

<!-- Agencies Section -->
<main class="main-content py-5">
    <div class="container">
        <h5 class="mb-3">Filter by Service Type</h5>

        <div class="d-flex gap-2 mb-4 flex-wrap">
            <button class="btn btn-sm btn-outline-primary active">All Services</button>
            <button class="btn btn-sm btn-outline-primary">VIP</button>
            <button class="btn btn-sm btn-outline-primary">Classic</button>
            <button class="btn btn-sm btn-outline-primary">Express</button>
            <button class="btn btn-sm btn-outline-primary">Luxury</button>
        </div>

        <div class="row g-3">

            <!-- Agency Card -->
            <div class="col-12 col-md-6 col-lg-4">
                <div class="travel-card">
                    <div class="d-flex align-items-start mb-3">
                        <div class="logo-box me-3">
                            <img src="/assets/images/logo.png" alt="Touristique Express">
                        </div>
                        <div>
                            <div class="company-name">Touristique Express</div>
                            <div class="text-warning mb-1">
                                ★ ★ ★ ★ ☆ 4.7
                            </div>
                            <div class="text-muted" style="font-size: 0.85rem;">
                                <i class="bi bi-geo-alt"></i> Douala, Akwa
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" style="font-style: italic; color: #666;">
                        Votre confort, notre priorité
                    </div>

                    <div class="mb-2">
                        <strong style="font-size: 0.9rem;">Contact</strong>
                        <div class="text-muted">
                            <i class="fas fa-phone"></i> +237 6 99 99 99 99
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-envelope"></i> contact@touristique.cm
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong style="font-size: 0.9rem;">Address</strong>
                        <div class="text-muted" style="font-size: 0.85rem;">
                            Carrefour Équinoxe, Douala
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

                    <div class="d-grid">
                        <a href="#" class="btn btn-primary">
                            View Full Profile <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="travel-card">
                    <div class="d-flex align-items-start mb-3">
                        <div class="logo-box me-3">
                            <img src="/assets/images/logo.png" alt="Touristique Express">
                        </div>
                        <div>
                            <div class="company-name">Touristique Express</div>
                            <div class="text-warning mb-1">
                                ★ ★ ★ ★ ☆ 4.7
                            </div>
                            <div class="text-muted" style="font-size: 0.85rem;">
                                <i class="bi bi-geo-alt"></i> Douala, Akwa
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" style="font-style: italic; color: #666;">
                        Votre confort, notre priorité
                    </div>

                    <div class="mb-2">
                        <strong style="font-size: 0.9rem;">Contact</strong>
                        <div class="text-muted">
                            <i class="fas fa-phone"></i> +237 6 99 99 99 99
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-envelope"></i> contact@touristique.cm
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong style="font-size: 0.9rem;">Address</strong>
                        <div class="text-muted" style="font-size: 0.85rem;">
                            Carrefour Équinoxe, Douala
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

                    <div class="d-grid">
                        <a href="#" class="btn btn-primary">
                            View Full Profile <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="travel-card">
                    <div class="d-flex align-items-start mb-3">
                        <div class="logo-box me-3">
                            <img src="/assets/images/logo.png" alt="Touristique Express">
                        </div>
                        <div>
                            <div class="company-name">Touristique Express</div>
                            <div class="text-warning mb-1">
                                ★ ★ ★ ★ ☆ 4.7
                            </div>
                            <div class="text-muted" style="font-size: 0.85rem;">
                                <i class="bi bi-geo-alt"></i> Douala, Akwa
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" style="font-style: italic; color: #666;">
                        Votre confort, notre priorité
                    </div>

                    <div class="mb-2">
                        <strong style="font-size: 0.9rem;">Contact</strong>
                        <div class="text-muted">
                            <i class="fas fa-phone"></i> +237 6 99 99 99 99
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-envelope"></i> contact@touristique.cm
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong style="font-size: 0.9rem;">Address</strong>
                        <div class="text-muted" style="font-size: 0.85rem;">
                            Carrefour Équinoxe, Douala
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

                    <div class="d-grid">
                        <a href="#" class="btn btn-primary">
                            View Full Profile <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="travel-card">
                    <div class="d-flex align-items-start mb-3">
                        <div class="logo-box me-3">
                            <img src="/assets/images/logo.png" alt="Touristique Express">
                        </div>
                        <div>
                            <div class="company-name">Touristique Express</div>
                            <div class="text-warning mb-1">
                                ★ ★ ★ ★ ☆ 4.7
                            </div>
                            <div class="text-muted" style="font-size: 0.85rem;">
                                <i class="bi bi-geo-alt"></i> Douala, Akwa
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" style="font-style: italic; color: #666;">
                        Votre confort, notre priorité
                    </div>

                    <div class="mb-2">
                        <strong style="font-size: 0.9rem;">Contact</strong>
                        <div class="text-muted">
                            <i class="fas fa-phone"></i> +237 6 99 99 99 99
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-envelope"></i> contact@touristique.cm
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong style="font-size: 0.9rem;">Address</strong>
                        <div class="text-muted" style="font-size: 0.85rem;">
                            Carrefour Équinoxe, Douala
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

                    <div class="d-grid">
                        <a href="#" class="btn btn-primary">
                            View Full Profile <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="travel-card">
                    <div class="d-flex align-items-start mb-3">
                        <div class="logo-box me-3">
                            <img src="/assets/images/logo.png" alt="Touristique Express">
                        </div>
                        <div>
                            <div class="company-name">Touristique Express</div>
                            <div class="text-warning mb-1">
                                ★ ★ ★ ★ ☆ 4.7
                            </div>
                            <div class="text-muted" style="font-size: 0.85rem;">
                                <i class="bi bi-geo-alt"></i> Douala, Akwa
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" style="font-style: italic; color: #666;">
                        Votre confort, notre priorité
                    </div>

                    <div class="mb-2">
                        <strong style="font-size: 0.9rem;">Contact</strong>
                        <div class="text-muted">
                            <i class="fas fa-phone"></i> +237 6 99 99 99 99
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-envelope"></i> contact@touristique.cm
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong style="font-size: 0.9rem;">Address</strong>
                        <div class="text-muted" style="font-size: 0.85rem;">
                            Carrefour Équinoxe, Douala
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

                    <div class="d-grid">
                        <a href="#" class="btn btn-primary">
                            View Full Profile <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="travel-card">
                    <div class="d-flex align-items-start mb-3">
                        <div class="logo-box me-3">
                            <img src="/assets/images/logo.png" alt="Touristique Express">
                        </div>
                        <div>
                            <div class="company-name">Touristique Express</div>
                            <div class="text-warning mb-1">
                                ★ ★ ★ ★ ☆ 4.7
                            </div>
                            <div class="text-muted" style="font-size: 0.85rem;">
                                <i class="bi bi-geo-alt"></i> Douala, Akwa
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" style="font-style: italic; color: #666;">
                        Votre confort, notre priorité
                    </div>

                    <div class="mb-2">
                        <strong style="font-size: 0.9rem;">Contact</strong>
                        <div class="text-muted">
                            <i class="fas fa-phone"></i> +237 6 99 99 99 99
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-envelope"></i> contact@touristique.cm
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong style="font-size: 0.9rem;">Address</strong>
                        <div class="text-muted" style="font-size: 0.85rem;">
                            Carrefour Équinoxe, Douala
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

                    <div class="d-grid">
                        <a href="#" class="btn btn-primary">
                            View Full Profile <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Duplicate cards if needed (static copy-paste) -->

        </div>
    </div>
</main>
@endsection
