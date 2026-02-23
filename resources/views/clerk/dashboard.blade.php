@extends('clerk.layout')

@section('active_nav', 'dashboard')
@section('title', 'Counter Clerk Dashboard')
@section('page_title', 'Counter Clerk Dashboard')
@section('page_subtitle', $agency->name ?? '')

@section('content')
<div class="stats-grid">
    <div class="stat-card"><p class="text-muted mb-1">Today Bookings</p><h3>{{ $stats['today_bookings'] }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Pending Payments</p><h3>{{ $stats['pending_payments'] }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Cash Register Balance</p><h3>{{ number_format($stats['cash_register_balance']) }}</h3><small>XAF</small></div>
</div>
<div class="content-card"><p class="mb-0 text-muted">Use the sidebar for reservation and cash register operations.</p></div>
@endsection
