@extends('layouts.app')

@section('title', ($company->name ?? 'Agency') . ' - Full Profile')

@section('content')
<style>
.agency-profile-page {
    background: #ffffff;
    padding-top: 96px;
    padding-bottom: 56px;
}

.profile-shell {
    max-width: 1180px;
}

.profile-hero {
    padding: 18px 0 12px;
}

.hero-logo {
    width: 86px;
    height: 86px;
    border-radius: 18px;
    background: linear-gradient(135deg, #eff6ff, #dbeafe);
    color: #1d4ed8;
    font-size: 1.8rem;
    font-weight: 800;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.hero-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.hero-title {
    margin: 0;
    font-size: clamp(2rem, 3vw, 3.1rem);
    font-weight: 800;
    color: #111827;
}

.verified-badge {
    margin-top: 10px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: #1e40af;
    background: #eff6ff;
    border-radius: 999px;
    padding: 6px 12px;
    font-weight: 600;
    font-size: 0.92rem;
}

.hero-description {
    margin-top: 14px;
    margin-bottom: 16px;
    color: #4b5563;
    line-height: 1.7;
    max-width: 820px;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.hero-btn {
    border: 0;
    border-radius: 10px;
    color: #fff;
    font-weight: 600;
    text-decoration: none;
    padding: 10px 16px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.hero-btn-call { background: #2097f3; }
.hero-btn-wa { background: #16a34a; }
.hero-btn-mail { background: #3b5bc9; }

.rating-box {
    text-align: right;
    padding-top: 18px;
}

.rating-score {
    color: #111827;
    font-size: 2rem;
    font-weight: 800;
}

.rating-meta {
    color: #6b7280;
    font-size: 0.92rem;
}

.tabs-wrap {
    border-top: 1px solid #edf1f7;
    border-bottom: 1px solid #edf1f7;
    margin-top: 16px;
}

.profile-tabs {
    border: 0;
    gap: 8px;
    padding: 10px 0;
}

.profile-tabs .nav-link {
    border: 0;
    border-radius: 10px;
    padding: 12px 24px;
    color: #4b5563;
    font-weight: 600;
}

.profile-tabs .nav-link.active {
    background: #1d4ed8;
    color: #fff;
}

.profile-content {
    padding-top: 26px;
}

.section-title {
    font-size: clamp(1.8rem, 2.6vw, 2.7rem);
    font-weight: 800;
    color: #111827;
    margin-bottom: 20px;
}

.route-block {
    border-bottom: 1px solid #edf1f7;
    padding: 24px 0;
}

.route-top {
    display: flex;
    justify-content: space-between;
    align-items: baseline;
    margin-bottom: 14px;
}

.route-name {
    margin: 0;
    font-size: clamp(1.3rem, 2vw, 2rem);
    font-weight: 700;
    color: #111827;
}

.route-duration {
    color: #6b7280;
    font-weight: 600;
}

.route-grid {
    display: grid;
    grid-template-columns: 1.1fr 1.35fr 1fr;
    gap: 28px;
}

.column-title {
    font-weight: 700;
    color: #111827;
    font-size: 1.32rem;
    margin-bottom: 12px;
}

.time-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(90px, 122px));
    gap: 10px;
}

.time-chip {
    background: #eef5ff;
    border-radius: 6px;
    text-align: center;
    padding: 10px 12px;
    font-weight: 600;
    color: #1f2937;
}

.fare-row {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 14px;
    align-items: center;
    padding: 7px 0;
}

.fare-title {
    color: #1f2937;
    font-weight: 700;
    font-size: 0.98rem;
}

.fare-meta {
    color: #6b7280;
    font-size: 0.88rem;
}

.fare-price {
    color: #111827;
    font-weight: 800;
    font-size: 1.56rem;
}

.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.quick-btn {
    border: 0;
    border-radius: 8px;
    color: #fff;
    text-decoration: none;
    text-align: center;
    font-weight: 700;
    padding: 11px 14px;
}

.quick-wa { background: #16a34a; }
.quick-classic { background: #1658d1; }
.quick-vip { background: #5b3fce; }
.quick-alert { background: #1f335e; }

.branch-card,
.review-card {
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 12px;
}

.branch-title,
.review-title {
    font-weight: 700;
    color: #111827;
}

.branch-meta,
.review-meta {
    color: #6b7280;
    margin: 0;
}

.empty-box {
    border: 1px dashed #cbd5e1;
    border-radius: 14px;
    padding: 24px;
    text-align: center;
    color: #64748b;
}

@media (max-width: 991.98px) {
    .route-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .rating-box {
        text-align: left;
        padding-top: 10px;
    }
}

@media (max-width: 767.98px) {
    .profile-tabs .nav-link {
        padding: 10px 14px;
        font-size: 0.92rem;
    }

    .time-grid {
        grid-template-columns: repeat(2, minmax(74px, 1fr));
    }
}
</style>

@php
    $phoneRaw = $company->phone ?? optional($company->agencies->first())->phone;
    $phoneDigits = $phoneRaw ? preg_replace('/\D+/', '', $phoneRaw) : null;
    $waLink = $phoneDigits ? 'https://wa.me/' . $phoneDigits : null;

    $safeReviewsCount = is_countable($reviews) ? count($reviews) : 0;
@endphp

<section class="agency-profile-page">
    <div class="container profile-shell">
        <div class="profile-hero">
            <div class="row align-items-start">
                <div class="col-lg-9">
                    <div class="d-flex gap-3 align-items-start">
                        <div class="hero-logo">
                            @if($company->logo)
                                <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}">
                            @else
                                {{ strtoupper(substr($company->acronym ?? $company->name, 0, 2)) }}
                            @endif
                        </div>

                        <div>
                            <h1 class="hero-title">{{ $company->name }}</h1>
                            <span class="verified-badge">
                                <i class="fas fa-check-circle"></i>
                                Verified Agency
                            </span>
                        </div>
                    </div>

                    <p class="hero-description">
                        {{ $company->description ?: ($company->name . ' is a transport agency serving intercity routes with multiple fare classes and daily departures.') }}
                    </p>

                    <div class="hero-actions">
                        @if($phoneRaw)
                            <a href="tel:{{ $phoneRaw }}" class="hero-btn hero-btn-call">
                                <i class="fas fa-phone"></i>
                                Call Now
                            </a>
                        @endif

                        @if($waLink)
                            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="hero-btn hero-btn-wa">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp
                            </a>
                        @endif

                        @if($company->email)
                            <a href="mailto:{{ $company->email }}" class="hero-btn hero-btn-mail">
                                <i class="fas fa-envelope"></i>
                                Email
                            </a>
                        @endif
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="rating-box">
                        <div class="rating-score"><i class="fas fa-star" style="color:#fbbf24;font-size:1rem"></i> {{ number_format($rating, 1) }}</div>
                        <div class="rating-meta">{{ $safeReviewsCount }} reviews</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tabs-wrap">
            <ul class="nav profile-tabs" id="agencyTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="schedules-tab" data-bs-toggle="tab" data-bs-target="#schedules" type="button" role="tab" aria-controls="schedules" aria-selected="true">Schedules & Fares</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="branches-tab" data-bs-toggle="tab" data-bs-target="#branches" type="button" role="tab" aria-controls="branches" aria-selected="false">Our Branches</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Customer Reviews</button>
                </li>
            </ul>
        </div>

        <div class="tab-content profile-content" id="agencyTabContent">
            <div class="tab-pane fade show active" id="schedules" role="tabpanel" aria-labelledby="schedules-tab">
                <h2 class="section-title">Schedules and Fares</h2>

                @forelse($tripsGroupedByRoute as $routeLabel => $routeTrips)
                    @php
                        $firstTrip = $routeTrips->first();
                        $routeName = ($firstTrip && $firstTrip->route && $firstTrip->route->fromCity && $firstTrip->route->toCity)
                            ? ($firstTrip->route->fromCity->name . ' - ' . $firstTrip->route->toCity->name)
                            : $routeLabel;

                        $times = $routeTrips->pluck('departure_time')->filter()->unique()->sort()->values();

                        $durationText = 'Flexible schedule';
                        if ($firstTrip && $firstTrip->departure_time && $firstTrip->arrival_time) {
                            $start = \Carbon\Carbon::createFromFormat('H:i:s', $firstTrip->departure_time);
                            $end = \Carbon\Carbon::createFromFormat('H:i:s', $firstTrip->arrival_time);
                            if ($end->lt($start)) {
                                $end->addDay();
                            }
                            $minutes = $start->diffInMinutes($end);
                            $durationText = floor($minutes / 60) . 'h ' . str_pad($minutes % 60, 2, '0', STR_PAD_LEFT) . 'm';
                        }

                        $fareRows = collect();
                        $earliestClassicTripId = null;
                        $earliestVipTripId = null;

                        $sortedRouteTrips = $routeTrips->sortBy(function ($trip) {
                            return ($trip->travel_date ? $trip->travel_date->format('Y-m-d') : '9999-12-31') . ' ' . ($trip->departure_time ?? '23:59:59');
                        })->values();
                        foreach ($sortedRouteTrips as $trip) {
                            $normal = $trip->tripPrices->firstWhere('class', 'Normal');
                            $vip = $trip->tripPrices->firstWhere('class', 'VIP');
                            $hasSeats = (int) ($trip->available_seats ?? 0) > 0;

                            if ($normal || strtoupper($trip->service_type ?? '') === 'NORMAL' || strtoupper($trip->service_type ?? '') === 'EXPRESS') {
                                $fareRows->push([
                                    'service' => 'Classic Bus',
                                    'meta' => ($trip->agency->name ?? $company->name),
                                    'price' => $normal ? $normal->price : $trip->base_price,
                                ]);

                                if ($hasSeats && !$earliestClassicTripId) {
                                    $earliestClassicTripId = $trip->id;
                                }
                            }

                            if ($vip || strtoupper($trip->service_type ?? '') === 'VIP') {
                                $fareRows->push([
                                    'service' => 'VIP Class',
                                    'meta' => ($trip->agency->name ?? $company->name),
                                    'price' => $vip ? $vip->price : $trip->base_price,
                                ]);

                                if ($hasSeats && !$earliestVipTripId) {
                                    $earliestVipTripId = $trip->id;
                                }
                            }
                        }

                        $fareRows = $fareRows
                            ->groupBy('service')
                            ->map(function ($rows, $service) {
                                return [
                                    'service' => $service,
                                    'meta' => $rows->pluck('meta')->filter()->unique()->implode(', '),
                                    'price' => $rows->min('price'),
                                ];
                            })
                            ->values();

                        $hasClassic = $fareRows->contains(function ($row) { return $row['service'] === 'Classic Bus'; });
                        $hasVip = $fareRows->contains(function ($row) { return $row['service'] === 'VIP Class'; });
                    @endphp

                    <div class="route-block">
                        <div class="route-top">
                            <h3 class="route-name">{{ $routeName }}</h3>
                            <span class="route-duration"><i class="far fa-clock"></i> {{ $durationText }}</span>
                        </div>

                        <div class="route-grid">
                            <div>
                                <div class="column-title">Departure Times</div>
                                <div class="time-grid">
                                    @forelse($times as $time)
                                        <div class="time-chip">{{ \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('H:i') }}</div>
                                    @empty
                                        <div class="time-chip">N/A</div>
                                    @endforelse
                                </div>
                            </div>

                            <div>
                                <div class="column-title">Service Classes & Fares (XAF)</div>
                                @foreach($fareRows as $row)
                                    <div class="fare-row">
                                        <div>
                                            <div class="fare-title">
                                                @if($row['service'] === 'VIP Class')
                                                    <i class="fas fa-crown"></i>
                                                @else
                                                    <i class="fas fa-bus"></i>
                                                @endif
                                                {{ $row['service'] }}
                                            </div>
                                            <div class="fare-meta">{{ $row['meta'] ?: $company->name }}</div>
                                        </div>
                                        <div class="fare-price">{{ number_format($row['price'] ?? 0, 0, ',', ' ') }}</div>
                                    </div>
                                @endforeach
                            </div>

                            <div>
                                <div class="column-title">Quick Actions</div>
                                <div class="quick-actions">
                                    @if($waLink)
                                        <a class="quick-btn quick-wa" href="{{ $waLink }}" target="_blank" rel="noopener">
                                            <i class="fab fa-whatsapp"></i> Book via WhatsApp
                                        </a>
                                    @endif

                                    @if($hasClassic)
                                        @if(auth()->check() && auth()->user()->role && auth()->user()->role->slug === 'customer')
                                            @if($earliestClassicTripId)
                                                <form method="POST" action="{{ route('customer.book.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="trip_id" value="{{ $earliestClassicTripId }}">
                                                    <input type="hidden" name="passenger_type" value="adult">
                                                    <input type="hidden" name="service_class" value="classic">
                                                    <button type="submit" class="quick-btn quick-classic w-100">
                                                        <i class="fas fa-ticket-alt"></i> Book Classic
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" class="quick-btn quick-classic w-100" disabled>
                                                    <i class="fas fa-ticket-alt"></i> Classic Unavailable
                                                </button>
                                            @endif
                                        @else
                                            <a class="quick-btn quick-classic" href="{{ route('sign_in', ['redirect' => url()->current() . '#schedules']) }}">
                                                <i class="fas fa-ticket-alt"></i> Book Classic
                                            </a>
                                        @endif
                                    @endif

                                    @if($hasVip)
                                        @if(auth()->check() && auth()->user()->role && auth()->user()->role->slug === 'customer')
                                            @if($earliestVipTripId)
                                                <form method="POST" action="{{ route('customer.book.store') }}">
                                                    @csrf
                                                    <input type="hidden" name="trip_id" value="{{ $earliestVipTripId }}">
                                                    <input type="hidden" name="passenger_type" value="adult">
                                                    <input type="hidden" name="service_class" value="vip">
                                                    <button type="submit" class="quick-btn quick-vip w-100">
                                                        <i class="fas fa-gem"></i> Book VIP
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" class="quick-btn quick-vip w-100" disabled>
                                                    <i class="fas fa-gem"></i> VIP Unavailable
                                                </button>
                                            @endif
                                        @else
                                            <a class="quick-btn quick-vip" href="{{ route('sign_in', ['redirect' => url()->current() . '#schedules']) }}">
                                                <i class="fas fa-gem"></i> Book VIP
                                            </a>
                                        @endif
                                    @endif

                                    <a class="quick-btn quick-alert" href="{{ route('agency_details', ['company' => $company->slug, 'price_alert' => 1]) }}#schedules">
                                        <i class="far fa-bell"></i> Set Price Alert
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-box">No scheduled trips are currently available for this agency.</div>
                @endforelse
            </div>

            <div class="tab-pane fade" id="branches" role="tabpanel" aria-labelledby="branches-tab">
                <h2 class="section-title">Our Branches</h2>
                @forelse($company->agencies as $agency)
                    <div class="branch-card">
                        <div class="branch-title">{{ $agency->name }}</div>
                        <p class="branch-meta"><i class="fas fa-map-marker-alt"></i> {{ $agency->full_address ?: (($agency->city->name ?? 'Unknown city') . ($agency->district ? ' - ' . $agency->district : '')) }}</p>
                        <p class="branch-meta"><i class="fas fa-phone"></i> {{ $agency->phone ?: ($company->phone ?: 'Not provided') }}</p>
                        <p class="branch-meta"><i class="fas fa-envelope"></i> {{ $agency->email ?: ($company->email ?: 'Not provided') }}</p>
                    </div>
                @empty
                    <div class="empty-box">No branch data available.</div>
                @endforelse
            </div>

            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <h2 class="section-title">Customer Reviews</h2>
                @forelse($reviews as $review)
                    <div class="review-card">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="review-title">{{ $review['customer_name'] }}</div>
                            <div class="review-meta"><i class="fas fa-star" style="color:#fbbf24"></i> {{ $review['rating'] }}/5</div>
                        </div>
                        <p class="review-meta mb-1">{{ $review['comment'] }}</p>
                        <p class="review-meta mb-0">{{ $review['date'] }}</p>
                    </div>
                @empty
                    <div class="empty-box">No reviews available yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
