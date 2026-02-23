@extends('director.layout')

@section('active_nav', 'dashboard')
@section('title', 'Director Dashboard')
@section('page_title', 'Director Dashboard')
@section('page_subtitle', 'Company: ' . ($company->name ?? 'N/A'))

@section('page_actions')
@if($companyApproved)
<a href="{{ route('director.agencies.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Create Agency</a>
@endif
@endsection

@section('content')
@if($company->approval_status !== 'approved')
    <div class="alert {{ $company->approval_status === 'rejected' ? 'alert-danger' : 'alert-warning' }}">
        @if($company->approval_status === 'rejected')
            <strong>Company rejected:</strong> {{ $company->rejection_reason }}
        @else
            Your company is pending approval. Agency creation is disabled until approval.
        @endif
    </div>
@endif

<div class="stats-grid">
    <div class="stat-card"><p class="text-muted mb-1">Total Agencies</p><h3>{{ $stats['total_agencies'] }}</h3><small>{{ $stats['approved_agencies'] }} approved / {{ $stats['pending_agencies'] }} pending</small></div>
    <div class="stat-card"><p class="text-muted mb-1">Active Vehicles</p><h3>{{ $stats['active_vehicles'] }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Total Bookings</p><h3>{{ $stats['total_bookings'] }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Monthly Revenue</p><h3>{{ number_format($stats['monthly_revenue']) }}</h3><small>XAF</small></div>
</div>

<div class="content-card">
    <h5 class="mb-2">Quick Navigation</h5>
    <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-outline-primary btn-sm" href="{{ route('director.company') }}">Company</a>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('director.agencies') }}">Agencies</a>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('director.managers') }}">Managers</a>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('director.fleet') }}">Fleet</a>
        <a class="btn btn-outline-primary btn-sm" href="{{ route('director.reports') }}">Reports</a>
    </div>
</div>
@endsection
