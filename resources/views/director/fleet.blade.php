@extends('director.layout')

@section('active_nav', 'fleet')
@section('title', 'Fleet Overview')
@section('page_title', 'Fleet Overview')
@section('page_subtitle', 'Company vehicles and status')

@section('content')
<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>Plate</th><th>Model</th><th>Type</th><th>Seats</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($vehicles as $vehicle)
                    <tr>
                        <td>{{ $vehicle->plate_number }}</td>
                        <td>{{ $vehicle->model ?? '-' }}</td>
                        <td>{{ ucfirst($vehicle->type) }}</td>
                        <td>{{ $vehicle->seat_count }}</td>
                        <td><span class="badge bg-{{ $vehicle->status === 'active' ? 'success' : ($vehicle->status === 'maintenance' ? 'warning text-dark' : 'secondary') }}">{{ ucfirst($vehicle->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No vehicles available.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $vehicles->links() }}</div>
</div>
@endsection
