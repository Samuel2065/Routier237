@extends('layouts.dashboard.base')

@section('sidebar')
<div class="sidebar">
    <div class="sidebar-header">
        <h4><i class="bi bi-truck"></i> Routier+237</h4>
        <small class="text-white-50">Driver Portal</small>
    </div>

    <div class="nav-menu">
        <div class="nav-item"><a href="{{ route('driver.dashboard') }}" class="nav-link {{ request()->routeIs('driver.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a></div>
        <div class="nav-item"><a href="{{ route('driver.trips') }}" class="nav-link {{ request()->routeIs('driver.trips') ? 'active' : '' }}"><i class="bi bi-signpost-split"></i> Trips</a></div>
        <div class="nav-item"><a href="{{ route('driver.schedule') }}" class="nav-link {{ request()->routeIs('driver.schedule') ? 'active' : '' }}"><i class="bi bi-calendar3"></i> Schedule</a></div>
        <div class="nav-item"><a href="{{ route('driver.vehicle') }}" class="nav-link {{ request()->routeIs('driver.vehicle') ? 'active' : '' }}"><i class="bi bi-bus-front"></i> Vehicle</a></div>
    </div>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="sidebar-logout-btn"><i class="bi bi-box-arrow-right"></i><span>Logout</span></button></form>
    </div>
</div>
@endsection
