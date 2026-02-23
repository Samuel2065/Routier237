@extends('customer.layout')
@section('active_nav', 'reservations')
@section('title', 'My Reservations')
@section('page_title', 'My Reservations')
@section('content')
<div class="content-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Ticket</th>
                    <th>Route</th>
                    <th>Travel Date</th>
                    <th>Seat</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->ticket_number ?? ('RSV-' . $reservation->id) }}</td>
                        <td>{{ data_get($reservation, 'trip.route.fromCity.name', '-') }} - {{ data_get($reservation, 'trip.route.toCity.name', '-') }}</td>
                        <td>{{ optional(data_get($reservation, 'trip.travel_date'))->format('Y-m-d') ?? ($reservation->departure_date ?? '-') }}</td>
                        <td>{{ $reservation->seat_number ?? '-' }}</td>
                        <td><span class="badge bg-{{ in_array(($reservation->status ?? ''), ['valid', 'confirmed']) ? 'success' : (($reservation->status ?? '') === 'used' ? 'secondary' : 'warning text-dark') }}">{{ ucfirst($reservation->status ?? '-') }}</span></td>
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
