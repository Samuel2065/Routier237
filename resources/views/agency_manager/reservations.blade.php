@extends('agency_manager.layout')

@section('active_nav', 'reservations')
@section('title', 'Reservations')
@section('page_title', 'Reservations')
@section('page_subtitle', $agency->name ?? '')

@section('content')
<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>#</th><th>Trip</th><th>Client</th><th>Date</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->id }}</td>
                        <td>{{ $reservation->trip_id }}</td>
                        <td>{{ data_get($reservation, 'client.full_name', '-') }}</td>
                        <td>{{ $reservation->created_at }}</td>
                        <td>{{ ucfirst($reservation->status ?? 'n/a') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">No reservations found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $reservations->links() }}</div>
</div>
@endsection
