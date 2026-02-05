@extends('layouts.app')

@section('title', $company->name . ' - Agency Details')

@section('content')
<style>
    .agency-header {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .logo-box {
        width: 100px;
        height: 100px;
        border: 2px solid #ddd;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #f0f4ff;
        flex-shrink: 0;
    }

    .logo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .logo-text {
        font-size: 32px;
        font-weight: bold;
        color: #1f6eff;
    }

    .verified-badge {
        background: #e8f4ff;
        color: #1f6eff;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-weight: 500;
    }

    .verified-badge i {
        color: #1f6eff;
    }

    .rating-stars {
        color: #fbbf24;
        font-size: 1.2rem;
    }

    .action-btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
    }

    .btn-call {
        background: #3b82f6;
        color: white;
        border: none;
    }

    .btn-call:hover {
        background: #2563eb;
        color: white;
        transform: translateY(-2px);
    }

    .btn-whatsapp {
        background: #25d366;
        color: white;
        border: none;
    }

    .btn-whatsapp:hover {
        background: #20ba5a;
        color: white;
        transform: translateY(-2px);
    }

    .btn-email {
        background: #6366f1;
        color: white;
        border: none;
    }

    .btn-email:hover {
        background: #4f46e5;
        color: white;
        transform: translateY(-2px);
    }

    .nav-tabs {
        border-bottom: 2px solid #e5e7eb;
        margin-bottom: 2rem;
    }

    .nav-tabs .nav-link {
        color: #6b7280;
        border: none;
        padding: 1rem 2rem;
        font-weight: 500;
        position: relative;
    }

    .nav-tabs .nav-link.active {
        color: #1f6eff;
        background: transparent;
        border-bottom: 3px solid #1f6eff;
    }

    .nav-tabs .nav-link:hover {
        color: #1f6eff;
    }

    .route-section {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
    }

    .route-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1.5rem;
    }

    .trip-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s;
    }

    .trip-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .time-badge {
        background: #dbeafe;
        color: #1e40af;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
    }

    .service-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .service-classic {
        background: #dbeafe;
        color: #1e40af;
    }

    .service-vip {
        background: #fef3c7;
        color: #92400e;
    }

    .service-express {
        background: #dcfce7;
        color: #166534;
    }

    .price-tag {
        font-size: 1.3rem;
        font-weight: 700;
        color: #1f6eff;
    }

    .quick-action-btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        display: block;
        text-align: center;
        margin-bottom: 0.5rem;
        transition: all 0.3s;
    }

    .btn-book-whatsapp {
        background: #25d366;
        color: white;
    }

    .btn-book-whatsapp:hover {
        background: #20ba5a;
        color: white;
        transform: translateX(5px);
    }

    .btn-book-classic {
        background: #3b82f6;
        color: white;
    }

    .btn-book-classic:hover {
        background: #2563eb;
        color: white;
        transform: translateX(5px);
    }

    .btn-book-vip {
        background: #8b5cf6;
        color: white;
    }

    .btn-book-vip:hover {
        background: #7c3aed;
        color: white;
        transform: translateX(5px);
    }

    .btn-price-alert {
        background: #374151;
        color: white;
    }

    .btn-price-alert:hover {
        background: #1f2937;
        color: white;
        transform: translateX(5px);
    }

    .branch-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .review-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .review-stars {
        color: #fbbf24;
    }

    .seats-available {
        color: #10b981;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .seats-limited {
        color: #f59e0b;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .no-trips-message {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }
</style>

<!-- Agency Header -->
<section class="container mt-4">
    <div class="agency-header">
        <div class="row align-items-start">
            <div class="col-auto">
                <div class="logo-box">
                    @if($company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}">
                    @else
                        <div class="logo-text">{{ strtoupper(substr($company->acronym ?? $company->name, 0, 2)) }}</div>
                    @endif
                </div>
            </div>
            <div class="col">
                <h1 class="mb-2">{{ $company->name }}</h1>
                <div class="mb-2">
                    <span class="verified-badge">
                        <i class="bi bi-patch-check-fill"></i>
                        Verified Agency
                    </span>
                </div>
                <div class="rating-stars mb-2">
                    @php
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
                    <span style="color: #6b7280; font-size: 1rem;">{{ number_format($rating, 1) }} ({{ count($reviews) }} reviews)</span>
                </div>
                <p class="text-muted mb-3" style="font-style: italic;">
                    {{ $company->description ?? $company->name . ' is a leading transport agency in Cameroon, providing quality services since 2015. We serve major cities across the country with a modern fleet and qualified staff.' }}
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    @if($company->phone)
                        <a href="tel:{{ $company->phone }}" class="action-btn btn-call">
                            <i class="bi bi-telephone-fill"></i>
                            Call Now
                        </a>
                    @endif
                    @if($company->phone)
                        <a href="https://wa.me/237{{ ltrim($company->phone, '0') }}" target="_blank" class="action-btn btn-whatsapp">
                            <i class="bi bi-whatsapp"></i>
                            WhatsApp
                        </a>
                    @endif
                    @if($company->email)
                        <a href="mailto:{{ $company->email }}" class="action-btn btn-email">
                            <i class="bi bi-envelope-fill"></i>
                            Email
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Navigation Tabs -->
<section class="container">
    <ul class="nav nav-tabs" id="agencyTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="schedules-tab" data-bs-toggle="tab" data-bs-target="#schedules" type="button" role="tab">
                Schedules & Fares
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="branches-tab" data-bs-toggle="tab" data-bs-target="#branches" type="button" role="tab">
                Our Branches
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                Customer Reviews
            </button>
        </li>
    </ul>

    <div class="tab-content" id="agencyTabsContent">
        <!-- Schedules & Fares Tab -->
        <div class="tab-pane fade show active" id="schedules" role="tabpanel">
            <div class="mt-4">
                <h3 class="mb-4">Schedules and Fares</h3>

                @forelse($tripsGroupedByRoute as $routeName => $trips)
                    <div class="route-section">
                        <h4 class="route-title">{{ $routeName }}</h4>

                        <div class="row">
                            <div class="col-lg-8">
                                @foreach($trips as $trip)
                                    <div class="trip-card">
                                        <div class="row align-items-center">
                                            <div class="col-md-3">
                                                <div class="mb-2"><strong>Departure Times</strong></div>
                                                <div class="time-badge">
                                                    {{ \Carbon\Carbon::parse($trip->departure_time)->format('H:i') }}
                                                </div>
                                                @if($trip->arrival_time)
                                                    <div class="mt-2 text-muted" style="font-size: 0.85rem;">
                                                        Arrival: {{ \Carbon\Carbon::parse($trip->arrival_time)->format('H:i') }}
                                                    </div>
                                                @endif
                                                <div class="mt-2 text-muted" style="font-size: 0.85rem;">
                                                    <i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($trip->travel_date)->format('M d, Y') }}
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="mb-2"><strong>Service Classes & Fares (XAF)</strong></div>
                                                @foreach($trip->tripPrices as $price)
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <div>
                                                            <span class="service-badge service-{{ strtolower($price->class) }}">
                                                                @if($price->class == 'Normal')
                                                                    <i class="bi bi-check-circle"></i> Classic Class
                                                                @else
                                                                    <i class="bi bi-star-fill"></i> {{ $price->class }} Class
                                                                @endif
                                                            </span>
                                                            <small class="text-muted d-block mt-1">
                                                                {{ $trip->service_type }} Service
                                                            </small>
                                                        </div>
                                                        <div class="price-tag">
                                                            {{ number_format($price->price, 0, ',', ' ') }}
                                                        </div>
                                                    </div>
                                                @endforeach

                                                <div class="mt-2">
                                                    @if($trip->available_seats > 10)
                                                        <span class="seats-available">
                                                            <i class="bi bi-check-circle-fill"></i> {{ $trip->available_seats }} seats available
                                                        </span>
                                                    @elseif($trip->available_seats > 0)
                                                        <span class="seats-limited">
                                                            <i class="bi bi-exclamation-circle-fill"></i> Only {{ $trip->available_seats }} seats left!
                                                        </span>
                                                    @else
                                                        <span class="text-danger">
                                                            <i class="bi bi-x-circle-fill"></i> Fully booked
                                                        </span>
                                                    @endif
                                                </div>

                                                @if($trip->agency)
                                                    <div class="mt-2 text-muted" style="font-size: 0.85rem;">
                                                        <i class="bi bi-geo-alt-fill"></i> {{ $trip->agency->name }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-2"><strong>Quick Actions</strong></div>
                                                @if($trip->agency && $trip->agency->phone)
                                                    <a href="https://wa.me/237{{ ltrim($trip->agency->phone, '0') }}?text=Hello, I want to book a trip from {{ $trip->route->fromCity->name }} to {{ $trip->route->toCity->name }} on {{ \Carbon\Carbon::parse($trip->travel_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($trip->departure_time)->format('H:i') }}" 
                                                       target="_blank" 
                                                       class="quick-action-btn btn-book-whatsapp">
                                                        <i class="bi bi-whatsapp"></i> Book via WhatsApp
                                                    </a>
                                                @endif
                                                
                                                @auth
                                                    @php
                                                        $classicPrice = $trip->tripPrices->where('class', 'Normal')->first();
                                                        $vipPrice = $trip->tripPrices->where('class', 'VIP')->first();
                                                    @endphp
                                                    
                                                    @if($classicPrice)
                                                        <a href="#" class="quick-action-btn btn-book-classic">
                                                            <i class="bi bi-ticket-detailed"></i> Book Classic
                                                        </a>
                                                    @endif
                                                    
                                                    @if($vipPrice)
                                                        <a href="#" class="quick-action-btn btn-book-vip">
                                                            <i class="bi bi-star"></i> Book VIP
                                                        </a>
                                                    @endif
                                                    
                                                    <a href="#" class="quick-action-btn btn-price-alert">
                                                        <i class="bi bi-bell"></i> Set Price Alert
                                                    </a>
                                                @else
                                                    <a href="{{ route('sign_in') }}" class="quick-action-btn btn-book-classic">
                                                        <i class="bi bi-ticket-detailed"></i> Book Classic
                                                    </a>
                                                    <a href="{{ route('sign_in') }}" class="quick-action-btn btn-book-vip">
                                                        <i class="bi bi-star"></i> Book VIP
                                                    </a>
                                                    <small class="text-muted d-block text-center mt-2">Login to book online</small>
                                                @endauth
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-trips-message">
                        <i class="bi bi-calendar-x" style="font-size: 64px; color: #d1d5db;"></i>
                        <h4 class="mt-3">No Scheduled Trips Available</h4>
                        <p>This agency currently has no scheduled trips. Please check back later or contact them directly.</p>
                        @if($company->phone)
                            <a href="tel:{{ $company->phone }}" class="btn btn-primary mt-3">
                                <i class="bi bi-telephone-fill"></i> Call for Information
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Our Branches Tab -->
        <div class="tab-pane fade" id="branches" role="tabpanel">
            <div class="mt-4">
                <h3 class="mb-4">Our Branches</h3>
                <div class="row">
                    @forelse($company->agencies as $agency)
                        <div class="col-md-6 mb-3">
                            <div class="branch-card">
                                <h5 class="mb-2">{{ $agency->name }}</h5>
                                @if($agency->type == 'main')
                                    <span class="badge bg-primary mb-2">Main Branch</span>
                                @endif
                                <div class="text-muted mb-2">
                                    <i class="bi bi-geo-alt-fill"></i> {{ $agency->full_address }}
                                </div>
                                @if($agency->phone)
                                    <div class="mb-2">
                                        <i class="bi bi-telephone-fill"></i> {{ $agency->phone }}
                                    </div>
                                @endif
                                @if($agency->email)
                                    <div class="mb-2">
                                        <i class="bi bi-envelope-fill"></i> {{ $agency->email }}
                                    </div>
                                @endif
                                <div class="rating-stars mt-2">
                                    ★★★★★ <span style="color: #6b7280; font-size: 0.9rem;">{{ number_format($agency->rating, 1) }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted text-center">No branches information available.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Customer Reviews Tab -->
        <div class="tab-pane fade" id="reviews" role="tabpanel">
            <div class="mt-4">
                <h3 class="mb-4">Customer Reviews</h3>
                @foreach($reviews as $review)
                    <div class="review-card">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="mb-1">{{ $review['customer_name'] }}</h6>
                                <div class="review-stars">
                                    @for($i = 0; $i < $review['rating']; $i++)
                                        ★
                                    @endfor
                                    @for($i = 0; $i < (5 - $review['rating']); $i++)
                                        ☆
                                    @endfor
                                </div>
                            </div>
                            <small class="text-muted">{{ $review['date'] }}</small>
                        </div>
                        <p class="mb-0">{{ $review['comment'] }}</p>
                    </div>
                @endforeach

                <div class="text-center mt-4">
                    <p class="text-muted">Have you traveled with {{ $company->name }}?</p>
                    <button class="btn btn-outline-primary">Leave a Review</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Initialize Bootstrap tabs
    var triggerTabList = [].slice.call(document.querySelectorAll('#agencyTabs button'))
    triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)

        triggerEl.addEventListener('click', function (event) {
            event.preventDefault()
            tabTrigger.show()
        })
    })
</script>

@endsection

