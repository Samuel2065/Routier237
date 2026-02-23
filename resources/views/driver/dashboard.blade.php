@extends('driver.layout')

@section('active_nav', 'dashboard')
@section('title', 'Driver Dashboard')
@section('page_title', 'Driver Dashboard')
@section('page_subtitle', data_get($driver, 'employee.agency.name', 'Driver overview'))

@section('content')
<div class="stats-grid">
    <div class="stat-card"><p class="text-muted mb-1">Upcoming Trips</p><h3>{{ $stats['upcoming_trips'] }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">In Progress</p><h3>{{ $stats['in_progress_trips'] }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Completed This Month</p><h3>{{ $stats['completed_trips'] }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Total Trips</p><h3>{{ $stats['total_trips'] }}</h3></div>
</div>
<div class="content-card">
    <h5>Next Trip</h5>
    @if($nextTrip)
        <p class="mb-1"><strong>Date:</strong> {{ $nextTrip->travel_date }}</p>
        <p class="mb-1"><strong>Departure:</strong> {{ $nextTrip->departure_time }}</p>
        <p class="mb-0"><strong>Vehicle:</strong> {{ data_get($nextTrip, 'vehicle.plate_number', '-') }}</p>
    @else
        <p class="text-muted mb-0">No upcoming trip scheduled.</p>
    @endif
</div>
@endsection
