@extends('layouts.app')

@section('content')

<style>
.results-header {
    background: linear-gradient(135deg, #1f6eff 0%, #1557d0 100%);
    padding: 60px 0 40px;
    margin-top: 80px;
    color: white;
}

.search-bar-sticky {
    background: white;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

/* =============== AGENCY CARD - GRID STYLE =============== */
.agency-card {
    border: 2px solid #e8e8e8;
    border-radius: 20px;
    overflow: hidden;
    background: white;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.agency-card:hover {
    box-shadow: 0 8px 24px rgba(31, 110, 255, 0.15);
    transform: translateY(-5px);
    border-color: #1f6eff;
}

/* Header Section */
.agency-card-header {
    padding: 20px;
    background: white;
    border-bottom: 1px solid #f0f0f0;
}

.agency-logo-circle {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: #f0f4ff;
    border: 2px solid #1f6eff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 18px;
    color: #1f6eff;
    margin-bottom: 10px;
}

.agency-name {
    font-size: 17px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 5px;
}

.agency-verification {
    font-size: 12px;
    color: #22c55e;
    display: flex;
    align-items: center;
    gap: 4px;
}

.agency-rating-stars {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    margin-top: 8px;
}

.rating-number {
    font-weight: 600;
    color: #1f6eff;
}

/* Trips Section */
.agency-trips-list {
    padding: 15px;
    flex-grow: 1;
}

.service-available-label {
    font-size: 13px;
    font-weight: 600;
    color: #666;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.trip-pill {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 14px;
    background: #f8f9fa;
    border-radius: 25px;
    margin-bottom: 8px;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.trip-pill:hover {
    background: #e3f2fd;
    border-color: #1f6eff;
    transform: translateX(3px);
}

.trip-route-text {
    font-size: 13px;
    font-weight: 500;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 4px;
}

.trip-route-arrow {
    color: #999;
    font-size: 11px;
}

.trip-service-badge {
    padding: 4px 10px;
    border-radius: 15px;
    font-size: 11px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.badge-classique {
    background: #dbeafe;
    color: #1e40af;
}

.badge-vip {
    background: #fae8ff;
    color: #a21caf;
}

.badge-express {
    background: #fed7aa;
    color: #c2410c;
}

.trip-price {
    font-size: 13px;
    font-weight: 700;
    color: #1f6eff;
    white-space: nowrap;
}

/* Choice Available Section */
.choice-available {
    padding: 12px 15px;
    background: #fafafa;
    border-top: 1px solid #f0f0f0;
}

.choice-label {
    font-size: 12px;
    font-weight: 600;
    color: #666;
    margin-bottom: 8px;
    text-transform: uppercase;
}

.choice-pills {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.choice-pill {
    padding: 6px 12px;
    background: white;
    border: 1.5px solid #e0e0e0;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    color: #555;
    transition: all 0.2s ease;
}

.choice-pill:hover {
    border-color: #1f6eff;
    background: #f0f7ff;
    color: #1f6eff;
}

/* Footer Section */
.agency-card-footer {
    padding: 15px;
    background: white;
    border-top: 1px solid #f0f0f0;
}

.starting-price {
    font-size: 13px;
    color: #666;
    margin-bottom: 3px;
}

.price-amount {
    font-size: 22px;
    font-weight: 800;
    color: #1f6eff;
}

.contact-buttons {
    display: flex;
    gap: 8px;
    margin-top: 10px;
}

.btn-contact-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #e0e0e0;
    background: white;
    color: #666;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-contact-icon:hover {
    border-color: #1f6eff;
    background: #1f6eff;
    color: white;
    transform: scale(1.1);
}

.btn-view-details {
    flex: 1;
    padding: 10px;
    border: none;
    background: #1f6eff;
    color: white;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    text-decoration: none;
}

.btn-view-details:hover {
    background: #1557d0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(31, 110, 255, 0.3);
    color: white;
}

/* No Results */
.no-results {
    text-align: center;
    padding: 60px 20px;
}

.no-results i {
    font-size: 64px;
    color: #ccc;
    margin-bottom: 20px;
}

/* Filter Button */
.filter-sort-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.filter-buttons {
    display: flex;
    gap: 10px;
}

.btn-filter {
    padding: 8px 16px;
    border: 1.5px solid #e0e0e0;
    background: white;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    color: #555;
    transition: all 0.2s ease;
}

.btn-filter:hover,
.btn-filter.active {
    border-color: #1f6eff;
    background: #1f6eff;
    color: white;
}
</style>

{{-- ================= RESULTS HEADER ================= --}}
<section class="results-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="fw-bold mb-2">Agencies in {{ $city->name }}</h1>
                <p class="mb-0">
                    @if($from && $to)
                        <i class="fas fa-map-marker-alt"></i> {{ $from }} → {{ $to }}
                        @if($date)
                            <span class="ms-3"><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</span>
                        @endif
                        @if($serviceType)
                            <span class="ms-3"><i class="fas fa-star"></i> {{ $serviceType }}</span>
                        @endif
                    @else
                        All available agencies in {{ $city->name }}
                    @endif
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <h3 class="fw-bold mb-0">{{ $agencies->total() }}</h3>
                <small>{{ $agencies->total() > 1 ? 'agencies found' : 'agency found' }}</small>
            </div>
        </div>
    </div>
</section>

{{-- ================= SEARCH BAR (Sticky) ================= --}}
<section class="py-4" style="background: #f5f7fa;">
    <div class="container">
        <div class="search-bar-sticky">
            <form method="GET" action="{{ route('marketplace.city', $city->slug) }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Departure city</label>
                        <select name="from" class="form-select">
                            <option value="">All</option>
                            @foreach($cities as $c)
                                <option value="{{ $c->name }}" {{ $from == $c->name ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold small">Destination</label>
                        <select name="to" class="form-select">
                            <option value="">All</option>
                            @foreach($cities as $c)
                                <option value="{{ $c->name }}" {{ $to == $c->name ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold small">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ $date }}" min="{{ date('Y-m-d') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold small">Class</label>
                        <select name="service_type" class="form-select">
                            <option value="">All</option>
                            <option value="Normal" {{ $serviceType == 'Standard' ? 'selected' : '' }}>Standard</option>
                            <option value="Express" {{ $serviceType == 'Express' ? 'selected' : '' }}>Express</option>
                            <option value="VIP" {{ $serviceType == 'VIP' ? 'selected' : '' }}>VIP</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- ================= RESULTS GRID ================= --}}
<section class="py-5">
    <div class="container">

        {{-- Filter & Sort Section --}}
        @if($agencies->count() > 0)
            <div class="filter-sort-section">
                <div class="text-muted small">
                    Showing {{ $agencies->count() }} agency(ies)
                </div>
                <div class="filter-buttons">
                    <button class="btn-filter active">
                        <i class="fas fa-th"></i> All classes
                    </button>
                    <button class="btn-filter">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        @endif

        {{-- Agency Cards Grid --}}
        <div class="row g-4">
            @forelse($agencies as $agency)
                <div class="col-lg-4 col-md-6">
                    <div class="agency-card">
                        
                        {{-- Card Header --}}
                        <div class="agency-card-header">
                            <div class="agency-logo-circle">
                                {{ strtoupper(substr($agency->company->acronym ?? $agency->name, 0, 2)) }}
                            </div>
                            <div class="agency-name">{{ $agency->company->name ?? $agency->name }}</div>
                            <div class="agency-verification">
                                <i class="fas fa-check-circle"></i>
                                <span>Verified</span>
                            </div>
                            <div class="agency-rating-stars">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="fas fa-star" style="color: #fbbf24; font-size: 12px;"></i>
                                @endfor
                                <span class="rating-number">4.{{ rand(5, 9) }}</span>
                            </div>
                        </div>

                        {{-- Trips List --}}
                        <div class="agency-trips-list">
                            <div class="service-available-label">Available services</div>
                            
                            @php
                                $displayTrips = $agency->trips->take(3);
                            @endphp

                            @if($displayTrips->count() > 0)
                                @foreach($displayTrips as $trip)
                                    <div class="trip-pill">
                                        <div class="trip-route-text">
                                            <i class="fas fa-bus" style="font-size: 11px;"></i>
                                            {{ $trip->route->fromCity->name }}
                                            <i class="fas fa-arrow-right trip-route-arrow"></i>
                                            {{ $trip->route->toCity->name }}
                                        </div>
                                        <span class="trip-service-badge badge-{{ strtolower($trip->service_type == 'Normal' ? 'classique' : $trip->service_type) }}">
                                            @if($trip->service_type == 'VIP')
                                                <i class="fas fa-star"></i>
                                            @elseif($trip->service_type == 'Express')
                                                <i class="fas fa-bolt"></i>
                                            @endif
                                            {{ $trip->service_type == 'Normal' ? 'Standard' : $trip->service_type }}
                                        </span>
                                        <span class="trip-price">{{ number_format($trip->base_price, 0, ',', ' ') }} XAF</span>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center text-muted small py-3">
                                    No trips available
                                </div>
                            @endif
                        </div>

                        {{-- Choice Available --}}
                        @if($agency->trips->count() > 0)
                            <div class="choice-available">
                                <div class="choice-label">Available options</div>
                                <div class="choice-pills">
                                    @php
                                        $uniqueServices = $agency->trips->pluck('service_type')->unique();
                                    @endphp
                                    @foreach($uniqueServices as $service)
                                        <div class="choice-pill">
                                            <i class="fas fa-{{ $service == 'VIP' ? 'star' : ($service == 'Express' ? 'bolt' : 'bus') }}"></i>
                                            {{ $service == 'Normal' ? 'Standard' : $service }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Card Footer --}}
                        <div class="agency-card-footer">
                            <div class="starting-price">Starting from</div>
                            @php
                                $minPrice = $agency->trips->min('base_price') ?? 0;
                            @endphp
                            <div class="price-amount">{{ number_format($minPrice, 0, ',', ' ') }} XAF</div>
                            
                            <div class="contact-buttons">
                                <a href="tel:{{ $agency->phone }}" class="btn-contact-icon" title="Call">
                                    <i class="fas fa-phone"></i>
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $agency->phone) }}" target="_blank" class="btn-contact-icon" title="WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="{{ route('agency_details', array_filter([
                                    'company' => ($agency->company->slug ?? 'agency-' . $agency->id),
                                    'from' => $from,
                                    'to' => $to,
                                    'date' => $date,
                                    'service_type' => $serviceType,
                                ], fn($value) => !is_null($value) && $value !== '')) }}" class="btn-view-details">
                                    View details & schedules
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="no-results">
                        <i class="fas fa-search"></i>
                        <h4 class="fw-bold mb-2">No agency found</h4>
                        <p class="text-muted">
                            @if($from && $to)
                                Sorry, no agency offers trips {{ $from }} → {{ $to }} 
                                @if($date)
                                    for {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                                @endif
                                matching your criteria.
                            @else
                                There is currently no registered agency in {{ $city->name }}.
                            @endif
                        </p>
                        <a href="{{ route('marketplace') }}" class="btn btn-primary mt-3">
                            Back to search
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($agencies->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $agencies->links() }}
            </div>
        @endif

    </div>
</section>

@endsection
