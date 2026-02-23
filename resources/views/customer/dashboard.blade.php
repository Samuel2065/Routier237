@extends('customer.layout')

@section('active_nav', 'dashboard')
@section('title', 'Customer Dashboard')
@section('page_title', 'Customer Dashboard')
@section('page_subtitle', 'Welcome back')

@section('content')
<div class="stats-grid">
    <div class="stat-card"><p class="text-muted mb-1">Total Trips</p><h3>{{ $stats['total_trips'] }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Upcoming Trips</p><h3>{{ $stats['upcoming_trips'] }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Total Bookings</p><h3>{{ $stats['total_bookings'] }}</h3></div>
</div>

<div class="content-card mb-3">
    <div class="d-flex flex-wrap gap-2 align-items-center">
        <a href="{{ route('customer.book') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Book a Trip</a>
        <a href="{{ route('customer.reservations') }}" class="btn btn-outline-primary btn-sm"><i class="bi bi-ticket-perforated"></i> View Booking History</a>
        <a href="{{ route('agency') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-shop"></i> Explore Agencies</a>
    </div>
</div>

<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">Recent Bookings</h5>
        <a href="{{ route('customer.reservations') }}" class="btn btn-link btn-sm p-0">View all</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Ticket</th>
                    <th>Route</th>
                    <th>Travel Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->ticket_number ?? ('RSV-' . $booking->id) }}</td>
                        <td>{{ data_get($booking, 'trip.route.fromCity.name', '-') }} - {{ data_get($booking, 'trip.route.toCity.name', '-') }}</td>
                        <td>{{ optional(data_get($booking, 'trip.travel_date'))->format('Y-m-d') ?? ($booking->departure_date ?? '-') }}</td>
                        <td><span class="badge bg-{{ in_array(($booking->status ?? ''), ['valid', 'confirmed']) ? 'success' : (($booking->status ?? '') === 'used' ? 'secondary' : 'warning text-dark') }}">{{ ucfirst($booking->status ?? '-') }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">No recent bookings.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
