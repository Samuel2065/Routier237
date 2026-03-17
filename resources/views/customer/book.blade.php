@extends('customer.layout')
@section('active_nav', 'book')
@section('title', 'Book Trip')
@section('page_title', 'Book a Trip')
@section('content')
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="content-card mb-3">
    <h5>Available Trips</h5>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Route</th>
                    <th>Agency</th>
                    <th>Date</th>
                    <th>Departure</th>
                    <th>Seats</th>
                    <th>Class Fares</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($availableTrips as $trip)
                    @php
                        $normalPrice = optional($trip->tripPrices->firstWhere('class', 'Normal'))->price ?? $trip->base_price;
                        $vipPrice = optional($trip->tripPrices->firstWhere('class', 'VIP'))->price;
                    @endphp
                    <tr>
                        <td>{{ data_get($trip, 'route.fromCity.name', '-') }} - {{ data_get($trip, 'route.toCity.name', '-') }}</td>
                        <td>
                            {{ data_get($trip, 'departureAgency.company.name') ?? data_get($trip, 'departureAgency.name', '-') }}
                        </td>
                        <td>{{ optional($trip->travel_date)->format('Y-m-d') ?? ($trip->departure_date ?? '-') }}</td>
                        <td>{{ $trip->departure_time ? \Carbon\Carbon::createFromFormat('H:i:s', $trip->departure_time)->format('H:i') : '-' }}</td>
                        <td>{{ $trip->available_seats }}</td>
                        <td>
                            <div><span class="badge bg-primary">Classic</span> {{ number_format($normalPrice ?? 0, 0, ',', ' ') }} XAF</div>
                            @if($vipPrice !== null)
                                <div class="mt-1"><span class="badge bg-secondary">VIP</span> {{ number_format($vipPrice, 0, ',', ' ') }} XAF</div>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <form method="POST" action="{{ route('customer.book.store') }}">
                                    @csrf
                                    <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                    <input type="hidden" name="passenger_type" value="adult">
                                    <input type="hidden" name="service_class" value="classic">
                                    <button class="btn btn-sm btn-primary w-100">Book Classic</button>
                                </form>
                                @if($vipPrice !== null)
                                    <form method="POST" action="{{ route('customer.book.store') }}">
                                        @csrf
                                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                        <input type="hidden" name="passenger_type" value="adult">
                                        <input type="hidden" name="service_class" value="vip">
                                        <button class="btn btn-sm btn-outline-dark w-100">Book VIP</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No trips available.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $availableTrips->links() }}</div>
</div>
@endsection
