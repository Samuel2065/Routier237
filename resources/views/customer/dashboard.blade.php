<!-- resources/views/customer/dashboard.blade.php -->
@extends('layouts.dashboard')

@section('sidebar')
<div class="nav-menu">
    <div class="nav-item">
        <a href="{{ route('customer.dashboard') }}" class="nav-link active">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="#" class="nav-link">
            <i class="bi bi-suitcase-lg"></i>
            <span>My Trips</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="#" class="nav-link">
            <i class="bi bi-calendar-check"></i>
            <span>Bookings</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="#" class="nav-link">
            <i class="bi bi-person"></i>
            <span>Profile</span>
        </a>
    </div>
</div>
@endsection

@section('topbar')
<div>
    <h2 class="mb-0">Customer Dashboard</h2>
    <small class="text-muted">Welcome back, {{ auth()->user()->name }}</small>
</div>
@endsection

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <p>Total Trips</p>
        <h3>{{ $totalTrips }}</h3>
    </div>
    <div class="stat-card">
        <p>Upcoming Trips</p>
        <h3>{{ $upcomingTrips }}</h3>
    </div>
    <div class="stat-card">
        <p>Total Bookings</p>
        <h3>{{ $totalBookings }}</h3>
    </div>
</div>

<div class="content-card">
    <h5 class="mb-3">Recent Bookings</h5>
    @forelse($recentBookings as $booking)
        <div class="d-flex justify-content-between border-bottom py-2">
            <span>{{ $booking->route->departure_city }} → {{ $booking->route->arrival_city }}</span>
            <span class="badge bg-primary">{{ ucfirst($booking->status) }}</span>
        </div>
    @empty
        <p class="text-muted">No recent bookings</p>
    @endforelse
</div>
@endsection
