@extends('clerk.layout')

@section('active_nav', 'reservations.create')
@section('title', 'New Reservation')
@section('page_title', 'Create Reservation')
@section('page_subtitle', $agency->name ?? '')

@section('content')
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<div class="content-card">
    <form method="POST" action="{{ route('counter_clerk.reservations.store') }}" class="row g-3">
        @csrf
        <div class="col-md-6"><label class="form-label">Customer Name</label><input class="form-control" name="customer_name" value="{{ old('customer_name') }}" required></div>
        <div class="col-md-6"><label class="form-label">Customer Phone</label><input class="form-control" name="customer_phone" value="{{ old('customer_phone') }}" required></div>
        <div class="col-md-4"><label class="form-label">Route ID</label><input class="form-control" name="route_id" value="{{ old('route_id') }}" required></div>
        <div class="col-md-4"><label class="form-label">Departure Date</label><input class="form-control" type="date" name="departure_date" value="{{ old('departure_date') }}" required></div>
        <div class="col-md-4"><label class="form-label">Seat Number</label><input class="form-control" name="seat_number" value="{{ old('seat_number') }}" required></div>
        <div class="col-md-4"><label class="form-label">Amount</label><input class="form-control" type="number" step="0.01" name="amount" value="{{ old('amount') }}" required></div>
        <div class="col-12"><button class="btn btn-primary" type="submit">Save Reservation</button></div>
    </form>
</div>
@endsection
