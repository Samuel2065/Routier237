@extends('agency_manager.layout')

@section('active_nav', 'dashboard')
@section('title', 'Agency Dashboard')
@section('page_title', 'Agency Dashboard')
@section('page_subtitle', $agency->name ?? 'Agency overview')

@section('page_actions')
<a href="{{ route('agency_manager.staff.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-person-plus"></i> Add Staff</a>
@endsection

@section('content')
<div class="stats-grid">
    <div class="stat-card"><p class="text-muted mb-1">Total Reservations</p><h3>{{ $stats['total_reservations'] }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Today Bookings</p><h3>{{ $stats['today_bookings'] }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Staff Count</p><h3>{{ $stats['staff_count'] }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Daily Revenue</p><h3>{{ number_format($stats['daily_revenue']) }}</h3><small>XAF</small></div>
</div>
<div class="content-card"><p class="mb-0 text-muted">Use the sidebar to manage agency operations.</p></div>
@endsection
