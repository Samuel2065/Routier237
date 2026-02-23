@extends('driver.layout')
@section('active_nav', 'trips')
@section('title', 'Trips')
@section('page_title', 'My Trips')
@section('content')
<div class="content-card"><div class="table-responsive"><table class="table table-hover"><thead><tr><th>Date</th><th>Route</th><th>Vehicle</th><th>Status</th></tr></thead><tbody>@forelse($trips as $trip)<tr><td>{{ $trip->travel_date }}</td><td>{{ data_get($trip,'route.id','-') }}</td><td>{{ data_get($trip,'vehicle.plate_number','-') }}</td><td>{{ ucfirst($trip->status) }}</td></tr>@empty<tr><td colspan="4" class="text-center text-muted py-4">No trips found.</td></tr>@endforelse</tbody></table></div><div class="mt-3">{{ $trips->links() }}</div></div>
@endsection
