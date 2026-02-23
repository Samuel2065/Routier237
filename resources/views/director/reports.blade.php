@extends('director.layout')

@section('active_nav', 'reports')
@section('title', 'Reports')
@section('page_title', 'Reports')
@section('page_subtitle', 'Company level summary')

@section('content')
<div class="stats-grid">
    <div class="stat-card"><p class="text-muted mb-1">Total Agencies</p><h3>{{ $company->agencies()->count() }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Approved Agencies</p><h3>{{ $company->agencies()->where('approval_status', 'approved')->count() }}</h3></div>
    <div class="stat-card"><p class="text-muted mb-1">Vehicles</p><h3>{{ $company->vehicles()->count() }}</h3></div>
</div>

<div class="content-card">
    <h5 class="mb-3">Reports Center</h5>
    <p class="text-muted mb-0">Detailed report exports and charts can be connected here.</p>
</div>
@endsection
