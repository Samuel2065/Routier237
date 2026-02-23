@extends('clerk.layout')

@section('active_nav', 'reservations')
@section('title', 'Reservations')
@section('page_title', 'Reservations')
@section('page_subtitle', $agency->name ?? '')

@section('content')
<div class="content-card">
    <p class="text-muted mb-3">Reservation list integration point.</p>
    <a href="{{ route('counter_clerk.reservations.create') }}" class="btn btn-primary btn-sm">Create Reservation</a>
</div>
@endsection
