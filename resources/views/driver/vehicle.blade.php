@extends('driver.layout')
@section('active_nav', 'vehicle')
@section('title', 'Vehicle')
@section('page_title', 'Current Vehicle')
@section('content')
<div class="content-card">
    @if($vehicle)
        <p class="mb-1"><strong>Plate:</strong> {{ $vehicle->plate_number }}</p>
        <p class="mb-1"><strong>Model:</strong> {{ $vehicle->model ?? '-' }}</p>
        <p class="mb-1"><strong>Type:</strong> {{ ucfirst($vehicle->type ?? '-') }}</p>
        <p class="mb-0"><strong>Status:</strong> {{ ucfirst($vehicle->status ?? '-') }}</p>
    @else
        <p class="text-muted mb-0">No vehicle assignment found.</p>
    @endif
</div>
@endsection
