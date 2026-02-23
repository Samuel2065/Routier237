@extends('driver.layout')
@section('active_nav', 'schedule')
@section('title', 'Schedule')
@section('page_title', 'Upcoming Schedule')
@section('content')
<div class="content-card"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>Date</th><th>Departure</th><th>Route</th><th>Vehicle</th></tr></thead><tbody>@forelse($upcomingTrips as $trip)<tr><td>{{ $trip->travel_date }}</td><td>{{ $trip->departure_time }}</td><td>{{ data_get($trip,'route.id','-') }}</td><td>{{ data_get($trip,'vehicle.plate_number','-') }}</td></tr>@empty<tr><td colspan="4" class="text-center text-muted py-4">No scheduled trips.</td></tr>@endforelse</tbody></table></div></div>
@endsection
